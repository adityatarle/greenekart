<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AgricultureProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'sale_price',
        'dealer_price',
        'dealer_sale_price',
        'dealer_discount_percentage',
        'bulk_pricing_tiers',
        'dealer_min_quantity',
        'is_dealer_exclusive',
        'dealer_notes',
        'sku',
        'stock_quantity',
        'manage_stock',
        'in_stock',
        'weight',
        'dimensions',
        'images',
        'featured_image',
        'primary_image',
        'gallery_images',
        'specifications',
        'is_featured',
        'is_active',
        'brand',
        'model',
        'power_source',
        'warranty',
        'agriculture_category_id',
        'agriculture_subcategory_id',
        'brand_id'
    ];

    protected $casts = [
        'images' => 'array',
        'gallery_images' => 'array',
        'bulk_pricing_tiers' => 'array',
        'specifications' => 'array',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'dealer_price' => 'decimal:2',
        'dealer_sale_price' => 'decimal:2',
        'dealer_discount_percentage' => 'decimal:2',
        'weight' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'in_stock' => 'boolean',
        'manage_stock' => 'boolean',
        'is_dealer_exclusive' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
        
        static::updating(function ($product) {
            // Ensure slug exists when updating, especially if name changed
            if (empty($product->slug) || ($product->isDirty('name') && empty($product->slug))) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    /**
     * Get the route key for the model.
     * This allows route model binding to use 'slug' instead of 'id'
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the value of the model's route key.
     * Falls back to ID if slug is null or empty (for backward compatibility)
     */
    public function getRouteKey()
    {
        $slug = $this->getAttribute('slug');
        $id = $this->getKey();
        
        // Return slug if it exists and is not empty, otherwise return ID
        return (!empty($slug)) ? $slug : $id;
    }

    /**
     * Retrieve the model for route model binding.
     * Handles both slug and ID for backward compatibility
     */
    public function resolveRouteBinding($value, $field = null)
    {
        // If field is explicitly set, use it
        if ($field && $field !== 'slug') {
            return $this->where($field, $value)->first();
        }

        // Try to find by slug first
        $product = $this->where('slug', $value)->first();
        
        // If not found and value is numeric, try ID as fallback
        if (!$product && is_numeric($value)) {
            $product = $this->where('id', $value)->first();
        }
        
        return $product;
    }

    public function category()
    {
        return $this->belongsTo(AgricultureCategory::class, 'agriculture_category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(AgricultureSubcategory::class, 'agriculture_subcategory_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function orderItems()
    {
        return $this->hasMany(AgricultureOrderItem::class, 'agriculture_product_id');
    }

    public function getCurrentPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    /**
     * Get the current dealer price (dealer sale price or dealer price)
     */
    public function getCurrentDealerPriceAttribute()
    {
        return $this->dealer_sale_price ?? $this->dealer_price;
    }

    /**
     * Get the appropriate price based on user role
     */
    public function getPriceForUser($user = null)
    {
        if ($user && $user->canAccessDealerPricing() && $this->dealer_price) {
            return $this->getCurrentDealerPriceAttribute();
        }
        
        return $this->getCurrentPriceAttribute();
    }

    /**
     * Get bulk pricing for quantity
     */
    public function getBulkPriceForQuantity($quantity, $user = null)
    {
        $basePrice = $this->getPriceForUser($user);
        
        if ($this->bulk_pricing_tiers && is_array($this->bulk_pricing_tiers)) {
            foreach ($this->bulk_pricing_tiers as $tier) {
                if ($quantity >= $tier['min_quantity']) {
                    return $tier['price'];
                }
            }
        }
        
        return $basePrice;
    }

    /**
     * Check if user can see dealer pricing
     */
    public function canUserSeeDealerPricing($user = null)
    {
        return $user && $user->canAccessDealerPricing();
    }

    /**
     * Get discount percentage for dealer pricing
     */
    public function getDealerDiscountPercentageAttribute()
    {
        if ($this->dealer_price && $this->price) {
            return round((($this->price - $this->dealer_price) / $this->price) * 100);
        }
        return 0;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->sale_price && $this->sale_price < $this->price) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

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

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('agriculture_category_id', $categoryId);
    }

    public function scopeBySubcategory($query, $subcategoryId)
    {
        return $query->where('agriculture_subcategory_id', $subcategoryId);
    }

    public function scopeByBrand($query, $brand)
    {
        return $query->where('brand', $brand);
    }

    public function scopeByPowerSource($query, $powerSource)
    {
        return $query->where('power_source', $powerSource);
    }
}