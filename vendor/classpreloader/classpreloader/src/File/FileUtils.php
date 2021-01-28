<?php

declare(strict_types=1);

/*
 * This file is part of Class Preloader.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 * (c) Michael Dowling <mtdowling@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ClassPreloader\File;

/**
 * This is the file utils class.
 *
 * @internal
 */
final class FileUtils
{
    /**
     * Read a PHP file.
     *
     * Returns the content as a string, or false on failure.
     *
     * @param string $filePath
     * @param bool   $withComments
     *
     * @return string|false
     */
    public static function readPhpFile(string $filePath, bool $withComments = true)
    {
        if ($filePath === '' || !is_readable($filePath)) {
            return false;
        }

        if ($withComments) {
            $content = @file_get_contents($filePath);
        } else {
            $content = @php_strip_whitespace($filePath);
        }

        return ($content === false || trim($content) === '') ? false : $content;
    }

    /**
     * Ensure that a directory exists.
     *
     * Returns true if exists already or we could create it, and false
     * otherwise.
     *
     * @param string $dirPath
     *
     * @return bool
     */
    public static function ensureDirectoryExists(string $dirPath)
    {
        return is_dir($dirPath) || @mkdir($dirPath, 0777, true);
    }

    /**
     * Open a file for writing if possible.
     *
     * Returns a file resource on success, and false otherwise.
     *
     * @param string $filePath
     *
     * @return resource|false
     */
    public static function openFileForWriting(string $filePath)
    {
        return @fopen($filePath, 'w');
    }

    /**
     * Writes the given content to the handle.
     *
     * Returns true on success, and false otherwise.
     *
     * @param resource $handle
     * @param string   $content
     *
     * @return bool
     */
    public static function writeString($handle, string $content)
    {
        return @fwrite($handle, $content) !== false;
    }

    /**
     * Close the given handle.
     *
     * @param resource $handle
     *
     * @return bool
     */
    public static function closeHandle($handle)
    {
        return @fclose($handle);
    }
}
