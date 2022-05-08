<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A Simple MIME Header.
 *
 * @author Chris Corbyn
 */
class Swift_Mime_Headers_UnstructuredHeader extends Swift_Mime_Headers_AbstractHeader
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
     * Creates a new SimpleHeader with $name.
     *
<<<<<<< HEAD
     * @param string                   $name
     * @param Swift_Mime_HeaderEncoder $encoder
     * @param Swift_Mime_Grammar       $grammar
     */
    public function __construct($name, Swift_Mime_HeaderEncoder $encoder, Swift_Mime_Grammar $grammar)
    {
        $this->setFieldName($name);
        $this->setEncoder($encoder);
        parent::__construct($grammar);
=======
     * @param string $name
     */
    public function __construct($name, Swift_Mime_HeaderEncoder $encoder)
    {
        $this->setFieldName($name);
        $this->setEncoder($encoder);
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
        $this->clearCachedValueIf($this->_value != $value);
        $this->_value = $value;
=======
        $this->clearCachedValueIf($this->value != $value);
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
        if (!$this->getCachedValue()) {
            $this->setCachedValue(
<<<<<<< HEAD
                $this->encodeWords($this, $this->_value)
=======
                $this->encodeWords($this, $this->value)
>>>>>>> v2-test
                );
        }

        return $this->getCachedValue();
    }
}
