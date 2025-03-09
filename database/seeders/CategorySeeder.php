<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()->withName('Power Tools')->create();
        Category::factory()->withName('Household')->create();
        Category::factory()->withName('Electronic')->create();
        Category::factory()->withName('Kitchen')->create();
        Category::factory()->withName('Film and Music')->create();
    }
}
