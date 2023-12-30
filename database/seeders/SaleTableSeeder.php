<?php

namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Seeder;

class SaleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sale::create([
            'date'        => now()->format('Y-m-d'),
            'grandTotal'  => 1400,
            'discount'    => 0,
            'tax'         => 0,
            'customer_id' => 1, 
        ]);
    }
}
