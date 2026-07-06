<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FinderNode extends Model
{
    protected $fillable = [
        'parent_id',
        'segment_id',
        'depth',
        'label',
        'slug',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'depth'     => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(FinderNode::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(FinderNode::class, 'parent_id')->orderBy('sort_order');
    }

    public function segment(): BelongsTo
    {
        return $this->belongsTo(Segment::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('sort_order')->orderByPivot('sort_order');
    }

    public function isLeaf(): bool
    {
        return $this->depth === 3;
    }
}
