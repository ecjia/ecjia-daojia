<?php namespace Royalcms\Component\QrCode\DataTypes;
/**
 * Simple QrCode Generator
 * A simple wrapper for the popular BaconQrCode made for Royalcms.
 *
 */

interface DataTypeInterface {

    /**
     * Generates the DataType Object and sets all of its properties.
     *
     * @return void
     */
    public function create(Array $arguments);

    /**
     * Returns the correct QrCode format.
     *
     * @return string
     */
    public function __toString();

}