<?php

namespace App\Macros;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;

class WhereSearchByWords
{
    protected $builder;

    protected $columns;

    protected $search;


    public function __construct(Builder $buider, string $search, $columns)
    {
        $this->builder = $buider;
        $this->search = $search;
        $this->columns = $columns;
    }

    /**
     * Get the words to search by.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function words(): Collection
    {
        return collect(explode(' ', $this->search))
            ->map(function ($word) {
                return '%'.$word.'%';
            });
    }

    /**
     * Get the columns to search over.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function columns(): Collection
    {
        return collect(Arr::wrap($this->columns))->flatten();
    }

    /**
     * Execute the search query.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function execute(): Builder
    {
        $this->words()->each(function ($word) {
            $this->builder->where(function ($query) use ($word) {
                $this->columns()->each(function ($column) use ($query, $word) {
                    $query->orWhere($column, 'LIKE', $word);
                });
            });
        });
        return $this->builder;
    }
}