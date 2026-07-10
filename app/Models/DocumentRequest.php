<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentRequest extends Model
{
    protected $fillable = [
        'product_id',
        'product_name',
        'full_name',
        'email',
        'phone',
        'company',
        'document_type',
        'message',
        'status',
        'sent_at',
        'ip_address',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
