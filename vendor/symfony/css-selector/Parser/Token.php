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
 * CSS selector token.
 *
 * This component is a port of the Python cssselect library,
 * which is copyright Ian Bicking, @see https://github.com/SimonSapin/cssselect.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
<<<<<<< HEAD
 */
class Token
{
    const TYPE_FILE_END = 'eof';
    const TYPE_DELIMITER = 'delimiter';
    const TYPE_WHITESPACE = 'whitespace';
    const TYPE_IDENTIFIER = 'identifier';
    const TYPE_HASH = 'hash';
    const TYPE_NUMBER = 'number';
    const TYPE_STRING = 'string';

    /**
     * @var int
     */
    private $type;

    /**
     * @var string
     */
    private $value;

    /**
     * @var int
     */
    private $position;

    /**
     * @param int    $type
     * @param string $value
     * @param int    $position
     */
    public function __construct($type, $value, $position)
=======
 *
 * @internal
 */
class Token
{
    public const TYPE_FILE_END = 'eof';
    public const TYPE_DELIMITER = 'delimiter';
    public const TYPE_WHITESPACE = 'whitespace';
    public const TYPE_IDENTIFIER = 'identifier';
    public const TYPE_HASH = 'hash';
    public const TYPE_NUMBER = 'number';
    public const TYPE_STRING = 'string';

    private $type;
    private $value;
    private $position;

    public function __construct(?string $type, ?string $value, ?int $position)
>>>>>>> v2-test
    {
        $this->type = $type;
        $this->value = $value;
        $this->position = $position;
    }

<<<<<<< HEAD
    /**
     * @return int
     */
    public function getType()
=======
    public function getType(): ?int
>>>>>>> v2-test
    {
        return $this->type;
    }

<<<<<<< HEAD
    /**
     * @return string
     */
    public function getValue()
=======
    public function getValue(): ?string
>>>>>>> v2-test
    {
        return $this->value;
    }

<<<<<<< HEAD
    /**
     * @return int
     */
    public function getPosition()
=======
    public function getPosition(): ?int
>>>>>>> v2-test
    {
        return $this->position;
    }

<<<<<<< HEAD
    /**
     * @return bool
     */
    public function isFileEnd()
=======
    public function isFileEnd(): bool
>>>>>>> v2-test
    {
        return self::TYPE_FILE_END === $this->type;
    }

<<<<<<< HEAD
    /**
     * @param array $values
     *
     * @return bool
     */
    public function isDelimiter(array $values = array())
=======
    public function isDelimiter(array $values = []): bool
>>>>>>> v2-test
    {
        if (self::TYPE_DELIMITER !== $this->type) {
            return false;
        }

        if (empty($values)) {
            return true;
        }

<<<<<<< HEAD
        return in_array($this->value, $values);
    }

    /**
     * @return bool
     */
    public function isWhitespace()
=======
        return \in_array($this->value, $values);
    }

    public function isWhitespace(): bool
>>>>>>> v2-test
    {
        return self::TYPE_WHITESPACE === $this->type;
    }

<<<<<<< HEAD
    /**
     * @return bool
     */
    public function isIdentifier()
=======
    public function isIdentifier(): bool
>>>>>>> v2-test
    {
        return self::TYPE_IDENTIFIER === $this->type;
    }

<<<<<<< HEAD
    /**
     * @return bool
     */
    public function isHash()
=======
    public function isHash(): bool
>>>>>>> v2-test
    {
        return self::TYPE_HASH === $this->type;
    }

<<<<<<< HEAD
    /**
     * @return bool
     */
    public function isNumber()
=======
    public function isNumber(): bool
>>>>>>> v2-test
    {
        return self::TYPE_NUMBER === $this->type;
    }

<<<<<<< HEAD
    /**
     * @return bool
     */
    public function isString()
=======
    public function isString(): bool
>>>>>>> v2-test
    {
        return self::TYPE_STRING === $this->type;
    }

<<<<<<< HEAD
    /**
     * @return string
     */
    public function __toString()
=======
    public function __toString(): string
>>>>>>> v2-test
    {
        if ($this->value) {
            return sprintf('<%s "%s" at %s>', $this->type, $this->value, $this->position);
        }

        return sprintf('<%s at %s>', $this->type, $this->position);
    }
}
