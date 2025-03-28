<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class TransactionDetail extends Model
{
    protected $fillable = [
        'transaction_header_id',
        'item_id',
        'quantity',
        'quantity_return',
        'duration',
        'total_price',
    ];

    public function transactionHeader()
    {
        return $this->belongsTo(TransactionHeader::class);
    }
    
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
