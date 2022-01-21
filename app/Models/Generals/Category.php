<?php

namespace App\Models\Generals;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
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
     * @return HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
