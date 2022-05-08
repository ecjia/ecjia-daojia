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
 * Formatter style interface for defining styles.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
interface OutputFormatterStyleInterface
{
    /**
     * Sets style foreground color.
<<<<<<< HEAD
     *
     * @param string $color The color name
     */
    public function setForeground($color = null);

    /**
     * Sets style background color.
     *
     * @param string $color The color name
     */
    public function setBackground($color = null);

    /**
     * Sets some specific style option.
     *
     * @param string $option The option name
     */
    public function setOption($option);

    /**
     * Unsets some specific style option.
     *
     * @param string $option The option name
     */
    public function unsetOption($option);
=======
     */
    public function setForeground(string $color = null);

    /**
     * Sets style background color.
     */
    public function setBackground(string $color = null);

    /**
     * Sets some specific style option.
     */
    public function setOption(string $option);

    /**
     * Unsets some specific style option.
     */
    public function unsetOption(string $option);
>>>>>>> v2-test

    /**
     * Sets multiple style options at once.
     */
    public function setOptions(array $options);

    /**
     * Applies the style to a given text.
     *
<<<<<<< HEAD
     * @param string $text The text to style
     *
     * @return string
     */
    public function apply($text);
=======
     * @return string
     */
    public function apply(string $text);
>>>>>>> v2-test
}
