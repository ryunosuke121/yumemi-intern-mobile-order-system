<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSubscriptionPlan extends Model
{
    use HasFactory;

    const BILLING_CYCLE_MONTHLY = 'monthly';
    const BILLING_CYCLE_ANNUAL = 'annual';

    public static function getBillingCycles(): array
    {
        return [
            self::BILLING_CYCLE_MONTHLY,
            self::BILLING_CYCLE_ANNUAL,
        ];
    }

    protected $fillable = [
        'name',
        'price',
        'billing_cycle',
    ];

    protected $casts = [
        'price' => 'integer',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
