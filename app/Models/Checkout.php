<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Checkout extends Model
{

    protected $table = 'checkouts';

    protected $fillable = [
        'ip_address',
        'hash',
        'event_id',
        'event_ticket_id',
        'user_id',
        'registration_id',
        'name',
        'email_address',
        'phone_number',
        'country',
        'city',
        'state',
        'address',
        'status',
        'amount',
        'quantity',
        'total',
        'attendees',
    ];

    protected $casts = [
        'amount'   => 'decimal:2',
        'total'    => 'decimal:2',
        'quantity' => 'integer',
        'status'   => \App\Enums\CheckoutStatus::class,
        'attendees' => 'array',
    ];



    public function event() : BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function ticket() : BelongsTo
    {
        return $this->belongsTo(EventTicket::class, 'event_ticket_id');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function registration() : BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }
}
