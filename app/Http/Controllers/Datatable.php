<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;

class Datatable
{
    /** The main collection to be filtered and be ready for datatable */
    private Collection $collection;

    /** Page number */
    private int $draw;

    /** Order items by this column */
    private int $orderColumn;

    /** Order items by this direction [sortBy: asc / sortByDesc: desc] */
    private string $orderDir;

    /** Starting from this item (offset) */
    private int $start;

    /** Per page count */
    private int $length;

    /** Searched for */
    private ?string $searchValue;

    /** Whether the search is regex or simple */
    private bool $searchRegex;

    /** Total number of all rows */
    private int $total;

    /** Total number of filtered results */
    private int $filtered;

    /**
     * @param Collection $collection
     * @param array      $sortable   Sortable columns e.g. [1 => 'title', 3 =>'description']
     *                               !!the index which is the column order is important!!
     * @param array      $searchable Searchable columns to search in for the requested query
     */
    public function __construct(
        Collection $collection,
        array $sortable,
        array $searchable
    ) {
        $this->collection = $collection;
        $this->total      = $collection->count();

        $this->draw        = (request('draw')) ?? 1;
        $this->orderColumn = (request('order.0.column')) ?? 0;
        if ($this->orderColumn === 0) {
            $this->orderDir = 'sortByDesc';
        } else {
            $this->orderDir = (request('order.0.dir') === 'desc') ? 'sortByDesc' : 'sortBy';
        }
        $this->start       = (request('start')) ?? 0;
        $this->length      = (request('length')) ?? 10;
        $this->searchValue = (request('search.value')) ?? null;
        $this->searchRegex = (request('search.regex')) ?? false;

        $this->search($searchable)->orderBy($sortable)->limit();
    }

    /**
     * Filter the collection based on the searched query in all searchable columns of the rows
     *
     * @param $searchable
     *
     * @return $this
     */
    private function search($searchable)
    {
        if ($this->searchValue && $searchable) {
            $this->collection = $this->collection->filter(function ($item) use ($searchable) {
                $contains = false;
                foreach ($searchable as $column) {
                    if(stristr($item[$column], $this->searchValue)) {
                        $contains = true;
                    }
                }
                return $contains;
            });
        }

        $this->filtered = intval($this->collection->count());

        return $this;
    }

    /**
     * Sort roles based on the clicked column
     *
     * @param $sortable
     *
     * @return $this
     */
    private function orderBy($sortable)
    {
        $column = $sortable[$this->orderColumn];

        $this->collection = $this->collection->{$this->orderDir}($column);

        return $this;
    }

    /**
     * @return $this
     */
    private function limit()
    {
        $this->collection = $this->collection->slice($this->start, $this->length);

        return $this;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return [
            'data'            => array_values($this->collection->toArray()),
            'draw'            => intval($this->draw),
            'recordsTotal'    => $this->total,
            'recordsFiltered' => $this->filtered,
        ];
    }

}
