<?php

namespace Royalcms\Component\Metable\DataType;

/**
 * Handle serialization of null values.
 *
 */
class NullHandler extends ScalarHandler
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'NULL';

    /**
     * {@inheritdoc}
     */
    public function getDataType()
    {
        return 'null';
    }
}
