<?php

namespace App\Listeners;

use App\Events\CheckoutCompleted;
use App\Models\Registration;
use App\Models\RegistrationAttendee;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\Admin\RegistrationCreated;
use App\Mail\Attendee\RegistrationQr;

class CreateRegistration implements ShouldQueue
{
    use InteractsWithQueue,  SerializesModels;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CheckoutCompleted $event): void
    {

        try {
            $checkout = $event->checkout;

            Log::info('CreateRegistration başladı', [
                'checkout_id' => $checkout->id
            ]);

            Log::info('Checkout Complete - Notification to Employee', ['checkout_id' => $checkout->id]);
            Log::info('Checkout Complete - Notification to Admin', ['checkout_id' => $checkout->id]);

            $registration = Registration::create([
                'event_id' => $checkout->event_id,
                'event_ticket_id' => $checkout->event_ticket_id,
                'user_id' => $checkout->user_id,
                'name' => $checkout->name,
                'email' => $checkout->email_address,
                'phone' => $checkout->phone_number,
                'item_price' => $checkout->amount,
                'quantity' => $checkout->quantity,
                'total_price' => $checkout->total,
            ]);

            $checkout->update([
                'registration_id' => $registration->id
            ]);

            if (!empty($checkout->attendees)) {
                foreach ($checkout->attendees as $attendee) {
                   $newAttendee = RegistrationAttendee::create([
                        'registration_id' => $registration->id,
                        'name' => $attendee['name'] ?? null,
                        'email' => $attendee['email'] ?? null,
                        'phone' => $attendee['phone'] ?? null,
                    ]);
                   
                   try {
                       Mail::to($newAttendee->email)->send(new RegistrationQr($newAttendee));
                   } catch (\Throwable $e) {
                       Log::error('Error sending attendee mail', ['error' => $e->getMessage()]);
                   }
                }
            }
            
            try {
                Mail::to('admin@example.com')->send(new RegistrationCreated($registration));
            } catch (\Throwable $e) {
                Log::error('Error sending admin registration mail', ['error' => $e->getMessage()]);
            }

            Log::info('CreateRegistration tamamlandı', [
                'registration_id' => $registration->id
            ]);

        } catch (\Throwable $e) {
            Log::error('CreateRegistration HATA', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
