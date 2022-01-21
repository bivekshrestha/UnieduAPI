<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        /**
         * Getting the origin of login request
         * Used to check which user to give access to
         */
        $url = $request->headers->get('origin');
//        $url = Str::replaceFirst('https://', '', $url);
        $url = Str::replaceFirst('http://', '', $url);

        /**
         * determining which user has sent the request
         */
//        $is_admin = Str::startsWith($url, 'admin');
//        $is_app = Str::startsWith($url, 'app');
//        $is_student = Str::startsWith($url, 'student');

        $is_admin = Str::contains($url, '3001');
        $is_app = Str::contains($url, '3000');
        $is_student = Str::contains($url, '3002');

        /**
         * retrieving requested user
         */
        $user = User::withRolesSlug($request->get('email'));
        /**
         * check if user exists
         */
        if ($user) {

            if(!$user->is_active){
                return response()->json([
                    'error' => 'Please verify or activate your account.'
                ], 403);
            }

            $type_check_pass = false;

            if ($is_admin) {
                $types = ['super-admin', 'country-admin', 'regional-admin'];
                if (Str::contains($user->roles, $types)) {
                    $type_check_pass = true;
                }
            }

            if ($is_app) {
                $types = ['partner', 'recruiter', 'staff', 'handler'];
                if (Str::contains($user->roles, $types)) {
                    $type_check_pass = true;
                }
            }

            if ($is_student) {
                $types = ['student'];
                if (Str::contains($user->roles, $types)) {
                    $type_check_pass = true;
                }
            }

            if ($type_check_pass && Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password'), 'is_active' => 1])) {
                return response()->json(true, 204);
            }
        }
        return response()->json([
            'error' => 'Invalid email address or password.'
        ], 403);

    }

    public function logout()
    {
        Auth::guard('web')->logout();

        return response()->json(true, 204);
    }

    public function user(Request $request)
    {
        $user = User::where('id', $request->user()->id)
            ->with('roles')
            ->with('permissions')
            ->with('staff')
            ->first();

        $roles = [];
        $permissions = [];

        foreach ($user->roles as $role) {
            array_push($roles, $role->slug);
        }

        if ($user->permissions) {
            foreach ($user->permissions as $permission) {
                array_push($permissions, $permission->slug);
            }
            unset($user->permissions);
            $user->permissions = $permissions;
        }

        unset($user->roles);
        $user->roles = $roles;

        return $user;
    }
}
