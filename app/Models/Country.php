<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Country extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [ 'created_at', 'updated_at' ];

    /**
     * @return BelongsToMany
     */
    public function region()
    {
        return $this->belongsToMany(Region::class);
    }
}
