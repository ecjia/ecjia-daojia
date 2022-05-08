<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A basic KeyCache backed by an array.
 *
 * @author Chris Corbyn
 */
class Swift_KeyCache_ArrayKeyCache implements Swift_KeyCache
{
    /**
     * Cache contents.
     *
     * @var array
     */
<<<<<<< HEAD
    private $_contents = array();
=======
    private $contents = [];
>>>>>>> v2-test

    /**
     * An InputStream for cloning.
     *
     * @var Swift_KeyCache_KeyCacheInputStream
     */
<<<<<<< HEAD
    private $_stream;
=======
    private $stream;
>>>>>>> v2-test

    /**
     * Create a new ArrayKeyCache with the given $stream for cloning to make
     * InputByteStreams.
<<<<<<< HEAD
     *
     * @param Swift_KeyCache_KeyCacheInputStream $stream
     */
    public function __construct(Swift_KeyCache_KeyCacheInputStream $stream)
    {
        $this->_stream = $stream;
=======
     */
    public function __construct(Swift_KeyCache_KeyCacheInputStream $stream)
    {
        $this->stream = $stream;
>>>>>>> v2-test
    }

    /**
     * Set a string into the cache under $itemKey for the namespace $nsKey.
     *
     * @see MODE_WRITE, MODE_APPEND
     *
     * @param string $nsKey
     * @param string $itemKey
     * @param string $string
     * @param int    $mode
     */
    public function setString($nsKey, $itemKey, $string, $mode)
    {
<<<<<<< HEAD
        $this->_prepareCache($nsKey);
        switch ($mode) {
            case self::MODE_WRITE:
                $this->_contents[$nsKey][$itemKey] = $string;
                break;
            case self::MODE_APPEND:
                if (!$this->hasKey($nsKey, $itemKey)) {
                    $this->_contents[$nsKey][$itemKey] = '';
                }
                $this->_contents[$nsKey][$itemKey] .= $string;
                break;
            default:
                throw new Swift_SwiftException(
                    'Invalid mode ['.$mode.'] used to set nsKey='.
                    $nsKey.', itemKey='.$itemKey
                    );
=======
        $this->prepareCache($nsKey);
        switch ($mode) {
            case self::MODE_WRITE:
                $this->contents[$nsKey][$itemKey] = $string;
                break;
            case self::MODE_APPEND:
                if (!$this->hasKey($nsKey, $itemKey)) {
                    $this->contents[$nsKey][$itemKey] = '';
                }
                $this->contents[$nsKey][$itemKey] .= $string;
                break;
            default:
                throw new Swift_SwiftException('Invalid mode ['.$mode.'] used to set nsKey='.$nsKey.', itemKey='.$itemKey);
>>>>>>> v2-test
        }
    }

    /**
     * Set a ByteStream into the cache under $itemKey for the namespace $nsKey.
     *
     * @see MODE_WRITE, MODE_APPEND
     *
<<<<<<< HEAD
     * @param string                 $nsKey
     * @param string                 $itemKey
     * @param Swift_OutputByteStream $os
     * @param int                    $mode
     */
    public function importFromByteStream($nsKey, $itemKey, Swift_OutputByteStream $os, $mode)
    {
        $this->_prepareCache($nsKey);
        switch ($mode) {
            case self::MODE_WRITE:
                $this->clearKey($nsKey, $itemKey);
            case self::MODE_APPEND:
                if (!$this->hasKey($nsKey, $itemKey)) {
                    $this->_contents[$nsKey][$itemKey] = '';
                }
                while (false !== $bytes = $os->read(8192)) {
                    $this->_contents[$nsKey][$itemKey] .= $bytes;
                }
                break;
            default:
                throw new Swift_SwiftException(
                    'Invalid mode ['.$mode.'] used to set nsKey='.
                    $nsKey.', itemKey='.$itemKey
                    );
=======
     * @param string $nsKey
     * @param string $itemKey
     * @param int    $mode
     */
    public function importFromByteStream($nsKey, $itemKey, Swift_OutputByteStream $os, $mode)
    {
        $this->prepareCache($nsKey);
        switch ($mode) {
            case self::MODE_WRITE:
                $this->clearKey($nsKey, $itemKey);
                // no break
            case self::MODE_APPEND:
                if (!$this->hasKey($nsKey, $itemKey)) {
                    $this->contents[$nsKey][$itemKey] = '';
                }
                while (false !== $bytes = $os->read(8192)) {
                    $this->contents[$nsKey][$itemKey] .= $bytes;
                }
                break;
            default:
                throw new Swift_SwiftException('Invalid mode ['.$mode.'] used to set nsKey='.$nsKey.', itemKey='.$itemKey);
>>>>>>> v2-test
        }
    }

    /**
     * Provides a ByteStream which when written to, writes data to $itemKey.
     *
     * NOTE: The stream will always write in append mode.
     *
<<<<<<< HEAD
     * @param string                $nsKey
     * @param string                $itemKey
     * @param Swift_InputByteStream $writeThrough
=======
     * @param string $nsKey
     * @param string $itemKey
>>>>>>> v2-test
     *
     * @return Swift_InputByteStream
     */
    public function getInputByteStream($nsKey, $itemKey, Swift_InputByteStream $writeThrough = null)
    {
<<<<<<< HEAD
        $is = clone $this->_stream;
=======
        $is = clone $this->stream;
>>>>>>> v2-test
        $is->setKeyCache($this);
        $is->setNsKey($nsKey);
        $is->setItemKey($itemKey);
        if (isset($writeThrough)) {
            $is->setWriteThroughStream($writeThrough);
        }

        return $is;
    }

    /**
     * Get data back out of the cache as a string.
     *
     * @param string $nsKey
     * @param string $itemKey
     *
     * @return string
     */
    public function getString($nsKey, $itemKey)
    {
<<<<<<< HEAD
        $this->_prepareCache($nsKey);
        if ($this->hasKey($nsKey, $itemKey)) {
            return $this->_contents[$nsKey][$itemKey];
=======
        $this->prepareCache($nsKey);
        if ($this->hasKey($nsKey, $itemKey)) {
            return $this->contents[$nsKey][$itemKey];
>>>>>>> v2-test
        }
    }

    /**
     * Get data back out of the cache as a ByteStream.
     *
     * @param string                $nsKey
     * @param string                $itemKey
     * @param Swift_InputByteStream $is      to write the data to
     */
    public function exportToByteStream($nsKey, $itemKey, Swift_InputByteStream $is)
    {
<<<<<<< HEAD
        $this->_prepareCache($nsKey);
=======
        $this->prepareCache($nsKey);
>>>>>>> v2-test
        $is->write($this->getString($nsKey, $itemKey));
    }

    /**
     * Check if the given $itemKey exists in the namespace $nsKey.
     *
     * @param string $nsKey
     * @param string $itemKey
     *
     * @return bool
     */
    public function hasKey($nsKey, $itemKey)
    {
<<<<<<< HEAD
        $this->_prepareCache($nsKey);

        return array_key_exists($itemKey, $this->_contents[$nsKey]);
=======
        $this->prepareCache($nsKey);

        return \array_key_exists($itemKey, $this->contents[$nsKey]);
>>>>>>> v2-test
    }

    /**
     * Clear data for $itemKey in the namespace $nsKey if it exists.
     *
     * @param string $nsKey
     * @param string $itemKey
     */
    public function clearKey($nsKey, $itemKey)
    {
<<<<<<< HEAD
        unset($this->_contents[$nsKey][$itemKey]);
=======
        unset($this->contents[$nsKey][$itemKey]);
>>>>>>> v2-test
    }

    /**
     * Clear all data in the namespace $nsKey if it exists.
     *
     * @param string $nsKey
     */
    public function clearAll($nsKey)
    {
<<<<<<< HEAD
        unset($this->_contents[$nsKey]);
=======
        unset($this->contents[$nsKey]);
>>>>>>> v2-test
    }

    /**
     * Initialize the namespace of $nsKey if needed.
     *
     * @param string $nsKey
     */
<<<<<<< HEAD
    private function _prepareCache($nsKey)
    {
        if (!array_key_exists($nsKey, $this->_contents)) {
            $this->_contents[$nsKey] = array();
=======
    private function prepareCache($nsKey)
    {
        if (!\array_key_exists($nsKey, $this->contents)) {
            $this->contents[$nsKey] = [];
>>>>>>> v2-test
        }
    }
}
