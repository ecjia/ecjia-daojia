<?php

namespace Royalcms\Component\Database\Eloquent;

interface ScopeInterface
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Royalcms\Component\Database\Eloquent\Builder  $builder
     * @param  \Royalcms\Component\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model);

    /**
     * Remove the scope from the given Eloquent query builder.
     *
     * @param  \Royalcms\Component\Database\Eloquent\Builder  $builder
     * @param  \Royalcms\Component\Database\Eloquent\Model  $model
     *
     * @return void
     */
    public function remove(Builder $builder, Model $model);
}
