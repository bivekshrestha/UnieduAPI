<?php

namespace Database\Seeders;

use App\Models\Partners\Recruiter;
use App\Models\Partners\Staff;
use App\Models\Partners\Team;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RecruiterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $r_detail = [
            'country' => 'Nepal',
            'city' => 'Kathmandu'
        ];

        $r_user = [
            'first_name' => 'Amit',
            'last_name' => 'Tiwari',
            'email' => 'amit@tiwari.io',
        ];

        $item = Recruiter::create($r_detail);

        $team = Team::create([
            'recruiter_id' => $item->id,
            'name' => 'Admin',
            'description' => 'This is your default administrator/handler team.',
            'status' => true
        ]);

        $user = User::create($r_user);
        $role = Role::where('slug', '=', 'handler')->first();
        $permission = Permission::where('slug', '=', 'full')->first();

        $user->roles()->attach($role);
        $user->permissions()->attach($permission);

        $staff = Staff::create([
            'recruiter_id' => $item->id,
            'user_id' => $user->id,
        ]);

        $team->staffs()->attach($staff);


        $r_user = [
            'first_name' => 'Bivek',
            'last_name' => 'Shrestha',
            'email' => 'bivek@uniedu.io',
        ];

        $user = User::create($r_user);
        $role = Role::where('slug', '=', 'handler')->first();
        $permission = Permission::where('slug', '=', 'full')->first();

        $user->roles()->attach($role);
        $user->permissions()->attach($permission);

        $staff = Staff::create([
            'recruiter_id' => $item->id,
            'user_id' => $user->id,
        ]);

        $team->staffs()->attach($staff);
    }
}
