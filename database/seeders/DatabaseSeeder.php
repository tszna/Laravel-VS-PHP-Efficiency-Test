<?php

namespace Database\Seeders;


use App\Models\User;
use App\Models\Car;
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
        User::factory()->count(10000)->create();
        for ($i=0; $i < 2; $i++) {
            Car::factory()->count(100000)->create();
        }
        
    }
}
