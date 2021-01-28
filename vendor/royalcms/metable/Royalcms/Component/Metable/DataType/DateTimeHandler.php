<?php

namespace Royalcms\Component\Metable\DataType;

use Carbon\Carbon;
use DateTimeInterface;

/**
 * Handle serialization of DateTimeInterface objects.
 *
 */
class DateTimeHandler implements HandlerInterface
{
    /**
     * The date format to use for serializing.
     *
     * @var string
     */
    protected $format = 'Y-m-d H:i:s.uO';

    /**
     * {@inheritdoc}
     */
    public function getDataType()
    {
        return 'datetime';
    }

    /**
     * {@inheritdoc}
     */
    public function canHandleValue($value)
    {
        return $value instanceof DateTimeInterface;
    }

    /**
     * {@inheritdoc}
     */
    public function serializeValue($value)
    {
        return $value->format($this->format);
    }

    /**
     * {@inheritdoc}
     */
    public function unserializeValue($value)
    {
        return Carbon::createFromFormat($this->format, $value);
    }
}
