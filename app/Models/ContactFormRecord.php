<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactFormRecord extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'subject',
        'message',
        'email',
    ];
}
