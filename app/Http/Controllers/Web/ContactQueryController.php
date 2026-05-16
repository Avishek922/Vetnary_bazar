<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactQueryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
        ]);

        $query = \App\Models\ContactQuery::create($validated);

        // Notify Admin
        try {
            \Illuminate\Support\Facades\Mail::to(config('mail.from.address'))
                ->send(new \App\Mail\NewContactQueryEmail($query));
        } catch (\Exception $e) {
            \Log::error('Failed to send contact query notification: ' . $e->getMessage());
        }

        return back()->with('success', 'Your message has been sent successfully. We will get back to you soon!');
    }
}
