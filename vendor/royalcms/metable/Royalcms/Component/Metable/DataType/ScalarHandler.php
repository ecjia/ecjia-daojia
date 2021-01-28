<?php

namespace Royalcms\Component\Metable\DataType;

/**
 * Handle serialization of scalar values.
 *
 */
abstract class ScalarHandler implements HandlerInterface
{
    /**
     * The name of the scalar data type.
     *
     * @var string
     */
    protected $type;

    /**
     * {@inheritdoc}
     */
    public function getDataType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function canHandleValue($value)
    {
        return gettype($value) == $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function serializeValue($value)
    {
        settype($value, 'string');

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function unserializeValue($value)
    {
        settype($value, $this->type);

        return $value;
    }
}
