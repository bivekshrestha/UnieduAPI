<?php

namespace App\Models\Partners;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staffs';

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * @return mixed
     */
    public static function selectData()
    {
        $items = Staff::with('user')
            ->select('id as value', 'user_id')
            ->get();

        $items = $items->each(function ($item) {
            $item->text = $item->user->first_name . ' ' . $item->user->last_name;
            unset($item->user);
            unset($item->user_id);
        });


        return $items;
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function selectDataByRecruiter($id)
    {
        $items = Staff::with('user')
            ->where('recruiter_id', $id)
            ->select('id as value', 'user_id')
            ->get();

        $items = $items->each(function ($item) {
            $item->text = $item->user->first_name . ' ' . $item->user->last_name;
            unset($item->user);
            unset($item->user_id);
        });


        return $items;
    }

    /**
     * @return BelongsTo
     */
    public function recruiter()
    {
        return $this->belongsTo(Recruiter::class);
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }
}
