<?php

namespace Database\Seeders;

use App\Models\Partners\Intake;
use Illuminate\Database\Seeder;

class IntakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['label' => 'January'],
            ['label' => 'February'],
            ['label' => 'March'],
            ['label' => 'April'],
            ['label' => 'May'],
            ['label' => 'June'],
            ['label' => 'July'],
            ['label' => 'August'],
            ['label' => 'September'],
            ['label' => 'October'],
            ['label' => 'November'],
            ['label' => 'December'],
        ];

        foreach ($items as $item) {
            Intake::create($item);
        }
    }
}
