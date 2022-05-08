<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\CssSelector\Parser\Handler;

use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\CssSelector\Exception\SyntaxErrorException;
use Symfony\Component\CssSelector\Parser\Reader;
use Symfony\Component\CssSelector\Parser\Token;
<<<<<<< HEAD
use Symfony\Component\CssSelector\Parser\TokenStream;
use Symfony\Component\CssSelector\Parser\Tokenizer\TokenizerEscaping;
use Symfony\Component\CssSelector\Parser\Tokenizer\TokenizerPatterns;
=======
use Symfony\Component\CssSelector\Parser\Tokenizer\TokenizerEscaping;
use Symfony\Component\CssSelector\Parser\Tokenizer\TokenizerPatterns;
use Symfony\Component\CssSelector\Parser\TokenStream;
>>>>>>> v2-test

/**
 * CSS selector comment handler.
 *
 * This component is a port of the Python cssselect library,
 * which is copyright Ian Bicking, @see https://github.com/SimonSapin/cssselect.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
<<<<<<< HEAD
 */
class StringHandler implements HandlerInterface
{
    /**
     * @var TokenizerPatterns
     */
    private $patterns;

    /**
     * @var TokenizerEscaping
     */
    private $escaping;

    /**
     * @param TokenizerPatterns $patterns
     * @param TokenizerEscaping $escaping
     */
=======
 *
 * @internal
 */
class StringHandler implements HandlerInterface
{
    private $patterns;
    private $escaping;

>>>>>>> v2-test
    public function __construct(TokenizerPatterns $patterns, TokenizerEscaping $escaping)
    {
        $this->patterns = $patterns;
        $this->escaping = $escaping;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function handle(Reader $reader, TokenStream $stream)
    {
        $quote = $reader->getSubstring(1);

        if (!in_array($quote, array("'", '"'))) {
=======
    public function handle(Reader $reader, TokenStream $stream): bool
    {
        $quote = $reader->getSubstring(1);

        if (!\in_array($quote, ["'", '"'])) {
>>>>>>> v2-test
            return false;
        }

        $reader->moveForward(1);
        $match = $reader->findPattern($this->patterns->getQuotedStringPattern($quote));

        if (!$match) {
<<<<<<< HEAD
            throw new InternalErrorException(sprintf('Should have found at least an empty match at %s.', $reader->getPosition()));
        }

        // check unclosed strings
        if (strlen($match[0]) === $reader->getRemainingLength()) {
=======
            throw new InternalErrorException(sprintf('Should have found at least an empty match at %d.', $reader->getPosition()));
        }

        // check unclosed strings
        if (\strlen($match[0]) === $reader->getRemainingLength()) {
>>>>>>> v2-test
            throw SyntaxErrorException::unclosedString($reader->getPosition() - 1);
        }

        // check quotes pairs validity
<<<<<<< HEAD
        if ($quote !== $reader->getSubstring(1, strlen($match[0]))) {
=======
        if ($quote !== $reader->getSubstring(1, \strlen($match[0]))) {
>>>>>>> v2-test
            throw SyntaxErrorException::unclosedString($reader->getPosition() - 1);
        }

        $string = $this->escaping->escapeUnicodeAndNewLine($match[0]);
        $stream->push(new Token(Token::TYPE_STRING, $string, $reader->getPosition()));
<<<<<<< HEAD
        $reader->moveForward(strlen($match[0]) + 1);
=======
        $reader->moveForward(\strlen($match[0]) + 1);
>>>>>>> v2-test

        return true;
    }
}
