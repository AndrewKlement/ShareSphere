<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ShippingDetail extends Model
{
    protected $fillable = [
        'phone_number',
        'province',
        'city',
        'postal_code',
        'address',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
