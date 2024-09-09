<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_subscription_plans')->insert([
            'id' => 1,
            'name' => 'free',
            'price' => 0,
            'max_table_count' => 20,
            'billing_cycle' => 'monthly',
        ]);

        DB::table('m_subscription_plans')->insert([
            'id' => 2,
            'name' => 'premium',
            'max_table_count' => 100,
            'price' => 5000,
            'billing_cycle' => 'monthly',
        ]);

        DB::table('subscriptions')->insert([
            'tenant_id' => 1,
            'subscription_plan_id' => 1,
            'start_date' => '2024-09-01',
            'next_billing_date' => '2024-10-01',
        ]);
    }
}
