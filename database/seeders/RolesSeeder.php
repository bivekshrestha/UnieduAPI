<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['title' => 'Super Admin'],
            ['title' => 'Regional Admin'],
            ['title' => 'Country Admin'],
            ['title' => 'Handler'],
            ['title' => 'Recruiter'],
            ['title' => 'Staff'],
            ['title' => 'Partner'],
            ['title' => 'Student'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        $permissions = [
            ['title' => 'Full'],
            ['title' => 'Partial']
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
