<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    protected $fillable = ['membership_id', 'name', 'phone', 'address', 'join_date', 'status'];

    // 1 Member just have 1 membership
    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class);
    }

    // 1 Member has many invoices
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
