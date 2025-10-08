<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'order_date' => 'datetime',
        'rental_start' => 'date',
        'rental_end' => 'date',
        'total_price' => 'decimal:2',
        // 'delivery_fee' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function productRentals(): HasMany
    {
        return $this->hasMany(ProductRental::class);
    }

    public static function getStatusOptions(): array
    {
        return [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'ongoing' => 'On Going',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];
    }

    public static function getStatusClasses(): array
    {
        return [
            'pending' => 'primary',
            'confirmed' => 'info',
            'ongoing' => 'warning',
            'completed' => 'success',
            'cancelled' => 'danger',
        ];
    }

    public function getStatusLabel(): string
    {
        return self::getStatusOptions()[$this->status] ?? ucfirst($this->status);
    }

    public function getStatusClass(): string
    {
        return self::getStatusClasses()[$this->status] ?? 'secondary';
    }

    public static function getPaymentStatusOptions(): array
    {
        return [
            'unpaid'   => 'Unpaid',
            'pending'  => 'Pending',
            'paid'     => 'Paid',
            'failed'   => 'Failed',
            'expired'  => 'Expired',
            'refunded' => 'Refunded',
        ];
    }

    public static function getPaymentStatusClasses(): array
    {
        return [
            'unpaid'   => 'primary',
            'pending'  => 'warning',
            'paid'     => 'success',
            'failed'   => 'danger',
            'expired'  => 'dark',
            'refunded' => 'info',
        ];
    }

    public function getPaymentStatusLabel(): string
    {
        return self::getPaymentStatusOptions()[$this->payment_status] ?? ucfirst($this->payment_status);
    }

    public function getPaymentStatusClass(): string
    {
        return self::getPaymentStatusClasses()[$this->payment_status] ?? 'secondary';
    }
}
