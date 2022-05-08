<?php

/*
 * This file is part of PhpSpec, A php toolset to drive emergent
 * design by specification.
 *
 * (c) Marcello Duarte <marcello.duarte@gmail.com>
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpSpec\Util;

use Symfony\Component\Finder\Finder;

class Filesystem
{
    /**
     * @param string $path
     *
     * @return bool
     */
<<<<<<< HEAD
    public function pathExists($path)
=======
    public function pathExists(string $path): bool
>>>>>>> v2-test
    {
        return file_exists($path);
    }

    /**
     * @param string $path
     *
     * @return string
     */
<<<<<<< HEAD
    public function getFileContents($path)
=======
    public function getFileContents(string $path): string
>>>>>>> v2-test
    {
        return file_get_contents($path);
    }

    /**
     * @param string $path
     * @param string $content
     */
<<<<<<< HEAD
    public function putFileContents($path, $content)
=======
    public function putFileContents(string $path, string $content)
>>>>>>> v2-test
    {
        file_put_contents($path, $content);
    }

    /**
     * @param string $path
     *
     * @return bool
     */
<<<<<<< HEAD
    public function isDirectory($path)
=======
    public function isDirectory(string $path): bool
>>>>>>> v2-test
    {
        return is_dir($path);
    }

    /**
     * @param string $path
     */
<<<<<<< HEAD
    public function makeDirectory($path)
=======
    public function makeDirectory(string $path): void
>>>>>>> v2-test
    {
        mkdir($path, 0777, true);
    }

    /**
     * @param string $path
     *
     * @return \SplFileInfo[]
     */
<<<<<<< HEAD
    public function findSpecFilesIn($path)
=======
    public function findSpecFilesIn(string $path): array
>>>>>>> v2-test
    {
        $finder = Finder::create()
            ->files()
            ->name('*Spec.php')
            ->followLinks()
            ->sortByName()
            ->in($path)
        ;

        return iterator_to_array($finder);
    }
<<<<<<< HEAD

    /**
     * @param $path
     *
     * @deprecated deprecated since 2.1
     * @return array
     */
    public function findPhpFilesIn($path)
    {
        $finder = Finder::create()
            ->files()
            ->name('*.php')
            ->followLinks()
            ->sortByName()
            ->in($path)
        ;

        return iterator_to_array($finder);
    }
=======
>>>>>>> v2-test
}
