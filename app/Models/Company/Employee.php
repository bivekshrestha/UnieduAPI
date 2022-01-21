<?php

namespace App\Models\Company;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [ 'created_at', 'updated_at' ];

    protected $casts = [
        'show' => 'boolean'
    ];

    /**
     * @return MorphOne
     */
    public function avatar()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
