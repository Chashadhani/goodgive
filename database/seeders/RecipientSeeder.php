<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\RecipientProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RecipientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Recipient 1 - Approved
        $recipient1 = User::updateOrCreate(
            ['email' => 'recipient@goodgive.com'],
            [
                'name' => 'Kumari Wijesekara',
                'email' => 'recipient@goodgive.com',
                'password' => Hash::make('recipient123456'),
                'user_type' => User::TYPE_USER,
                'email_verified_at' => now(),
            ]
        );

        RecipientProfile::updateOrCreate(
            ['user_id' => $recipient1->id],
            [
                'phone' => '0711112222',
                'location' => 'Colombo 15',
                'need_category' => 'education',
                'description' => 'Single mother needing support for children\'s education. Two children attending government school.',
                'status' => 'approved',
                'approved_at' => now(),
            ]
        );

        // Recipient 2 - Approved
        $recipient2 = User::updateOrCreate(
            ['email' => 'recipient2@goodgive.com'],
            [
                'name' => 'Sunil Bandara',
                'email' => 'recipient2@goodgive.com',
                'password' => Hash::make('recipient123456'),
                'user_type' => User::TYPE_USER,
                'email_verified_at' => now(),
            ]
        );

        RecipientProfile::updateOrCreate(
            ['user_id' => $recipient2->id],
            [
                'phone' => '0723334444',
                'location' => 'Matara',
                'need_category' => 'healthcare',
                'description' => 'Elderly person requiring medical assistance for ongoing treatment.',
                'status' => 'approved',
                'approved_at' => now(),
            ]
        );

        // Recipient 3 - Pending
        $recipient3 = User::updateOrCreate(
            ['email' => 'recipient3@goodgive.com'],
            [
                'name' => 'Dilani Perera',
                'email' => 'recipient3@goodgive.com',
                'password' => Hash::make('recipient123456'),
                'user_type' => User::TYPE_USER,
                'email_verified_at' => now(),
            ]
        );

        RecipientProfile::updateOrCreate(
            ['user_id' => $recipient3->id],
            [
                'phone' => '0745556677',
                'location' => 'Anuradhapura',
                'need_category' => 'food',
                'description' => 'Family of five affected by floods, in need of food and basic supplies.',
                'status' => 'pending',
            ]
        );

        $this->command->info('Recipient users created successfully!');
        $this->command->info('Email: recipient@goodgive.com / Password: recipient123456 (Approved)');
        $this->command->info('Email: recipient2@goodgive.com / Password: recipient123456 (Approved)');
        $this->command->info('Email: recipient3@goodgive.com / Password: recipient123456 (Pending)');
    }
}
