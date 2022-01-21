<?php

namespace App\Filters;

class Duration extends Filter
{
    /**
     * @param $builder
     * @return mixed
     */
    protected function applyFilter($builder)
    {
        return $builder->whereIn('duration', request($this->filterName()));
    }
}
