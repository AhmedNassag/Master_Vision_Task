<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Category 1', 
        ]);

        Category::create([
            'name' => 'Category 2',
        ]);

        Category::create([
            'name' => 'Category 3',
        ]);



        Category::create([
            'name'      => 'Category 4',
            'parent_id' => '1', 
        ]);

        Category::create([
            'name'      => 'Category 5',
            'parent_id' => '2',
        ]);

        Category::create([
            'name'      => 'Category 6',
            'parent_id' => '3',
        ]);
    }
}
