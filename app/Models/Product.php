<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'technical_specs',
        'package_sizes',
        'application_steps',
        'coverage_min',
        'coverage_max',
        'coverage_unit',
        'tds_file',
        'sds_file',
        'ce_file',
        'image',
        'gallery',
        'meta_title',
        'meta_description',
        'is_active',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'technical_specs'   => 'array',
        'package_sizes'     => 'array',
        'application_steps' => 'array',
        'gallery'           => 'array',
        'coverage_min'      => 'decimal:2',
        'coverage_max'      => 'decimal:2',
        'is_active'         => 'boolean',
        'is_featured'       => 'boolean',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function documentRequests(): HasMany
    {
        return $this->hasMany(DocumentRequest::class);
    }

    public function finderNodes(): BelongsToMany
    {
        return $this->belongsToMany(FinderNode::class)->withPivot('sort_order');
    }

    public function blogPosts(): BelongsToMany
    {
        return $this->belongsToMany(BlogPost::class, 'blog_post_product')->withPivot('sort_order');
    }

    public function referenceProjects(): BelongsToMany
    {
        return $this->belongsToMany(ReferenceProject::class, 'product_reference_project')
            ->withPivot('sort_order')
            ->orderByPivot('sort_order');
    }

    /** Doküman talep modalında hangi checkbox'ların seçilebilir olacağı (Brief §05/§06). */
    public function availableDocTypes(): array
    {
        return collect([
            'tds' => $this->tds_file,
            'sds' => $this->sds_file,
            'ce'  => $this->ce_file,
        ])->filter()->keys()->all();
    }
}
