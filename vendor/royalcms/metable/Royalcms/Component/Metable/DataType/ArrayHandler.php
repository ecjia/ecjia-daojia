<?php

namespace Royalcms\Component\Metable\DataType;

/**
 * Handle serialization of arrays.
 *
 */
class ArrayHandler implements HandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataType()
    {
        return 'array';
    }

    /**
     * {@inheritdoc}
     */
    public function canHandleValue($value)
    {
        return is_array($value);
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
        return json_decode($value, true);
    }
}
