<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Formatter;

/**
 * Formatter interface for console output.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
interface OutputFormatterInterface
{
    /**
     * Sets the decorated flag.
<<<<<<< HEAD
     *
     * @param bool $decorated Whether to decorate the messages or not
     */
    public function setDecorated($decorated);
=======
     */
    public function setDecorated(bool $decorated);
>>>>>>> v2-test

    /**
     * Gets the decorated flag.
     *
     * @return bool true if the output will decorate messages, false otherwise
     */
    public function isDecorated();

    /**
     * Sets a new style.
<<<<<<< HEAD
     *
     * @param string                        $name  The style name
     * @param OutputFormatterStyleInterface $style The style instance
     */
    public function setStyle($name, OutputFormatterStyleInterface $style);
=======
     */
    public function setStyle(string $name, OutputFormatterStyleInterface $style);
>>>>>>> v2-test

    /**
     * Checks if output formatter has style with specified name.
     *
<<<<<<< HEAD
     * @param string $name
     *
     * @return bool
     */
    public function hasStyle($name);
=======
     * @return bool
     */
    public function hasStyle(string $name);
>>>>>>> v2-test

    /**
     * Gets style options from style with specified name.
     *
<<<<<<< HEAD
     * @param string $name
     *
=======
>>>>>>> v2-test
     * @return OutputFormatterStyleInterface
     *
     * @throws \InvalidArgumentException When style isn't defined
     */
<<<<<<< HEAD
    public function getStyle($name);

    /**
     * Formats a message according to the given styles.
     *
     * @param string $message The message to style
     *
     * @return string The styled message
     */
    public function format($message);
=======
    public function getStyle(string $name);

    /**
     * Formats a message according to the given styles.
     */
    public function format(?string $message);
>>>>>>> v2-test
}
