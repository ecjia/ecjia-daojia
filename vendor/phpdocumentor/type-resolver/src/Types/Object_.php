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

<<<<<<< HEAD
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Type;
=======
use InvalidArgumentException;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Type;
use function strpos;
>>>>>>> v2-test

/**
 * Value Object representing an object.
 *
 * An object can be either typed or untyped. When an object is typed it means that it has an identifier, the FQSEN,
 * pointing to an element in PHP. Object types that are untyped do not refer to a specific class but represent objects
 * in general.
<<<<<<< HEAD
=======
 *
 * @psalm-immutable
>>>>>>> v2-test
 */
final class Object_ implements Type
{
    /** @var Fqsen|null */
    private $fqsen;

    /**
     * Initializes this object with an optional FQSEN, if not provided this object is considered 'untyped'.
     *
<<<<<<< HEAD
     * @param Fqsen $fqsen
     */
    public function __construct(Fqsen $fqsen = null)
    {
        if (strpos((string)$fqsen, '::') !== false || strpos((string)$fqsen, '()') !== false) {
            throw new \InvalidArgumentException(
                'Object types can only refer to a class, interface or trait but a method, function, constant or '
                . 'property was received: ' . (string)$fqsen
=======
     * @throws InvalidArgumentException When provided $fqsen is not a valid type.
     */
    public function __construct(?Fqsen $fqsen = null)
    {
        if (strpos((string) $fqsen, '::') !== false || strpos((string) $fqsen, '()') !== false) {
            throw new InvalidArgumentException(
                'Object types can only refer to a class, interface or trait but a method, function, constant or '
                . 'property was received: ' . (string) $fqsen
>>>>>>> v2-test
            );
        }

        $this->fqsen = $fqsen;
    }

    /**
     * Returns the FQSEN associated with this object.
<<<<<<< HEAD
     *
     * @return Fqsen|null
     */
    public function getFqsen()
=======
     */
    public function getFqsen() : ?Fqsen
>>>>>>> v2-test
    {
        return $this->fqsen;
    }

<<<<<<< HEAD
    /**
     * Returns a rendered output of the Type as it would be used in a DocBlock.
     *
     * @return string
     */
    public function __toString()
    {
        if ($this->fqsen) {
            return (string)$this->fqsen;
=======
    public function __toString() : string
    {
        if ($this->fqsen) {
            return (string) $this->fqsen;
>>>>>>> v2-test
        }

        return 'object';
    }
}
