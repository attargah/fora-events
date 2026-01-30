<?php

namespace App\Services;


use App\Enums\CheckoutStatus;
use App\Models\Checkout;
use App\Models\Event;
use App\Models\EventTicket;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Support\Str;

class CheckoutService
{

    protected Checkout $checkout;

    protected Event $event;
    protected EventTicket $eventTicket;

    protected null|User $user = null;

    protected null|Registration $registration = null;


    protected string $ip;

    protected string|null $name = null;
    protected string|null $hash = null;
    protected string|null $email = null;
    protected string|null $phone = null;
    protected string|null $country = null;
    protected string|null $city = null;
    protected string|null $states = null;
    protected string|null $address = null;
    protected int|float|null $amount = 0;
    protected int|null $quantity = 0;
    protected int|float|null $total = 1;


    protected string|null|CheckoutStatus $status = CheckoutStatus::Pending;

    protected array|null $attendees = [];

    /**
     * @throws \Exception
     */
    public function __construct(Checkout|null $checkout = null)
    {

        if (!empty($checkout)) {
            $this->checkout = $checkout;
            $this->setFromModel();

        }
    }

    public function setRelations(Event $event, EventTicket $eventTicket, User|null $user = null, Registration|null $registration = null): self
    {
        $this->event = $event;
        $this->eventTicket = $eventTicket;
        $this->user = $user;
        $this->registration = $registration;

        return $this;
    }


    public function set(array $data): self
    {
        $this->ip = $data['ip_address'] ?? $this->ip;
        $this->name = $data['name'] ?? $this->name;
        $this->email = $data['email_address'] ?? $this->email;
        $this->phone = $data['phone_number'] ?? $this->phone;
        $this->country = $data['country'] ?? $this->country;
        $this->city = $data['city'] ?? $this->city;
        $this->states = $data['state'] ?? $this->states;
        $this->address = $data['address'] ?? $this->address;
        $this->status = $data['status'] ?? $this->status;
        $this->quantity = isset($data['quantity']) ? max(1, (int)$data['quantity']) : $this->quantity;
        $this->amount = isset($data['amount']) ? (float)$data['amount'] : $this->amount;
        $this->attendees = $data['attendees'] ?? $this->attendees;
        $this->total = $this->amount * $this->quantity;

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function setFromModel(): self
    {
        if (empty($this->checkout)) {
            throw new \Exception('Checkout Model cannot be empty');
        }

        $this->hash = $this->checkout->hash ?? null;
        $this->ip = $this->checkout->ip_address ?? null;
        $this->name = $this->checkout->name ?? null;
        $this->email = $this->checkout->email_address ?? null;
        $this->phone = $this->checkout->phone_number ?? null;
        $this->country = $this->checkout->country ?? null;
        $this->city = $this->checkout->city ?? null;
        $this->states = $this->checkout->state ?? null;
        $this->address = $this->checkout->address ?? null;
        $this->quantity = $this->checkout->quantity ?? 1;
        $this->amount = $this->checkout->amount ?? 0;
        $this->total = $this->checkout->total ?? 0;
        $this->attendees = $this->checkout->attendees ?? [];
        $this->setRelations($this->checkout->event, $this->checkout->ticket, $this->checkout->user, $this->checkout->registration);
        return $this;
    }

    public function get(): array
    {
        return [
            'ip_address' => $this->ip,
            'hash' => $this->hash,
            'event_id' => $this->event->id,
            'event_ticket_id' => $this->eventTicket->id,
            'user_id' => $this->user?->id,
            'registration_id' => $this->registration?->id,
            'name' => $this->name,
            'email_address' => $this->email,
            'phone_number' => $this->phone,
            'country' => $this->country,
            'city' => $this->city,
            'state' => $this->states,
            'address' => $this->address,
            'status' => $this->status,
            'amount' => $this->amount,
            'quantity' => $this->quantity,
            'total' => $this->total,
            'attendees' => $this->attendees,
        ];
    }

    public function createHash(): self
    {
        $hash = Str::uuid();

        if (Checkout::query()->where('hash', $hash)->exists()) {
            return $this->createHash();
        }

        $this->hash = $hash;

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function handle(): self
    {

        if (empty($this->hash)) {
            $this->createHash();
        }
        $this->isReady();
        return $this->make();
    }

    /**
     * @throws \Exception
     */
    protected function make(): self
    {
        $checkout = Checkout::query()->updateOrCreate(['hash' => $this->hash], $this->get());
        $this->checkout = $checkout;
        $this->setFromModel();
        return $this;
    }

    /**
     * @throws \Exception
     */
    protected function isReady(): bool
    {

        if (empty($this->hash)) {
            throw new \Exception('Hash is required for checkout.');
        }

        if (empty($this->ip)) {
            throw new \Exception('IP Address is required for checkout.');
        }

        if (empty($this->event)) {
            throw new \Exception('Event is required for checkout.');
        }

        if (empty($this->eventTicket)) {
            throw new \Exception('Ticket is required for checkout.');
        }

        return true;

    }

    public function handleLastRecords(): self
    {
        $query = Checkout::query()->where('status', CheckoutStatus::Pending)->where('ip_address', $this->ip);

        $check = $query->count() > 5;

        if ($check) {
            $query
                ->oldest()
                ->first()
                ?->delete();
        }

        return $this;
    }

}