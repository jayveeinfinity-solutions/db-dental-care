<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Preventive',
            'Diagnostic',
            'Add-ons',
            'Restorative',
            'Prosthodontics',
            'Pediatric Dentistry',
            'Orthodontics',
            'Oral Surgery',
            'Implantology',
            'Endodontics',
            'Special Prosthetics',
            'Administrative',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category]);
        }
    }
}
