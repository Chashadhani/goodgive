<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run Admin Seeder
        $this->call(AdminSeeder::class);
        
        // Run Help Categories Seeder
        $this->call(HelpCategorySeeder::class);
    }
}
