<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::create([
            'user_id' => '2', 
        ]);



        Customer::create([
            'user_id' => '3',
        ]);



        Customer::create([
            'user_id' => '3',
        ]);
    }
}
