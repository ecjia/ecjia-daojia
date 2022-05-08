<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Provides the base functionality for an InputStream supporting filters.
 *
 * @author Chris Corbyn
 */
abstract class Swift_ByteStream_AbstractFilterableInputStream implements Swift_InputByteStream, Swift_Filterable
{
    /**
     * Write sequence.
     */
<<<<<<< HEAD
    protected $_sequence = 0;
=======
    protected $sequence = 0;
>>>>>>> v2-test

    /**
     * StreamFilters.
     *
     * @var Swift_StreamFilter[]
     */
<<<<<<< HEAD
    private $_filters = array();
=======
    private $filters = [];
>>>>>>> v2-test

    /**
     * A buffer for writing.
     */
<<<<<<< HEAD
    private $_writeBuffer = '';
=======
    private $writeBuffer = '';
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
     * Commit the given bytes to the storage medium immediately.
     *
     * @param string $bytes
     */
<<<<<<< HEAD
    abstract protected function _commit($bytes);
=======
    abstract protected function doCommit($bytes);
>>>>>>> v2-test

    /**
     * Flush any buffers/content with immediate effect.
     */
<<<<<<< HEAD
    abstract protected function _flush();
=======
    abstract protected function flush();
>>>>>>> v2-test

    /**
     * Add a StreamFilter to this InputByteStream.
     *
<<<<<<< HEAD
     * @param Swift_StreamFilter $filter
     * @param string             $key
     */
    public function addFilter(Swift_StreamFilter $filter, $key)
    {
        $this->_filters[$key] = $filter;
=======
     * @param string $key
     */
    public function addFilter(Swift_StreamFilter $filter, $key)
    {
        $this->filters[$key] = $filter;
>>>>>>> v2-test
    }

    /**
     * Remove an already present StreamFilter based on its $key.
     *
     * @param string $key
     */
    public function removeFilter($key)
    {
<<<<<<< HEAD
        unset($this->_filters[$key]);
=======
        unset($this->filters[$key]);
>>>>>>> v2-test
    }

    /**
     * Writes $bytes to the end of the stream.
     *
     * @param string $bytes
     *
     * @throws Swift_IoException
     *
     * @return int
     */
    public function write($bytes)
    {
<<<<<<< HEAD
        $this->_writeBuffer .= $bytes;
        foreach ($this->_filters as $filter) {
            if ($filter->shouldBuffer($this->_writeBuffer)) {
                return;
            }
        }
        $this->_doWrite($this->_writeBuffer);

        return ++$this->_sequence;
=======
        $this->writeBuffer .= $bytes;
        foreach ($this->filters as $filter) {
            if ($filter->shouldBuffer($this->writeBuffer)) {
                return;
            }
        }
        $this->doWrite($this->writeBuffer);

        return ++$this->sequence;
>>>>>>> v2-test
    }

    /**
     * For any bytes that are currently buffered inside the stream, force them
     * off the buffer.
     *
     * @throws Swift_IoException
     */
    public function commit()
    {
<<<<<<< HEAD
        $this->_doWrite($this->_writeBuffer);
=======
        $this->doWrite($this->writeBuffer);
>>>>>>> v2-test
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
                if ($this->_writeBuffer !== '') {
                    $stream->write($this->_writeBuffer);
                }
                unset($this->_mirrors[$k]);
=======
     */
    public function unbind(Swift_InputByteStream $is)
    {
        foreach ($this->mirrors as $k => $stream) {
            if ($is === $stream) {
                if ('' !== $this->writeBuffer) {
                    $stream->write($this->writeBuffer);
                }
                unset($this->mirrors[$k]);
>>>>>>> v2-test
            }
        }
    }

    /**
     * Flush the contents of the stream (empty it) and set the internal pointer
     * to the beginning.
     *
     * @throws Swift_IoException
     */
    public function flushBuffers()
    {
<<<<<<< HEAD
        if ($this->_writeBuffer !== '') {
            $this->_doWrite($this->_writeBuffer);
        }
        $this->_flush();

        foreach ($this->_mirrors as $stream) {
=======
        if ('' !== $this->writeBuffer) {
            $this->doWrite($this->writeBuffer);
        }
        $this->flush();

        foreach ($this->mirrors as $stream) {
>>>>>>> v2-test
            $stream->flushBuffers();
        }
    }

    /** Run $bytes through all filters */
<<<<<<< HEAD
    private function _filter($bytes)
    {
        foreach ($this->_filters as $filter) {
=======
    private function filter($bytes)
    {
        foreach ($this->filters as $filter) {
>>>>>>> v2-test
            $bytes = $filter->filter($bytes);
        }

        return $bytes;
    }

    /** Just write the bytes to the stream */
<<<<<<< HEAD
    private function _doWrite($bytes)
    {
        $this->_commit($this->_filter($bytes));

        foreach ($this->_mirrors as $stream) {
            $stream->write($bytes);
        }

        $this->_writeBuffer = '';
=======
    private function doWrite($bytes)
    {
        $this->doCommit($this->filter($bytes));

        foreach ($this->mirrors as $stream) {
            $stream->write($bytes);
        }

        $this->writeBuffer = '';
>>>>>>> v2-test
    }
}
