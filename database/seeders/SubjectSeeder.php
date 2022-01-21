<?php

namespace Database\Seeders;

use App\Models\Partners\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'Science'],
            ['name' => 'Management'],
            ['name' => 'Computer Science'],
            ['name' => 'Business and Finance'],
            ['name' => 'Arts'],
            ['name' => 'Health'],
            ['name' => 'Social Worker'],
        ];

        foreach ($items as $item) {
            Subject::create($item);
        }
    }
}
