<?php

namespace Royalcms\Component\DirectoryHasher\Comparator\Difference;

/**
 * Difference if a hash is wrong
 */
class WrongHash implements DifferenceInterface
{

    /**
     * @var string
     */
    protected $file;

    /**
     * @var string
     */
    protected $hashname;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var string
     */
    protected $expectedValue;

    /**
     *
     * @param string $file
     * @param string $hashname
     * @param string $value
     * @param string $expectedValue
     */
    public function __construct($file, $hashname, $value, $expectedValue) {
        $this->file = $file;
        $this->hashname = $hashname;
        $this->value = $value;
        $this->expectedValue = $expectedValue;
    }

    public function getFile()
    {
        return $this->file;
    }

    /**
     * {@inheritDoc}
     */
    public function toString() {
        return 'File "' . $this->file . '" has wrong "' . $this->hashname . '" of "' . $this->value . '" expected "' . $this->expectedValue . '"';
    }

}
