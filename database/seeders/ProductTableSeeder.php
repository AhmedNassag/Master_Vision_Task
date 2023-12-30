<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name'        => 'Product 1',
            'price'       => 100,
            'category_id' => 1, 
        ]);



        Product::create([
            'name'        => 'Product 2',
            'price'       => 200,
            'category_id' => 2,
        ]);


        
        Product::create([
            'name'        => 'Product 3',
            'price'       => 300,
            'category_id' => 3,
        ]);
    }
}
