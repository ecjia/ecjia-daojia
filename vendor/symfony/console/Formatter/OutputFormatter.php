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

use Symfony\Component\Console\Exception\InvalidArgumentException;

/**
 * Formatter class for console output.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
<<<<<<< HEAD
 */
class OutputFormatter implements OutputFormatterInterface
{
    private $decorated;
    private $styles = array();
    private $styleStack;

    /**
     * Escapes "<" special char in given text.
     *
     * @param string $text Text to escape
     *
     * @return string Escaped text
     */
    public static function escape($text)
=======
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class OutputFormatter implements WrappableOutputFormatterInterface
{
    private $decorated;
    private $styles = [];
    private $styleStack;

    public function __clone()
    {
        $this->styleStack = clone $this->styleStack;
        foreach ($this->styles as $key => $value) {
            $this->styles[$key] = clone $value;
        }
    }

    /**
     * Escapes "<" special char in given text.
     *
     * @return string Escaped text
     */
    public static function escape(string $text)
>>>>>>> v2-test
    {
        $text = preg_replace('/([^\\\\]?)</', '$1\\<', $text);

        return self::escapeTrailingBackslash($text);
    }

    /**
     * Escapes trailing "\" in given text.
     *
<<<<<<< HEAD
     * @param string $text Text to escape
     *
     * @return string Escaped text
     *
     * @internal
     */
    public static function escapeTrailingBackslash($text)
=======
     * @internal
     */
    public static function escapeTrailingBackslash(string $text): string
>>>>>>> v2-test
    {
        if ('\\' === substr($text, -1)) {
            $len = \strlen($text);
            $text = rtrim($text, '\\');
            $text = str_replace("\0", '', $text);
            $text .= str_repeat("\0", $len - \strlen($text));
        }

        return $text;
    }

    /**
     * Initializes console output formatter.
     *
<<<<<<< HEAD
     * @param bool                            $decorated Whether this formatter should actually decorate strings
     * @param OutputFormatterStyleInterface[] $styles    Array of "name => FormatterStyle" instances
     */
    public function __construct($decorated = false, array $styles = array())
    {
        $this->decorated = (bool) $decorated;
=======
     * @param OutputFormatterStyleInterface[] $styles Array of "name => FormatterStyle" instances
     */
    public function __construct(bool $decorated = false, array $styles = [])
    {
        $this->decorated = $decorated;
>>>>>>> v2-test

        $this->setStyle('error', new OutputFormatterStyle('white', 'red'));
        $this->setStyle('info', new OutputFormatterStyle('green'));
        $this->setStyle('comment', new OutputFormatterStyle('yellow'));
        $this->setStyle('question', new OutputFormatterStyle('black', 'cyan'));

        foreach ($styles as $name => $style) {
            $this->setStyle($name, $style);
        }

        $this->styleStack = new OutputFormatterStyleStack();
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function setDecorated($decorated)
    {
        $this->decorated = (bool) $decorated;
=======
    public function setDecorated(bool $decorated)
    {
        $this->decorated = $decorated;
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
    public function isDecorated()
    {
        return $this->decorated;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function setStyle($name, OutputFormatterStyleInterface $style)
=======
    public function setStyle(string $name, OutputFormatterStyleInterface $style)
>>>>>>> v2-test
    {
        $this->styles[strtolower($name)] = $style;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function hasStyle($name)
=======
    public function hasStyle(string $name)
>>>>>>> v2-test
    {
        return isset($this->styles[strtolower($name)]);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getStyle($name)
    {
        if (!$this->hasStyle($name)) {
            throw new InvalidArgumentException(sprintf('Undefined style: %s', $name));
=======
    public function getStyle(string $name)
    {
        if (!$this->hasStyle($name)) {
            throw new InvalidArgumentException(sprintf('Undefined style: "%s".', $name));
>>>>>>> v2-test
        }

        return $this->styles[strtolower($name)];
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function format($message)
    {
        $message = (string) $message;
        $offset = 0;
        $output = '';
        $tagRegex = '[a-z][a-z0-9,_=;-]*+';
        preg_match_all("#<(($tagRegex) | /($tagRegex)?)>#ix", $message, $matches, PREG_OFFSET_CAPTURE);
=======
    public function format(?string $message)
    {
        return $this->formatAndWrap($message, 0);
    }

    /**
     * {@inheritdoc}
     */
    public function formatAndWrap(?string $message, int $width)
    {
        $offset = 0;
        $output = '';
        $tagRegex = '[a-z][^<>]*+';
        $currentLineLength = 0;
        preg_match_all("#<(($tagRegex) | /($tagRegex)?)>#ix", $message, $matches, \PREG_OFFSET_CAPTURE);
>>>>>>> v2-test
        foreach ($matches[0] as $i => $match) {
            $pos = $match[1];
            $text = $match[0];

            if (0 != $pos && '\\' == $message[$pos - 1]) {
                continue;
            }

            // add the text up to the next tag
<<<<<<< HEAD
            $output .= $this->applyCurrentStyle(substr($message, $offset, $pos - $offset));
=======
            $output .= $this->applyCurrentStyle(substr($message, $offset, $pos - $offset), $output, $width, $currentLineLength);
>>>>>>> v2-test
            $offset = $pos + \strlen($text);

            // opening tag?
            if ($open = '/' != $text[1]) {
                $tag = $matches[1][$i][0];
            } else {
<<<<<<< HEAD
                $tag = isset($matches[3][$i][0]) ? $matches[3][$i][0] : '';
=======
                $tag = $matches[3][$i][0] ?? '';
>>>>>>> v2-test
            }

            if (!$open && !$tag) {
                // </>
                $this->styleStack->pop();
<<<<<<< HEAD
            } elseif (false === $style = $this->createStyleFromString(strtolower($tag))) {
                $output .= $this->applyCurrentStyle($text);
=======
            } elseif (null === $style = $this->createStyleFromString($tag)) {
                $output .= $this->applyCurrentStyle($text, $output, $width, $currentLineLength);
>>>>>>> v2-test
            } elseif ($open) {
                $this->styleStack->push($style);
            } else {
                $this->styleStack->pop($style);
            }
        }

<<<<<<< HEAD
        $output .= $this->applyCurrentStyle(substr($message, $offset));

        if (false !== strpos($output, "\0")) {
            return strtr($output, array("\0" => '\\', '\\<' => '<'));
=======
        $output .= $this->applyCurrentStyle(substr($message, $offset), $output, $width, $currentLineLength);

        if (false !== strpos($output, "\0")) {
            return strtr($output, ["\0" => '\\', '\\<' => '<']);
>>>>>>> v2-test
        }

        return str_replace('\\<', '<', $output);
    }

    /**
     * @return OutputFormatterStyleStack
     */
    public function getStyleStack()
    {
        return $this->styleStack;
    }

    /**
     * Tries to create new style instance from string.
<<<<<<< HEAD
     *
     * @param string $string
     *
     * @return OutputFormatterStyle|false false if string is not format string
     */
    private function createStyleFromString($string)
=======
     */
    private function createStyleFromString(string $string): ?OutputFormatterStyleInterface
>>>>>>> v2-test
    {
        if (isset($this->styles[$string])) {
            return $this->styles[$string];
        }

<<<<<<< HEAD
        if (!preg_match_all('/([^=]+)=([^;]+)(;|$)/', $string, $matches, PREG_SET_ORDER)) {
            return false;
=======
        if (!preg_match_all('/([^=]+)=([^;]+)(;|$)/', $string, $matches, \PREG_SET_ORDER)) {
            return null;
>>>>>>> v2-test
        }

        $style = new OutputFormatterStyle();
        foreach ($matches as $match) {
            array_shift($match);
<<<<<<< HEAD

            if ('fg' == $match[0]) {
                $style->setForeground($match[1]);
            } elseif ('bg' == $match[0]) {
                $style->setBackground($match[1]);
            } elseif ('options' === $match[0]) {
                preg_match_all('([^,;]+)', $match[1], $options);
                $options = array_shift($options);
                foreach ($options as $option) {
                    try {
                        $style->setOption($option);
                    } catch (\InvalidArgumentException $e) {
                        @trigger_error(sprintf('Unknown style options are deprecated since Symfony 3.2 and will be removed in 4.0. Exception "%s".', $e->getMessage()), E_USER_DEPRECATED);

                        return false;
                    }
                }
            } else {
                return false;
=======
            $match[0] = strtolower($match[0]);

            if ('fg' == $match[0]) {
                $style->setForeground(strtolower($match[1]));
            } elseif ('bg' == $match[0]) {
                $style->setBackground(strtolower($match[1]));
            } elseif ('href' === $match[0]) {
                $style->setHref($match[1]);
            } elseif ('options' === $match[0]) {
                preg_match_all('([^,;]+)', strtolower($match[1]), $options);
                $options = array_shift($options);
                foreach ($options as $option) {
                    $style->setOption($option);
                }
            } else {
                return null;
>>>>>>> v2-test
            }
        }

        return $style;
    }

    /**
     * Applies current style from stack to text, if must be applied.
<<<<<<< HEAD
     *
     * @param string $text Input text
     *
     * @return string Styled text
     */
    private function applyCurrentStyle($text)
    {
        return $this->isDecorated() && \strlen($text) > 0 ? $this->styleStack->getCurrent()->apply($text) : $text;
=======
     */
    private function applyCurrentStyle(string $text, string $current, int $width, int &$currentLineLength): string
    {
        if ('' === $text) {
            return '';
        }

        if (!$width) {
            return $this->isDecorated() ? $this->styleStack->getCurrent()->apply($text) : $text;
        }

        if (!$currentLineLength && '' !== $current) {
            $text = ltrim($text);
        }

        if ($currentLineLength) {
            $prefix = substr($text, 0, $i = $width - $currentLineLength)."\n";
            $text = substr($text, $i);
        } else {
            $prefix = '';
        }

        preg_match('~(\\n)$~', $text, $matches);
        $text = $prefix.preg_replace('~([^\\n]{'.$width.'})\\ *~', "\$1\n", $text);
        $text = rtrim($text, "\n").($matches[1] ?? '');

        if (!$currentLineLength && '' !== $current && "\n" !== substr($current, -1)) {
            $text = "\n".$text;
        }

        $lines = explode("\n", $text);

        foreach ($lines as $line) {
            $currentLineLength += \strlen($line);
            if ($width <= $currentLineLength) {
                $currentLineLength = 0;
            }
        }

        if ($this->isDecorated()) {
            foreach ($lines as $i => $line) {
                $lines[$i] = $this->styleStack->getCurrent()->apply($line);
            }
        }

        return implode("\n", $lines);
>>>>>>> v2-test
    }
}
