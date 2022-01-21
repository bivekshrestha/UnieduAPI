<?php

namespace App\Filters;

class Subject extends Filter
{
    /**
     * @param $builder
     * @return mixed
     */
    protected function applyFilter($builder)
    {
        return $builder->with('subject:id,name')
            ->whereHas('subject', function ($query) {
                $query->whereIn('name', request($this->filterName()));
            });
    }
}
