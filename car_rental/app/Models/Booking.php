<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'car_id',
        'booking_number',
        'pickup_location',
        'dropoff_location',
        'pickup_date',
        'return_date',
        'days',
        'daily_rate',
        'total_amount',
        'tax_amount',
        'discount_amount',
        'final_amount',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'special_requirements',
        'extras',
        'status',
        'payment_status',
        'payment_method',
        'transaction_id',
        'confirmed_at',
        'cancelled_at',
        'completed_at',
        'admin_notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'pickup_date' => 'datetime',
        'return_date' => 'datetime',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'completed_at' => 'datetime',
        'extras' => 'array',
        'daily_rate' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
    ];

    /**
     * Get the user that owns the booking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the car that was booked.
     */
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Generate a unique booking number.
     */
    public static function generateBookingNumber(): string
    {
        do {
            $number = 'BK' . date('Y') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::where('booking_number', $number)->exists());

        return $number;
    }

    /**
     * Calculate the number of days between pickup and return.
     */
    public function calculateDays(): int
    {
        $pickup = Carbon::parse($this->pickup_date);
        $return = Carbon::parse($this->return_date);
        
        return max(1, $pickup->diffInDays($return));
    }

    /**
     * Calculate total amount based on daily rate and days.
     */
    public function calculateTotalAmount(): float
    {
        return $this->daily_rate * $this->days;
    }

    /**
     * Calculate final amount after tax and discount.
     */
    public function calculateFinalAmount(): float
    {
        return $this->total_amount + $this->tax_amount - $this->discount_amount;
    }

    /**
     * Check if booking is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if booking is confirmed.
     */
    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    /**
     * Check if booking is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Check if booking is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Get status badge color.
     */
    public function getStatusBadgeColor(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'confirmed' => 'info',
            'active' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Scope a query to only include active bookings.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include confirmed bookings.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope a query to only include pending bookings.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
