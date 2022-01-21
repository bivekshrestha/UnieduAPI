<?php

namespace App\Filters;

class Level extends Filter
{
    /**
     * @param $builder
     * @return mixed
     */
    protected function applyFilter($builder)
    {
        return $builder->whereIn('level', request($this->filterName()));
    }
}
