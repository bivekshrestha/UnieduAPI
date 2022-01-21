<?php

namespace App\Models\Students;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentDocument extends Model
{
    use HasFactory;

     protected $guarded = [];

     protected $hidden = [ 'created_at', 'updated_at' ];

    /**
     * @return BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
