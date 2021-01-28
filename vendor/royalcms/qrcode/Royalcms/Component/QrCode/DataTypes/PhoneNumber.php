<?php namespace Royalcms\Component\QrCode\DataTypes;
/**
 * Simple QrCode Generator
 * A simple wrapper for the popular BaconQrCode made for Royalcms.
 *
 */

class PhoneNumber implements DataTypeInterface {

    /**
     * The prefix of the QrCode
     *
     * @var string
     */
    private $prefix = 'tel:';

    /**
     * The phone number
     *
     * @var
     */
    private $phoneNumber;

    /**
     * Generates the DataType Object and sets all of its properties.
     *
     * @param $arguments
     * @return void
     */
    public function create(Array $arguments)
    {
        $this->phoneNumber = $arguments[0];
    }

    /**
     * Returns the correct QrCode format.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->prefix . $this->phoneNumber;
    }

}