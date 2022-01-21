<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [ 'created_at', 'updated_at', 'imageable_type', 'imageable_id' ];

    protected $casts = [
        'imageable_id' => 'int'
    ];

    /**
     * morphing image to different models like User, Blog ....
     * @return MorphTo
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
