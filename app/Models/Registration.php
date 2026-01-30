<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Registration extends Model
{
    protected $fillable = [
        'event_id',
        'event_ticket_id',
        'user_id',
        'name',
        'email',
        'phone',
        'item_price',
        'quantity',
        'total_price',
    ];

    protected function casts(): array
    {
        return [
            'item_price' => 'decimal:2',
            'total_price' => 'decimal:2',
        ];
    }


    protected static function booting(): void
    {
        static::created(function ($model) {
            if ($model->ticket->is_limited()) {
                $model->ticket->increment('available_quantity',$model->quantity);
            }
        });
        static::deleted(function ($model) {
            if ($model->ticket->is_limited()) {
                $model->ticket->decrement('available_quantity',$model->quantity);
            }
        });

        static::updated(function ($model) {
            if ($model->ticket->is_limited()) {
                $model->ticket->increment('available_quantity',$model->quantity);
            }
        });
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(EventTicket::class, 'event_ticket_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attendees(): HasMany
    {
        return $this->hasMany(RegistrationAttendee::class);
    }
}
