<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A CharacterStream implementation which stores characters in an internal array.
 *
<<<<<<< HEAD
 * @author Xavier De Cock <xdecock@gmail.com>
=======
 * @author     Xavier De Cock <xdecock@gmail.com>
>>>>>>> v2-test
 */
class Swift_CharacterStream_NgCharacterStream implements Swift_CharacterStream
{
    /**
     * The char reader (lazy-loaded) for the current charset.
     *
     * @var Swift_CharacterReader
     */
<<<<<<< HEAD
    private $_charReader;
=======
    private $charReader;
>>>>>>> v2-test

    /**
     * A factory for creating CharacterReader instances.
     *
     * @var Swift_CharacterReaderFactory
     */
<<<<<<< HEAD
    private $_charReaderFactory;
=======
    private $charReaderFactory;
>>>>>>> v2-test

    /**
     * The character set this stream is using.
     *
     * @var string
     */
<<<<<<< HEAD
    private $_charset;
=======
    private $charset;
>>>>>>> v2-test

    /**
     * The data's stored as-is.
     *
     * @var string
     */
<<<<<<< HEAD
    private $_datas = '';
=======
    private $datas = '';
>>>>>>> v2-test

    /**
     * Number of bytes in the stream.
     *
     * @var int
     */
<<<<<<< HEAD
    private $_datasSize = 0;
=======
    private $datasSize = 0;
>>>>>>> v2-test

    /**
     * Map.
     *
     * @var mixed
     */
<<<<<<< HEAD
    private $_map;
=======
    private $map;
>>>>>>> v2-test

    /**
     * Map Type.
     *
     * @var int
     */
<<<<<<< HEAD
    private $_mapType = 0;
=======
    private $mapType = 0;
>>>>>>> v2-test

    /**
     * Number of characters in the stream.
     *
     * @var int
     */
<<<<<<< HEAD
    private $_charCount = 0;
=======
    private $charCount = 0;
>>>>>>> v2-test

    /**
     * Position in the stream.
     *
     * @var int
     */
<<<<<<< HEAD
    private $_currentPos = 0;
=======
    private $currentPos = 0;
>>>>>>> v2-test

    /**
     * Constructor.
     *
<<<<<<< HEAD
     * @param Swift_CharacterReaderFactory $factory
     * @param string                       $charset
=======
     * @param string $charset
>>>>>>> v2-test
     */
    public function __construct(Swift_CharacterReaderFactory $factory, $charset)
    {
        $this->setCharacterReaderFactory($factory);
        $this->setCharacterSet($charset);
    }

    /* -- Changing parameters of the stream -- */

    /**
     * Set the character set used in this CharacterStream.
     *
     * @param string $charset
     */
    public function setCharacterSet($charset)
    {
<<<<<<< HEAD
        $this->_charset = $charset;
        $this->_charReader = null;
        $this->_mapType = 0;
=======
        $this->charset = $charset;
        $this->charReader = null;
        $this->mapType = 0;
>>>>>>> v2-test
    }

