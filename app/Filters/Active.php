<?php

namespace App\Filters;

class Active extends Filter
{
    /**
     * @param $builder
     * @return mixed
     */
    protected function applyFilter($builder)
    {
        return $builder->whereIn('status', request($this->filterName()));
    }
}
