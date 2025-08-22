<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('contact_admin');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        ContactMessage::create([
            'user_id' => Auth::id(),
            'subject' => $validated['subject'],
            'description' => $validated['description'],
        ]);

        return redirect()->back()->with('success', 'تم إرسال رسالتك بنجاح! سيتم التواصل معك قريبًا.');
    }

    public function index()
    {
        $contactMessages = ContactMessage::with('user')->latest()->get();
        return view('admin.contact_messages.index', compact('contactMessages'));
    }

    public function show(ContactMessage $contactMessage)
    {
        $contactMessage->load('user');
        return view('admin.contact_messages.show', compact('contactMessage'));
    }

    public function create(ContactMessage $contactMessage)
    {
        $contactMessage->load('user');
        return view('admin.contact_messages.create', compact('contactMessage'));
    }

    public function reply(Request $request, ContactMessage $contactMessage)
    {
        $validated = $request->validate([
            'reply' => 'required|string',
        ]);

        // Store the reply in the database
        $contactMessage->update(['reply' => $validated['reply']]);

        // Send the reply via email to the user
        if ($contactMessage->user && $contactMessage->user->email) {
            Mail::raw($validated['reply'], function ($message) use ($contactMessage) {
                $message->to($contactMessage->user->email)
                    ->subject('رد على رسالتك: ' . $contactMessage->subject);
            });
        }

        return redirect()->route('admin.contact-messages.index')->with('success', 'تم إرسال الرد بنجاح!');
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        return redirect()->route('admin.contact-messages.index')->with('success', 'تم حذف الرسالة بنجاح!');
    }
}
