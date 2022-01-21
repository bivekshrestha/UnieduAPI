<?php

namespace Database\Seeders;

use App\Models\Generals\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['label' => 'Intro'],
            ['label' => 'Plans'],
            ['label' => 'Work Flow'],
        ];

        foreach ($items as $item) {
            Category::create($item);
        }
    }
}
