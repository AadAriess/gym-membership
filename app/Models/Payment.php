<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'invoice_id',
        'amount_paid',
        'payment_date'
    ];

    // 1 Payment just have 1 invoice
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
