<?php


namespace App\Filters;


use Illuminate\Http\Request;


abstract class Filters
{
    protected $request, $queryBuilder;
    protected $filters = [];

    /**
     * ThreadFilters constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply our filters to the builder
     *
     * @param $queryBuilder
     * @return mixed
     */
    public function apply($queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;

        foreach ($this->getFiltersOnly() as $filter => $value) {
            if(method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->queryBuilder;
    }

    public function getFiltersOnly() {

        return $this->request->intersect($this->filters);
    }

}