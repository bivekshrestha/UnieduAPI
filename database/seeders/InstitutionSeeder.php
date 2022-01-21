<?php

namespace Database\Seeders;

use App\Models\Partners\Institution;
use Illuminate\Database\Seeder;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $item = [
            'name' => 'John Wick University',
            'country' => 'UK',
            'route' => 'both',
            'email' => 'johnwick@uni.com',
            'address' => 'Fourth Street 405',
            'cities' => 'All',
            'url' => 'https://johnwick.com.edu.eu',
        ];

        Institution::create($item);
    }
}
