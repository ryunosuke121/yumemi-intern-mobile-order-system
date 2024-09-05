<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
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

    public function currentSubscriptionPlan()
    {
        $subscriptions = $this->subscriptions;
        foreach ($subscriptions as $subscription) {
            if ($subscription->start_date < now() && (is_null($subscription->end_date) || $subscription->end_date > now())) {
                return $subscription->subscriptionPlan;
            }
        }
        return null;
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function staffs()
    {
        return $this->hasMany(Staff::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
