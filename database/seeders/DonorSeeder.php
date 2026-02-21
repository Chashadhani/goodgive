<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\DonorProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DonorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Donor 1
        $donor1 = User::updateOrCreate(
            ['email' => 'donor@goodgive.com'],
            [
                'name' => 'Amal Fernando',
                'email' => 'donor@goodgive.com',
                'password' => Hash::make('donor123456'),
                'user_type' => User::TYPE_DONOR,
                'email_verified_at' => now(),
            ]
        );

        DonorProfile::updateOrCreate(
            ['user_id' => $donor1->id],
            [
                'phone' => '0771234567',
                'address' => '23 Lake Drive, Colombo 07',
                'total_donated' => 15000.00,
                'donation_count' => 5,
            ]
        );

        // Donor 2
        $donor2 = User::updateOrCreate(
            ['email' => 'donor2@goodgive.com'],
            [
                'name' => 'Priya Jayawardena',
                'email' => 'donor2@goodgive.com',
                'password' => Hash::make('donor123456'),
                'user_type' => User::TYPE_DONOR,
                'email_verified_at' => now(),
            ]
        );

        DonorProfile::updateOrCreate(
            ['user_id' => $donor2->id],
            [
                'phone' => '0769876543',
                'address' => '56 Hill Street, Kandy',
                'total_donated' => 8500.00,
                'donation_count' => 3,
            ]
        );

        // Donor 3 - New donor with no donations yet
        $donor3 = User::updateOrCreate(
            ['email' => 'donor3@goodgive.com'],
            [
                'name' => 'Ruwan De Silva',
                'email' => 'donor3@goodgive.com',
                'password' => Hash::make('donor123456'),
                'user_type' => User::TYPE_DONOR,
                'email_verified_at' => now(),
            ]
        );

        DonorProfile::updateOrCreate(
            ['user_id' => $donor3->id],
            [
                'phone' => '0755556666',
                'address' => '9 Beach Road, Negombo',
                'total_donated' => 0,
                'donation_count' => 0,
            ]
        );

        $this->command->info('Donor users created successfully!');
        $this->command->info('Email: donor@goodgive.com / Password: donor123456');
        $this->command->info('Email: donor2@goodgive.com / Password: donor123456');
        $this->command->info('Email: donor3@goodgive.com / Password: donor123456');
    }
}
