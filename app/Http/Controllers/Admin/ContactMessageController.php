<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * List contact form submissions with optional search and filters.
     */
    public function index(Request $request)
    {
        $query = ContactMessage::query();

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")
                    ->orWhere('subject', 'like', "%{$term}%")
                    ->orWhere('message', 'like', "%{$term}%");
            });
        }

        if ($request->filled('read')) {
            if ($request->read === '1') {
                $query->read();
            } elseif ($request->read === '0') {
                $query->unread();
            }
        }

        $messages = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => ContactMessage::count(),
            'unread' => ContactMessage::unread()->count(),
            'read' => ContactMessage::read()->count(),
        ];

        return view('admin.contact-messages.index', compact('messages', 'stats'));
    }

    /**
     * Show a single contact message and mark as read.
     */
    public function show(ContactMessage $contactMessage)
    {
        if ($contactMessage->read_at === null) {
            $contactMessage->markAsRead();
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    /**
     * Mark message as read (AJAX or redirect).
     */
    public function markAsRead(ContactMessage $contactMessage)
    {
        $contactMessage->markAsRead();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.contact-messages.show', $contactMessage)
            ->with('success', 'Marked as read.');
    }
}
