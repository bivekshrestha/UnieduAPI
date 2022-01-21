<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'vacancy_id',
        'first_name',
        'last_name',
        'email',
        'status',
        'document',
    ];

    protected $hidden = ['updated_at'];

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class);
    }
}
