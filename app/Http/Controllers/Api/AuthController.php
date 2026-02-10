<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Notification;
use App\Services\WhatsAppOtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected WhatsAppOtpService $otpService;

    public function __construct(WhatsAppOtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        // Keep existing direct registration for now (without OTP) for backward compatibility
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required', 'confirmed', Password::defaults()],
                'role' => 'required|in:customer,dealer',
                'phone' => 'required|string|max:20',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'viewable_password' => $request->password, // Store plain text for admin viewing
                'role' => $request->role,
                'phone' => $request->phone,
            ]);

            // Create welcome notification
            Notification::create([
                'user_id' => $user->id,
                'title' => 'Welcome!',
                'message' => 'Thank you for registering with us!',
                'type' => 'info',
            ]);

            $token = $user->createToken('mobile-app')->plainTextToken;

            // Get user data (business details will be null initially until dealer registration is submitted)
            $userData = $user->makeHidden(['password', 'remember_token'])->toArray();

            return response()->json([
                'success' => true,
                'message' => 'Registration successful',
                'data' => [
                    'user' => $userData,
                    'token' => $token,
                ]
            ], 201);
        } catch (\Exception $e) {
            \Log::error('API Register Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred during registration. Please try again.'
            ], 500);
        }
    }

    /**
     * Login user
     * Accepts either email or phone for authentication
     */
    public function login(Request $request)
    {
        try {
            // Validate that either email or phone is provided (but not both required)
            $validator = Validator::make($request->all(), [
                'email' => 'required_without:phone|email',
                'phone' => 'required_without:email|string',
                'password' => 'required|string',
            ], [
                'email.required_without' => 'Either email or phone number is required.',
                'phone.required_without' => 'Either email or phone number is required.',
                'email.email' => 'Please provide a valid email address.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Find user by email or phone
            $user = null;
            if ($request->filled('email')) {
                $user = User::where('email', $request->email)->first();
            } elseif ($request->filled('phone')) {
                $user = User::where('phone', $request->phone)->first();
            }

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            // Revoke existing tokens (optional - for single device login)
            // $user->tokens()->delete();

            $token = $user->createToken('mobile-app')->plainTextToken;

            // Get user data with business details if dealer
            $userData = $user->makeHidden(['password', 'remember_token'])->toArray();
            
            // If dealer has registration, merge business details from dealer_registrations
            if ($user->isDealer() && $user->dealerRegistration) {
                $registration = $user->dealerRegistration;
                
                // Merge business information from dealer_registrations
                $userData['business_name'] = $registration->business_name ?? $userData['business_name'] ?? null;
                $userData['gst_number'] = $registration->gst_number ?? $userData['gst_number'] ?? null;
                $userData['business_address'] = $registration->business_address ?? $userData['business_address'] ?? null;
                $userData['contact_person'] = $registration->contact_person ?? $userData['contact_person'] ?? null;
                $userData['company_website'] = $registration->company_website ?? $userData['company_website'] ?? null;
                $userData['business_description'] = $registration->business_description ?? $userData['business_description'] ?? null;
                $userData['pan_number'] = $registration->pan_number ?? $userData['pan_number'] ?? null;
            }

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => $userData,
                    'token' => $token,
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('API Login Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred during login. Please try again.'
            ], 500);
        }
    }

    /**
     * Start login with WhatsApp OTP (step 1)
     * - Validates credentials
     * - Sends OTP via WhatsApp
     * - Returns an otp_token that the app must use in verify step
     */
    public function startLoginOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required_without:phone|email',
            'phone' => 'required_without:email|string',
            'password' => 'required|string',
        ], [
            'email.required_without' => 'Either email or phone number is required.',
            'phone.required_without' => 'Either email or phone number is required.',
            'email.email' => 'Please provide a valid email address.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Find user by email or phone
        $user = null;
        if ($request->filled('email')) {
            $user = User::where('email', $request->email)->first();
        } elseif ($request->filled('phone')) {
            $user = User::where('phone', $request->phone)->first();
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        if (empty($user->phone)) {
            return response()->json([
                'success' => false,
                'message' => 'No phone number on file. Please contact support to add a phone for OTP login.'
            ], 400);
        }

        // Rate limit by phone (same as web flow)
        $digits = preg_replace('/\D/', '', $user->phone);
        $rateKey = 'otp_sent:' . $digits;
        if (\Cache::has($rateKey)) {
            return response()->json([
                'success' => false,
                'message' => 'Please wait a minute before requesting another OTP.'
            ], 429);
        }

        $result = $this->otpService->sendOtp($user->phone);
        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'] ?? 'Failed to send OTP. Please try again.'
            ], 500);
        }

        \Cache::put($rateKey, true, now()->addMinute());

        // Store minimal state against a random otp_token (so mobile is stateless)
        $otpToken = bin2hex(random_bytes(16));
        $tokenKey = 'api_login_otp:' . $otpToken;
        $ttlMinutes = (int) config('otp.expiry_minutes', 10);

        \Cache::put($tokenKey, [
            'user_id' => $user->id,
            'phone' => $user->phone,
        ], now()->addMinutes($ttlMinutes));

        return response()->json([
            'success' => true,
            'message' => 'OTP sent to your WhatsApp. Please verify to complete login.',
            'data' => [
                'otp_token' => $otpToken,
                'expires_in_minutes' => $ttlMinutes,
            ],
        ]);
    }

    /**
     * Verify login OTP (step 2) and issue Sanctum token
     */
    public function verifyLoginOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp_token' => 'required|string',
            'otp' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $tokenKey = 'api_login_otp:' . $request->otp_token;
        $data = \Cache::get($tokenKey);

        if (!$data || empty($data['user_id']) || empty($data['phone'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP session. Please login again.'
            ], 400);
        }

        $phone = $data['phone'];
        if (!$this->otpService->verify($phone, $request->otp)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP. Please try again.'
            ], 422);
        }

        \Cache::forget($tokenKey);

        $user = User::find($data['user_id']);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found. Please login again.'
            ], 404);
        }

        $token = $user->createToken('mobile-app')->plainTextToken;
        $userData = $user->makeHidden(['password', 'remember_token'])->toArray();

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => $userData,
                'token' => $token,
            ]
        ]);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        try {
            // Revoke current token
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('API Logout Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred during logout.'
            ], 500);
        }
    }

    /**
     * Get authenticated user
     */
    public function user(Request $request)
    {
        $user = $request->user();
        $userData = $user->makeHidden(['password', 'remember_token'])->toArray();
        
        // Add dealer-specific information
        $userData['is_dealer'] = $user->isDealer();
        $userData['is_approved_dealer'] = $user->isApprovedDealer();
        $userData['can_access_dealer_pricing'] = $user->canAccessDealerPricing();
        
        // Add dealer registration status and business details if dealer
        if ($user->isDealer() && $user->dealerRegistration) {
            $registration = $user->dealerRegistration;
            
            // Merge business information from dealer_registrations
            $userData['business_name'] = $registration->business_name ?? $userData['business_name'] ?? null;
            $userData['gst_number'] = $registration->gst_number ?? $userData['gst_number'] ?? null;
            $userData['business_address'] = $registration->business_address ?? $userData['business_address'] ?? null;
            $userData['contact_person'] = $registration->contact_person ?? $userData['contact_person'] ?? null;
            $userData['company_website'] = $registration->company_website ?? $userData['company_website'] ?? null;
            $userData['business_description'] = $registration->business_description ?? $userData['business_description'] ?? null;
            $userData['pan_number'] = $registration->pan_number ?? $userData['pan_number'] ?? null;
            
            $userData['dealer_registration'] = [
                'status' => $registration->status,
                'is_approved' => $registration->isApproved(),
                'is_pending' => $registration->isPending(),
                'reviewed_at' => $registration->reviewed_at?->toISOString(),
            ];
        } elseif ($user->isDealer()) {
            $userData['dealer_registration'] = [
                'status' => 'not_submitted',
                'is_approved' => false,
                'is_pending' => false,
            ];
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'user' => $userData,
            ]
        ]);
    }

    /**
     * Send password reset link
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // TODO: Implement password reset functionality
        // For now, just return success message

        return response()->json([
            'success' => true,
            'message' => 'Password reset link sent to your email'
        ]);
    }

    /**
     * Start registration with WhatsApp OTP (step 1)
     * Validates data and sends OTP, returns otp_token
     */
    public function startRegisterOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', Password::defaults()],
            'role' => 'required|in:customer,dealer',
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Rate limit by phone
        $digits = preg_replace('/\D/', '', $request->phone);
        $rateKey = 'otp_sent:' . $digits;
        if (\Cache::has($rateKey)) {
            return response()->json([
                'success' => false,
                'message' => 'Please wait a minute before requesting another OTP.'
            ], 429);
        }

        $result = $this->otpService->sendOtp($request->phone);
        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'] ?? 'Failed to send OTP. Please try again.'
            ], 500);
        }

        \Cache::put($rateKey, true, now()->addMinute());

        $otpToken = bin2hex(random_bytes(16));
        $tokenKey = 'api_register_otp:' . $otpToken;
        $ttlMinutes = (int) config('otp.expiry_minutes', 10);

        \Cache::put($tokenKey, [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
            'phone' => $request->phone,
        ], now()->addMinutes($ttlMinutes));

        return response()->json([
            'success' => true,
            'message' => 'OTP sent to your WhatsApp. Please verify to complete registration.',
            'data' => [
                'otp_token' => $otpToken,
                'expires_in_minutes' => $ttlMinutes,
            ],
        ]);
    }

    /**
     * Verify registration OTP (step 2) and create user
     */
    public function verifyRegisterOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp_token' => 'required|string',
            'otp' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $tokenKey = 'api_register_otp:' . $request->otp_token;
        $data = \Cache::get($tokenKey);

        if (!$data || empty($data['phone']) || empty($data['email'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP session. Please register again.'
            ], 400);
        }

        if (!$this->otpService->verify($data['phone'], $request->otp)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP. Please try again.'
            ], 422);
        }

        \Cache::forget($tokenKey);

        // Create user (similar to normal register)
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'viewable_password' => $data['password'],
            'role' => $data['role'],
            'phone' => $data['phone'],
        ]);

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Welcome!',
            'message' => 'Thank you for registering with us!',
            'type' => 'info',
        ]);

        $token = $user->createToken('mobile-app')->plainTextToken;
        $userData = $user->makeHidden(['password', 'remember_token'])->toArray();

        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
            'data' => [
                'user' => $userData,
                'token' => $token,
            ]
        ], 201);
    }
}
