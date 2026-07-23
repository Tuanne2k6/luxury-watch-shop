<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_code', 'customer_name', 'customer_email',
        'customer_phone', 'customer_address',
        'total_amount', 'shipping_fee', 'status', 'note',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateCode(): string
    {
        return 'LW' . strtoupper(uniqid());
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'shipping'  => 'Đang giao hàng',
            'delivered' => 'Đã giao',
            'cancelled' => 'Đã huỷ',
            default     => $this->status,
        };
    }
}
