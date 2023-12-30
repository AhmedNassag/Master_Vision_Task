<?php

namespace Database\Seeders;

use App\Models\ShopProduct;
use Illuminate\Database\Seeder;

class ShopProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShopProduct::create([
            'quantity'   => 10,
            'shop_id'    => 1,
            'product_id' => 1, 
        ]);

        ShopProduct::create([
            'quantity'   => 20,
            'shop_id'    => 1,
            'product_id' => 2,
        ]);

        ShopProduct::create([
            'quantity'   => 30,
            'shop_id'    => 1,
            'product_id' => 3,
        ]);


        
        ShopProduct::create([
            'quantity'   => 100,
            'shop_id'    => 2,
            'product_id' => 1, 
        ]);

        ShopProduct::create([
            'quantity'   => 200,
            'shop_id'    => 2,
            'product_id' => 2,
        ]);

        ShopProduct::create([
            'quantity'   => 300,
            'shop_id'    => 2,
            'product_id' => 3,
        ]);
    }
}
