<?php

namespace Database\Seeders;

use Database\Seeders\API\UserSeeder;
use Database\Seeders\API\CategorySeeder;
use Database\Seeders\API\ProductSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class
        ]);
    }
}
