<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * An abstract base MIME Header.
 *
 * @author Chris Corbyn
 */
<<<<<<< HEAD
class Swift_Mime_Headers_ParameterizedHeader extends Swift_Mime_Headers_UnstructuredHeader implements Swift_Mime_ParameterizedHeader
=======
class Swift_Mime_Headers_ParameterizedHeader extends Swift_Mime_Headers_UnstructuredHeader
>>>>>>> v2-test
{
    /**
     * RFC 2231's definition of a token.
     *
     * @var string
     */
    const TOKEN_REGEX = '(?:[\x21\x23-\x27\x2A\x2B\x2D\x2E\x30-\x39\x41-\x5A\x5E-\x7E]+)';

    /**
     * The Encoder used to encode the parameters.
     *
     * @var Swift_Encoder
     */
<<<<<<< HEAD
    private $_paramEncoder;
=======
    private $paramEncoder;
>>>>>>> v2-test

    /**
     * The parameters as an associative array.
     *
     * @var string[]
     */
<<<<<<< HEAD
    private $_params = array();
=======
    private $params = [];
>>>>>>> v2-test

    /**
     * Creates a new ParameterizedHeader with $name.
     *
<<<<<<< HEAD
     * @param string                   $name
     * @param Swift_Mime_HeaderEncoder $encoder
     * @param Swift_Encoder            $paramEncoder, optional
     * @param Swift_Mime_Grammar       $grammar
     */
    public function __construct($name, Swift_Mime_HeaderEncoder $encoder, Swift_Encoder $paramEncoder = null, Swift_Mime_Grammar $grammar)
    {
        parent::__construct($name, $encoder, $grammar);
        $this->_paramEncoder = $paramEncoder;
=======
     * @param string $name
     */
    public function __construct($name, Swift_Mime_HeaderEncoder $encoder, Swift_Encoder $paramEncoder = null)
    {
        parent::__construct($name, $encoder);
        $this->paramEncoder = $paramEncoder;
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
        return self::TYPE_PARAMETERIZED;
    }

    /**
     * Set the character set used in this Header.
     *
     * @param string $charset
     */
    public function setCharset($charset)
    {
        parent::setCharset($charset);
<<<<<<< HEAD
        if (isset($this->_paramEncoder)) {
            $this->_paramEncoder->charsetChanged($charset);
=======
        if (isset($this->paramEncoder)) {
            $this->paramEncoder->charsetChanged($charset);
>>>>>>> v2-test
        }
    }

    /**
     * Set the value of $parameter.
     *
     * @param string $parameter
     * @param string $value
     */
    public function setParameter($parameter, $value)
    {
<<<<<<< HEAD
        $this->setParameters(array_merge($this->getParameters(), array($parameter => $value)));
=======
        $this->setParameters(array_merge($this->getParameters(), [$parameter => $value]));
>>>>>>> v2-test
    }

    /**
     * Get the value of $parameter.
     *
     * @param string $parameter
     *
     * @return string
     */
    public function getParameter($parameter)
    {
        $params = $this->getParameters();

<<<<<<< HEAD
        return array_key_exists($parameter, $params) ? $params[$parameter] : null;
=======
        return $params[$parameter] ?? null;
>>>>>>> v2-test
    }

    /**
     * Set an associative array of parameter names mapped to values.
     *
     * @param string[] $parameters
     */
    public function setParameters(array $parameters)
    {
<<<<<<< HEAD
        $this->clearCachedValueIf($this->_params != $parameters);
        $this->_params = $parameters;
=======
        $this->clearCachedValueIf($this->params != $parameters);
        $this->params = $parameters;
>>>>>>> v2-test
    }

    /**
     * Returns an associative array of parameter names mapped to values.
     *
     * @return string[]
     */
    public function getParameters()
    {
<<<<<<< HEAD
        return $this->_params;
=======
        return $this->params;
>>>>>>> v2-test
    }

    /**
     * Get the value of this header prepared for rendering.
     *
     * @return string
     */
    public function getFieldBody() //TODO: Check caching here
    {
        $body = parent::getFieldBody();
<<<<<<< HEAD
        foreach ($this->_params as $name => $value) {
            if (!is_null($value)) {
                // Add the parameter
                $body .= '; '.$this->_createParameter($name, $value);
=======
        foreach ($this->params as $name => $value) {
            if (null !== $value) {
                // Add the parameter
                $body .= '; '.$this->createParameter($name, $value);
>>>>>>> v2-test
            }
        }

        return $body;
    }

    /**
     * Generate a list of all tokens in the final header.
     *
     * This doesn't need to be overridden in theory, but it is for implementation
     * reasons to prevent potential breakage of attributes.
     *
     * @param string $string The string to tokenize
     *
     * @return array An array of tokens as strings
     */
    protected function toTokens($string = null)
    {
        $tokens = parent::toTokens(parent::getFieldBody());

        // Try creating any parameters
<<<<<<< HEAD
        foreach ($this->_params as $name => $value) {
            if (!is_null($value)) {
                // Add the semi-colon separator
                $tokens[count($tokens) - 1] .= ';';
                $tokens = array_merge($tokens, $this->generateTokenLines(
                    ' '.$this->_createParameter($name, $value)
=======
        foreach ($this->params as $name => $value) {
            if (null !== $value) {
                // Add the semi-colon separator
                $tokens[\count($tokens) - 1] .= ';';
                $tokens = array_merge($tokens, $this->generateTokenLines(
                    ' '.$this->createParameter($name, $value)
>>>>>>> v2-test
                    ));
            }
        }

        return $tokens;
    }

    /**
     * Render a RFC 2047 compliant header parameter from the $name and $value.
     *
     * @param string $name
     * @param string $value
     *
     * @return string
     */
<<<<<<< HEAD
    private function _createParameter($name, $value)
=======
    private function createParameter($name, $value)
>>>>>>> v2-test
    {
        $origValue = $value;

        $encoded = false;
        // Allow room for parameter name, indices, "=" and DQUOTEs
<<<<<<< HEAD
        $maxValueLength = $this->getMaxLineLength() - strlen($name.'=*N"";') - 1;
=======
        $maxValueLength = $this->getMaxLineLength() - \strlen($name.'=*N"";') - 1;
>>>>>>> v2-test
        $firstLineOffset = 0;

        // If it's not already a valid parameter value...
        if (!preg_match('/^'.self::TOKEN_REGEX.'$/D', $value)) {
            // TODO: text, or something else??
            // ... and it's not ascii
<<<<<<< HEAD
            if (!preg_match('/^'.$this->getGrammar()->getDefinition('text').'*$/D', $value)) {
                $encoded = true;
                // Allow space for the indices, charset and language
                $maxValueLength = $this->getMaxLineLength() - strlen($name.'*N*="";') - 1;
                $firstLineOffset = strlen(
=======
            if (!preg_match('/^[\x00-\x08\x0B\x0C\x0E-\x7F]*$/D', $value)) {
                $encoded = true;
                // Allow space for the indices, charset and language
                $maxValueLength = $this->getMaxLineLength() - \strlen($name.'*N*="";') - 1;
                $firstLineOffset = \strlen(
>>>>>>> v2-test
                    $this->getCharset()."'".$this->getLanguage()."'"
                    );
            }
        }

        // Encode if we need to
<<<<<<< HEAD
        if ($encoded || strlen($value) > $maxValueLength) {
            if (isset($this->_paramEncoder)) {
                $value = $this->_paramEncoder->encodeString(
=======
        if ($encoded || \strlen($value) > $maxValueLength) {
            if (isset($this->paramEncoder)) {
                $value = $this->paramEncoder->encodeString(
>>>>>>> v2-test
                    $origValue, $firstLineOffset, $maxValueLength, $this->getCharset()
                    );
            } else {
                // We have to go against RFC 2183/2231 in some areas for interoperability
                $value = $this->getTokenAsEncodedWord($origValue);
                $encoded = false;
            }
        }

<<<<<<< HEAD
        $valueLines = isset($this->_paramEncoder) ? explode("\r\n", $value) : array($value);

        // Need to add indices
        if (count($valueLines) > 1) {
            $paramLines = array();
            foreach ($valueLines as $i => $line) {
                $paramLines[] = $name.'*'.$i.
                    $this->_getEndOfParameterValue($line, true, $i == 0);
=======
        $valueLines = isset($this->paramEncoder) ? explode("\r\n", $value) : [$value];

        // Need to add indices
        if (\count($valueLines) > 1) {
            $paramLines = [];
            foreach ($valueLines as $i => $line) {
                $paramLines[] = $name.'*'.$i.
                    $this->getEndOfParameterValue($line, true, 0 == $i);
>>>>>>> v2-test
            }

            return implode(";\r\n ", $paramLines);
        } else {
<<<<<<< HEAD
            return $name.$this->_getEndOfParameterValue(
=======
            return $name.$this->getEndOfParameterValue(
>>>>>>> v2-test
                $valueLines[0], $encoded, true
                );
        }
    }

    /**
     * Returns the parameter value from the "=" and beyond.
     *
     * @param string $value     to append
     * @param bool   $encoded
     * @param bool   $firstLine
     *
     * @return string
     */
<<<<<<< HEAD
    private function _getEndOfParameterValue($value, $encoded = false, $firstLine = false)
=======
    private function getEndOfParameterValue($value, $encoded = false, $firstLine = false)
>>>>>>> v2-test
    {
        if (!preg_match('/^'.self::TOKEN_REGEX.'$/D', $value)) {
            $value = '"'.$value.'"';
        }
        $prepend = '=';
        if ($encoded) {
            $prepend = '*=';
            if ($firstLine) {
                $prepend = '*='.$this->getCharset()."'".$this->getLanguage().
                    "'";
            }
        }

        return $prepend.$value;
    }
}
