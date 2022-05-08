<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

<<<<<<< HEAD
=======
use Egulias\EmailValidator\EmailValidator;

>>>>>>> v2-test
/**
 * Creates MIME headers.
 *
 * @author Chris Corbyn
 */
<<<<<<< HEAD
class Swift_Mime_SimpleHeaderFactory implements Swift_Mime_HeaderFactory
{
    /** The HeaderEncoder used by these headers */
    private $_encoder;

    /** The Encoder used by parameters */
    private $_paramEncoder;

    /** The Grammar */
    private $_grammar;

    /** The charset of created Headers */
    private $_charset;
=======
class Swift_Mime_SimpleHeaderFactory implements Swift_Mime_CharsetObserver
{
    /** The HeaderEncoder used by these headers */
    private $encoder;

    /** The Encoder used by parameters */
    private $paramEncoder;

    /** Strict EmailValidator */
    private $emailValidator;

    /** The charset of created Headers */
    private $charset;

    /** Swift_AddressEncoder */
    private $addressEncoder;
>>>>>>> v2-test

    /**
     * Creates a new SimpleHeaderFactory using $encoder and $paramEncoder.
     *
<<<<<<< HEAD
     * @param Swift_Mime_HeaderEncoder $encoder
     * @param Swift_Encoder            $paramEncoder
     * @param Swift_Mime_Grammar       $grammar
     * @param string|null              $charset
     */
    public function __construct(Swift_Mime_HeaderEncoder $encoder, Swift_Encoder $paramEncoder, Swift_Mime_Grammar $grammar, $charset = null)
    {
        $this->_encoder = $encoder;
        $this->_paramEncoder = $paramEncoder;
        $this->_grammar = $grammar;
        $this->_charset = $charset;
=======
     * @param string|null $charset
     */
    public function __construct(Swift_Mime_HeaderEncoder $encoder, Swift_Encoder $paramEncoder, EmailValidator $emailValidator, $charset = null, Swift_AddressEncoder $addressEncoder = null)
    {
        $this->encoder = $encoder;
        $this->paramEncoder = $paramEncoder;
        $this->emailValidator = $emailValidator;
        $this->charset = $charset;
        $this->addressEncoder = $addressEncoder ?? new Swift_AddressEncoder_IdnAddressEncoder();
>>>>>>> v2-test
    }

    /**
     * Create a new Mailbox Header with a list of $addresses.
     *
     * @param string            $name
     * @param array|string|null $addresses
     *
     * @return Swift_Mime_Header
     */
    public function createMailboxHeader($name, $addresses = null)
    {
<<<<<<< HEAD
        $header = new Swift_Mime_Headers_MailboxHeader($name, $this->_encoder, $this->_grammar);
        if (isset($addresses)) {
            $header->setFieldBodyModel($addresses);
        }
        $this->_setHeaderCharset($header);
=======
        $header = new Swift_Mime_Headers_MailboxHeader($name, $this->encoder, $this->emailValidator, $this->addressEncoder);
        if (isset($addresses)) {
            $header->setFieldBodyModel($addresses);
        }
        $this->setHeaderCharset($header);
>>>>>>> v2-test

        return $header;
    }

    /**
<<<<<<< HEAD
     * Create a new Date header using $timestamp (UNIX time).
     *
     * @param string   $name
     * @param int|null $timestamp
     *
     * @return Swift_Mime_Header
     */
    public function createDateHeader($name, $timestamp = null)
    {
        $header = new Swift_Mime_Headers_DateHeader($name, $this->_grammar);
        if (isset($timestamp)) {
            $header->setFieldBodyModel($timestamp);
        }
        $this->_setHeaderCharset($header);
=======
     * Create a new Date header using $dateTime.
     *
     * @param string $name
     *
     * @return Swift_Mime_Header
     */
    public function createDateHeader($name, DateTimeInterface $dateTime = null)
    {
        $header = new Swift_Mime_Headers_DateHeader($name);
        if (isset($dateTime)) {
            $header->setFieldBodyModel($dateTime);
        }
        $this->setHeaderCharset($header);
>>>>>>> v2-test

        return $header;
    }

    /**
     * Create a new basic text header with $name and $value.
     *
     * @param string $name
     * @param string $value
     *
     * @return Swift_Mime_Header
     */
    public function createTextHeader($name, $value = null)
    {
<<<<<<< HEAD
        $header = new Swift_Mime_Headers_UnstructuredHeader($name, $this->_encoder, $this->_grammar);
        if (isset($value)) {
            $header->setFieldBodyModel($value);
        }
        $this->_setHeaderCharset($header);
=======
        $header = new Swift_Mime_Headers_UnstructuredHeader($name, $this->encoder);
        if (isset($value)) {
            $header->setFieldBodyModel($value);
        }
        $this->setHeaderCharset($header);
>>>>>>> v2-test

        return $header;
    }

    /**
     * Create a new ParameterizedHeader with $name, $value and $params.
     *
     * @param string $name
     * @param string $value
     * @param array  $params
     *
<<<<<<< HEAD
     * @return Swift_Mime_ParameterizedHeader
     */
    public function createParameterizedHeader($name, $value = null,
        $params = array())
    {
        $header = new Swift_Mime_Headers_ParameterizedHeader($name, $this->_encoder, strtolower($name) == 'content-disposition' ? $this->_paramEncoder : null, $this->_grammar);
=======
     * @return Swift_Mime_Headers_ParameterizedHeader
     */
    public function createParameterizedHeader($name, $value = null, $params = [])
    {
        $header = new Swift_Mime_Headers_ParameterizedHeader($name, $this->encoder, ('content-disposition' == strtolower($name)) ? $this->paramEncoder : null);
>>>>>>> v2-test
        if (isset($value)) {
            $header->setFieldBodyModel($value);
        }
        foreach ($params as $k => $v) {
            $header->setParameter($k, $v);
        }
<<<<<<< HEAD
        $this->_setHeaderCharset($header);
=======
        $this->setHeaderCharset($header);
>>>>>>> v2-test

        return $header;
    }

    /**
     * Create a new ID header for Message-ID or Content-ID.
     *
     * @param string       $name
     * @param string|array $ids
     *
     * @return Swift_Mime_Header
     */
    public function createIdHeader($name, $ids = null)
    {
<<<<<<< HEAD
        $header = new Swift_Mime_Headers_IdentificationHeader($name, $this->_grammar);
        if (isset($ids)) {
            $header->setFieldBodyModel($ids);
        }
        $this->_setHeaderCharset($header);
=======
        $header = new Swift_Mime_Headers_IdentificationHeader($name, $this->emailValidator);
        if (isset($ids)) {
            $header->setFieldBodyModel($ids);
        }
        $this->setHeaderCharset($header);
>>>>>>> v2-test

        return $header;
    }

    /**
     * Create a new Path header with an address (path) in it.
     *
     * @param string $name
     * @param string $path
     *
     * @return Swift_Mime_Header
     */
    public function createPathHeader($name, $path = null)
    {
<<<<<<< HEAD
        $header = new Swift_Mime_Headers_PathHeader($name, $this->_grammar);
        if (isset($path)) {
            $header->setFieldBodyModel($path);
        }
        $this->_setHeaderCharset($header);
=======
        $header = new Swift_Mime_Headers_PathHeader($name, $this->emailValidator);
        if (isset($path)) {
            $header->setFieldBodyModel($path);
        }
        $this->setHeaderCharset($header);
>>>>>>> v2-test

        return $header;
    }

    /**
     * Notify this observer that the entity's charset has changed.
     *
     * @param string $charset
     */
    public function charsetChanged($charset)
    {
<<<<<<< HEAD
        $this->_charset = $charset;
        $this->_encoder->charsetChanged($charset);
        $this->_paramEncoder->charsetChanged($charset);
=======
        $this->charset = $charset;
        $this->encoder->charsetChanged($charset);
        $this->paramEncoder->charsetChanged($charset);
>>>>>>> v2-test
    }

    /**
     * Make a deep copy of object.
     */
    public function __clone()
    {
<<<<<<< HEAD
        $this->_encoder = clone $this->_encoder;
        $this->_paramEncoder = clone $this->_paramEncoder;
    }

    /** Apply the charset to the Header */
    private function _setHeaderCharset(Swift_Mime_Header $header)
    {
        if (isset($this->_charset)) {
            $header->setCharset($this->_charset);
=======
        $this->encoder = clone $this->encoder;
        $this->paramEncoder = clone $this->paramEncoder;
    }

    /** Apply the charset to the Header */
    private function setHeaderCharset(Swift_Mime_Header $header)
    {
        if (isset($this->charset)) {
            $header->setCharset($this->charset);
>>>>>>> v2-test
        }
    }
}
