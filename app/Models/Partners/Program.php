<?php

namespace App\Models\Partners;

use App\Filters\Country as CountryFilter;
use App\Filters\Duration as DurationFilter;
use App\Filters\Fee as FeeFilter;
use App\Filters\Intake as IntakeFilter;
use App\Filters\Level as LevelFilter;
use App\Filters\Subject as SubjectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Str;

class Program extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * @param $id
     * @return Builder[]|Collection
     */
    public static function withFormatIntakes($id)
    {
        $data = Program::with(['subject', 'institution', 'intakes'])->where('institution_id', $id)->get();

        foreach ($data as $item) {

            $intakes = [];
            foreach ($item->intakes as $intake) {
                array_push($intakes, $intake->id);
            }
            unset($item->intakes);
            $item->intakes = $intakes;
        }

        return $data;
    }

    /**
     * filters the data
     * @return mixed
     */
    public static function filterResult()
    {
        /**
         * Prepare the query
         * Generate a query of Program
         * Bind Institution (university) with Program
         */
        $items = Program::query()->with('institution.image')->with('intakes');

        /**
         * Pass query through all requested filter pipe
         * Paginate the filtered data
         */
        return app(Pipeline::class)
            ->send($items)
            ->through([
                CountryFilter::class,
                DurationFilter::class,
                FeeFilter::class,
                IntakeFilter::class,
                LevelFilter::class,
                SubjectFilter::class
            ])
            ->thenReturn()
            ->paginate(10);
    }

    /**
     * @return BelongsTo
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * @return BelongsTo
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    /**
     * @return BelongsToMany
     */
    public function intakes()
    {
        return $this->belongsToMany(Intake::class);
    }
}
