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
<<<<<<< HEAD
 * @author Chris Corbyn
 */
abstract class Swift_Mime_Headers_AbstractHeader implements Swift_Mime_Header
{
=======
 * @author     Chris Corbyn
 */
abstract class Swift_Mime_Headers_AbstractHeader implements Swift_Mime_Header
{
    const PHRASE_PATTERN = '(?:(?:(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?[a-zA-Z0-9!#\$%&\'\*\+\-\/=\?\^_`\{\}\|~]+(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?)|(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?"((?:(?:[ \t]*(?:\r\n))?[ \t])?(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21\x23-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])))*(?:(?:[ \t]*(?:\r\n))?[ \t])?"(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?))+?)';

>>>>>>> v2-test
    /**
     * The name of this Header.
     *
     * @var string
     */
<<<<<<< HEAD
    private $_name;

    /**
     * The Grammar used for this Header.
     *
     * @var Swift_Mime_Grammar
     */
    private $_grammar;
=======
    private $name;
>>>>>>> v2-test

    /**
     * The Encoder used to encode this Header.
     *
     * @var Swift_Encoder
     */
<<<<<<< HEAD
    private $_encoder;
=======
    private $encoder;
>>>>>>> v2-test

    /**
     * The maximum length of a line in the header.
     *
     * @var int
     */
<<<<<<< HEAD
    private $_lineLength = 78;
=======
    private $lineLength = 78;
>>>>>>> v2-test

    /**
     * The language used in this Header.
     *
     * @var string
     */
<<<<<<< HEAD
    private $_lang;
=======
    private $lang;
>>>>>>> v2-test

    /**
     * The character set of the text in this Header.
     *
     * @var string
     */
<<<<<<< HEAD
    private $_charset = 'utf-8';
=======
    private $charset = 'utf-8';
>>>>>>> v2-test

    /**
     * The value of this Header, cached.
     *
     * @var string
     */
<<<<<<< HEAD
    private $_cachedValue = null;

    /**
     * Creates a new Header.
     *
     * @param Swift_Mime_Grammar $grammar
     */
    public function __construct(Swift_Mime_Grammar $grammar)
    {
        $this->setGrammar($grammar);
    }
=======
    private $cachedValue = null;
>>>>>>> v2-test

