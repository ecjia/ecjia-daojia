<?php
<<<<<<< HEAD
=======

declare(strict_types=1);

>>>>>>> v2-test
/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
<<<<<<< HEAD
 * @copyright 2010-2015 Mike van Riel<mike@phpdoc.org>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
=======
>>>>>>> v2-test
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Reflection\Types;

use phpDocumentor\Reflection\Type;

/**
 * Value Object representing a Compound Type.
 *
 * A Compound Type is not so much a special keyword or object reference but is a series of Types that are separated
 * using an OR operator (`|`). This combination of types signifies that whatever is associated with this compound type
 * may contain a value with any of the given types.
<<<<<<< HEAD
 */
final class Compound implements Type
{
    /** @var Type[] */
    private $types = [];

    /**
     * Initializes a compound type (i.e. `string|int`) and tests if the provided types all implement the Type interface.
     *
     * @param Type[] $types
     */
    public function __construct(array $types)
    {
        foreach ($types as $type) {
            if (!$type instanceof Type) {
                throw new \InvalidArgumentException('A compound type can only have other types as elements');
            }
        }

        $this->types = $types;
    }

    /**
     * Returns the type at the given index.
     *
     * @param integer $index
     *
     * @return Type|null
     */
    public function get($index)
    {
        if (!$this->has($index)) {
            return null;
        }

        return $this->types[$index];
    }

    /**
     * Tests if this compound type has a type with the given index.
     *
     * @param integer $index
     *
     * @return bool
     */
    public function has($index)
    {
        return isset($this->types[$index]);
    }

    /**
     * Returns a rendered output of the Type as it would be used in a DocBlock.
     *
     * @return string
     */
    public function __toString()
    {
        return implode('|', $this->types);
=======
 *
 * @psalm-immutable
 */
final class Compound extends AggregatedType
{
    /**
     * Initializes a compound type (i.e. `string|int`) and tests if the provided types all implement the Type interface.
     *
     * @param array<Type> $types
     */
    public function __construct(array $types)
    {
        parent::__construct($types, '|');
>>>>>>> v2-test
    }
}
