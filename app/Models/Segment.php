<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Segment extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'color_key',
        'icon',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class)->orderBy('sort_order');
    }

    public function referenceProjects(): HasMany
    {
        return $this->hasMany(ReferenceProject::class);
    }

    public function finderNodes(): HasMany
    {
        return $this->hasMany(FinderNode::class);
    }
}
