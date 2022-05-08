<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Prints all log messages in real time.
 *
 * @author Chris Corbyn
 */
class Swift_Plugins_Loggers_EchoLogger implements Swift_Plugins_Logger
{
    /** Whether or not HTML should be output */
<<<<<<< HEAD
    private $_isHtml;
=======
    private $isHtml;
>>>>>>> v2-test

    /**
     * Create a new EchoLogger.
     *
     * @param bool $isHtml
     */
    public function __construct($isHtml = true)
    {
<<<<<<< HEAD
        $this->_isHtml = $isHtml;
=======
        $this->isHtml = $isHtml;
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
        if ($this->_isHtml) {
=======
        if ($this->isHtml) {
>>>>>>> v2-test
            printf('%s%s%s', htmlspecialchars($entry, ENT_QUOTES), '<br />', PHP_EOL);
        } else {
            printf('%s%s', $entry, PHP_EOL);
        }
    }

    /**
     * Not implemented.
     */
    public function clear()
    {
    }

    /**
     * Not implemented.
     */
    public function dump()
    {
    }
}
