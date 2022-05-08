<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\CssSelector\Parser\Tokenizer;

/**
 * CSS selector tokenizer patterns builder.
 *
 * This component is a port of the Python cssselect library,
 * which is copyright Ian Bicking, @see https://github.com/SimonSapin/cssselect.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
<<<<<<< HEAD
 */
class TokenizerPatterns
{
    /**
     * @var string
     */
    private $unicodeEscapePattern;

    /**
     * @var string
     */
    private $simpleEscapePattern;

    /**
     * @var string
     */
    private $newLineEscapePattern;

    /**
     * @var string
     */
    private $escapePattern;

    /**
     * @var string
     */
    private $stringEscapePattern;

    /**
     * @var string
     */
    private $nonAsciiPattern;

    /**
     * @var string
     */
    private $nmCharPattern;

    /**
     * @var string
     */
    private $nmStartPattern;

    /**
     * @var string
     */
    private $identifierPattern;

    /**
     * @var string
     */
    private $hashPattern;

    /**
     * @var string
     */
    private $numberPattern;

    /**
     * @var string
     */
    private $quotedStringPattern;

    /**
     * Constructor.
     */
=======
 *
 * @internal
 */
class TokenizerPatterns
{
    private $unicodeEscapePattern;
    private $simpleEscapePattern;
    private $newLineEscapePattern;
    private $escapePattern;
    private $stringEscapePattern;
    private $nonAsciiPattern;
    private $nmCharPattern;
    private $nmStartPattern;
    private $identifierPattern;
    private $hashPattern;
    private $numberPattern;
    private $quotedStringPattern;

>>>>>>> v2-test
    public function __construct()
    {
        $this->unicodeEscapePattern = '\\\\([0-9a-f]{1,6})(?:\r\n|[ \n\r\t\f])?';
        $this->simpleEscapePattern = '\\\\(.)';
        $this->newLineEscapePattern = '\\\\(?:\n|\r\n|\r|\f)';
        $this->escapePattern = $this->unicodeEscapePattern.'|\\\\[^\n\r\f0-9a-f]';
        $this->stringEscapePattern = $this->newLineEscapePattern.'|'.$this->escapePattern;
        $this->nonAsciiPattern = '[^\x00-\x7F]';
        $this->nmCharPattern = '[_a-z0-9-]|'.$this->escapePattern.'|'.$this->nonAsciiPattern;
        $this->nmStartPattern = '[_a-z]|'.$this->escapePattern.'|'.$this->nonAsciiPattern;
<<<<<<< HEAD
        $this->identifierPattern = '(?:'.$this->nmStartPattern.')(?:'.$this->nmCharPattern.')*';
=======
        $this->identifierPattern = '-?(?:'.$this->nmStartPattern.')(?:'.$this->nmCharPattern.')*';
>>>>>>> v2-test
        $this->hashPattern = '#((?:'.$this->nmCharPattern.')+)';
        $this->numberPattern = '[+-]?(?:[0-9]*\.[0-9]+|[0-9]+)';
        $this->quotedStringPattern = '([^\n\r\f%s]|'.$this->stringEscapePattern.')*';
    }

<<<<<<< HEAD
    /**
     * @return string
     */
    public function getNewLineEscapePattern()
=======
    public function getNewLineEscapePattern(): string
>>>>>>> v2-test
    {
        return '~^'.$this->newLineEscapePattern.'~';
    }

<<<<<<< HEAD
    /**
     * @return string
     */
    public function getSimpleEscapePattern()
=======
    public function getSimpleEscapePattern(): string
>>>>>>> v2-test
    {
        return '~^'.$this->simpleEscapePattern.'~';
    }

<<<<<<< HEAD
    /**
     * @return string
     */
    public function getUnicodeEscapePattern()
=======
    public function getUnicodeEscapePattern(): string
>>>>>>> v2-test
    {
        return '~^'.$this->unicodeEscapePattern.'~i';
    }

<<<<<<< HEAD
    /**
     * @return string
     */
    public function getIdentifierPattern()
=======
    public function getIdentifierPattern(): string
>>>>>>> v2-test
    {
        return '~^'.$this->identifierPattern.'~i';
    }

<<<<<<< HEAD
    /**
     * @return string
     */
    public function getHashPattern()
=======
    public function getHashPattern(): string
>>>>>>> v2-test
    {
        return '~^'.$this->hashPattern.'~i';
    }

<<<<<<< HEAD
    /**
     * @return string
     */
    public function getNumberPattern()
=======
    public function getNumberPattern(): string
>>>>>>> v2-test
    {
        return '~^'.$this->numberPattern.'~';
    }

<<<<<<< HEAD
    /**
     * @param string $quote
     *
     * @return string
     */
    public function getQuotedStringPattern($quote)
=======
    public function getQuotedStringPattern(string $quote): string
>>>>>>> v2-test
    {
        return '~^'.sprintf($this->quotedStringPattern, $quote).'~i';
    }
}
