<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\MailFormRecord;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        try {
            $existing = MailFormRecord::where('email', $validated['email'])->first();
            
            if ($existing) {
                return redirect()->back()->with('success', 'Thank you for subscribing to our newsletter!');
            }

            MailFormRecord::create($validated);

            return redirect()->back()->with('success', 'Thank you for subscribing to our newsletter!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }
}
