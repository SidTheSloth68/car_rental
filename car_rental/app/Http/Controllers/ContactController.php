<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    /**
     * Show the contact page.
     */
    public function show()
    {
        return view('pages.contact');
    }

    /**
     * Process the contact form submission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ]);

        try {
            // Send email to admin
            Mail::to(config('mail.admin_email', 'admin@caravel.com'))
                ->send(new ContactMail($validated));

            return redirect()->back()
                ->with('success', 'Thank you for your message! We\'ll get back to you within 24 hours.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Sorry, there was an error sending your message. Please try again or contact us directly.');
        }
    }
}
