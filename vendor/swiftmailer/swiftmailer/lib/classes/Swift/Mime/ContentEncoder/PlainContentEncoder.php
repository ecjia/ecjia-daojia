<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Handles binary/7/8-bit Transfer Encoding in Swift Mailer.
 *
<<<<<<< HEAD
=======
 * When sending 8-bit content over SMTP, you should use
 * Swift_Transport_Esmtp_EightBitMimeHandler to enable the 8BITMIME SMTP
 * extension.
 *
>>>>>>> v2-test
 * @author Chris Corbyn
 */
class Swift_Mime_ContentEncoder_PlainContentEncoder implements Swift_Mime_ContentEncoder
{
    /**
     * The name of this encoding scheme (probably 7bit or 8bit).
     *
     * @var string
     */
<<<<<<< HEAD
    private $_name;
=======
    private $name;
>>>>>>> v2-test

    /**
     * True if canonical transformations should be done.
     *
     * @var bool
     */
<<<<<<< HEAD
    private $_canonical;
=======
    private $canonical;
>>>>>>> v2-test

    /**
     * Creates a new PlainContentEncoder with $name (probably 7bit or 8bit).
     *
     * @param string $name
<<<<<<< HEAD
     * @param bool   $canonical If canonicalization transformation should be done.
     */
    public function __construct($name, $canonical = false)
    {
        $this->_name = $name;
        $this->_canonical = $canonical;
=======
     * @param bool   $canonical if canonicalization transformation should be done
     */
    public function __construct($name, $canonical = false)
    {
        $this->name = $name;
        $this->canonical = $canonical;
>>>>>>> v2-test
    }

    /**
     * Encode a given string to produce an encoded string.
     *
     * @param string $string
     * @param int    $firstLineOffset ignored
     * @param int    $maxLineLength   - 0 means no wrapping will occur
     *
     * @return string
     */
    public function encodeString($string, $firstLineOffset = 0, $maxLineLength = 0)
    {
<<<<<<< HEAD
        if ($this->_canonical) {
            $string = $this->_canonicalize($string);
        }

        return $this->_safeWordWrap($string, $maxLineLength, "\r\n");
=======
        if ($this->canonical) {
            $string = $this->canonicalize($string);
        }

        return $this->safeWordwrap($string, $maxLineLength, "\r\n");
>>>>>>> v2-test
    }

    /**
     * Encode stream $in to stream $out.
     *
<<<<<<< HEAD
     * @param Swift_OutputByteStream $os
     * @param Swift_InputByteStream  $is
     * @param int                    $firstLineOffset ignored
     * @param int                    $maxLineLength   optional, 0 means no wrapping will occur
=======
     * @param int $firstLineOffset ignored
     * @param int $maxLineLength   optional, 0 means no wrapping will occur
>>>>>>> v2-test
     */
    public function encodeByteStream(Swift_OutputByteStream $os, Swift_InputByteStream $is, $firstLineOffset = 0, $maxLineLength = 0)
    {
        $leftOver = '';
        while (false !== $bytes = $os->read(8192)) {
            $toencode = $leftOver.$bytes;
<<<<<<< HEAD
            if ($this->_canonical) {
                $toencode = $this->_canonicalize($toencode);
            }
            $wrapped = $this->_safeWordWrap($toencode, $maxLineLength, "\r\n");
=======
            if ($this->canonical) {
                $toencode = $this->canonicalize($toencode);
            }
            $wrapped = $this->safeWordwrap($toencode, $maxLineLength, "\r\n");
>>>>>>> v2-test
            $lastLinePos = strrpos($wrapped, "\r\n");
            $leftOver = substr($wrapped, $lastLinePos);
            $wrapped = substr($wrapped, 0, $lastLinePos);

            $is->write($wrapped);
        }
<<<<<<< HEAD
        if (strlen($leftOver)) {
=======
        if (\strlen($leftOver)) {
>>>>>>> v2-test
            $is->write($leftOver);
        }
    }

    /**
     * Get the name of this encoding scheme.
     *
     * @return string
     */
    public function getName()
    {
<<<<<<< HEAD
        return $this->_name;
=======
        return $this->name;
>>>>>>> v2-test
    }

    /**
     * Not used.
     */
    public function charsetChanged($charset)
    {
    }

    /**
     * A safer (but weaker) wordwrap for unicode.
     *
     * @param string $string
     * @param int    $length
     * @param string $le
     *
     * @return string
     */
<<<<<<< HEAD
    private function _safeWordwrap($string, $length = 75, $le = "\r\n")
=======
    private function safeWordwrap($string, $length = 75, $le = "\r\n")
>>>>>>> v2-test
    {
        if (0 >= $length) {
            return $string;
        }

        $originalLines = explode($le, $string);

<<<<<<< HEAD
        $lines = array();
=======
        $lines = [];
>>>>>>> v2-test
        $lineCount = 0;

        foreach ($originalLines as $originalLine) {
            $lines[] = '';
            $currentLine = &$lines[$lineCount++];

            //$chunks = preg_split('/(?<=[\ \t,\.!\?\-&\+\/])/', $originalLine);
            $chunks = preg_split('/(?<=\s)/', $originalLine);

            foreach ($chunks as $chunk) {
<<<<<<< HEAD
                if (0 != strlen($currentLine)
                    && strlen($currentLine.$chunk) > $length) {
=======
                if (0 != \strlen($currentLine)
                    && \strlen($currentLine.$chunk) > $length) {
>>>>>>> v2-test
                    $lines[] = '';
                    $currentLine = &$lines[$lineCount++];
                }
                $currentLine .= $chunk;
            }
        }

        return implode("\r\n", $lines);
    }

    /**
     * Canonicalize string input (fix CRLF).
     *
     * @param string $string
     *
     * @return string
     */
<<<<<<< HEAD
    private function _canonicalize($string)
    {
        return str_replace(
            array("\r\n", "\r", "\n"),
            array("\n", "\n", "\r\n"),
=======
    private function canonicalize($string)
    {
        return str_replace(
            ["\r\n", "\r", "\n"],
            ["\n", "\n", "\r\n"],
>>>>>>> v2-test
            $string
            );
    }
}
