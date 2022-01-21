<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'Bivek',
            'last_name' => 'Shrestha',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'is_active' => true
        ]);

        $role = Role::where('slug', 'super-admin')->first();

        $user->roles()->attach($role->id);

        $data = [
            'primary_number' => '9869110044',
            'position' => 'Developer',
            'country' => 'Nepal',
        ];

        $admin = new Admin($data);
        $user->admin()->save($admin);
    }
}
