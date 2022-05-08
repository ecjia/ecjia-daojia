<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Session\Storage\Handler;

/**
<<<<<<< HEAD
 * NativeFileSessionHandler.
 *
=======
>>>>>>> v2-test
 * Native session handler using PHP's built in file storage.
 *
 * @author Drak <drak@zikula.org>
 */
<<<<<<< HEAD
class NativeFileSessionHandler extends NativeSessionHandler
{
    /**
     * Constructor.
     *
=======
class NativeFileSessionHandler extends \SessionHandler
{
    /**
>>>>>>> v2-test
     * @param string $savePath Path of directory to save session files
     *                         Default null will leave setting as defined by PHP.
     *                         '/path', 'N;/path', or 'N;octal-mode;/path
     *
<<<<<<< HEAD
     * @see http://php.net/session.configuration.php#ini.session.save-path for further details.
     *
     * @throws \InvalidArgumentException On invalid $savePath
     */
    public function __construct($savePath = null)
=======
     * @see https://php.net/session.configuration#ini.session.save-path for further details.
     *
     * @throws \InvalidArgumentException On invalid $savePath
     * @throws \RuntimeException         When failing to create the save directory
     */
    public function __construct(string $savePath = null)
>>>>>>> v2-test
    {
        if (null === $savePath) {
            $savePath = ini_get('session.save_path');
        }

        $baseDir = $savePath;

        if ($count = substr_count($savePath, ';')) {
            if ($count > 2) {
<<<<<<< HEAD
                throw new \InvalidArgumentException(sprintf('Invalid argument $savePath \'%s\'', $savePath));
=======
                throw new \InvalidArgumentException(sprintf('Invalid argument $savePath \'%s\'.', $savePath));
>>>>>>> v2-test
            }

            // characters after last ';' are the path
            $baseDir = ltrim(strrchr($savePath, ';'), ';');
        }

        if ($baseDir && !is_dir($baseDir) && !@mkdir($baseDir, 0777, true) && !is_dir($baseDir)) {
<<<<<<< HEAD
            throw new \RuntimeException(sprintf('Session Storage was not able to create directory "%s"', $baseDir));
=======
            throw new \RuntimeException(sprintf('Session Storage was not able to create directory "%s".', $baseDir));
>>>>>>> v2-test
        }

        ini_set('session.save_path', $savePath);
        ini_set('session.save_handler', 'files');
    }
}
