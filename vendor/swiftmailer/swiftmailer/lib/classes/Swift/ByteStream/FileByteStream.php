<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Allows reading and writing of bytes to and from a file.
 *
<<<<<<< HEAD
 * @author Chris Corbyn
=======
 * @author     Chris Corbyn
>>>>>>> v2-test
 */
class Swift_ByteStream_FileByteStream extends Swift_ByteStream_AbstractFilterableInputStream implements Swift_FileStream
{
    /** The internal pointer offset */
<<<<<<< HEAD
    private $_offset = 0;

    /** The path to the file */
    private $_path;

    /** The mode this file is opened in for writing */
    private $_mode;

    /** A lazy-loaded resource handle for reading the file */
    private $_reader;

    /** A lazy-loaded resource handle for writing the file */
    private $_writer;

    /** If magic_quotes_runtime is on, this will be true */
    private $_quotes = false;

    /** If stream is seekable true/false, or null if not known */
    private $_seekable = null;
=======
    private $offset = 0;

    /** The path to the file */
    private $path;

    /** The mode this file is opened in for writing */
    private $mode;

    /** A lazy-loaded resource handle for reading the file */
    private $reader;

    /** A lazy-loaded resource handle for writing the file */
    private $writer;

    /** If stream is seekable true/false, or null if not known */
    private $seekable = null;
>>>>>>> v2-test

    /**
     * Create a new FileByteStream for $path.
     *
     * @param string $path
     * @param bool   $writable if true
     */
    public function __construct($path, $writable = false)
    {
        if (empty($path)) {
            throw new Swift_IoException('The path cannot be empty');
        }
<<<<<<< HEAD
        $this->_path = $path;
        $this->_mode = $writable ? 'w+b' : 'rb';

        if (function_exists('get_magic_quotes_runtime') && @get_magic_quotes_runtime() == 1) {
            $this->_quotes = true;
        }
=======
        $this->path = $path;
        $this->mode = $writable ? 'w+b' : 'rb';
>>>>>>> v2-test
    }

