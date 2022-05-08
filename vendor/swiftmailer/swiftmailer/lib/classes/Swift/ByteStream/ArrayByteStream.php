<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Allows reading and writing of bytes to and from an array.
 *
<<<<<<< HEAD
 * @author Chris Corbyn
=======
 * @author     Chris Corbyn
>>>>>>> v2-test
 */
class Swift_ByteStream_ArrayByteStream implements Swift_InputByteStream, Swift_OutputByteStream
{
    /**
     * The internal stack of bytes.
     *
     * @var string[]
     */
<<<<<<< HEAD
    private $_array = array();
=======
    private $array = [];
>>>>>>> v2-test

    /**
     * The size of the stack.
     *
     * @var int
     */
<<<<<<< HEAD
    private $_arraySize = 0;
=======
    private $arraySize = 0;
>>>>>>> v2-test

    /**
     * The internal pointer offset.
     *
     * @var int
     */
<<<<<<< HEAD
    private $_offset = 0;
=======
    private $offset = 0;
>>>>>>> v2-test

    /**
     * Bound streams.
     *
     * @var Swift_InputByteStream[]
     */
<<<<<<< HEAD
    private $_mirrors = array();
=======
    private $mirrors = [];
>>>>>>> v2-test

    /**
     * Create a new ArrayByteStream.
     *
     * If $stack is given the stream will be populated with the bytes it contains.
     *
     * @param mixed $stack of bytes in string or array form, optional
     */
    public function __construct($stack = null)
    {
<<<<<<< HEAD
        if (is_array($stack)) {
            $this->_array = $stack;
            $this->_arraySize = count($stack);
        } elseif (is_string($stack)) {
            $this->write($stack);
        } else {
            $this->_array = array();
=======
        if (\is_array($stack)) {
            $this->array = $stack;
            $this->arraySize = \count($stack);
        } elseif (\is_string($stack)) {
            $this->write($stack);
        } else {
            $this->array = [];
>>>>>>> v2-test
        }
    }

    /**
     * Reads $length bytes from the stream into a string and moves the pointer
     * through the stream by $length.
     *
     * If less bytes exist than are requested the
     * remaining bytes are given instead. If no bytes are remaining at all, boolean
     * false is returned.
     *
     * @param int $length
     *
     * @return string
     */
    public function read($length)
    {
<<<<<<< HEAD
        if ($this->_offset == $this->_arraySize) {
=======
        if ($this->offset == $this->arraySize) {
>>>>>>> v2-test
            return false;
        }

        // Don't use array slice
<<<<<<< HEAD
        $end = $length + $this->_offset;
        $end = $this->_arraySize < $end ? $this->_arraySize : $end;
        $ret = '';
        for (; $this->_offset < $end; ++$this->_offset) {
            $ret .= $this->_array[$this->_offset];
=======
        $end = $length + $this->offset;
        $end = $this->arraySize < $end ? $this->arraySize : $end;
        $ret = '';
        for (; $this->offset < $end; ++$this->offset) {
            $ret .= $this->array[$this->offset];
>>>>>>> v2-test
        }

        return $ret;
    }

    /**
     * Writes $bytes to the end of the stream.
     *
     * @param string $bytes
     */
    public function write($bytes)
    {
        $to_add = str_split($bytes);
        foreach ($to_add as $value) {
<<<<<<< HEAD
            $this->_array[] = $value;
        }
        $this->_arraySize = count($this->_array);

        foreach ($this->_mirrors as $stream) {
=======
            $this->array[] = $value;
        }
        $this->arraySize = \count($this->array);

        foreach ($this->mirrors as $stream) {
>>>>>>> v2-test
            $stream->write($bytes);
        }
    }

    /**
     * Not used.
     */
    public function commit()
    {
    }

    /**
     * Attach $is to this stream.
     *
     * The stream acts as an observer, receiving all data that is written.
     * All {@link write()} and {@link flushBuffers()} operations will be mirrored.
<<<<<<< HEAD
     *
     * @param Swift_InputByteStream $is
     */
    public function bind(Swift_InputByteStream $is)
    {
        $this->_mirrors[] = $is;
=======
     */
    public function bind(Swift_InputByteStream $is)
    {
        $this->mirrors[] = $is;
>>>>>>> v2-test
    }

    /**
     * Remove an already bound stream.
     *
     * If $is is not bound, no errors will be raised.
     * If the stream currently has any buffered data it will be written to $is
     * before unbinding occurs.
<<<<<<< HEAD
     *
     * @param Swift_InputByteStream $is
     */
    public function unbind(Swift_InputByteStream $is)
    {
        foreach ($this->_mirrors as $k => $stream) {
            if ($is === $stream) {
                unset($this->_mirrors[$k]);
=======
     */
    public function unbind(Swift_InputByteStream $is)
    {
        foreach ($this->mirrors as $k => $stream) {
            if ($is === $stream) {
                unset($this->mirrors[$k]);
>>>>>>> v2-test
            }
        }
    }

    /**
     * Move the internal read pointer to $byteOffset in the stream.
     *
     * @param int $byteOffset
     *
     * @return bool
     */
    public function setReadPointer($byteOffset)
    {
<<<<<<< HEAD
        if ($byteOffset > $this->_arraySize) {
            $byteOffset = $this->_arraySize;
=======
        if ($byteOffset > $this->arraySize) {
            $byteOffset = $this->arraySize;
>>>>>>> v2-test
        } elseif ($byteOffset < 0) {
            $byteOffset = 0;
        }

<<<<<<< HEAD
        $this->_offset = $byteOffset;
=======
        $this->offset = $byteOffset;
>>>>>>> v2-test
    }

    /**
     * Flush the contents of the stream (empty it) and set the internal pointer
     * to the beginning.
     */
    public function flushBuffers()
    {
<<<<<<< HEAD
        $this->_offset = 0;
        $this->_array = array();
        $this->_arraySize = 0;

        foreach ($this->_mirrors as $stream) {
=======
        $this->offset = 0;
        $this->array = [];
        $this->arraySize = 0;

        foreach ($this->mirrors as $stream) {
>>>>>>> v2-test
            $stream->flushBuffers();
        }
    }
}
