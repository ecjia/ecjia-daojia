<?php

namespace Royalcms\Component\Queue;

use Royalcms\Component\Queue\Contracts\QueueableEntity;
use Royalcms\Component\Database\Contracts\ModelIdentifier;
use Royalcms\Component\Queue\Contracts\QueueableCollection;
use Royalcms\Component\Database\Eloquent\Collection as EloquentCollection;

trait SerializesAndRestoresModelIdentifiers
{
    /**
     * Get the property value prepared for serialization.
     *
     * @param  mixed  $value
     * @return mixed
     */
    protected function getSerializedPropertyValue($value)
    {
        if ($value instanceof QueueableCollection) {
            return new ModelIdentifier($value->getQueueableClass(), $value->getQueueableIds());
        }

        if ($value instanceof QueueableEntity) {
            return new ModelIdentifier(get_class($value), $value->getQueueableId());
        }

        return $value;
    }

    /**
     * Get the restored property value after deserialization.
     *
     * @param  mixed  $value
     * @return mixed
     */
    protected function getRestoredPropertyValue($value)
    {
        if (! $value instanceof ModelIdentifier) {
            return $value;
        }

        return is_array($value->id)
                ? $this->restoreCollection($value)
                : with(new $value->class)->newQuery()->useWritePdo()->findOrFail($value->id);
    }

    /**
     * Restore a queueable collection instance.
     *
     * @param  \Royalcms\Component\Contracts\Database\ModelIdentifier  $value
     * @return \Royalcms\Component\Database\Eloquent\Collection
     */
    protected function restoreCollection($value)
    {
        if (! $value->class || count($value->id) === 0) {
            return new EloquentCollection;
        }

        $model = new $value->class;

        return $model->newQuery()->useWritePdo()
                    ->whereIn($model->getKeyName(), $value->id)->get();
    }
}
