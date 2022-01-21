<?php

namespace App\Filters;

class Country extends Filter
{
    /**
     * @param $builder
     * @return mixed
     */
    protected function applyFilter($builder)
    {
        return $builder->whereHas('institution', function ($query) {
            $query->where('country', request($this->filterName()));
        });
    }
}
