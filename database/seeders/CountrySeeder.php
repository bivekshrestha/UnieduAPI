<?php

namespace Database\Seeders;

use App\Imports\CountryImport;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $collection = Excel::toCollection(new CountryImport, public_path('imports/') . 'countries.xlsx');
        $temp = $collection[0];
        $countries = $temp->filter(function ($item) {
            if ($item['label'] != null) {
                return $item;
            }
        });

        foreach ($countries as $country) {
            Country::create([
                'label' => trim($country['label']),
                'phone_code' => trim($country['phone_code']),
                'iso_code' => trim($country['iso_code'])
            ]);
        }
    }
}
