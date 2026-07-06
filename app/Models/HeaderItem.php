<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HeaderItem extends Model
{
    protected $fillable = [
        'parent_id',
        'label',
        'url',
        'type',
        'target',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(HeaderItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(HeaderItem::class, 'parent_id')->orderBy('sort_order');
    }
}
