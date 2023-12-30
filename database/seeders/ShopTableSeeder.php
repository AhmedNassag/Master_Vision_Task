<?php

namespace Database\Seeders;

use App\Models\Shop;
use Illuminate\Database\Seeder;

class ShopTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shop::create([
            'name' => 'Shop 1', 
        ]);



        Shop::create([
            'name' => 'Shop 2',
        ]);



        Shop::create([
            'name' => 'Shop 3',
        ]);
    }
}
