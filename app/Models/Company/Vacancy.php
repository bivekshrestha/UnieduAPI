<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'country',
        'position',
        'description',
        'status',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
}
