<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tenants')->insert([
            'id' => 1,
            'name' => 'test tenant1',
            'email' => 'tenant1@test.com',
            'table_count' => 10,
        ]);

        DB::table('staffs')->insert([
            'tenant_id' => 1,
            'name' => 'test staff1',
            'email' => 'staff1@test.com',
            'password_hash' => Hash::make('password'),
        ]);
    }
}
