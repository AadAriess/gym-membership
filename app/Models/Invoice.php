<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = [
        'member_id',
        'invoice_number',
        'billing_month',
        'billing_year',
        'base_price',
        'tax',
        'total_amount',
        'status',
        'due_date'
    ];

    // 1 Invoice just have 1 Member
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    // 1 Invoice has many payment
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
