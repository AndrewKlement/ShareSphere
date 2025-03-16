<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Item extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'description',
        'price',
        'stock',
        'user_id'
    ];

    public function item_images(): HasMany
    {
        return $this->hasMany(ItemImage::class);
    }    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shippingDetail()
    {
        return $this->hasOneThrough(ShippingDetail::class, User::class, 'id', 'user_id', 'user_id', 'id');
    }
}
