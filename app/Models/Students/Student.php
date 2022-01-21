<?php

namespace App\Models\Students;

use App\Models\Partners\Staff;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['updated_at'];

    protected $casts = [
        'created_at' => 'datetime: dS M, Y'
    ];

    /**
     * @param $value
     */
    public function setReferenceAttribute($value)
    {
        $this->attributes['reference'] = $value;
        $this->attributes['identifier'] = 'ST' . time();
    }

    /**
     * @return HasOne
     */
    public function detail()
    {
        return $this->hasOne(StudentDetail::class);
    }

    /**
     * @return HasOne
     */
    public function preference()
    {
        return $this->hasOne(StudentPreference::class);
    }

    /**
     * @return HasMany
     */
    public function shortlists()
    {
        return $this->hasMany(Shortlist::class);
    }

    /**
     * @return BelongsTo
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    /**
     * @return HasMany
     */
    public function guardians()
    {
        return $this->hasMany(StudentGuardian::class);
    }

    /**
     * @return HasMany
     */
    public function educations()
    {
        return $this->hasMany(StudentEducation::class);
    }

    /**
     * @return HasMany
     */
    public function documents()
    {
        return $this->hasMany(StudentDocument::class);
    }
}
