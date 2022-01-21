<?php

namespace App\Models\Partners;

use App\Models\Image;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Notifications\Notifiable;

class Institution extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * @param $value
     * @throws Exception
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['identifier'] = 'INS' . (time() - random_int(5, 5555) + random_int(5555, 99999));
    }

    /**
     * @return MorphOne
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
