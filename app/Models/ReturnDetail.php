<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ReturnDetail extends Model
{
    protected $fillable = [
        'return_header_id',
        'transaction_detail_id',
        'item_id',
        'quantity',
        'confirmed',
    ];

    protected $casts = [
        'confirmed' => 'boolean',
    ];

    public function returnHeader()
    {
        return $this->belongsTo(ReturnHeader::class);
    }
    
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
