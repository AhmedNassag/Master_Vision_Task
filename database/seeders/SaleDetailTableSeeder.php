<?php

namespace Database\Seeders;

use App\Models\Sale_Detail;
use Illuminate\Database\Seeder;

class SaleDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sale_Detail::create([
            'quantity'   => 1,
            'unit_price' => 100,
            'product_id' => 1,
            'shop_id'    => 1,
            'sale_id'    => 1,
        ]);


        
        Sale_Detail::create([
            'quantity'   => 2,
            'unit_price' => 200,
            'product_id' => 2,
            'shop_id'    => 1,
            'sale_id'    => 1,
        ]);


        
        Sale_Detail::create([
            'quantity'   => 3,
            'unit_price' => 300,
            'product_id' => 3,
            'shop_id'    => 3,
            'sale_id'    => 1,
        ]);
    }
}
