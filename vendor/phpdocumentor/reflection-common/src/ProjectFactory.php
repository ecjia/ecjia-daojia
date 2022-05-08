<?php
<<<<<<< HEAD
/**
 * phpDocumentor
 *
 * PHP Version 5.5
 *
 * @copyright 2010-2015 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */
=======

declare(strict_types=1);

/**
 * phpDocumentor
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link      http://phpdoc.org
 */

>>>>>>> v2-test
namespace phpDocumentor\Reflection;

/**
 * Interface for project factories. A project factory shall convert a set of files
 * into an object implementing the Project interface.
 */
interface ProjectFactory
{
    /**
     * Creates a project from the set of files.
     *
<<<<<<< HEAD
     * @param string $name
     * @param File[] $files
     * @return Project
     */
    public function create($name, array $files);
=======
     * @param File[] $files
     */
    public function create(string $name, array $files) : Project;
>>>>>>> v2-test
}
