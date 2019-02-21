<?php

namespace Royalcms\Component\Metable\DataType;

/**
 * Handle serialization of plain objects.
 *
 */
class ObjectHandler implements HandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataType()
    {
        return 'object';
    }

    /**
     * {@inheritdoc}
     */
    public function canHandleValue($value)
    {
        return is_object($value);
    }

    /**
     * {@inheritdoc}
     */
    public function serializeValue($value)
    {
        return json_encode($value);
    }

    /**
     * {@inheritdoc}
     */
    public function unserializeValue($value)
    {
        return json_decode($value, false);
    }
}
