<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        User::updateOrCreate(
            ['email' => 'admin@goodgive.com'],
            [
                'name' => 'Super Admin',
                'email' => 'admin@goodgive.com',
                'password' => Hash::make('admin123456'),
                'user_type' => User::TYPE_ADMIN,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@goodgive.com');
        $this->command->info('Password: admin123456');
        $this->command->warn('Please change the password after first login!');
    }
}
