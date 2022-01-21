<?php

namespace App\Models\Partners;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Intake extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * @param $value
     */
    public function setLabelAttribute($value)
    {
        $this->attributes['label'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * @return BelongsToMany
     */
    public function programs()
    {
        return $this->belongsToMany(Program::class);
    }
}
