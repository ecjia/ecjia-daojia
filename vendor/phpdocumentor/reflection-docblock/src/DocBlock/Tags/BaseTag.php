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
 * @link      http://phpdoc.org
=======
 * @link http://phpdoc.org
>>>>>>> v2-test
 */

namespace phpDocumentor\Reflection\DocBlock\Tags;

use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlock\Description;

/**
 * Parses a tag definition for a DocBlock.
 */
abstract class BaseTag implements DocBlock\Tag
{
    /** @var string Name of the tag */
    protected $name = '';

    /** @var Description|null Description of the tag. */
    protected $description;

    /**
     * Gets the name of this tag.
     *
     * @return string The name of this tag.
     */
<<<<<<< HEAD
    public function getName()
=======
    public function getName() : string
>>>>>>> v2-test
    {
        return $this->name;
    }

<<<<<<< HEAD
    public function getDescription()
=======
    public function getDescription() : ?Description
>>>>>>> v2-test
    {
        return $this->description;
    }

<<<<<<< HEAD
    public function render(Formatter $formatter = null)
=======
    public function render(?Formatter $formatter = null) : string
>>>>>>> v2-test
    {
        if ($formatter === null) {
            $formatter = new Formatter\PassthroughFormatter();
        }

        return $formatter->format($this);
    }
}
