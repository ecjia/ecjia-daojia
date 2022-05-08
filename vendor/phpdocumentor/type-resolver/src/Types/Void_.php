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
 * Value Object representing the pseudo-type 'void'.
 *
 * Void is generally only used when working with return types as it signifies that the method intentionally does not
 * return any value.
<<<<<<< HEAD
=======
 *
 * @psalm-immutable
>>>>>>> v2-test
 */
final class Void_ implements Type
{
    /**
     * Returns a rendered output of the Type as it would be used in a DocBlock.
<<<<<<< HEAD
     *
     * @return string
     */
    public function __toString()
=======
     */
    public function __toString() : string
>>>>>>> v2-test
    {
        return 'void';
    }
}