    /**
     * Set the CharacterReaderFactory for multi charset support.
<<<<<<< HEAD
     *
     * @param Swift_CharacterReaderFactory $factory
     */
    public function setCharacterReaderFactory(Swift_CharacterReaderFactory $factory)
    {
        $this->_charReaderFactory = $factory;
=======
     */
    public function setCharacterReaderFactory(Swift_CharacterReaderFactory $factory)
    {
        $this->charReaderFactory = $factory;
>>>>>>> v2-test
    }

    /**
     * @see Swift_CharacterStream::flushContents()
     */
    public function flushContents()
    {
<<<<<<< HEAD
        $this->_datas = null;
        $this->_map = null;
        $this->_charCount = 0;
        $this->_currentPos = 0;
        $this->_datasSize = 0;
=======
        $this->datas = null;
        $this->map = null;
        $this->charCount = 0;
        $this->currentPos = 0;
        $this->datasSize = 0;
>>>>>>> v2-test
    }

    /**
     * @see Swift_CharacterStream::importByteStream()
<<<<<<< HEAD
     *
     * @param Swift_OutputByteStream $os
=======
>>>>>>> v2-test
     */
    public function importByteStream(Swift_OutputByteStream $os)
    {
        $this->flushContents();
        $blocks = 512;
        $os->setReadPointer(0);
        while (false !== ($read = $os->read($blocks))) {
            $this->write($read);
        }
    }

    /**
     * @see Swift_CharacterStream::importString()
     *
     * @param string $string
     */
    public function importString($string)
    {
        $this->flushContents();
        $this->write($string);
    }

    /**
     * @see Swift_CharacterStream::read()
     *
     * @param int $length
     *
     * @return string
     */
    public function read($length)
    {
<<<<<<< HEAD
        if ($this->_currentPos >= $this->_charCount) {
            return false;
        }
        $ret = false;
        $length = $this->_currentPos + $length > $this->_charCount ? $this->_charCount - $this->_currentPos : $length;
        switch ($this->_mapType) {
            case Swift_CharacterReader::MAP_TYPE_FIXED_LEN:
                $len = $length * $this->_map;
                $ret = substr($this->_datas,
                        $this->_currentPos * $this->_map,
                        $len);
                $this->_currentPos += $length;
=======
        if ($this->currentPos >= $this->charCount) {
            return false;
        }
        $ret = false;
        $length = ($this->currentPos + $length > $this->charCount) ? $this->charCount - $this->currentPos : $length;
        switch ($this->mapType) {
            case Swift_CharacterReader::MAP_TYPE_FIXED_LEN:
                $len = $length * $this->map;
                $ret = substr($this->datas,
                        $this->currentPos * $this->map,
                        $len);
                $this->currentPos += $length;
>>>>>>> v2-test
                break;

            case Swift_CharacterReader::MAP_TYPE_INVALID:
                $ret = '';
<<<<<<< HEAD
                for (; $this->_currentPos < $length; ++$this->_currentPos) {
                    if (isset($this->_map[$this->_currentPos])) {
                        $ret .= '?';
                    } else {
                        $ret .= $this->_datas[$this->_currentPos];
=======
                for (; $this->currentPos < $length; ++$this->currentPos) {
                    if (isset($this->map[$this->currentPos])) {
                        $ret .= '?';
                    } else {
                        $ret .= $this->datas[$this->currentPos];
>>>>>>> v2-test
                    }
                }
                break;

            case Swift_CharacterReader::MAP_TYPE_POSITIONS:
<<<<<<< HEAD
                $end = $this->_currentPos + $length;
                $end = $end > $this->_charCount ? $this->_charCount : $end;
                $ret = '';
                $start = 0;
                if ($this->_currentPos > 0) {
                    $start = $this->_map['p'][$this->_currentPos - 1];
                }
                $to = $start;
                for (; $this->_currentPos < $end; ++$this->_currentPos) {
                    if (isset($this->_map['i'][$this->_currentPos])) {
                        $ret .= substr($this->_datas, $start, $to - $start).'?';
                        $start = $this->_map['p'][$this->_currentPos];
                    } else {
                        $to = $this->_map['p'][$this->_currentPos];
                    }
                }
                $ret .= substr($this->_datas, $start, $to - $start);
=======
                $end = $this->currentPos + $length;
                $end = $end > $this->charCount ? $this->charCount : $end;
                $ret = '';
                $start = 0;
                if ($this->currentPos > 0) {
                    $start = $this->map['p'][$this->currentPos - 1];
                }
                $to = $start;
                for (; $this->currentPos < $end; ++$this->currentPos) {
                    if (isset($this->map['i'][$this->currentPos])) {
                        $ret .= substr($this->datas, $start, $to - $start).'?';
                        $start = $this->map['p'][$this->currentPos];
                    } else {
                        $to = $this->map['p'][$this->currentPos];
                    }
                }
                $ret .= substr($this->datas, $start, $to - $start);
>>>>>>> v2-test
                break;
        }

        return $ret;
    }

    /**
     * @see Swift_CharacterStream::readBytes()
     *
     * @param int $length
     *
     * @return int[]
     */
    public function readBytes($length)
    {
        $read = $this->read($length);
<<<<<<< HEAD
        if ($read !== false) {
=======
        if (false !== $read) {
>>>>>>> v2-test
            $ret = array_map('ord', str_split($read, 1));

            return $ret;
        }

        return false;
    }

    /**
     * @see Swift_CharacterStream::setPointer()
     *
     * @param int $charOffset
     */
    public function setPointer($charOffset)
    {
<<<<<<< HEAD
        if ($this->_charCount < $charOffset) {
            $charOffset = $this->_charCount;
        }
        $this->_currentPos = $charOffset;
=======
        if ($this->charCount < $charOffset) {
            $charOffset = $this->charCount;
        }
        $this->currentPos = $charOffset;
>>>>>>> v2-test
    }

    /**
     * @see Swift_CharacterStream::write()
     *
     * @param string $chars
     */
    public function write($chars)
    {
<<<<<<< HEAD
        if (!isset($this->_charReader)) {
            $this->_charReader = $this->_charReaderFactory->getReaderFor(
                $this->_charset);
            $this->_map = array();
            $this->_mapType = $this->_charReader->getMapType();
        }
        $ignored = '';
        $this->_datas .= $chars;
        $this->_charCount += $this->_charReader->getCharPositions(substr($this->_datas, $this->_datasSize), $this->_datasSize, $this->_map, $ignored);
        if ($ignored !== false) {
            $this->_datasSize = strlen($this->_datas) - strlen($ignored);
        } else {
            $this->_datasSize = strlen($this->_datas);
=======
        if (!isset($this->charReader)) {
            $this->charReader = $this->charReaderFactory->getReaderFor(
                $this->charset);
            $this->map = [];
            $this->mapType = $this->charReader->getMapType();
        }
        $ignored = '';
        $this->datas .= $chars;
        $this->charCount += $this->charReader->getCharPositions(substr($this->datas, $this->datasSize), $this->datasSize, $this->map, $ignored);
        if (false !== $ignored) {
            $this->datasSize = \strlen($this->datas) - \strlen($ignored);
        } else {
            $this->datasSize = \strlen($this->datas);
>>>>>>> v2-test
        }
    }
}
