<?php

namespace App\Filters;

use Closure;
use Illuminate\Support\Str;

abstract class Filter
{
    /**
     * Passes a builder i.e. sql query through series of requested filter pipelines for filtering process
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*
         * Check if a filter is requested by end-user
         * if no filter is requested then return the query for pagination and response
         * If any filter is requested then pass query through that requested filter pipe
         *  for example: if sort is requested then pass query to Sort Filter class (pipe)
         */
        if (!request()->has($this->filterName())) {
            return $next($request);
        }
        $builder = $next($request);

        return $this->applyFilter($builder);
    }

    /**
     * get the name of requested filter in snake case
     * used to determine the query name
     * @return string
     */
    protected function filterName()
    {
        return Str::snake(class_basename($this));
    }

    /**
     * @param $builder
     * @return mixed
     */
    abstract protected function applyFilter($builder);
}