    /**
     * Get the complete path to the file.
     *
     * @return string
     */
    public function getPath()
    {
<<<<<<< HEAD
        return $this->_path;
=======
        return $this->path;
>>>>>>> v2-test
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
<<<<<<< HEAD
     * @throws Swift_IoException
     *
     * @return string|bool
     */
    public function read($length)
    {
        $fp = $this->_getReadHandle();
        if (!feof($fp)) {
            if ($this->_quotes) {
                ini_set('magic_quotes_runtime', 0);
            }
            $bytes = fread($fp, $length);
            if ($this->_quotes) {
                ini_set('magic_quotes_runtime', 1);
            }
            $this->_offset = ftell($fp);

            // If we read one byte after reaching the end of the file
            // feof() will return false and an empty string is returned
            if ($bytes === '' && feof($fp)) {
                $this->_resetReadHandle();
=======
     * @return string|bool
     *
     * @throws Swift_IoException
     */
    public function read($length)
    {
        $fp = $this->getReadHandle();
        if (!feof($fp)) {
            $bytes = fread($fp, $length);
            $this->offset = ftell($fp);

            // If we read one byte after reaching the end of the file
            // feof() will return false and an empty string is returned
            if ((false === $bytes || '' === $bytes) && feof($fp)) {
                $this->resetReadHandle();
>>>>>>> v2-test

                return false;
            }

            return $bytes;
        }

<<<<<<< HEAD
        $this->_resetReadHandle();
=======
        $this->resetReadHandle();
>>>>>>> v2-test

        return false;
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
        if (isset($this->_reader)) {
            $this->_seekReadStreamToPosition($byteOffset);
        }
        $this->_offset = $byteOffset;
    }

    /** Just write the bytes to the file */
    protected function _commit($bytes)
    {
        fwrite($this->_getWriteHandle(), $bytes);
        $this->_resetReadHandle();
    }

    /** Not used */
    protected function _flush()
=======
        if (isset($this->reader)) {
            $this->seekReadStreamToPosition($byteOffset);
        }
        $this->offset = $byteOffset;
    }

    /** Just write the bytes to the file */
    protected function doCommit($bytes)
    {
        fwrite($this->getWriteHandle(), $bytes);
        $this->resetReadHandle();
    }

    /** Not used */
    protected function flush()
>>>>>>> v2-test
    {
    }

    /** Get the resource for reading */
<<<<<<< HEAD
    private function _getReadHandle()
    {
        if (!isset($this->_reader)) {
            $pointer = @fopen($this->_path, 'rb');
            if (!$pointer) {
                throw new Swift_IoException(
                    'Unable to open file for reading ['.$this->_path.']'
                );
            }
            $this->_reader = $pointer;
            if ($this->_offset != 0) {
                $this->_getReadStreamSeekableStatus();
                $this->_seekReadStreamToPosition($this->_offset);
            }
        }

        return $this->_reader;
    }

    /** Get the resource for writing */
    private function _getWriteHandle()
    {
        if (!isset($this->_writer)) {
            if (!$this->_writer = fopen($this->_path, $this->_mode)) {
                throw new Swift_IoException(
                    'Unable to open file for writing ['.$this->_path.']'
                );
            }
        }

        return $this->_writer;
    }

    /** Force a reload of the resource for reading */
    private function _resetReadHandle()
    {
        if (isset($this->_reader)) {
            fclose($this->_reader);
            $this->_reader = null;
=======
    private function getReadHandle()
    {
        if (!isset($this->reader)) {
            $pointer = @fopen($this->path, 'rb');
            if (!$pointer) {
                throw new Swift_IoException('Unable to open file for reading ['.$this->path.']');
            }
            $this->reader = $pointer;
            if (0 != $this->offset) {
                $this->getReadStreamSeekableStatus();
                $this->seekReadStreamToPosition($this->offset);
            }
        }

        return $this->reader;
    }

    /** Get the resource for writing */
    private function getWriteHandle()
    {
        if (!isset($this->writer)) {
            if (!$this->writer = fopen($this->path, $this->mode)) {
                throw new Swift_IoException('Unable to open file for writing ['.$this->path.']');
            }
        }

        return $this->writer;
    }

    /** Force a reload of the resource for reading */
    private function resetReadHandle()
    {
        if (isset($this->reader)) {
            fclose($this->reader);
            $this->reader = null;
>>>>>>> v2-test
        }
    }

    /** Check if ReadOnly Stream is seekable */
<<<<<<< HEAD
    private function _getReadStreamSeekableStatus()
    {
        $metas = stream_get_meta_data($this->_reader);
        $this->_seekable = $metas['seekable'];
    }

    /** Streams in a readOnly stream ensuring copy if needed */
    private function _seekReadStreamToPosition($offset)
    {
        if ($this->_seekable === null) {
            $this->_getReadStreamSeekableStatus();
        }
        if ($this->_seekable === false) {
            $currentPos = ftell($this->_reader);
            if ($currentPos < $offset) {
                $toDiscard = $offset - $currentPos;
                fread($this->_reader, $toDiscard);

                return;
            }
            $this->_copyReadStream();
        }
        fseek($this->_reader, $offset, SEEK_SET);
    }

    /** Copy a readOnly Stream to ensure seekability */
    private function _copyReadStream()
    {
        if ($tmpFile = fopen('php://temp/maxmemory:4096', 'w+b')) {
            /* We have opened a php:// Stream Should work without problem */
        } elseif (function_exists('sys_get_temp_dir') && is_writable(sys_get_temp_dir()) && ($tmpFile = tmpfile())) {
=======
    private function getReadStreamSeekableStatus()
    {
        $metas = stream_get_meta_data($this->reader);
        $this->seekable = $metas['seekable'];
    }

    /** Streams in a readOnly stream ensuring copy if needed */
    private function seekReadStreamToPosition($offset)
    {
        if (null === $this->seekable) {
            $this->getReadStreamSeekableStatus();
        }
        if (false === $this->seekable) {
            $currentPos = ftell($this->reader);
            if ($currentPos < $offset) {
                $toDiscard = $offset - $currentPos;
                fread($this->reader, $toDiscard);

                return;
            }
            $this->copyReadStream();
        }
        fseek($this->reader, $offset, SEEK_SET);
    }

    /** Copy a readOnly Stream to ensure seekability */
    private function copyReadStream()
    {
        if ($tmpFile = fopen('php://temp/maxmemory:4096', 'w+b')) {
            /* We have opened a php:// Stream Should work without problem */
        } elseif (\function_exists('sys_get_temp_dir') && is_writable(sys_get_temp_dir()) && ($tmpFile = tmpfile())) {
>>>>>>> v2-test
            /* We have opened a tmpfile */
        } else {
            throw new Swift_IoException('Unable to copy the file to make it seekable, sys_temp_dir is not writable, php://memory not available');
        }
<<<<<<< HEAD
        $currentPos = ftell($this->_reader);
        fclose($this->_reader);
        $source = fopen($this->_path, 'rb');
        if (!$source) {
            throw new Swift_IoException('Unable to open file for copying ['.$this->_path.']');
=======
        $currentPos = ftell($this->reader);
        fclose($this->reader);
        $source = fopen($this->path, 'rb');
        if (!$source) {
            throw new Swift_IoException('Unable to open file for copying ['.$this->path.']');
>>>>>>> v2-test
        }
        fseek($tmpFile, 0, SEEK_SET);
        while (!feof($source)) {
            fwrite($tmpFile, fread($source, 4096));
        }
        fseek($tmpFile, $currentPos, SEEK_SET);
        fclose($source);
<<<<<<< HEAD
        $this->_reader = $tmpFile;
=======
        $this->reader = $tmpFile;
>>>>>>> v2-test
    }
}
