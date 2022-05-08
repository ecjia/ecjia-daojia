<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * An OpenDKIM Specific Header using only raw header datas without encoding.
 *
 * @author De Cock Xavier <xdecock@gmail.com>
<<<<<<< HEAD
=======
 *
 * @deprecated since SwiftMailer 6.1.0; use Swift_Signers_DKIMSigner instead.
>>>>>>> v2-test
 */
class Swift_Mime_Headers_OpenDKIMHeader implements Swift_Mime_Header
{
    /**
     * The value of this Header.
     *
     * @var string
     */
<<<<<<< HEAD
    private $_value;
=======
    private $value;
>>>>>>> v2-test

    /**
     * The name of this Header.
     *
     * @var string
     */
<<<<<<< HEAD
    private $_fieldName;

    /**
     * Creates a new SimpleHeader with $name.
     *
     * @param string                   $name
     * @param Swift_Mime_HeaderEncoder $encoder
     * @param Swift_Mime_Grammar       $grammar
     */
    public function __construct($name)
    {
        $this->_fieldName = $name;
=======
    private $fieldName;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->fieldName = $name;
>>>>>>> v2-test
    }

    /**
     * Get the type of Header that this instance represents.
     *
     * @see TYPE_TEXT, TYPE_PARAMETERIZED, TYPE_MAILBOX
     * @see TYPE_DATE, TYPE_ID, TYPE_PATH
     *
     * @return int
     */
    public function getFieldType()
    {
        return self::TYPE_TEXT;
    }

    /**
     * Set the model for the field body.
     *
     * This method takes a string for the field value.
     *
     * @param string $model
     */
    public function setFieldBodyModel($model)
    {
        $this->setValue($model);
    }

    /**
     * Get the model for the field body.
     *
     * This method returns a string.
     *
     * @return string
     */
    public function getFieldBodyModel()
    {
        return $this->getValue();
    }

    /**
     * Get the (unencoded) value of this header.
     *
     * @return string
     */
    public function getValue()
    {
<<<<<<< HEAD
        return $this->_value;
=======
        return $this->value;
>>>>>>> v2-test
    }

    /**
     * Set the (unencoded) value of this header.
     *
     * @param string $value
     */
    public function setValue($value)
    {
<<<<<<< HEAD
        $this->_value = $value;
=======
        $this->value = $value;
>>>>>>> v2-test
    }

    /**
     * Get the value of this header prepared for rendering.
     *
     * @return string
     */
    public function getFieldBody()
    {
<<<<<<< HEAD
        return $this->_value;
=======
        return $this->value;
>>>>>>> v2-test
    }

    /**
     * Get this Header rendered as a RFC 2822 compliant string.
     *
     * @return string
     */
    public function toString()
    {
<<<<<<< HEAD
        return $this->_fieldName.': '.$this->_value;
=======
        return $this->fieldName.': '.$this->value."\r\n";
>>>>>>> v2-test
    }

    /**
     * Set the Header FieldName.
     *
     * @see Swift_Mime_Header::getFieldName()
     */
    public function getFieldName()
    {
<<<<<<< HEAD
        return $this->_fieldName;
=======
        return $this->fieldName;
>>>>>>> v2-test
    }

    /**
     * Ignored.
     */
    public function setCharset($charset)
    {
    }
}
