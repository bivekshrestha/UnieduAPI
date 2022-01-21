<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesSeeder::class,
            AdminSeeder::class,
            CountrySeeder::class,
            CategorySeeder::class,
            SubjectSeeder::class,
            IntakeSeeder::class,
            InstitutionSeeder::class,
            RecruiterSeeder::class
        ]);
    }
}
