<?php

namespace App\Models;

use App\Traits\CreateSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class EventCategory extends Model
{
    use HasFactory, CreateSlug;


    protected $fillable = [
        'name',
        'slug',
        'description',
        'created_by',
    ];

    protected static function booted()
    {
        static::saved(function () {
           Cache::forget('event_categories');
        });

        static::deleted(function () {
            Cache::forget('event_categories');
        });
    }


    public function createdBy() : BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function events() : HasMany
    {
        return $this->hasMany(Event::class);
    }
}
