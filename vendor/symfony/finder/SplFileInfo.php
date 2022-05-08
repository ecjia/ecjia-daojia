<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Finder;

/**
 * Extends \SplFileInfo to support relative paths.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class SplFileInfo extends \SplFileInfo
{
    private $relativePath;
    private $relativePathname;

    /**
<<<<<<< HEAD
     * Constructor.
     *
=======
>>>>>>> v2-test
     * @param string $file             The file name
     * @param string $relativePath     The relative path
     * @param string $relativePathname The relative path name
     */
<<<<<<< HEAD
    public function __construct($file, $relativePath, $relativePathname)
=======
    public function __construct(string $file, string $relativePath, string $relativePathname)
>>>>>>> v2-test
    {
        parent::__construct($file);
        $this->relativePath = $relativePath;
        $this->relativePathname = $relativePathname;
    }

    /**
     * Returns the relative path.
     *
     * This path does not contain the file name.
     *
     * @return string the relative path
     */
    public function getRelativePath()
    {
        return $this->relativePath;
    }

    /**
     * Returns the relative path name.
     *
     * This path contains the file name.
     *
     * @return string the relative path name
     */
    public function getRelativePathname()
    {
        return $this->relativePathname;
    }

<<<<<<< HEAD
=======
    public function getFilenameWithoutExtension(): string
    {
        $filename = $this->getFilename();

        return pathinfo($filename, \PATHINFO_FILENAME);
    }

>>>>>>> v2-test
    /**
     * Returns the contents of the file.
     *
     * @return string the contents of the file
     *
     * @throws \RuntimeException
     */
    public function getContents()
    {
<<<<<<< HEAD
        $level = error_reporting(0);
        $content = file_get_contents($this->getPathname());
        error_reporting($level);
        if (false === $content) {
            $error = error_get_last();
            throw new \RuntimeException($error['message']);
=======
        set_error_handler(function ($type, $msg) use (&$error) { $error = $msg; });
        $content = file_get_contents($this->getPathname());
        restore_error_handler();
        if (false === $content) {
            throw new \RuntimeException($error);
>>>>>>> v2-test
        }

        return $content;
    }
}
