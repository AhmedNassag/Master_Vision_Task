<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionTableSeeder::class);
        $this->call(CreateAdminUserSeeder::class);

        $this->call(UserTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(ShopTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(ShopProductTableSeeder::class);
        $this->call(SaleTableSeeder::class);
        $this->call(SaleDetailTableSeeder::class);
    }
}
