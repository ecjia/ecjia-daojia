<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Process;

/**
 * Generic executable finder.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class ExecutableFinder
{
<<<<<<< HEAD
    private $suffixes = array('.exe', '.bat', '.cmd', '.com');

    /**
     * Replaces default suffixes of executable.
     *
     * @param array $suffixes
=======
    private $suffixes = ['.exe', '.bat', '.cmd', '.com'];

    /**
     * Replaces default suffixes of executable.
>>>>>>> v2-test
     */
    public function setSuffixes(array $suffixes)
    {
        $this->suffixes = $suffixes;
    }

    /**
     * Adds new possible suffix to check for executable.
<<<<<<< HEAD
     *
     * @param string $suffix
     */
    public function addSuffix($suffix)
=======
     */
    public function addSuffix(string $suffix)
>>>>>>> v2-test
    {
        $this->suffixes[] = $suffix;
    }

    /**
     * Finds an executable by name.
     *
<<<<<<< HEAD
     * @param string $name      The executable name (without the extension)
     * @param string $default   The default to return if no executable is found
     * @param array  $extraDirs Additional dirs to check into
     *
     * @return string The executable path or default value
     */
    public function find($name, $default = null, array $extraDirs = array())
    {
        if (ini_get('open_basedir')) {
            $searchPath = explode(PATH_SEPARATOR, ini_get('open_basedir'));
            $dirs = array();
=======
     * @param string      $name      The executable name (without the extension)
     * @param string|null $default   The default to return if no executable is found
     * @param array       $extraDirs Additional dirs to check into
     *
     * @return string|null The executable path or default value
     */
    public function find(string $name, string $default = null, array $extraDirs = [])
    {
        if (ini_get('open_basedir')) {
            $searchPath = array_merge(explode(\PATH_SEPARATOR, ini_get('open_basedir')), $extraDirs);
            $dirs = [];
>>>>>>> v2-test
            foreach ($searchPath as $path) {
                // Silencing against https://bugs.php.net/69240
                if (@is_dir($path)) {
                    $dirs[] = $path;
                } else {
                    if (basename($path) == $name && @is_executable($path)) {
                        return $path;
                    }
                }
            }
        } else {
            $dirs = array_merge(
<<<<<<< HEAD
                explode(PATH_SEPARATOR, getenv('PATH') ?: getenv('Path')),
=======
                explode(\PATH_SEPARATOR, getenv('PATH') ?: getenv('Path')),
>>>>>>> v2-test
                $extraDirs
            );
        }

<<<<<<< HEAD
        $suffixes = array('');
        if ('\\' === DIRECTORY_SEPARATOR) {
            $pathExt = getenv('PATHEXT');
            $suffixes = $pathExt ? explode(PATH_SEPARATOR, $pathExt) : $this->suffixes;
        }
        foreach ($suffixes as $suffix) {
            foreach ($dirs as $dir) {
                if (is_file($file = $dir.DIRECTORY_SEPARATOR.$name.$suffix) && ('\\' === DIRECTORY_SEPARATOR || is_executable($file))) {
=======
        $suffixes = [''];
        if ('\\' === \DIRECTORY_SEPARATOR) {
            $pathExt = getenv('PATHEXT');
            $suffixes = array_merge($pathExt ? explode(\PATH_SEPARATOR, $pathExt) : $this->suffixes, $suffixes);
        }
        foreach ($suffixes as $suffix) {
            foreach ($dirs as $dir) {
                if (@is_file($file = $dir.\DIRECTORY_SEPARATOR.$name.$suffix) && ('\\' === \DIRECTORY_SEPARATOR || @is_executable($file))) {
>>>>>>> v2-test
                    return $file;
                }
            }
        }

        return $default;
    }
}
