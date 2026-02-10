<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OTP Expiry (minutes)
    |--------------------------------------------------------------------------
    */
    'expiry_minutes' => env('OTP_EXPIRY_MINUTES', 10),

    /*
    |--------------------------------------------------------------------------
    | OTP Length (digits)
    |--------------------------------------------------------------------------
    */
    'length' => env('OTP_LENGTH', 6),

    /*
    |--------------------------------------------------------------------------
    | WhatsApp API (for sending OTP) - BigTos (cp.bigtos.com)
    |--------------------------------------------------------------------------
    | Set WHATSAPP_OTP_API_URL to your send-message endpoint. For BigTos: open
    | https://www.cp.bigtos.com/ → Settings → WhatsApp Setting → Documentation
    | and use the send-message URL they provide. Phone numbers need country
    | code (e.g. 919876543210). If API_URL is empty, OTP is only logged (testing).
    */
    'whatsapp' => [
        'api_key' => env('WHATSAPP_OTP_API_KEY'),
        'api_url' => env('WHATSAPP_OTP_API_URL'),
        'enabled' => env('WHATSAPP_OTP_ENABLED', true),
    ],

];
