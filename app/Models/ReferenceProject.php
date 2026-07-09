<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ReferenceProject extends Model
{
    protected $fillable = [
        'segment_id',
        'title',
        'slug',
        'client',
        'location',
        'year',
        'description',
        'content',
        'used_products',
        'image',
        'gallery',
        'is_active',
        'is_featured',
        'source',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'used_products' => 'array',
        'gallery'       => 'array',
        'is_active'     => 'boolean',
        'is_featured'   => 'boolean',
    ];

    public function segment(): BelongsTo
    {
        return $this->belongsTo(Segment::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_reference_project')
            ->withPivot('sort_order')
            ->orderByPivot('sort_order');
    }
}
