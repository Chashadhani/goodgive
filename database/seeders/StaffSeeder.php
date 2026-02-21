<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'staff@goodgive.com'],
            [
                'name' => 'Staff Member',
                'email' => 'staff@goodgive.com',
                'password' => Hash::make('staff123456'),
                'user_type' => User::TYPE_STAFF,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff2@goodgive.com'],
            [
                'name' => 'Jane Staff',
                'email' => 'staff2@goodgive.com',
                'password' => Hash::make('staff123456'),
                'user_type' => User::TYPE_STAFF,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Staff users created successfully!');
        $this->command->info('Email: staff@goodgive.com / Password: staff123456');
        $this->command->info('Email: staff2@goodgive.com / Password: staff123456');
    }
}
