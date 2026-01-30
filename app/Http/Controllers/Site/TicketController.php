<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {
        $registrations = Auth::user()->registrations()
            ->with(['event'])
            ->latest()
            ->paginate(10);

        return view('site.tickets.index', compact('registrations'));
    }

    public function show(Registration $registration)
    {
        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        $registration->load(['event', 'attendees']);

        return view('site.tickets.show', compact('registration'));
    }
}
