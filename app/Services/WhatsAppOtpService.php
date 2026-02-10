<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppOtpService
{
    protected string $apiKey;
    protected ?string $apiUrl;
    protected bool $enabled;
    protected int $expiryMinutes;
    protected int $otpLength;

    public function __construct()
    {
        $this->apiKey = config('otp.whatsapp.api_key', '');
        $this->apiUrl = config('otp.whatsapp.api_url');
        $this->enabled = config('otp.whatsapp.enabled', true) && !empty($this->apiKey);
        $this->expiryMinutes = (int) config('otp.expiry_minutes', 10);
        $this->otpLength = (int) config('otp.length', 6);
    }

    /**
     * Generate a numeric OTP and store in cache.
     */
    public function generateAndStore(string $phone): string
    {
        $phone = $this->normalizePhone($phone);
        $otp = $this->generateOtp();
        Cache::put($this->cacheKey($phone), $otp, now()->addMinutes($this->expiryMinutes));
        return $otp;
    }

    /**
     * Send OTP to phone via WhatsApp API and store in cache.
     * Returns the OTP on success (for logging in dev); returns false on send failure.
     */
    public function sendOtp(string $phone): array
    {
        $phone = $this->normalizePhone($phone);
        $otp = $this->generateOtp();
        Cache::put($this->cacheKey($phone), $otp, now()->addMinutes($this->expiryMinutes));

        $message = $this->otpMessage($otp);
        $sent = $this->sendWhatsAppMessage($phone, $message);

        if (!$sent && $this->enabled) {
            Log::warning('WhatsApp OTP send failed', ['phone' => $phone]);
            return ['success' => false, 'message' => 'Failed to send OTP. Please try again or contact support.'];
        }

        if (!$this->enabled) {
            Log::info('OTP (WhatsApp disabled, for testing)', ['phone' => $phone, 'otp' => $otp]);
        }

        return ['success' => true, 'message' => 'OTP sent to your WhatsApp.'];
    }

    /**
     * Verify OTP for a phone number.
     */
    public function verify(string $phone, string $code): bool
    {
        $phone = $this->normalizePhone($phone);
        $stored = Cache::get($this->cacheKey($phone));
        if ($stored === null) {
            return false;
        }
        if ((string) $stored !== (string) $code) {
            return false;
        }
        Cache::forget($this->cacheKey($phone));
        return true;
    }

    protected function cacheKey(string $phone): string
    {
        return 'otp:' . preg_replace('/\D/', '', $phone);
    }

    protected function generateOtp(): string
    {
        $min = (10 ** ($this->otpLength - 1));
        $max = (10 ** $this->otpLength) - 1;
        return (string) random_int($min, $max);
    }

    protected function otpMessage(string $otp): string
    {
        $app = config('app.name');
        return "Your {$app} verification code is: {$otp}. Valid for " . $this->expiryMinutes . " minutes. Do not share with anyone.";
    }

    /**
     * Normalize phone: digits only, ensure country code if needed.
     */
    protected function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D/', '', $phone);
        if (strlen($digits) === 10 && in_array(substr($digits, 0, 1), ['6', '7', '8', '9'])) {
            $digits = '91' . $digits; // India
        }
        return $digits;
    }

    protected function maskPhone(string $phone): string
    {
        $len = strlen($phone);
        if ($len <= 4) {
            return str_repeat('*', $len);
        }
        return substr($phone, 0, 2) . str_repeat('*', $len - 4) . substr($phone, -2);
    }

    protected function isLoginPage(string $body): bool
    {
        return stripos($body, 'BigTos Login') !== false || stripos($body, 'Sign In') !== false;
    }

    /**
     * Send message via configured WhatsApp API.
     * Uses a generic POST/GET pattern; set WHATSAPP_OTP_API_URL in .env to your provider's endpoint.
     */
    protected function sendWhatsAppMessage(string $phone, string $message): bool
    {
        if (!$this->enabled) {
            return true;
        }
        if (empty($this->apiUrl)) {
            Log::info('OTP (no WHATSAPP_OTP_API_URL). For testing, use this code: ' . $message, ['phone' => $phone]);
            return true; // Allow flow to continue; check storage/logs/laravel.log for the code when testing
        }

        $url = rtrim($this->apiUrl, '/');

        // BigTos Send Text API: key, mobileno, msg, type (POST form)
        $isBigTos = (str_contains($url, 'bigtos.com'));
        $payload = $isBigTos
            ? [
                'key' => $this->apiKey,
                'mobileno' => $phone,
                'msg' => $message,
                'type' => 'Text',
            ]
            : [
                'auth_key' => $this->apiKey,
                'api_key' => $this->apiKey,
                'to' => $phone,
                'mobile' => $phone,
                'message' => $message,
            ];

        try {
            $client = Http::timeout(15)->withHeaders([
                'User-Agent' => 'Greenleaf-OTP/1.0',
            ]);

            // BigTos expects POST with form fields (CURLOPT_POSTFIELDS)
            $response = $client->asForm()->post($url, $payload);

            if ($response->successful() && !$this->isLoginPage($response->body())) {
                Log::info('WhatsApp OTP sent successfully', ['phone' => $this->maskPhone($phone)]);
                return true;
            }

            $status = $response->status();
            $body = $response->body();
            Log::warning('WhatsApp OTP API failed', [
                'url' => $url,
                'status' => $status,
                'body' => strlen($body) > 500 ? substr($body, 0, 500) . '...' : $body,
                'phone' => $this->maskPhone($phone),
            ]);
            return false;
        } catch (\Throwable $e) {
            Log::error('WhatsApp OTP send exception', [
                'error' => $e->getMessage(),
                'url' => $url,
                'phone' => $this->maskPhone($phone),
            ]);
            return false;
        }
    }
}
