<?php

namespace Royalcms\Component\Metable\DataType;

use Royalcms\Component\Database\Eloquent\Collection;

/**
 * Handle serialization of Eloquent collections.
 *
 */
class ModelCollectionHandler implements HandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataType()
    {
        return 'collection';
    }

    /**
     * {@inheritdoc}
     */
    public function canHandleValue($value)
    {
        return $value instanceof Collection;
    }

    /**
     * {@inheritdoc}
     */
    public function serializeValue($value)
    {
        $items = [];
        foreach ($value as $key => $model) {
            $items[$key] = [
                'class' => get_class($model),
                'key'   => $model->exists ? $model->getKey() : null,
            ];
        }

        return json_encode(['class'=> get_class($value), 'items' => $items]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserializeValue($value)
    {
        $data = json_decode($value, true);

        $collection = new $data['class']();
        $models = $this->loadModels($data['items']);

        // Repopulate collection keys with loaded models.
        foreach ($data['items'] as $key => $item) {
            if (is_null($item['key'])) {
                $collection[$key] = new $item['class']();
            } elseif (isset($models[$item['class']][$item['key']])) {
                $collection[$key] = $models[$item['class']][$item['key']];
            }
        }

        return $collection;
    }

    /**
     * Load each model instance, grouped by class.
     *
     * @param array $items
     *
     * @return array
     */
    private function loadModels(array $items)
    {
        $classes = [];
        $results = [];

        // Retrieve a list of keys to load from each class.
        foreach ($items as $item) {
            if (!is_null($item['key'])) {
                $classes[$item['class']][] = $item['key'];
            }
        }

        // Iterate list of classes and load all records matching a key.
        foreach ($classes as $class => $keys) {
            $model = new $class();
            $results[$class] = $model->whereIn($model->getKeyName(), $keys)->get()->keyBy($model->getKeyName());
        }

        return $results;
    }
}
