<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticTranslate extends Model
{
    protected $fillable = [
        'key',
        'locale',
        'value',
        'group',
    ];
}
