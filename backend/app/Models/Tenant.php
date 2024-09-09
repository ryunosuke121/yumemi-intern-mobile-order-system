<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Tenant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'table_count',
        'deleted_at',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function currentSubscriptionPlan(): ?MSubscriptionPlan
    {
        $subscriptions = $this->subscriptions;
        foreach ($subscriptions as $subscription) {
            if ($subscription->start_date < now() && (null === $subscription->end_date || $subscription->end_date > now())) {
                return $subscription->subscriptionPlan;
            }
        }
        return null;
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function staffs(): HasMany
    {
        return $this->hasMany(Staff::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
