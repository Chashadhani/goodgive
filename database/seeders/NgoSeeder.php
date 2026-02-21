<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\NgoProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NgoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // NGO 1 - Verified
        $ngo1 = User::updateOrCreate(
            ['email' => 'ngo@goodgive.com'],
            [
                'name' => 'Hope Foundation',
                'email' => 'ngo@goodgive.com',
                'password' => Hash::make('ngo123456'),
                'user_type' => User::TYPE_NGO,
                'email_verified_at' => now(),
            ]
        );

        NgoProfile::updateOrCreate(
            ['user_id' => $ngo1->id],
            [
                'organization_name' => 'Hope Foundation Sri Lanka',
                'registration_number' => 'NGO-2025-001',
                'address' => '45 Galle Road, Colombo 03',
                'contact_person' => 'Kamal Perera',
                'phone' => '0112345678',
                'verification_status' => 'verified',
                'verified_at' => now(),
            ]
        );

        // NGO 2 - Verified
        $ngo2 = User::updateOrCreate(
            ['email' => 'ngo2@goodgive.com'],
            [
                'name' => 'Care Lanka',
                'email' => 'ngo2@goodgive.com',
                'password' => Hash::make('ngo123456'),
                'user_type' => User::TYPE_NGO,
                'email_verified_at' => now(),
            ]
        );

        NgoProfile::updateOrCreate(
            ['user_id' => $ngo2->id],
            [
                'organization_name' => 'Care Lanka Trust',
                'registration_number' => 'NGO-2025-002',
                'address' => '12 Kandy Road, Kandy',
                'contact_person' => 'Nimal Silva',
                'phone' => '0812345678',
                'verification_status' => 'verified',
                'verified_at' => now(),
            ]
        );

        // NGO 3 - Pending verification
        $ngo3 = User::updateOrCreate(
            ['email' => 'ngo3@goodgive.com'],
            [
                'name' => 'Green Future',
                'email' => 'ngo3@goodgive.com',
                'password' => Hash::make('ngo123456'),
                'user_type' => User::TYPE_NGO,
                'email_verified_at' => now(),
            ]
        );

        NgoProfile::updateOrCreate(
            ['user_id' => $ngo3->id],
            [
                'organization_name' => 'Green Future Organization',
                'registration_number' => 'NGO-2025-003',
                'address' => '78 Main Street, Galle',
                'contact_person' => 'Saman Kumara',
                'phone' => '0912345678',
                'verification_status' => 'pending',
            ]
        );

        $this->command->info('NGO users created successfully!');
        $this->command->info('Email: ngo@goodgive.com / Password: ngo123456 (Verified)');
        $this->command->info('Email: ngo2@goodgive.com / Password: ngo123456 (Verified)');
        $this->command->info('Email: ngo3@goodgive.com / Password: ngo123456 (Pending)');
    }
}
