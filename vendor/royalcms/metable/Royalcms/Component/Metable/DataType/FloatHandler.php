<?php

namespace Royalcms\Component\Metable\DataType;

/**
 * Handle serialization of floats.
 *
 */
class FloatHandler extends ScalarHandler
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'double';

    /**
     * {@inheritdoc}
     */
    public function getDataType()
    {
        return 'float';
    }
}
