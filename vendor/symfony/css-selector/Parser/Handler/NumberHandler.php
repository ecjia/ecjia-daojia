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

use Symfony\Component\CssSelector\Parser\Reader;
use Symfony\Component\CssSelector\Parser\Token;
<<<<<<< HEAD
use Symfony\Component\CssSelector\Parser\TokenStream;
use Symfony\Component\CssSelector\Parser\Tokenizer\TokenizerPatterns;
=======
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
class NumberHandler implements HandlerInterface
{
    /**
     * @var TokenizerPatterns
     */
    private $patterns;

    /**
     * @param TokenizerPatterns $patterns
     */
=======
 *
 * @internal
 */
class NumberHandler implements HandlerInterface
{
    private $patterns;

>>>>>>> v2-test
    public function __construct(TokenizerPatterns $patterns)
    {
        $this->patterns = $patterns;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function handle(Reader $reader, TokenStream $stream)
=======
    public function handle(Reader $reader, TokenStream $stream): bool
>>>>>>> v2-test
    {
        $match = $reader->findPattern($this->patterns->getNumberPattern());

        if (!$match) {
            return false;
        }

        $stream->push(new Token(Token::TYPE_NUMBER, $match[0], $reader->getPosition()));
<<<<<<< HEAD
        $reader->moveForward(strlen($match[0]));
=======
        $reader->moveForward(\strlen($match[0]));
>>>>>>> v2-test

        return true;
    }
}
