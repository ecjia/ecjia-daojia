<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\CssSelector\Parser;

use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\CssSelector\Exception\SyntaxErrorException;

/**
 * CSS selector token stream.
 *
 * This component is a port of the Python cssselect library,
 * which is copyright Ian Bicking, @see https://github.com/SimonSapin/cssselect.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
<<<<<<< HEAD
=======
 *
 * @internal
>>>>>>> v2-test
 */
class TokenStream
{
    /**
     * @var Token[]
     */
<<<<<<< HEAD
    private $tokens = array();

    /**
     * @var bool
     */
    private $frozen = false;
=======
    private $tokens = [];
>>>>>>> v2-test

    /**
     * @var Token[]
     */
<<<<<<< HEAD
    private $used = array();
=======
    private $used = [];
>>>>>>> v2-test

    /**
     * @var int
     */
    private $cursor = 0;

    /**
     * @var Token|null
     */
<<<<<<< HEAD
    private $peeked = null;
=======
    private $peeked;
>>>>>>> v2-test

    /**
     * @var bool
     */
    private $peeking = false;

    /**
     * Pushes a token.
     *
<<<<<<< HEAD
     * @param Token $token
     *
     * @return TokenStream
     */
    public function push(Token $token)
=======
     * @return $this
     */
    public function push(Token $token): self
>>>>>>> v2-test
    {
        $this->tokens[] = $token;

        return $this;
    }

    /**
     * Freezes stream.
     *
<<<<<<< HEAD
     * @return TokenStream
     */
    public function freeze()
    {
        $this->frozen = true;

=======
     * @return $this
     */
    public function freeze(): self
    {
>>>>>>> v2-test
        return $this;
    }

    /**
     * Returns next token.
     *
<<<<<<< HEAD
     * @return Token
     *
     * @throws InternalErrorException If there is no more token
     */
    public function getNext()
=======
     * @throws InternalErrorException If there is no more token
     */
    public function getNext(): Token
>>>>>>> v2-test
    {
        if ($this->peeking) {
            $this->peeking = false;
            $this->used[] = $this->peeked;

            return $this->peeked;
        }

        if (!isset($this->tokens[$this->cursor])) {
            throw new InternalErrorException('Unexpected token stream end.');
        }

        return $this->tokens[$this->cursor++];
    }

    /**
     * Returns peeked token.
<<<<<<< HEAD
     *
     * @return Token
     */
    public function getPeek()
=======
     */
    public function getPeek(): Token
>>>>>>> v2-test
    {
        if (!$this->peeking) {
            $this->peeked = $this->getNext();
            $this->peeking = true;
        }

        return $this->peeked;
    }

    /**
     * Returns used tokens.
     *
     * @return Token[]
     */
<<<<<<< HEAD
    public function getUsed()
=======
    public function getUsed(): array
>>>>>>> v2-test
    {
        return $this->used;
    }

    /**
     * Returns nex identifier token.
     *
     * @return string The identifier token value
     *
     * @throws SyntaxErrorException If next token is not an identifier
     */
<<<<<<< HEAD
    public function getNextIdentifier()
=======
    public function getNextIdentifier(): string
>>>>>>> v2-test
    {
        $next = $this->getNext();

        if (!$next->isIdentifier()) {
            throw SyntaxErrorException::unexpectedToken('identifier', $next);
        }

        return $next->getValue();
    }

    /**
     * Returns nex identifier or star delimiter token.
     *
<<<<<<< HEAD
     * @return null|string The identifier token value or null if star found
     *
     * @throws SyntaxErrorException If next token is not an identifier or a star delimiter
     */
    public function getNextIdentifierOrStar()
=======
     * @return string|null The identifier token value or null if star found
     *
     * @throws SyntaxErrorException If next token is not an identifier or a star delimiter
     */
    public function getNextIdentifierOrStar(): ?string
>>>>>>> v2-test
    {
        $next = $this->getNext();

        if ($next->isIdentifier()) {
            return $next->getValue();
        }

<<<<<<< HEAD
        if ($next->isDelimiter(array('*'))) {
            return;
=======
        if ($next->isDelimiter(['*'])) {
            return null;
>>>>>>> v2-test
        }

        throw SyntaxErrorException::unexpectedToken('identifier or "*"', $next);
    }

    /**
     * Skips next whitespace if any.
     */
    public function skipWhitespace()
    {
        $peek = $this->getPeek();

        if ($peek->isWhitespace()) {
            $this->getNext();
        }
    }
}
