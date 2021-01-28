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

namespace ClassPreloader;

use ClassPreloader\Exception\IOException;
use ClassPreloader\File\FileUtils;

/**
 * This is the output writer.
 */
final class OutputWriter
{
    /**
     * Open an output file, ensuring its directory exists.
     *
     * @param string $filePath
     *
     * @throws \ClassPreloader\Exception\IOException
     *
     * @return resource
     */
    public static function openOutputFile(string $filePath)
    {
        $dirPath = dirname($filePath);

        if (!FileUtils::ensureDirectoryExists($dirPath)) {
            throw new IOException("Unable to create directory $dirPath.");
        }

        $handle = FileUtils::openFileForWriting($filePath);

        if ($handle === false) {
            throw new IOException("Unable to open $filePath for writing.");
        }

        return $handle;
    }

    /**
     * Write an opening PHP tag to the given handle.
     *
     * @param resource $handle
     * @param bool     $strictTypes
     *
     * @throws \ClassPreloader\Exception\IOException
     *
     * @return void
     */
    public static function writeOpeningTag($handle, bool $strictTypes)
    {
        if (!FileUtils::writeString($handle, $strictTypes ? "<?php declare(strict_types=1);\n" : "<?php\n")) {
            throw new IOException('Unable to write opening tag to the output file.');
        }
    }

    /**
     * Write the given file content to the given handle.
     *
     * @param resource $handle
     * @param string   $fileContent
     *
     * @throws \ClassPreloader\Exception\IOException
     *
     * @return void
     */
    public static function writeFileContent($handle, string $fileContent)
    {
        if (!FileUtils::writeString($handle, $fileContent)) {
            throw new IOException('Unable to write file content to the output file.');
        }
    }

    /**
     * Close the given handle.
     *
     * @param resource $handle
     *
     * @throws \ClassPreloader\Exception\IOException
     *
     * @return void
     */
    public static function closeHandle($handle)
    {
        if (!FileUtils::closeHandle($handle)) {
            throw new IOException('Unable to close the output file.');
        }
    }
}
