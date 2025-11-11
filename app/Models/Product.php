<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        "category_id",
        "brand_id",
        "name",
        "slug",
        "images",
        "description",
        "price",
        "is_active",
        "is_featured",
        "in_stock",
        "on_sale",
    ];

    protected $casts = [
        'images' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'in_stock' => 'boolean',
        'on_sale' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('in_stock', true);
    }

    public function scopeOnSale($query)
    {
        return $query->where('on_sale', true);
    }

    // Accessors
    public function getFirstImageAttribute()
    {
        return $this->images ? $this->images[0] : null;
    }

    public function getFormattedPriceAttribute()
    {
        return number_format((float) $this->price, 2) . ' €';
    }
}
