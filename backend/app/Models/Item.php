<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Item extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'name',
        'description',
        's3_key',
        'cost_price',
        'tax_rate_id',
        'deleted_at',
    ];

    protected $casts = [
        'cost_price' => 'integer',
        'deleted_at' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function taxRate()
    {
        return $this->belongsTo(MTaxRate::class);
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
