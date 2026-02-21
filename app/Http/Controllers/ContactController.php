<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    /**
     * Handle contact form submission with spam prevention:
     * - Rate limit: applied via throttle:3,15 middleware (3 per 15 min per IP)
     * - Honeypot: hidden "website" field must be empty
     */
    public function submit(Request $request)
    {
        // Honeypot: bots often fill hidden fields
        if ($request->filled('website')) {
            throw ValidationException::withMessages([
                'email' => ['Something went wrong. Please try again.'],
            ]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:10000',
        ]);

        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}
