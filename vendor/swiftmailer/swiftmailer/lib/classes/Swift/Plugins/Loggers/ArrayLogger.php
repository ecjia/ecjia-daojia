<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Logs to an Array backend.
 *
 * @author Chris Corbyn
 */
class Swift_Plugins_Loggers_ArrayLogger implements Swift_Plugins_Logger
{
    /**
     * The log contents.
     *
     * @var array
     */
<<<<<<< HEAD
    private $_log = array();
=======
    private $log = [];
>>>>>>> v2-test

    /**
     * Max size of the log.
     *
     * @var int
     */
<<<<<<< HEAD
    private $_size = 0;
=======
    private $size = 0;
>>>>>>> v2-test

    /**
     * Create a new ArrayLogger with a maximum of $size entries.
     *
     * @var int
     */
    public function __construct($size = 50)
    {
<<<<<<< HEAD
        $this->_size = $size;
=======
        $this->size = $size;
>>>>>>> v2-test
    }

    /**
     * Add a log entry.
     *
     * @param string $entry
     */
    public function add($entry)
    {
<<<<<<< HEAD
        $this->_log[] = $entry;
        while (count($this->_log) > $this->_size) {
            array_shift($this->_log);
=======
        $this->log[] = $entry;
        while (\count($this->log) > $this->size) {
            array_shift($this->log);
>>>>>>> v2-test
        }
    }

    /**
     * Clear the log contents.
     */
    public function clear()
    {
<<<<<<< HEAD
        $this->_log = array();
=======
        $this->log = [];
>>>>>>> v2-test
    }

    /**
     * Get this log as a string.
     *
     * @return string
     */
    public function dump()
    {
<<<<<<< HEAD
        return implode(PHP_EOL, $this->_log);
=======
        return implode(PHP_EOL, $this->log);
>>>>>>> v2-test
    }
}
