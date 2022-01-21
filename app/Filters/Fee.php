<?php

namespace App\Filters;

class Fee extends Filter
{
    /**
     * @param $builder
     * @return mixed
     */
    protected function applyFilter($builder)
    {
        return $builder->whereBetween('fee', request($this->filterName()));
    }
}
