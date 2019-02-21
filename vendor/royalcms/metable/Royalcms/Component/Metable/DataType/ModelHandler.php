<?php

namespace Royalcms\Component\Metable\DataType;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Handle serialization of Eloquent Models.
 *
 */
class ModelHandler implements HandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataType()
    {
        return 'model';
    }

    /**
     * {@inheritdoc}
     */
    public function canHandleValue($value)
    {
        return $value instanceof Model;
    }

    /**
     * {@inheritdoc}
     */
    public function serializeValue($value)
    {
        if ($value->exists) {
            return get_class($value).'#'.$value->getKey();
        }

        return get_class($value);
    }

    /**
     * {@inheritdoc}
     */
    public function unserializeValue($value)
    {
        // Return blank instances.
        if (strpos($value, '#') === false) {
            return new $value();
        }

        // Fetch specific instances.
        list($class, $id) = explode('#', $value);

        return with(new $class())->findOrFail($id);
    }
}
