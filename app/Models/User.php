<?php

namespace App\Models;

use App\Models\Partners\Staff;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'password', 'remember_token', 'updated_at', 'created_at', 'email_verified_at'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = $value;
        $this->attributes['password'] = bcrypt($value . '@123');
    }

    /**
     * returns full name of admin
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * @param $email
     * @return Builder|Model|object|null
     */
    public static function withRolesSlug($email)
    {
        $user = User::with('roles')->where('email', $email)->first();
        if ($user) {
            $roles = [];
            foreach ($user->roles as $role) {
                array_push($roles, $role->slug);
            }
            unset($user->roles);
            $user->roles = implode(',', $roles);
        }

        return $user;
    }

    /**
     * @return BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)
            ->select('id', 'slug');
    }

    /**
     * @return BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class)
            ->select('id', 'slug');
    }

    /**
     * @return HasOne
     */
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    /**
     * @return HasOne
     */
    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    /**
     * every user has one profile picture
     * @return MorphOne
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
