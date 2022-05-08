<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Extractor;

<<<<<<< HEAD
=======
use Symfony\Component\Translation\Exception\InvalidArgumentException;

>>>>>>> v2-test
/**
 * Base class used by classes that extract translation messages from files.
 *
 * @author Marcos D. Sánchez <marcosdsanchez@gmail.com>
 */
abstract class AbstractFileExtractor
{
    /**
<<<<<<< HEAD
     * @param string|array $resource files, a file or a directory
     *
     * @return array
     */
    protected function extractFiles($resource)
    {
        if (is_array($resource) || $resource instanceof \Traversable) {
            $files = array();
=======
     * @param string|iterable $resource Files, a file or a directory
     *
     * @return iterable
     */
    protected function extractFiles($resource)
    {
        if (is_iterable($resource)) {
            $files = [];
>>>>>>> v2-test
            foreach ($resource as $file) {
                if ($this->canBeExtracted($file)) {
                    $files[] = $this->toSplFileInfo($file);
                }
            }
        } elseif (is_file($resource)) {
<<<<<<< HEAD
            $files = $this->canBeExtracted($resource) ? array($this->toSplFileInfo($resource)) : array();
=======
            $files = $this->canBeExtracted($resource) ? [$this->toSplFileInfo($resource)] : [];
>>>>>>> v2-test
        } else {
            $files = $this->extractFromDirectory($resource);
        }

        return $files;
    }

<<<<<<< HEAD
    /**
     * @param string $file
     *
     * @return \SplFileInfo
     */
    private function toSplFileInfo($file)
    {
        return ($file instanceof \SplFileInfo) ? $file : new \SplFileInfo($file);
    }

    /**
     * @param string $file
     *
     * @return bool
     *
     * @throws \InvalidArgumentException
     */
    protected function isFile($file)
    {
        if (!is_file($file)) {
            throw new \InvalidArgumentException(sprintf('The "%s" file does not exist.', $file));
=======
    private function toSplFileInfo(string $file): \SplFileInfo
    {
        return new \SplFileInfo($file);
    }

    /**
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    protected function isFile(string $file)
    {
        if (!is_file($file)) {
            throw new InvalidArgumentException(sprintf('The "%s" file does not exist.', $file));
>>>>>>> v2-test
        }

        return true;
    }

    /**
<<<<<<< HEAD
     * @param string $file
     *
     * @return bool
     */
    abstract protected function canBeExtracted($file);

    /**
     * @param string|array $resource files, a file or a directory
     *
     * @return array files to be extracted
=======
     * @return bool
     */
    abstract protected function canBeExtracted(string $file);

    /**
     * @param string|array $resource Files, a file or a directory
     *
     * @return iterable files to be extracted
>>>>>>> v2-test
     */
    abstract protected function extractFromDirectory($resource);
}
