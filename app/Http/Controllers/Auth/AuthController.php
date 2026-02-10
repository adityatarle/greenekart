<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Notification;
use App\Services\WhatsAppOtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    protected WhatsAppOtpService $otpService;

    public function __construct(WhatsAppOtpService $otpService)
    {
        $this->otpService = $otpService;
    }
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request - validate credentials then send OTP.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return redirect()->back()
                ->withErrors(['email' => 'The provided credentials do not match our records.'])
                ->withInput($request->except('password'));
        }

        $user = Auth::user();
        $phone = $user->phone ?? '';

        if (empty($phone)) {
            Auth::logout();
            return redirect()->back()
                ->withErrors(['email' => 'No phone number on file. Please contact support to add a phone for OTP login.'])
                ->withInput($request->except('password'));
        }

        $rateKey = 'otp_sent:' . preg_replace('/\D/', '', $phone);
        if (Cache::has($rateKey)) {
            Auth::logout();
            return redirect()->back()
                ->withErrors(['email' => 'Please wait a minute before requesting another OTP.'])
                ->withInput($request->except('password'));
        }

        $result = $this->otpService->sendOtp($phone);
        if (!$result['success']) {
            Auth::logout();
            return redirect()->back()
                ->withErrors(['email' => $result['message'] ?? 'Failed to send OTP.'])
                ->withInput($request->except('password'));
        }

        Cache::put($rateKey, true, now()->addMinute());
        Auth::logout();
        $request->session()->regenerateToken();
        $request->session()->put('otp_intent', 'login');
        $request->session()->put('otp_phone', $phone);
        $request->session()->put('otp_user_id', $user->id);
        $request->session()->put('otp_remember', $remember);

        return redirect()->route('auth.otp.verify')
            ->with('success', 'OTP sent to your WhatsApp. Enter it below.');
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request - validate then send OTP to phone.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|in:customer,dealer',
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $phone = $request->phone;
        $rateKey = 'otp_sent:' . preg_replace('/\D/', '', $phone);
        if (Cache::has($rateKey)) {
            return redirect()->back()
                ->withErrors(['phone' => 'Please wait a minute before requesting another OTP.'])
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $result = $this->otpService->sendOtp($phone);
        if (!$result['success']) {
            return redirect()->back()
                ->withErrors(['phone' => $result['message'] ?? 'Failed to send OTP.'])
                ->withInput($request->except('password', 'password_confirmation'));
        }

        Cache::put($rateKey, true, now()->addMinute());
        $request->session()->put('otp_intent', 'register');
        $request->session()->put('otp_phone', $phone);
        $request->session()->put('register_data', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
            'phone' => $request->phone,
        ]);

        return redirect()->route('auth.otp.verify')
            ->with('success', 'OTP sent to your WhatsApp. Enter it below to complete registration.');
    }

    /**
     * Show OTP verification form (after login or register).
     */
    public function showOtpVerify(Request $request)
    {
        $intent = $request->session()->get('otp_intent');
        if (!in_array($intent, ['login', 'register'], true)) {
            return redirect()->route('auth.login')->with('error', 'Invalid or expired session. Please try again.');
        }
        $phone = $request->session()->get('otp_phone', '');
        $maskedPhone = strlen($phone) > 4 ? '****' . substr($phone, -4) : $phone;
        return view('auth.otp-verify', [
            'intent' => $intent,
            'masked_phone' => $maskedPhone,
        ]);
    }

    /**
     * Verify OTP and complete login or registration.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|string|size:6']);

        $intent = $request->session()->get('otp_intent');
        $phone = $request->session()->get('otp_phone');
        if (!in_array($intent, ['login', 'register'], true) || empty($phone)) {
            return redirect()->route('auth.login')->with('error', 'Invalid or expired session. Please try again.');
        }

        if (!$this->otpService->verify($phone, $request->otp)) {
            return redirect()->back()
                ->withErrors(['otp' => 'Invalid or expired OTP. Please try again.'])
                ->withInput($request->only('otp'));
        }

        if ($intent === 'login') {
            $userId = $request->session()->get('otp_user_id');
            $remember = (bool) $request->session()->get('otp_remember', false);
            $request->session()->forget(['otp_intent', 'otp_phone', 'otp_user_id', 'otp_remember', 'register_data']);
            $user = User::find($userId);
            if (!$user) {
                return redirect()->route('auth.login')->with('error', 'Session expired. Please log in again.');
            }
            Auth::login($user, $remember);
            $request->session()->regenerate();
            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Welcome back!');
            }
            if ($user->isDealer()) {
                return redirect()->intended(route('dealer.dashboard'))->with('success', 'Welcome back!');
            }
            return redirect()->intended(route('agriculture.home'))->with('success', 'Welcome back!');
        }

        $request->session()->forget(['otp_intent', 'otp_phone', 'otp_user_id', 'otp_remember']);
        $data = $request->session()->get('register_data');
        if (!$data) {
            $request->session()->forget('register_data');
            return redirect()->route('auth.register')->with('error', 'Session expired. Please register again.');
        }
        $request->session()->forget('register_data');

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'viewable_password' => $data['password'],
            'role' => $data['role'],
            'phone' => $data['phone'],
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        Notification::create([
            'user_id' => $user->id,
            'type' => 'welcome',
            'title' => 'Welcome to Nexus Agriculture!',
            'message' => 'Thank you for registering with us. You can now browse our agricultural products.',
        ]);

        if ($user->isDealer()) {
            return redirect()->route('dealer.registration')->with('success', 'Account created successfully! Please complete your dealer registration.');
        }
        return redirect()->route('agriculture.home')->with('success', 'Account created successfully!');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('agriculture.home')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show dealer login form
     */
    public function showDealerLogin()
    {
        return view('auth.dealer-login');
    }

    /**
     * Handle dealer login
     */
    public function dealerLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            if (!$user->isDealer()) {
                Auth::logout();
                return redirect()->back()
                    ->withErrors(['email' => 'This account is not registered as a dealer.'])
                    ->withInput($request->except('password'));
            }

            if (!$user->isApprovedDealer()) {
                return redirect()->route('dealer.pending')->with('info', 'Your dealer registration is pending approval.');
            }

            return redirect()->intended(route('dealer.dashboard'));
        }

        return redirect()->back()
            ->withErrors(['email' => 'The provided credentials do not match our records.'])
            ->withInput($request->except('password'));
    }

    /**
     * Show customer login form
     */
    public function showCustomerLogin()
    {
        return view('auth.customer-login');
    }

    /**
     * Handle customer login
     */
    public function customerLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            if (!$user->isCustomer()) {
                Auth::logout();
                return redirect()->back()
                    ->withErrors(['email' => 'This account is not registered as a customer.'])
                    ->withInput($request->except('password'));
            }

            return redirect()->intended(route('agriculture.home'));
        }

        return redirect()->back()
            ->withErrors(['email' => 'The provided credentials do not match our records.'])
            ->withInput($request->except('password'));
    }
}