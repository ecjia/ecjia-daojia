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
 * An executable finder specifically designed for the PHP executable.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class PhpExecutableFinder
{
    private $executableFinder;

    public function __construct()
    {
        $this->executableFinder = new ExecutableFinder();
    }

    /**
     * Finds The PHP executable.
     *
<<<<<<< HEAD
     * @param bool $includeArgs Whether or not include command arguments
     *
     * @return string|false The PHP executable path or false if it cannot be found
     */
    public function find($includeArgs = true)
    {
        $args = $this->findArguments();
        $args = $includeArgs && $args ? ' '.implode(' ', $args) : '';

        // HHVM support
        if (defined('HHVM_VERSION')) {
            return (getenv('PHP_BINARY') ?: PHP_BINARY).$args;
        }

        // PHP_BINARY return the current sapi executable
        if (defined('PHP_BINARY') && PHP_BINARY && in_array(PHP_SAPI, array('cli', 'cli-server', 'phpdbg')) && is_file(PHP_BINARY)) {
            return PHP_BINARY.$args;
        }

        if ($php = getenv('PHP_PATH')) {
            if (!is_executable($php)) {
=======
     * @return string|false The PHP executable path or false if it cannot be found
     */
    public function find(bool $includeArgs = true)
    {
        if ($php = getenv('PHP_BINARY')) {
            if (!is_executable($php)) {
                $command = '\\' === \DIRECTORY_SEPARATOR ? 'where' : 'command -v';
                if ($php = strtok(exec($command.' '.escapeshellarg($php)), \PHP_EOL)) {
                    if (!is_executable($php)) {
                        return false;
                    }
                } else {
                    return false;
                }
            }

            return $php;
        }

        $args = $this->findArguments();
        $args = $includeArgs && $args ? ' '.implode(' ', $args) : '';

        // PHP_BINARY return the current sapi executable
        if (\PHP_BINARY && \in_array(\PHP_SAPI, ['cgi-fcgi', 'cli', 'cli-server', 'phpdbg'], true)) {
            return \PHP_BINARY.$args;
        }

        if ($php = getenv('PHP_PATH')) {
            if (!@is_executable($php)) {
>>>>>>> v2-test
                return false;
            }

            return $php;
        }

        if ($php = getenv('PHP_PEAR_PHP_BIN')) {
<<<<<<< HEAD
            if (is_executable($php)) {
=======
            if (@is_executable($php)) {
>>>>>>> v2-test
                return $php;
            }
        }

<<<<<<< HEAD
        $dirs = array(PHP_BINDIR);
        if ('\\' === DIRECTORY_SEPARATOR) {
=======
        if (@is_executable($php = \PHP_BINDIR.('\\' === \DIRECTORY_SEPARATOR ? '\\php.exe' : '/php'))) {
            return $php;
        }

        $dirs = [\PHP_BINDIR];
        if ('\\' === \DIRECTORY_SEPARATOR) {
>>>>>>> v2-test
            $dirs[] = 'C:\xampp\php\\';
        }

        return $this->executableFinder->find('php', false, $dirs);
    }

    /**
     * Finds the PHP executable arguments.
     *
     * @return array The PHP executable arguments
     */
    public function findArguments()
    {
<<<<<<< HEAD
        $arguments = array();

        if (defined('HHVM_VERSION')) {
            $arguments[] = '--php';
        } elseif ('phpdbg' === PHP_SAPI) {
=======
        $arguments = [];
        if ('phpdbg' === \PHP_SAPI) {
>>>>>>> v2-test
            $arguments[] = '-qrr';
        }

        return $arguments;
    }
}
