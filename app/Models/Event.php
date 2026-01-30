<?php

namespace App\Models;

use App\Enums\EventStatus;
use App\Traits\CreateSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory, CreateSlug;




    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'banner',
        'images',
        'start_date',
        'end_date',
        'sales_start_date',
        'sales_end_date',
        'is_featured',
        'city',
        'district',
        'minimum_age',
        'is_alcohol_allowed',
        'event_category_id',
        'event_type_id',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'status' => EventStatus::class,
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'sales_start_date' => 'datetime',
            'sales_end_date' => 'datetime',
            'is_alcohol_allowed' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    protected static function booted()
    {
        static::saved(function ($event) {
            Cache::forget('featured_events');
            Cache::forget('trending_events');
            Cache::forget("event_detail_{$event->slug}");
        });

        static::deleted(function ($event) {
            Cache::forget('featured_events');
            Cache::forget('trending_events');
            Cache::forget("event_detail_{$event->slug}");
        });
    }

    public function getImages()
    {
        return !empty($this->images) ?
            collect($this->images)
                ->map(fn($img) => filter_var($img, FILTER_VALIDATE_URL) ? $img : Storage::url($img))
            : [$this->getBanner()];
    }

    public function getBanner(): string
    {
        return filter_var($this->banner, FILTER_VALIDATE_URL) ? $this->banner : Storage::url($this->banner);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(EventType::class, 'event_type_id');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(EventTicket::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }
}
