<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;

class RegistrationAttendee extends Model
{
    protected $fillable = [
        'registration_id',
        'name',
        'email',
        'phone',
        'registration_code',
    ];

    protected static function booting(): void
    {
       self::creating(function ($model) {
           $model->registration_code = Hash::make($model->id.now()->format('YmdHis'));
       });
    }

    public function registration() : BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }
}
