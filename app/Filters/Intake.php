<?php

namespace App\Filters;

class Intake extends Filter
{
    /**
     * @param $builder
     * @return mixed
     */
    protected function applyFilter($builder)
    {
        return $builder->with('intakes:id,label')
            ->whereHas('intakes', function ($query) {
                $query->whereIn('label', request($this->filterName()));
            });
    }
}
