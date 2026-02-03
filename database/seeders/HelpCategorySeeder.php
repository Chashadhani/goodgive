<?php

namespace Database\Seeders;

use App\Models\HelpCategory;
use Illuminate\Database\Seeder;

class HelpCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Education',
                'slug' => 'education',
                'icon' => '📚',
                'description' => 'School fees, books, supplies, and educational support',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Healthcare',
                'slug' => 'healthcare',
                'icon' => '🏥',
                'description' => 'Medical treatment, medicine, and healthcare expenses',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Shelter',
                'slug' => 'shelter',
                'icon' => '🏠',
                'description' => 'Housing, rent assistance, and home repairs',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Food Security',
                'slug' => 'food',
                'icon' => '🍚',
                'description' => 'Food supplies, groceries, and nutrition support',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Clothing',
                'slug' => 'clothing',
                'icon' => '👕',
                'description' => 'Clothes, footwear, and essential garments',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Emergency Relief',
                'slug' => 'emergency',
                'icon' => '🚨',
                'description' => 'Disaster relief, crisis support, and urgent assistance',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Livelihood',
                'slug' => 'livelihood',
                'icon' => '💼',
                'description' => 'Business support, job assistance, and income generation',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Other',
                'slug' => 'other',
                'icon' => '📋',
                'description' => 'Other types of assistance not listed above',
                'is_active' => true,
                'sort_order' => 99,
            ],
        ];

        foreach ($categories as $category) {
            HelpCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        $this->command->info('Help categories seeded successfully!');
    }
}
