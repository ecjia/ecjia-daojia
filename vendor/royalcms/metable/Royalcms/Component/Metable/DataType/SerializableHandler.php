<?php

namespace Royalcms\Component\Metable\DataType;

use Serializable;

/**
 * Handle serialization of Serializable objects.
 *
 */
class SerializableHandler implements HandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataType()
    {
        return 'serializable';
    }

    /**
     * {@inheritdoc}
     */
    public function canHandleValue($value)
    {
        return $value instanceof Serializable;
    }

    /**
     * {@inheritdoc}
     */
    public function serializeValue($value)
    {
        return serialize($value);
    }

    /**
     * {@inheritdoc}
     */
    public function unserializeValue($value)
    {
        return unserialize($value);
    }
}
