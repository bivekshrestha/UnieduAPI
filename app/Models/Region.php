<?php

namespace App\Models;

use App\Models\Generals\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Region extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [ 'created_at', 'updated_at' ];

    /**
     * @param $value
     */
    public function setLabelAttribute($value)
    {
        $this->attributes['label'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * @return Builder[]|Collection
     */
    public static function withFormatCountries()
    {
        $data = Region::with('countries')->get();
        foreach ($data as $item) {
            $countries = [];
            foreach ($item->countries as $country) {
                array_push($countries, $country->id);
            }
            unset($item->countries);
            $item->countries = $countries;
        }

        return $data;
    }

    /**
     * @return BelongsToMany
     */
    public function countries()
    {
        return $this->belongsToMany(Country::class);
    }
}
