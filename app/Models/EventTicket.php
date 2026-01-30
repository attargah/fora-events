<?php

namespace App\Models;

use App\Enums\EventTicketStatus;
use App\Traits\CreateSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventTicket extends Model
{
    use HasFactory, CreateSlug;

    protected $fillable = [
        'event_id',
        'name',
        'description',
        'status',
        'price',
        'quantity',
        'max_tickets_per_person',
        'available_quantity',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'status' => EventTicketStatus::class
        ];
    }



    public function is_limited(): bool
    {
        return $this->quantity > 0;
    }


    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }
}
