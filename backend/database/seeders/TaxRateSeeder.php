<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class TaxRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $taxRates = [
            [
                'tax_rate' => 1.0,
            ],
            [
                'tax_rate' => 1.08
            ],
            [
                'tax_rate' => 1.10
            ]
        ];

        foreach ($taxRates as $taxRate) {
            \App\Models\MTaxRate::create($taxRate);
        }
    }
}
