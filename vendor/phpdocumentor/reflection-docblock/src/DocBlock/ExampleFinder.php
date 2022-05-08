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
 */

namespace phpDocumentor\Reflection;

use phpDocumentor\Reflection\DocBlock\Tags\Example;
=======
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Reflection\DocBlock;

use phpDocumentor\Reflection\DocBlock\Tags\Example;
use function array_slice;
use function file;
use function getcwd;
use function implode;
use function is_readable;
use function rtrim;
use function sprintf;
use function trim;
use const DIRECTORY_SEPARATOR;
>>>>>>> v2-test

/**
 * Class used to find an example file's location based on a given ExampleDescriptor.
 */
class ExampleFinder
{
    /** @var string */
    private $sourceDirectory = '';

    /** @var string[] */
<<<<<<< HEAD
    private $exampleDirectories = array();

    /**
     * Attempts to find the example contents for the given descriptor.
     *
     * @param Example $example
     *
     * @return string
     */
    public function find(Example $example)
=======
    private $exampleDirectories = [];

    /**
     * Attempts to find the example contents for the given descriptor.
     */
    public function find(Example $example) : string
>>>>>>> v2-test
    {
        $filename = $example->getFilePath();

        $file = $this->getExampleFileContents($filename);
        if (!$file) {
<<<<<<< HEAD
            return "** File not found : {$filename} **";
=======
            return sprintf('** File not found : %s **', $filename);
>>>>>>> v2-test
        }

        return implode('', array_slice($file, $example->getStartingLine() - 1, $example->getLineCount()));
    }

    /**
     * Registers the project's root directory where an 'examples' folder can be expected.
<<<<<<< HEAD
     *
     * @param string $directory
     *
     * @return void
     */
    public function setSourceDirectory($directory = '')
=======
     */
    public function setSourceDirectory(string $directory = '') : void
>>>>>>> v2-test
    {
        $this->sourceDirectory = $directory;
    }

    /**
     * Returns the project's root directory where an 'examples' folder can be expected.
<<<<<<< HEAD
     *
     * @return string
     */
    public function getSourceDirectory()
=======
     */
    public function getSourceDirectory() : string
>>>>>>> v2-test
    {
        return $this->sourceDirectory;
    }

    /**
     * Registers a series of directories that may contain examples.
     *
     * @param string[] $directories
     */
<<<<<<< HEAD
    public function setExampleDirectories(array $directories)
=======
    public function setExampleDirectories(array $directories) : void
>>>>>>> v2-test
    {
        $this->exampleDirectories = $directories;
    }

    /**
     * Returns a series of directories that may contain examples.
     *
     * @return string[]
     */
<<<<<<< HEAD
    public function getExampleDirectories()
=======
    public function getExampleDirectories() : array
>>>>>>> v2-test
    {
        return $this->exampleDirectories;
    }

    /**
     * Attempts to find the requested example file and returns its contents or null if no file was found.
     *
     * This method will try several methods in search of the given example file, the first one it encounters is
     * returned:
     *
     * 1. Iterates through all examples folders for the given filename
     * 2. Checks the source folder for the given filename
     * 3. Checks the 'examples' folder in the current working directory for examples
     * 4. Checks the path relative to the current working directory for the given filename
     *
<<<<<<< HEAD
     * @param string $filename
     *
     * @return string|null
     */
    private function getExampleFileContents($filename)
=======
     * @return string[] all lines of the example file
     */
    private function getExampleFileContents(string $filename) : ?array
>>>>>>> v2-test
    {
        $normalizedPath = null;

        foreach ($this->exampleDirectories as $directory) {
            $exampleFileFromConfig = $this->constructExamplePath($directory, $filename);
            if (is_readable($exampleFileFromConfig)) {
                $normalizedPath = $exampleFileFromConfig;
                break;
            }
        }

        if (!$normalizedPath) {
            if (is_readable($this->getExamplePathFromSource($filename))) {
                $normalizedPath = $this->getExamplePathFromSource($filename);
            } elseif (is_readable($this->getExamplePathFromExampleDirectory($filename))) {
                $normalizedPath = $this->getExamplePathFromExampleDirectory($filename);
            } elseif (is_readable($filename)) {
                $normalizedPath = $filename;
            }
        }

<<<<<<< HEAD
        return $normalizedPath && is_readable($normalizedPath) ? file($normalizedPath) : null;
=======
        $lines = $normalizedPath && is_readable($normalizedPath) ? file($normalizedPath) : false;

        return $lines !== false ? $lines : null;
>>>>>>> v2-test
    }

    /**
     * Get example filepath based on the example directory inside your project.
<<<<<<< HEAD
     *
     * @param string $file
     *
     * @return string
     */
    private function getExamplePathFromExampleDirectory($file)
=======
     */
    private function getExamplePathFromExampleDirectory(string $file) : string
>>>>>>> v2-test
    {
        return getcwd() . DIRECTORY_SEPARATOR . 'examples' . DIRECTORY_SEPARATOR . $file;
    }

    /**
     * Returns a path to the example file in the given directory..
<<<<<<< HEAD
     *
     * @param string $directory
     * @param string $file
     *
     * @return string
     */
    private function constructExamplePath($directory, $file)
=======
     */
    private function constructExamplePath(string $directory, string $file) : string
>>>>>>> v2-test
    {
        return rtrim($directory, '\\/') . DIRECTORY_SEPARATOR . $file;
    }

    /**
     * Get example filepath based on sourcecode.
<<<<<<< HEAD
     *
     * @param string $file
     *
     * @return string
     */
    private function getExamplePathFromSource($file)
=======
     */
    private function getExamplePathFromSource(string $file) : string
>>>>>>> v2-test
    {
        return sprintf(
            '%s%s%s',
            trim($this->getSourceDirectory(), '\\/'),
            DIRECTORY_SEPARATOR,
            trim($file, '"')
        );
    }
}
