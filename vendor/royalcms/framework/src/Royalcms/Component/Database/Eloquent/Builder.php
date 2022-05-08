<?php


namespace Royalcms\Component\Database\Eloquent;


use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class Builder extends QueryBuilder
{

//    /**
//     * Get the hydrated models without eager loading.
//     *
//     * @param  array  $columns
//     * @return \Illuminate\Database\Eloquent\Model[]|\Illuminate\Database\Eloquent\Builder[]
//     */
//    public function getModels($columns = ['*'])
//    {
//        return $this->model->hydrate(
//            $this->query->get($columns)->all()
//        )->all();
//    }

//    /**
//     * Execute the query and get the first result.
//     *
//     * @param  array  $columns
//     * @return \Royalcms\Component\Database\Eloquent\Model|static|null
//     */
//    public function first($columns = ['*'])
//    {
//        return $this->take(1)->get($columns)->first();
//    }

    /**
     * Get an array with the values of a given column.
     *
     * @param  string  $column
     * @param  string|null  $key
     * @return \Royalcms\Component\Support\Collection
     */
    public function lists($column, $key = null)
    {
        $results = $this->query->lists($column, $key);

        // If the model has a mutator for the requested column, we will spin through
        // the results and mutate the values so that the mutated version of these
        // columns are returned as you would expect from these Eloquent models.
        if ($this->model->hasGetMutator($column)) {
            foreach ($results as $key => &$value) {
                $fill = [$column => $value];

                $value = $this->model->newFromBuilder($fill)->$column;
            }
        }

        return collect($results);
    }

}