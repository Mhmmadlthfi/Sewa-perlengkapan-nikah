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
            ['name' => 'Dekorasi & Panggung'],
            ['name' => 'Sound System & Elektronik'],
            ['name' => 'Furniture'],
            ['name' => 'Peralatan Makan'],
            ['name' => 'Peralatan Dapur & Catering'],
            ['name' => 'Peralatan Minuman'],
            ['name' => 'Peralatan Tambahan'],
            ['name' => 'Kategori Demo'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
