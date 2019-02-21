<?php

namespace Royalcms\Component\Metable\DataType;

/**
 * Provides means to serialize and unserialize values of different data types.
 *
 */
interface HandlerInterface
{
    /**
     * Return the identifier for the data type being handled.
     *
     * @return string
     */
    public function getDataType();

    /**
     * Determine if the value is of the correct type for this handler.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function canHandleValue($value);

    /**
     * Convert the value to a string, so that it can be stored in the database.
     *
     * @param mixed $value
     *
     * @return string
     */
    public function serializeValue($value);

    /**
     * Convert a serialized string back to its original value.
     *
     * @param string $serializedValue
     *
     * @return mixed
     */
    public function unserializeValue($serializedValue);
}
