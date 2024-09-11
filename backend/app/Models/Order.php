<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Order extends Model
{
    use HasFactory;

    const STATUS_OPEN = 'open';
    const STATUS_PAID = 'paid';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'tenant_id',
        'table_number',
        'total_price',
        'status',
    ];

    protected $casts = [
        'total_price' => 'integer',
    ];

    public function update_total_price(): void
    {
        $total_price = 0;
        foreach ($this->order_items as $order_item) {
            if ($order_item->status === OrderItem::STATUS_CANCELLED) {
                continue;
            }
            $total_price += $order_item->sub_total;
        }
        $this->total_price = $total_price;
        $this->save();
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
