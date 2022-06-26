<?php

namespace Database\Seeders\API;

use App\Models\API\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()
            ->times(50)
            ->create();
    }
}
