<?php
<<<<<<< HEAD
/**
 * phpDocumentor
 *
 * PHP Version 5.5
 *
 * @copyright 2010-2015 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
=======

declare(strict_types=1);

/**
 * phpDocumentor
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
>>>>>>> v2-test
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Reflection;

/**
 * Interface for project. Since the definition of a project can be different per factory this interface will be small.
 */
interface Project
{
    /**
     * Returns the name of the project.
<<<<<<< HEAD
     *
     * @return string
     */
    public function getName();
=======
     */
    public function getName() : string;
>>>>>>> v2-test
}
