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

/**
 * CSS selector reader.
 *
 * This component is a port of the Python cssselect library,
 * which is copyright Ian Bicking, @see https://github.com/SimonSapin/cssselect.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
<<<<<<< HEAD
 */
class Reader
{
    /**
     * @var string
     */
    private $source;

    /**
     * @var int
     */
    private $length;

    /**
     * @var int
     */
    private $position = 0;

    /**
     * @param string $source
     */
    public function __construct($source)
    {
        $this->source = $source;
        $this->length = strlen($source);
    }

    /**
     * @return bool
     */
    public function isEOF()
=======
 *
 * @internal
 */
class Reader
{
    private $source;
    private $length;
    private $position = 0;

    public function __construct(string $source)
    {
        $this->source = $source;
        $this->length = \strlen($source);
    }

    public function isEOF(): bool
>>>>>>> v2-test
    {
        return $this->position >= $this->length;
    }

<<<<<<< HEAD
    /**
     * @return int
     */
    public function getPosition()
=======
    public function getPosition(): int
>>>>>>> v2-test
    {
        return $this->position;
    }

<<<<<<< HEAD
    /**
     * @return int
     */
    public function getRemainingLength()
=======
    public function getRemainingLength(): int
>>>>>>> v2-test
    {
        return $this->length - $this->position;
    }

<<<<<<< HEAD
    /**
     * @param int $length
     * @param int $offset
     *
     * @return string
     */
    public function getSubstring($length, $offset = 0)
=======
    public function getSubstring(int $length, int $offset = 0): string
>>>>>>> v2-test
    {
        return substr($this->source, $this->position + $offset, $length);
    }

<<<<<<< HEAD
    /**
     * @param string $string
     *
     * @return int
     */
    public function getOffset($string)
=======
    public function getOffset(string $string)
>>>>>>> v2-test
    {
        $position = strpos($this->source, $string, $this->position);

        return false === $position ? false : $position - $this->position;
    }

    /**
<<<<<<< HEAD
     * @param string $pattern
     *
     * @return bool
     */
    public function findPattern($pattern)
=======
     * @return array|false
     */
    public function findPattern(string $pattern)
>>>>>>> v2-test
    {
        $source = substr($this->source, $this->position);

        if (preg_match($pattern, $source, $matches)) {
            return $matches;
        }

        return false;
    }

<<<<<<< HEAD
    /**
     * @param int $length
     */
    public function moveForward($length)
=======
    public function moveForward(int $length)
>>>>>>> v2-test
    {
        $this->position += $length;
    }

<<<<<<< HEAD
    /**
     */
=======
>>>>>>> v2-test
    public function moveToEnd()
    {
        $this->position = $this->length;
    }
}
