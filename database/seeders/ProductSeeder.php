<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::all()->each(function (Category $category) {
            for ($i=1; $i <= 5 ; $i++) { 
                $category->products()->create([
                    'name' => "product $i of $category->name",
                    'price' => rand(1000, 10000)
                ]);
            }
        });
    }
}
