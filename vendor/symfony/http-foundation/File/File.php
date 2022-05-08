<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\File;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
<<<<<<< HEAD
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;
=======
use Symfony\Component\Mime\MimeTypes;
>>>>>>> v2-test

/**
 * A file in the file system.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class File extends \SplFileInfo
{
    /**
     * Constructs a new file from the given path.
     *
     * @param string $path      The path to the file
     * @param bool   $checkPath Whether to check the path or not
     *
     * @throws FileNotFoundException If the given path is not a file
     */
<<<<<<< HEAD
    public function __construct($path, $checkPath = true)
=======
    public function __construct(string $path, bool $checkPath = true)
>>>>>>> v2-test
    {
        if ($checkPath && !is_file($path)) {
            throw new FileNotFoundException($path);
        }

        parent::__construct($path);
    }

    /**
     * Returns the extension based on the mime type.
     *
     * If the mime type is unknown, returns null.
     *
     * This method uses the mime type as guessed by getMimeType()
     * to guess the file extension.
     *
     * @return string|null The guessed extension or null if it cannot be guessed
     *
<<<<<<< HEAD
     * @see ExtensionGuesser
=======
     * @see MimeTypes
>>>>>>> v2-test
     * @see getMimeType()
     */
    public function guessExtension()
    {
<<<<<<< HEAD
        $type = $this->getMimeType();
        $guesser = ExtensionGuesser::getInstance();

        return $guesser->guess($type);
=======
        if (!class_exists(MimeTypes::class)) {
            throw new \LogicException('You cannot guess the extension as the Mime component is not installed. Try running "composer require symfony/mime".');
        }

        return MimeTypes::getDefault()->getExtensions($this->getMimeType())[0] ?? null;
>>>>>>> v2-test
    }

    /**
     * Returns the mime type of the file.
     *
<<<<<<< HEAD
     * The mime type is guessed using a MimeTypeGuesser instance, which uses finfo(),
     * mime_content_type() and the system binary "file" (in this order), depending on
     * which of those are available.
     *
     * @return string|null The guessed mime type (e.g. "application/pdf")
     *
     * @see MimeTypeGuesser
     */
    public function getMimeType()
    {
        $guesser = MimeTypeGuesser::getInstance();

        return $guesser->guess($this->getPathname());
=======
     * The mime type is guessed using a MimeTypeGuesserInterface instance,
     * which uses finfo_file() then the "file" system binary,
     * depending on which of those are available.
     *
     * @return string|null The guessed mime type (e.g. "application/pdf")
     *
     * @see MimeTypes
     */
    public function getMimeType()
    {
        if (!class_exists(MimeTypes::class)) {
            throw new \LogicException('You cannot guess the mime type as the Mime component is not installed. Try running "composer require symfony/mime".');
        }

        return MimeTypes::getDefault()->guessMimeType($this->getPathname());
>>>>>>> v2-test
    }

    /**
     * Moves the file to a new location.
     *
<<<<<<< HEAD
     * @param string $directory The destination folder
     * @param string $name      The new file name
     *
     * @return File A File object representing the new file
     *
     * @throws FileException if the target file could not be created
     */
    public function move($directory, $name = null)
    {
        $target = $this->getTargetFile($directory, $name);

        if (!@rename($this->getPathname(), $target)) {
            $error = error_get_last();
            throw new FileException(sprintf('Could not move the file "%s" to "%s" (%s)', $this->getPathname(), $target, strip_tags($error['message'])));
=======
     * @return self A File object representing the new file
     *
     * @throws FileException if the target file could not be created
     */
    public function move(string $directory, string $name = null)
    {
        $target = $this->getTargetFile($directory, $name);

        set_error_handler(function ($type, $msg) use (&$error) { $error = $msg; });
        $renamed = rename($this->getPathname(), $target);
        restore_error_handler();
        if (!$renamed) {
            throw new FileException(sprintf('Could not move the file "%s" to "%s" (%s).', $this->getPathname(), $target, strip_tags($error)));
>>>>>>> v2-test
        }

        @chmod($target, 0666 & ~umask());

        return $target;
    }

<<<<<<< HEAD
    protected function getTargetFile($directory, $name = null)
    {
        if (!is_dir($directory)) {
            if (false === @mkdir($directory, 0777, true) && !is_dir($directory)) {
                throw new FileException(sprintf('Unable to create the "%s" directory', $directory));
            }
        } elseif (!is_writable($directory)) {
            throw new FileException(sprintf('Unable to write in the "%s" directory', $directory));
        }

        $target = rtrim($directory, '/\\').DIRECTORY_SEPARATOR.(null === $name ? $this->getBasename() : $this->getName($name));
=======
    public function getContent(): string
    {
        $content = file_get_contents($this->getPathname());

        if (false === $content) {
            throw new FileException(sprintf('Could not get the content of the file "%s".', $this->getPathname()));
        }

        return $content;
    }

    /**
     * @return self
     */
    protected function getTargetFile(string $directory, string $name = null)
    {
        if (!is_dir($directory)) {
            if (false === @mkdir($directory, 0777, true) && !is_dir($directory)) {
                throw new FileException(sprintf('Unable to create the "%s" directory.', $directory));
            }
        } elseif (!is_writable($directory)) {
            throw new FileException(sprintf('Unable to write in the "%s" directory.', $directory));
        }

        $target = rtrim($directory, '/\\').\DIRECTORY_SEPARATOR.(null === $name ? $this->getBasename() : $this->getName($name));
>>>>>>> v2-test

        return new self($target, false);
    }

    /**
     * Returns locale independent base name of the given path.
     *
<<<<<<< HEAD
     * @param string $name The new file name
     *
     * @return string containing
     */
    protected function getName($name)
=======
     * @return string
     */
    protected function getName(string $name)
>>>>>>> v2-test
    {
        $originalName = str_replace('\\', '/', $name);
        $pos = strrpos($originalName, '/');
        $originalName = false === $pos ? $originalName : substr($originalName, $pos + 1);

        return $originalName;
    }
}
