<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class OrderItem extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'order_id',
        'item_id',
        'tax_rate',
        'cost_price',
        'quantity',
        'sub_total',
        'status',
    ];

    protected $casts = [
        'cost_price' => 'integer',
        'quantity' => 'integer',
        'sub_total' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
