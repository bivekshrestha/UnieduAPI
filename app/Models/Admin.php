<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Admin extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [ 'created_at', 'updated_at' ];

    protected $casts = [
        'user_id' => 'int'
    ];

    /**
     * @return Builder[]|Collection
     */
    public static function withFormatUser()
    {
        $data = Admin::with('user.roles')->get();
        foreach ($data as $item) {
            $roles = [];
            foreach ($item->user->roles as $role) {
                array_push($roles, $role->id);
            }
            unset($item->user->roles);
            $item->user->roles = $roles;
        }

        return $data;
    }

    /**
     * user relation
     * every admin belongs to one user for authentication
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
