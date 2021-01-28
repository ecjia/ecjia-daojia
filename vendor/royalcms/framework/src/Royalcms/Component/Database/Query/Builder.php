<?php


namespace Royalcms\Component\Database\Query;

use Illuminate\Database\Concerns\BuildsQueries;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Royalcms\Component\Support\Arr;

class Builder extends QueryBuilder
{

//    /**
//     * Execute the query as a "select" statement.
//     *
//     * @param  array|string  $columns
//     * @return array
//     */
//    public function get($columns = ['*'])
//    {
//        return parent::get($columns)->all();
//    }

//    /**
//     * Execute an aggregate function on the database.
//     *
//     * @param  string  $function
//     * @param  array   $columns
//     * @return mixed
//     */
//    public function aggregate($function, $columns = ['*'])
//    {
//        $results = $this->cloneWithout($this->unions ? [] : ['columns'])
//            ->cloneWithoutBindings($this->unions ? [] : ['select'])
//            ->setAggregate($function, $columns)
//            ->get($columns);
//
//        if (isset($results[0])) {
//            return array_change_key_case((array) $results[0])['aggregate'];
//        }
//    }

//    /**
//     * Execute the query and get the first result.
//     *
//     * @param  array  $columns
//     * @return \Illuminate\Database\Eloquent\Model|object|static|null
//     */
//    public function first($columns = ['*'])
//    {
//        $results = $this->take(1)->get($columns)->all();
//
//        return count($results) > 0 ? reset($results) : null;
//    }

    /**
     * Get an array with the values of a given column.
     *
     * @param  string  $column
     * @param  string|null  $key
     * @return array
     */
    public function lists($column, $key = null)
    {
        $results = $this->get(is_null($key) ? [$column] : [$column, $key]);

        // If the columns are qualified with a table or have an alias, we cannot use
        // those directly in the "pluck" operations since the results from the DB
        // are only keyed by the column itself. We'll strip the table out here.
        return Arr::pluck(
            $results,
            $this->stripTableForPluck($column),
            $this->stripTableForPluck($key)
        );
    }

//    /**
//     * Get a single column's value from the first result of a query.
//     *
//     * This is an alias for the "value" method.
//     *
//     * @param  string  $column
//     * @return mixed
//     *
//     * @deprecated since version 5.1.
//     */
//    public function pluck($column, $key = null)
//    {
//        return $this->value($column);
//    }

}