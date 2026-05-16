<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, \App\Traits\HasHashId;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'buying_price',
        'stock',
        'category_id',
        'images',
        'specifications',
        'is_active',
        'sizes',
        'offer_price',
        'offer_start_date',
        'offer_end_date',
        'offer_discount_percentage'
    ];

    protected $casts = [
        'images' => 'array',
        'specifications' => 'array',
        'sizes' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'buying_price' => 'decimal:2',
        'offer_price' => 'decimal:2',
        'offer_start_date' => 'datetime',
        'offer_end_date' => 'datetime',
        'offer_discount_percentage' => 'integer'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Helper to check if offer is active
    public function hasActiveOffer()
    {
        if (!$this->offer_discount_percentage && !$this->offer_price) return false;
        
        $now = now();
        
        if ($this->offer_start_date && $now->lt($this->offer_start_date)) return false;
        if ($this->offer_end_date && $now->gt($this->offer_end_date)) return false;
        
        return true;
    }

    // Get first/base price (for listing pages)
    public function getFirstPriceAttribute()
    {
        if ($this->hasSizePricing()) {
            return $this->sizes[0]['price'] ?? $this->price;
        }
        return $this->price;
    }

    // Check if product has size-based pricing
    public function hasSizePricing()
    {
        return is_array($this->sizes) && count($this->sizes) > 0 && isset($this->sizes[0]['price']);
    }

    // Get price for a specific size
    public function getPriceForSize($size)
    {
        if ($this->hasSizePricing()) {
            foreach ($this->sizes as $sizeData) {
                if ($sizeData['size'] === $size) {
                    return $sizeData['price'];
                }
            }
        }
        return $this->price;
    }

    // Get offer price for a specific size
    public function getOfferPriceForSize($size)
    {
        $basePrice = $this->getPriceForSize($size);
        
        if (!$this->hasActiveOffer()) {
            return $basePrice;
        }

        // Priority 1: Use explicit percentage if set
        if ($this->offer_discount_percentage) {
            return $basePrice * (1 - $this->offer_discount_percentage / 100);
        }
        
        // Priority 2: If fixed offer price is set, apply implied discount percentage across all sizes
        if ($this->offer_price && $this->first_price > 0) {
            $impliedDiscount = ($this->first_price - $this->offer_price) / $this->first_price;
            return $basePrice * (1 - $impliedDiscount);
        }

        return $basePrice;
    }

    // Get current selling price (first size or base)
    public function getSellPriceAttribute()
    {
        $firstSize = isset($this->sizes[0]['size']) ? $this->sizes[0]['size'] : null;
        return $this->getOfferPriceForSize($firstSize);
    }
    
    // Calculate discount percentage
    public function getDiscountPercentageAttribute()
    {
        if ($this->hasActiveOffer() && $this->offer_discount_percentage) {
            return $this->offer_discount_percentage;
        }
        if ($this->hasActiveOffer() && $this->offer_price && $this->first_price > 0) {
            return round((($this->first_price - $this->offer_price) / $this->first_price) * 100);
        }
        return 0;
    }
}
