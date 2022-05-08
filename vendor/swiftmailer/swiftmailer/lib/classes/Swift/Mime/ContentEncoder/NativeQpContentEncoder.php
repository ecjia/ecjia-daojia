<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Handles Quoted Printable (QP) Transfer Encoding in Swift Mailer using the PHP core function.
 *
 * @author Lars Strojny
 */
class Swift_Mime_ContentEncoder_NativeQpContentEncoder implements Swift_Mime_ContentEncoder
{
    /**
<<<<<<< HEAD
     * @var null|string
=======
     * @var string|null
>>>>>>> v2-test
     */
    private $charset;

    /**
<<<<<<< HEAD
     * @param null|string $charset
     */
    public function __construct($charset = null)
    {
        $this->charset = $charset ? $charset : 'utf-8';
=======
     * @param string|null $charset
     */
    public function __construct($charset = null)
    {
        $this->charset = $charset ?: 'utf-8';
>>>>>>> v2-test
    }

    /**
     * Notify this observer that the entity's charset has changed.
     *
     * @param string $charset
     */
    public function charsetChanged($charset)
    {
        $this->charset = $charset;
    }

    /**
     * Encode $in to $out.
     *
     * @param Swift_OutputByteStream $os              to read from
     * @param Swift_InputByteStream  $is              to write to
     * @param int                    $firstLineOffset
     * @param int                    $maxLineLength   0 indicates the default length for this encoding
     *
     * @throws RuntimeException
     */
    public function encodeByteStream(Swift_OutputByteStream $os, Swift_InputByteStream $is, $firstLineOffset = 0, $maxLineLength = 0)
    {
<<<<<<< HEAD
        if ($this->charset !== 'utf-8') {
            throw new RuntimeException(
                sprintf('Charset "%s" not supported. NativeQpContentEncoder only supports "utf-8"', $this->charset));
=======
        if ('utf-8' !== $this->charset) {
            throw new RuntimeException(sprintf('Charset "%s" not supported. NativeQpContentEncoder only supports "utf-8"', $this->charset));
>>>>>>> v2-test
        }

        $string = '';

        while (false !== $bytes = $os->read(8192)) {
            $string .= $bytes;
        }

        $is->write($this->encodeString($string));
    }

    /**
     * Get the MIME name of this content encoding scheme.
     *
     * @return string
     */
    public function getName()
    {
        return 'quoted-printable';
    }

    /**
     * Encode a given string to produce an encoded string.
     *
     * @param string $string
     * @param int    $firstLineOffset if first line needs to be shorter
     * @param int    $maxLineLength   0 indicates the default length for this encoding
     *
     * @throws RuntimeException
     *
     * @return string
     */
    public function encodeString($string, $firstLineOffset = 0, $maxLineLength = 0)
    {
<<<<<<< HEAD
        if ($this->charset !== 'utf-8') {
            throw new RuntimeException(
                sprintf('Charset "%s" not supported. NativeQpContentEncoder only supports "utf-8"', $this->charset));
        }

        return $this->_standardize(quoted_printable_encode($string));
=======
        if ('utf-8' !== $this->charset) {
            throw new RuntimeException(sprintf('Charset "%s" not supported. NativeQpContentEncoder only supports "utf-8"', $this->charset));
        }

        return $this->standardize(quoted_printable_encode($string));
>>>>>>> v2-test
    }

    /**
     * Make sure CRLF is correct and HT/SPACE are in valid places.
     *
     * @param string $string
     *
     * @return string
     */
<<<<<<< HEAD
    protected function _standardize($string)
=======
    protected function standardize($string)
>>>>>>> v2-test
    {
        // transform CR or LF to CRLF
        $string = preg_replace('~=0D(?!=0A)|(?<!=0D)=0A~', '=0D=0A', $string);
        // transform =0D=0A to CRLF
<<<<<<< HEAD
        $string = str_replace(array("\t=0D=0A", ' =0D=0A', '=0D=0A'), array("=09\r\n", "=20\r\n", "\r\n"), $string);

        switch ($end = ord(substr($string, -1))) {
=======
        $string = str_replace(["\t=0D=0A", ' =0D=0A', '=0D=0A'], ["=09\r\n", "=20\r\n", "\r\n"], $string);

        switch (\ord(substr($string, -1))) {
>>>>>>> v2-test
            case 0x09:
                $string = substr_replace($string, '=09', -1);
                break;
            case 0x20:
                $string = substr_replace($string, '=20', -1);
                break;
        }

        return $string;
    }
}
