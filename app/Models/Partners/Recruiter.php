<?php

namespace App\Models\Partners;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recruiter extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * @param $value
     */
    public function setCountryAttribute($value)
    {
        $this->attributes['country'] = $value;
        $this->attributes['identifier'] = 'RP' . time();
    }

    /**
     * @return HasMany
     */
    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    /**
     * @return HasMany
     */
    public function staffs()
    {
        return $this->hasMany(Staff::class);
    }
}
