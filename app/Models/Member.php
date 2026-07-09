<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'name',
        'email',
        'receives_notifications',
        'is_active',
    ];

    protected $casts = [
        'receives_notifications' => 'boolean',
        'is_active'               => 'boolean',
    ];
}
