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

namespace phpDocumentor\Reflection\DocBlock\Tags\Formatter;

use phpDocumentor\Reflection\DocBlock\Tag;
use phpDocumentor\Reflection\DocBlock\Tags\Formatter;
<<<<<<< HEAD
=======
use function trim;
>>>>>>> v2-test

class PassthroughFormatter implements Formatter
{
    /**
     * Formats the given tag to return a simple plain text version.
<<<<<<< HEAD
     *
     * @param Tag $tag
     *
     * @return string
     */
    public function format(Tag $tag)
    {
        return '@' . $tag->getName() . ' ' . (string)$tag;
=======
     */
    public function format(Tag $tag) : string
    {
        return trim('@' . $tag->getName() . ' ' . $tag);
>>>>>>> v2-test
    }
}
