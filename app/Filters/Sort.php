<?php

namespace App\Filters;

class Sort extends Filter
{
    /**
     * @param $builder
     * @return mixed
     */
    protected function applyFilter($builder)
    {
        return $builder->orderBy('title', request($this->filterName()));
    }
}
