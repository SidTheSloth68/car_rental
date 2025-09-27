<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'make',
        'model',
        'year',
        'type',
        'fuel_type',
        'transmission',
        'seats',
        'doors',
        'luggage_capacity',
        'daily_rate',
        'weekly_rate',
        'monthly_rate',
        'mileage',
        'color',
        'license_plate',
        'vin',
        'engine_size',
        'horsepower',
        'image',
        'gallery',
        'features',
        'description',
        'is_available',
        'is_featured',
        'location',
        'pickup_locations',
        'insurance_included',
        'minimum_age',
        'deposit_amount',
        'cancellation_policy',
        'total_bookings',
        'average_rating',
        'likes_count'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'year' => 'integer',
        'seats' => 'integer',
        'doors' => 'integer',
        'daily_rate' => 'decimal:2',
        'weekly_rate' => 'decimal:2',
        'monthly_rate' => 'decimal:2',
        'mileage' => 'integer',
        'engine_size' => 'decimal:1',
        'horsepower' => 'integer',
        'gallery' => 'array',
        'features' => 'array',
        'pickup_locations' => 'array',
        'is_available' => 'boolean',
        'is_featured' => 'boolean',
        'insurance_included' => 'boolean',
        'minimum_age' => 'integer',
        'deposit_amount' => 'decimal:2',
        'total_bookings' => 'integer',
        'average_rating' => 'decimal:2',
        'likes_count' => 'integer',
        'deleted_at' => 'datetime'
    ];

    /**
     * Car types enum values
     */
    const CAR_TYPES = [
        'economy' => 'Economy',
        'compact' => 'Compact',
        'standard' => 'Standard',
        'intermediate' => 'Intermediate',
        'full_size' => 'Full Size',
        'premium' => 'Premium',
        'luxury' => 'Luxury',
        'suv' => 'SUV',
        'minivan' => 'Minivan',
        'convertible' => 'Convertible',
        'sports_car' => 'Sports Car',
        'truck' => 'Truck',
        'van' => 'Van',
        'exotic' => 'Exotic'
    ];

    /**
     * Fuel types enum values
     */
    const FUEL_TYPES = [
        'petrol' => 'Petrol',
        'diesel' => 'Diesel',
        'hybrid' => 'Hybrid',
        'electric' => 'Electric',
        'lpg' => 'LPG'
    ];

    /**
     * Transmission types enum values
     */
    const TRANSMISSION_TYPES = [
        'manual' => 'Manual',
        'automatic' => 'Automatic',
        'cvt' => 'CVT'
    ];

    /**
     * Get the car's full name (make + model + year)
     */
    public function getFullNameAttribute(): string
    {
        return $this->year . ' ' . $this->make . ' ' . $this->model;
    }

    /**
     * Get the car's primary image URL
     */
    public function getImageUrlAttribute(): string
    {
        return asset('images/cars/' . ($this->image ?: 'default-car.jpg'));
    }

    /**
     * Get the car's gallery images URLs
     */
    public function getGalleryUrlsAttribute(): array
    {
        if (!$this->gallery || !is_array($this->gallery)) {
            return [];
        }

        return array_map(function ($image) {
            return asset('images/cars/' . $image);
        }, $this->gallery);
    }

    /**
     * Scope to get available cars
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope to get featured cars
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope to filter by car type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to filter by price range
     */
    public function scopePriceRange($query, $min, $max = null)
    {
        $query->where('daily_rate', '>=', $min);
        
        if ($max) {
            $query->where('daily_rate', '<=', $max);
        }
        
        return $query;
    }

    /**
     * Scope to search cars by make, model, or type
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('make', 'like', '%' . $search . '%')
              ->orWhere('model', 'like', '%' . $search . '%')
              ->orWhere('type', 'like', '%' . $search . '%');
        });
    }

    /**
     * Get bookings for this car
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get reviews for this car
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get users who liked this car
     */
    public function likedBy()
    {
        return $this->belongsToMany(User::class, 'car_likes')->withTimestamps();
    }

    /**
     * Check if car is available for given date range
     */
    public function isAvailableForDates($startDate, $endDate): bool
    {
        if (!$this->is_available) {
            return false;
        }

        // Check for conflicting bookings
        $conflictingBookings = $this->bookings()
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('pickup_date', [$startDate, $endDate])
                      ->orWhereBetween('return_date', [$startDate, $endDate])
                      ->orWhere(function ($q) use ($startDate, $endDate) {
                          $q->where('pickup_date', '<=', $startDate)
                            ->where('return_date', '>=', $endDate);
                      });
            })
            ->exists();

        return !$conflictingBookings;
    }

    /**
     * Calculate total price for given number of days
     */
    public function calculatePrice($days, $discountCode = null): array
    {
        $basePrice = $this->daily_rate * $days;
        $discount = 0;
        $tax = $basePrice * 0.1; // 10% tax
        
        // Apply weekly/monthly discounts
        if ($days >= 30) {
            $basePrice = $this->monthly_rate ?: ($this->daily_rate * $days * 0.8);
        } elseif ($days >= 7) {
            $basePrice = $this->weekly_rate ?: ($this->daily_rate * $days * 0.9);
        }

        // Apply discount code logic (to be implemented)
        if ($discountCode) {
            // Discount code logic will be implemented later
        }

        $totalPrice = $basePrice - $discount + $tax;

        return [
            'base_price' => $basePrice,
            'discount' => $discount,
            'tax' => $tax,
            'total_price' => $totalPrice,
            'daily_rate' => $this->daily_rate,
            'days' => $days
        ];
    }

    /**
     * Accessor for price_per_day to map to daily_rate
     */
    public function getPricePerDayAttribute()
    {
        return $this->daily_rate;
    }

    /**
     * Accessor for images to provide gallery or image
     */
    public function getImagesAttribute()
    {
        if ($this->gallery && is_array($this->gallery) && count($this->gallery) > 0) {
            return $this->gallery;
        } elseif ($this->image) {
            return [$this->image];
        }
        return [];
    }

    /**
     * Accessor for car_type to map to type
     */
    public function getCarTypeAttribute()
    {
        return $this->type;
    }
}
