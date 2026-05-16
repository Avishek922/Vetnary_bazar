<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory, \App\Traits\HasHashId;

    protected $fillable = ['user_id', 'product_id', 'quantity', 'size'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getPriceAttribute()
    {
        if ($this->size) {
            return $this->product->getOfferPriceForSize($this->size);
        }
        return $this->product->sell_price;
    }

    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}
