<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

final class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tenants')->insert([
            'id' => 1,
            'name' => 'test tenant1',
            'email' => 'tenant1@example.com',
            'table_count' => 10,
        ]);

        DB::table('staffs')->insert([
            'tenant_id' => 1,
            'name' => 'test staff1',
            'email' => 'staff1@example.com',
            'password_hash' => Hash::make('password'),
        ]);
    }
}
