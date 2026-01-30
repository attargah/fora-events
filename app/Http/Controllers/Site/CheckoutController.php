<?php

namespace App\Http\Controllers\Site;

use App\Enums\CheckoutStatus;
use App\Events\CheckoutCompleted;
use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\Event;
use App\Models\EventTicket;
use App\Services\CheckoutService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->validate([
            'event_id' => 'required|integer|exists:events,id',
            'event_ticket_id' => 'required|integer|exists:event_tickets,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $event = Event::findOrFail($data['event_id']);
        $ticket =EventTicket::findOrFail($data['event_ticket_id']);

        $service = new CheckoutService();

        try {
            $service->setRelations($event, $ticket, auth()->user() ?? null)->set([
                'ip_address' => $request->ip(),
                'quantity' => $data['quantity'],
                'amount' => $ticket->price,
                'total' => $ticket->price * $data['quantity']
            ])->createHash()->handle();


            $checkoutData = $service->get();
            $hash = $checkoutData['hash'];

            return redirect()->route('checkout.index', ['hash' => $hash]);

        } catch (\Exception $e) {
            return back()->with('error', 'Error creating checkout: ' . $e->getMessage());
        }
    }

    public function index(Request $request, $hash)
    {
        $checkout = Checkout::where('hash', $hash)->with(['event', 'ticket'])->firstOrFail();

        if ($checkout->status === CheckoutStatus::Completed) {
            return view('site.checkout.success', compact('checkout'));
        }

        if ($checkout->status === CheckoutStatus::Failed) {
            return view('site.checkout.failed', compact('checkout'));
        }

        return view('site.checkout.index', compact('checkout'));
    }

    public function store(Request $request, $hash)
    {
        $checkout = Checkout::where('hash', $hash)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'address' => 'required|string',
            'attendees' => 'required|array|min:'.$checkout->quantity,
            'attendees.*.name' => 'required|string|max:255',
            'attendees.*.email' => 'required|email|max:255',
            'attendees.*.phone' => 'required|string|max:20',
        ]);

        try {

            $service = new CheckoutService($checkout);

            $service->set([
                'name'=>$request->name,
                'email_address'=>$request->email,
                'phone_number'=>$request->phone,
                'country'=>$request->country,
                'city'=>$request->city,
                'state'=>$request->state,
                'address'=>$request->address,
                'attendees'=>$request->attendees,
                'ip_address'=>$request->ip(),
                'status'=>CheckoutStatus::Completed,
            ])->handle();

            $checkout->refresh();

            CheckoutCompleted::dispatch($checkout);

            return redirect()->route('checkout.index', ['hash' => $hash]);

        } catch (\Exception $e) {
            return back()->with('error', 'Error processing checkout: ' . $e->getMessage());
        }
    }
}

