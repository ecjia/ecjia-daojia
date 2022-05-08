<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Writes data to a KeyCache using a stream.
 *
 * @author Chris Corbyn
 */
class Swift_KeyCache_SimpleKeyCacheInputStream implements Swift_KeyCache_KeyCacheInputStream
{
    /** The KeyCache being written to */
<<<<<<< HEAD
    private $_keyCache;

    /** The nsKey of the KeyCache being written to */
    private $_nsKey;

    /** The itemKey of the KeyCache being written to */
    private $_itemKey;

    /** A stream to write through on each write() */
    private $_writeThrough = null;

    /**
     * Set the KeyCache to wrap.
     *
     * @param Swift_KeyCache $keyCache
     */
    public function setKeyCache(Swift_KeyCache $keyCache)
    {
        $this->_keyCache = $keyCache;
=======
    private $keyCache;

    /** The nsKey of the KeyCache being written to */
    private $nsKey;

    /** The itemKey of the KeyCache being written to */
    private $itemKey;

    /** A stream to write through on each write() */
    private $writeThrough = null;

    /**
     * Set the KeyCache to wrap.
     */
    public function setKeyCache(Swift_KeyCache $keyCache)
    {
        $this->keyCache = $keyCache;
>>>>>>> v2-test
    }

    /**
     * Specify a stream to write through for each write().
<<<<<<< HEAD
     *
     * @param Swift_InputByteStream $is
     */
    public function setWriteThroughStream(Swift_InputByteStream $is)
    {
        $this->_writeThrough = $is;
=======
     */
    public function setWriteThroughStream(Swift_InputByteStream $is)
    {
        $this->writeThrough = $is;
>>>>>>> v2-test
    }

    /**
     * Writes $bytes to the end of the stream.
     *
     * @param string                $bytes
     * @param Swift_InputByteStream $is    optional
     */
    public function write($bytes, Swift_InputByteStream $is = null)
    {
<<<<<<< HEAD
        $this->_keyCache->setString(
            $this->_nsKey, $this->_itemKey, $bytes, Swift_KeyCache::MODE_APPEND
=======
        $this->keyCache->setString(
            $this->nsKey, $this->itemKey, $bytes, Swift_KeyCache::MODE_APPEND
>>>>>>> v2-test
            );
        if (isset($is)) {
            $is->write($bytes);
        }
<<<<<<< HEAD
        if (isset($this->_writeThrough)) {
            $this->_writeThrough->write($bytes);
=======
        if (isset($this->writeThrough)) {
            $this->writeThrough->write($bytes);
>>>>>>> v2-test
        }
    }

    /**
     * Not used.
     */
    public function commit()
    {
    }

    /**
     * Not used.
     */
    public function bind(Swift_InputByteStream $is)
    {
    }

    /**
     * Not used.
     */
    public function unbind(Swift_InputByteStream $is)
    {
    }

    /**
     * Flush the contents of the stream (empty it) and set the internal pointer
     * to the beginning.
     */
    public function flushBuffers()
    {
<<<<<<< HEAD
        $this->_keyCache->clearKey($this->_nsKey, $this->_itemKey);
=======
        $this->keyCache->clearKey($this->nsKey, $this->itemKey);
>>>>>>> v2-test
    }

    /**
     * Set the nsKey which will be written to.
     *
     * @param string $nsKey
     */
    public function setNsKey($nsKey)
    {
<<<<<<< HEAD
        $this->_nsKey = $nsKey;
=======
        $this->nsKey = $nsKey;
>>>>>>> v2-test
    }

    /**
     * Set the itemKey which will be written to.
     *
     * @param string $itemKey
     */
    public function setItemKey($itemKey)
    {
<<<<<<< HEAD
        $this->_itemKey = $itemKey;
=======
        $this->itemKey = $itemKey;
>>>>>>> v2-test
    }

    /**
     * Any implementation should be cloneable, allowing the clone to access a
     * separate $nsKey and $itemKey.
     */
    public function __clone()
    {
<<<<<<< HEAD
        $this->_writeThrough = null;
=======
        $this->writeThrough = null;
>>>>>>> v2-test
    }
}
