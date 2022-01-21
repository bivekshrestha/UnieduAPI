<?php

namespace App\Models\Students;

use App\Models\Partners\Program;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shortlist extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * @return BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(Program::class, 'course_id');
    }

    /**
     * @return BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(Student::class,);
    }
}
