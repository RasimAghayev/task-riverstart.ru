<?php

namespace Database\Seeders\API;

use App\Models\API\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()
            ->times(50)
            ->create();
    }
}
