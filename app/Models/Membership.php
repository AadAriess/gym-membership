<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Membership extends Model
{
    protected $fillable = ['name', 'description', 'monthly_price'];

    // 1 Membership has Many members
    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }
}
