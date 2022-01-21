<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\BaseController;
use App\Models\Partners\Institution;
use App\Models\Partners\Intake;
use App\Models\Partners\Program;
use App\Models\Partners\Subject;
use Illuminate\Http\JsonResponse;

class FilterController extends BaseController
{
    /**
     * Get data for filter
     * @return JsonResponse
     */
    public function filters()
    {
        /**
         * Subject Model
         * Plucking all available subject's name
         */
        $subjects = Subject::all()->pluck('name');

        /**
         * Institution Model
         * Plucking all available distinct countries name
         * Only fetching the countries that has at least one institution registered at Uniedu
         */
        $countries = Institution::all()->pluck('country')->unique()->flatten();

        /**
         * Program Model
         * Plucking all available distinct level of study
         * Only fetching the levels that are saved with program details
         */
        $levels = Program::all()->pluck('level')->unique()->flatten();

        /**
         * Program Model
         * Plucking all available distinct duration of study
         * Only fetching the duration that are saved with program details
         */
        $durations = Program::all()->pluck('duration')->unique()->flatten();

        $intakes = Intake::all()->pluck('label')->flatten();

        return response()->json([
            'subjects' => $subjects,
            'countries' => $countries,
            'levels' => $levels,
            'durations' => $durations,
            'intakes' => $intakes,
        ], 200);
    }

    /**
     * Filter the data
     * @return mixed
     */
    public function results()
    {
        /**
         * returns paginated data
         * if any filter is requested then data is filtered in pipeline
         */
        return Program::filterResult();
    }
}