    /**
     * Set the character set used in this Header.
     *
     * @param string $charset
     */
    public function setCharset($charset)
    {
<<<<<<< HEAD
        $this->clearCachedValueIf($charset != $this->_charset);
        $this->_charset = $charset;
        if (isset($this->_encoder)) {
            $this->_encoder->charsetChanged($charset);
=======
        $this->clearCachedValueIf($charset != $this->charset);
        $this->charset = $charset;
        if (isset($this->encoder)) {
            $this->encoder->charsetChanged($charset);
>>>>>>> v2-test
        }
    }

    /**
     * Get the character set used in this Header.
     *
     * @return string
     */
    public function getCharset()
    {
<<<<<<< HEAD
        return $this->_charset;
=======
        return $this->charset;
>>>>>>> v2-test
    }

    /**
     * Set the language used in this Header.
     *
     * For example, for US English, 'en-us'.
     * This can be unspecified.
     *
     * @param string $lang
     */
    public function setLanguage($lang)
    {
<<<<<<< HEAD
        $this->clearCachedValueIf($this->_lang != $lang);
        $this->_lang = $lang;
=======
        $this->clearCachedValueIf($this->lang != $lang);
        $this->lang = $lang;
>>>>>>> v2-test
    }

    /**
     * Get the language used in this Header.
     *
     * @return string
     */
    public function getLanguage()
    {
<<<<<<< HEAD
        return $this->_lang;
=======
        return $this->lang;
>>>>>>> v2-test
    }

    /**
     * Set the encoder used for encoding the header.
<<<<<<< HEAD
     *
     * @param Swift_Mime_HeaderEncoder $encoder
     */
    public function setEncoder(Swift_Mime_HeaderEncoder $encoder)
    {
        $this->_encoder = $encoder;
=======
     */
    public function setEncoder(Swift_Mime_HeaderEncoder $encoder)
    {
        $this->encoder = $encoder;
>>>>>>> v2-test
        $this->setCachedValue(null);
    }

    /**
     * Get the encoder used for encoding this Header.
     *
     * @return Swift_Mime_HeaderEncoder
     */
    public function getEncoder()
    {
<<<<<<< HEAD
        return $this->_encoder;
    }

    /**
     * Set the grammar used for the header.
     *
     * @param Swift_Mime_Grammar $grammar
     */
    public function setGrammar(Swift_Mime_Grammar $grammar)
    {
        $this->_grammar = $grammar;
        $this->setCachedValue(null);
    }

    /**
     * Get the grammar used for this Header.
     *
     * @return Swift_Mime_Grammar
     */
    public function getGrammar()
    {
        return $this->_grammar;
=======
        return $this->encoder;
>>>>>>> v2-test
    }

    /**
     * Get the name of this header (e.g. charset).
     *
     * @return string
     */
    public function getFieldName()
    {
<<<<<<< HEAD
        return $this->_name;
=======
        return $this->name;
>>>>>>> v2-test
    }

    /**
     * Set the maximum length of lines in the header (excluding EOL).
     *
     * @param int $lineLength
     */
    public function setMaxLineLength($lineLength)
    {
<<<<<<< HEAD
        $this->clearCachedValueIf($this->_lineLength != $lineLength);
        $this->_lineLength = $lineLength;
=======
        $this->clearCachedValueIf($this->lineLength != $lineLength);
        $this->lineLength = $lineLength;
>>>>>>> v2-test
    }

    /**
     * Get the maximum permitted length of lines in this Header.
     *
     * @return int
     */
    public function getMaxLineLength()
    {
<<<<<<< HEAD
        return $this->_lineLength;
=======
        return $this->lineLength;
>>>>>>> v2-test
    }

    /**
     * Get this Header rendered as a RFC 2822 compliant string.
     *
<<<<<<< HEAD
     * @throws Swift_RfcComplianceException
     *
     * @return string
     */
    public function toString()
    {
        return $this->_tokensToString($this->toTokens());
=======
     * @return string
     *
     * @throws Swift_RfcComplianceException
     */
    public function toString()
    {
        return $this->tokensToString($this->toTokens());
>>>>>>> v2-test
    }

    /**
     * Returns a string representation of this object.
     *
     * @return string
     *
     * @see toString()
     */
    public function __toString()
    {
        return $this->toString();
    }

<<<<<<< HEAD
    // -- Points of extension

=======
>>>>>>> v2-test
    /**
     * Set the name of this Header field.
     *
     * @param string $name
     */
    protected function setFieldName($name)
    {
<<<<<<< HEAD
        $this->_name = $name;
=======
        $this->name = $name;
>>>>>>> v2-test
    }

    /**
     * Produces a compliant, formatted RFC 2822 'phrase' based on the string given.
     *
<<<<<<< HEAD
     * @param Swift_Mime_Header        $header
     * @param string                   $string  as displayed
     * @param string                   $charset of the text
     * @param Swift_Mime_HeaderEncoder $encoder
     * @param bool                     $shorten the first line to make remove for header name
=======
     * @param string $string  as displayed
     * @param string $charset of the text
     * @param bool   $shorten the first line to make remove for header name
>>>>>>> v2-test
     *
     * @return string
     */
    protected function createPhrase(Swift_Mime_Header $header, $string, $charset, Swift_Mime_HeaderEncoder $encoder = null, $shorten = false)
    {
        // Treat token as exactly what was given
        $phraseStr = $string;
        // If it's not valid
<<<<<<< HEAD
        if (!preg_match('/^'.$this->getGrammar()->getDefinition('phrase').'$/D', $phraseStr)) {
            // .. but it is just ascii text, try escaping some characters
            // and make it a quoted-string
            if (preg_match('/^'.$this->getGrammar()->getDefinition('text').'*$/D', $phraseStr)) {
                $phraseStr = $this->getGrammar()->escapeSpecials(
                    $phraseStr, array('"'), $this->getGrammar()->getSpecials()
                    );
=======

        if (!preg_match('/^'.self::PHRASE_PATTERN.'$/D', $phraseStr)) {
            // .. but it is just ascii text, try escaping some characters
            // and make it a quoted-string
            if (preg_match('/^[\x00-\x08\x0B\x0C\x0E-\x7F]*$/D', $phraseStr)) {
                $phraseStr = $this->escapeSpecials($phraseStr, ['"']);
>>>>>>> v2-test
                $phraseStr = '"'.$phraseStr.'"';
            } else {
                // ... otherwise it needs encoding
                // Determine space remaining on line if first line
                if ($shorten) {
<<<<<<< HEAD
                    $usedLength = strlen($header->getFieldName().': ');
=======
                    $usedLength = \strlen($header->getFieldName().': ');
>>>>>>> v2-test
                } else {
                    $usedLength = 0;
                }
                $phraseStr = $this->encodeWords($header, $string, $usedLength);
            }
        }

        return $phraseStr;
    }

    /**
<<<<<<< HEAD
     * Encode needed word tokens within a string of input.
     *
     * @param Swift_Mime_Header $header
     * @param string            $input
     * @param string            $usedLength optional
=======
     * Escape special characters in a string (convert to quoted-pairs).
     *
     * @param string   $token
     * @param string[] $include additional chars to escape
     *
     * @return string
     */
    private function escapeSpecials($token, $include = [])
    {
        foreach (array_merge(['\\'], $include) as $char) {
            $token = str_replace($char, '\\'.$char, $token);
        }

        return $token;
    }

    /**
     * Encode needed word tokens within a string of input.
     *
     * @param string $input
     * @param string $usedLength optional
>>>>>>> v2-test
     *
     * @return string
     */
    protected function encodeWords(Swift_Mime_Header $header, $input, $usedLength = -1)
    {
        $value = '';

        $tokens = $this->getEncodableWordTokens($input);

        foreach ($tokens as $token) {
            // See RFC 2822, Sect 2.2 (really 2.2 ??)
            if ($this->tokenNeedsEncoding($token)) {
                // Don't encode starting WSP
                $firstChar = substr($token, 0, 1);
                switch ($firstChar) {
                    case ' ':
                    case "\t":
                        $value .= $firstChar;
                        $token = substr($token, 1);
                }

                if (-1 == $usedLength) {
<<<<<<< HEAD
                    $usedLength = strlen($header->getFieldName().': ') + strlen($value);
=======
                    $usedLength = \strlen($header->getFieldName().': ') + \strlen($value);
>>>>>>> v2-test
                }
                $value .= $this->getTokenAsEncodedWord($token, $usedLength);

                $header->setMaxLineLength(76); // Forcefully override
            } else {
                $value .= $token;
            }
        }

        return $value;
    }

    /**
     * Test if a token needs to be encoded or not.
     *
     * @param string $token
     *
     * @return bool
     */
    protected function tokenNeedsEncoding($token)
    {
        return preg_match('~[\x00-\x08\x10-\x19\x7F-\xFF\r\n]~', $token);
    }

    /**
     * Splits a string into tokens in blocks of words which can be encoded quickly.
     *
     * @param string $string
     *
     * @return string[]
     */
    protected function getEncodableWordTokens($string)
    {
<<<<<<< HEAD
        $tokens = array();
=======
        $tokens = [];
>>>>>>> v2-test

        $encodedToken = '';
        // Split at all whitespace boundaries
        foreach (preg_split('~(?=[\t ])~', $string) as $token) {
            if ($this->tokenNeedsEncoding($token)) {
                $encodedToken .= $token;
            } else {
<<<<<<< HEAD
                if (strlen($encodedToken) > 0) {
=======
                if (\strlen($encodedToken) > 0) {
>>>>>>> v2-test
                    $tokens[] = $encodedToken;
                    $encodedToken = '';
                }
                $tokens[] = $token;
            }
        }
<<<<<<< HEAD
        if (strlen($encodedToken)) {
=======
        if (\strlen($encodedToken)) {
>>>>>>> v2-test
            $tokens[] = $encodedToken;
        }

        return $tokens;
    }

    /**
     * Get a token as an encoded word for safe insertion into headers.
     *
     * @param string $token           token to encode
     * @param int    $firstLineOffset optional
     *
     * @return string
     */
    protected function getTokenAsEncodedWord($token, $firstLineOffset = 0)
    {
        // Adjust $firstLineOffset to account for space needed for syntax
<<<<<<< HEAD
        $charsetDecl = $this->_charset;
        if (isset($this->_lang)) {
            $charsetDecl .= '*'.$this->_lang;
        }
        $encodingWrapperLength = strlen(
            '=?'.$charsetDecl.'?'.$this->_encoder->getName().'??='
=======
        $charsetDecl = $this->charset;
        if (isset($this->lang)) {
            $charsetDecl .= '*'.$this->lang;
        }
        $encodingWrapperLength = \strlen(
            '=?'.$charsetDecl.'?'.$this->encoder->getName().'??='
>>>>>>> v2-test
            );

        if ($firstLineOffset >= 75) {
            //Does this logic need to be here?
            $firstLineOffset = 0;
        }

        $encodedTextLines = explode("\r\n",
<<<<<<< HEAD
            $this->_encoder->encodeString(
                $token, $firstLineOffset, 75 - $encodingWrapperLength, $this->_charset
                )
        );

        if (strtolower($this->_charset) !== 'iso-2022-jp') {
            // special encoding for iso-2022-jp using mb_encode_mimeheader
            foreach ($encodedTextLines as $lineNum => $line) {
                $encodedTextLines[$lineNum] = '=?'.$charsetDecl.
                    '?'.$this->_encoder->getName().
=======
            $this->encoder->encodeString(
                $token, $firstLineOffset, 75 - $encodingWrapperLength, $this->charset
                )
        );

        if ('iso-2022-jp' !== strtolower($this->charset)) {
            // special encoding for iso-2022-jp using mb_encode_mimeheader
            foreach ($encodedTextLines as $lineNum => $line) {
                $encodedTextLines[$lineNum] = '=?'.$charsetDecl.
                    '?'.$this->encoder->getName().
>>>>>>> v2-test
                    '?'.$line.'?=';
            }
        }

        return implode("\r\n ", $encodedTextLines);
    }

    /**
     * Generates tokens from the given string which include CRLF as individual tokens.
     *
     * @param string $token
     *
     * @return string[]
     */
    protected function generateTokenLines($token)
    {
        return preg_split('~(\r\n)~', $token, -1, PREG_SPLIT_DELIM_CAPTURE);
    }

    /**
     * Set a value into the cache.
     *
     * @param string $value
     */
    protected function setCachedValue($value)
    {
<<<<<<< HEAD
        $this->_cachedValue = $value;
=======
        $this->cachedValue = $value;
>>>>>>> v2-test
    }

    /**
     * Get the value in the cache.
     *
     * @return string
     */
    protected function getCachedValue()
    {
<<<<<<< HEAD
        return $this->_cachedValue;
=======
        return $this->cachedValue;
>>>>>>> v2-test
    }

    /**
     * Clear the cached value if $condition is met.
     *
     * @param bool $condition
     */
    protected function clearCachedValueIf($condition)
    {
        if ($condition) {
            $this->setCachedValue(null);
        }
    }

    /**
     * Generate a list of all tokens in the final header.
     *
     * @param string $string The string to tokenize
     *
     * @return array An array of tokens as strings
     */
    protected function toTokens($string = null)
    {
<<<<<<< HEAD
        if (is_null($string)) {
            $string = $this->getFieldBody();
        }

        $tokens = array();
=======
        if (null === $string) {
            $string = $this->getFieldBody();
        }

        $tokens = [];
>>>>>>> v2-test

        // Generate atoms; split at all invisible boundaries followed by WSP
        foreach (preg_split('~(?=[ \t])~', $string) as $token) {
            $newTokens = $this->generateTokenLines($token);
            foreach ($newTokens as $newToken) {
                $tokens[] = $newToken;
            }
        }

        return $tokens;
    }

    /**
     * Takes an array of tokens which appear in the header and turns them into
     * an RFC 2822 compliant string, adding FWSP where needed.
     *
     * @param string[] $tokens
     *
     * @return string
     */
<<<<<<< HEAD
    private function _tokensToString(array $tokens)
    {
        $lineCount = 0;
        $headerLines = array();
        $headerLines[] = $this->_name.': ';
=======
    private function tokensToString(array $tokens)
    {
        $lineCount = 0;
        $headerLines = [];
        $headerLines[] = $this->name.': ';
>>>>>>> v2-test
        $currentLine = &$headerLines[$lineCount++];

        // Build all tokens back into compliant header
        foreach ($tokens as $i => $token) {
            // Line longer than specified maximum or token was just a new line
            if (("\r\n" == $token) ||
<<<<<<< HEAD
                ($i > 0 && strlen($currentLine.$token) > $this->_lineLength)
                && 0 < strlen($currentLine)) {
=======
                ($i > 0 && \strlen($currentLine.$token) > $this->lineLength)
                && 0 < \strlen($currentLine)) {
>>>>>>> v2-test
                $headerLines[] = '';
                $currentLine = &$headerLines[$lineCount++];
            }

            // Append token to the line
            if ("\r\n" != $token) {
                $currentLine .= $token;
            }
        }

        // Implode with FWS (RFC 2822, 2.2.3)
        return implode("\r\n", $headerLines)."\r\n";
    }
}
