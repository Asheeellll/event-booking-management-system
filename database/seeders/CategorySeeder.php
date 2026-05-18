<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

/**
 * CATEGORY SEEDER
 * ---------------
 * Creates 5 event categories.
 * Categories are used to filter and group events.
 * The 'slug' is the URL-friendly version of the name.
 */
class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Define 5 realistic event categories
        $categories = [
            ['name' => 'Technology',   'slug' => 'technology'],
            ['name' => 'Music',        'slug' => 'music'],
            ['name' => 'Sports',       'slug' => 'sports'],
            ['name' => 'Business',     'slug' => 'business'],
            ['name' => 'Education',    'slug' => 'education'],
        ];

        // Loop through and insert each category into the database
        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('✅ 5 Categories seeded.');
    }
}
