<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\VarDumper\Dumper;

use Symfony\Component\VarDumper\Cloner\Data;
use Symfony\Component\VarDumper\Cloner\DumperInterface;

/**
 * Abstract mechanism for dumping a Data object.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
abstract class AbstractDumper implements DataDumperInterface, DumperInterface
{
<<<<<<< HEAD
=======
    public const DUMP_LIGHT_ARRAY = 1;
    public const DUMP_STRING_LENGTH = 2;
    public const DUMP_COMMA_SEPARATOR = 4;
    public const DUMP_TRAILING_COMMA = 8;

>>>>>>> v2-test
    public static $defaultOutput = 'php://output';

    protected $line = '';
    protected $lineDumper;
    protected $outputStream;
    protected $decimalPoint; // This is locale dependent
    protected $indentPad = '  ';
<<<<<<< HEAD

    private $charset;
    private $charsetConverter;

    /**
     * @param callable|resource|string|null $output  A line dumper callable, an opened stream or an output path, defaults to static::$defaultOutput
     * @param string                        $charset The default character encoding to use for non-UTF8 strings
     */
    public function __construct($output = null, $charset = null)
    {
        $this->setCharset($charset ?: ini_get('php.output_encoding') ?: ini_get('default_charset') ?: 'UTF-8');
        $this->decimalPoint = (string) 0.5;
        $this->decimalPoint = $this->decimalPoint[1];
        $this->setOutput($output ?: static::$defaultOutput);
        if (!$output && is_string(static::$defaultOutput)) {
=======
    protected $flags;

    private $charset = '';

    /**
     * @param callable|resource|string|null $output  A line dumper callable, an opened stream or an output path, defaults to static::$defaultOutput
     * @param string|null                   $charset The default character encoding to use for non-UTF8 strings
     * @param int                           $flags   A bit field of static::DUMP_* constants to fine tune dumps representation
     */
    public function __construct($output = null, string $charset = null, int $flags = 0)
    {
        $this->flags = $flags;
        $this->setCharset($charset ?: ini_get('php.output_encoding') ?: ini_get('default_charset') ?: 'UTF-8');
        $this->decimalPoint = localeconv();
        $this->decimalPoint = $this->decimalPoint['decimal_point'];
        $this->setOutput($output ?: static::$defaultOutput);
        if (!$output && \is_string(static::$defaultOutput)) {
>>>>>>> v2-test
            static::$defaultOutput = $this->outputStream;
        }
    }

    /**
     * Sets the output destination of the dumps.
     *
     * @param callable|resource|string $output A line dumper callable, an opened stream or an output path
     *
     * @return callable|resource|string The previous output destination
     */
    public function setOutput($output)
    {
        $prev = null !== $this->outputStream ? $this->outputStream : $this->lineDumper;

<<<<<<< HEAD
        if (is_callable($output)) {
            $this->outputStream = null;
            $this->lineDumper = $output;
        } else {
            if (is_string($output)) {
                $output = fopen($output, 'wb');
            }
            $this->outputStream = $output;
            $this->lineDumper = array($this, 'echoLine');
=======
        if (\is_callable($output)) {
            $this->outputStream = null;
            $this->lineDumper = $output;
        } else {
            if (\is_string($output)) {
                $output = fopen($output, 'w');
            }
            $this->outputStream = $output;
            $this->lineDumper = [$this, 'echoLine'];
>>>>>>> v2-test
        }

        return $prev;
    }

    /**
     * Sets the default character encoding to use for non-UTF8 strings.
     *
<<<<<<< HEAD
     * @param string $charset The default character encoding to use for non-UTF8 strings
     *
     * @return string The previous charset
     */
    public function setCharset($charset)
    {
        $prev = $this->charset;
        $charset = strtoupper($charset);
        $charset = null === $charset || 'UTF-8' === $charset || 'UTF8' === $charset ? 'CP1252' : $charset;

        if ($prev === $charset) {
            return $prev;
        }
        $this->charsetConverter = 'fallback';
        $supported = true;
        set_error_handler(function () use (&$supported) {$supported = false;});

        if (function_exists('mb_encoding_aliases') && mb_encoding_aliases($charset)) {
            $this->charset = $charset;
            $this->charsetConverter = 'mbstring';
        } elseif (function_exists('iconv')) {
            $supported = true;
            iconv($charset, 'UTF-8', '');
            if ($supported) {
                $this->charset = $charset;
                $this->charsetConverter = 'iconv';
            }
        }
        if ('fallback' === $this->charsetConverter) {
            $this->charset = 'ISO-8859-1';
        }
        restore_error_handler();
=======
     * @return string The previous charset
     */
    public function setCharset(string $charset)
    {
        $prev = $this->charset;

        $charset = strtoupper($charset);
        $charset = null === $charset || 'UTF-8' === $charset || 'UTF8' === $charset ? 'CP1252' : $charset;

        $this->charset = $charset;
>>>>>>> v2-test

        return $prev;
    }

    /**
     * Sets the indentation pad string.
     *
<<<<<<< HEAD
     * @param string $pad A string the will be prepended to dumped lines, repeated by nesting level
     *
     * @return string The indent pad
     */
    public function setIndentPad($pad)
=======
     * @param string $pad A string that will be prepended to dumped lines, repeated by nesting level
     *
     * @return string The previous indent pad
     */
    public function setIndentPad(string $pad)
>>>>>>> v2-test
    {
        $prev = $this->indentPad;
        $this->indentPad = $pad;

        return $prev;
    }

    /**
     * Dumps a Data object.
     *
<<<<<<< HEAD
     * @param Data                          $data   A Data object
     * @param callable|resource|string|null $output A line dumper callable, an opened stream or an output path
     */
    public function dump(Data $data, $output = null)
    {
        $exception = null;
=======
     * @param callable|resource|string|true|null $output A line dumper callable, an opened stream, an output path or true to return the dump
     *
     * @return string|null The dump as string when $output is true
     */
    public function dump(Data $data, $output = null)
    {
        $this->decimalPoint = localeconv();
        $this->decimalPoint = $this->decimalPoint['decimal_point'];

        if ($locale = $this->flags & (self::DUMP_COMMA_SEPARATOR | self::DUMP_TRAILING_COMMA) ? setlocale(\LC_NUMERIC, 0) : null) {
            setlocale(\LC_NUMERIC, 'C');
        }

        if ($returnDump = true === $output) {
            $output = fopen('php://memory', 'r+');
        }
>>>>>>> v2-test
        if ($output) {
            $prevOutput = $this->setOutput($output);
        }
        try {
            $data->dump($this);
            $this->dumpLine(-1);
<<<<<<< HEAD
        } catch (\Exception $exception) {
            // Re-thrown below
        } catch (\Throwable $exception) {
            // Re-thrown below
        }
        if ($output) {
            $this->setOutput($prevOutput);
        }
        if (null !== $exception) {
            throw $exception;
        }
=======

            if ($returnDump) {
                $result = stream_get_contents($output, -1, 0);
                fclose($output);

                return $result;
            }
        } finally {
            if ($output) {
                $this->setOutput($prevOutput);
            }
            if ($locale) {
                setlocale(\LC_NUMERIC, $locale);
            }
        }

        return null;
>>>>>>> v2-test
    }

    /**
     * Dumps the current line.
     *
<<<<<<< HEAD
     * @param int $depth The recursive depth in the dumped structure for the line being dumped
     */
    protected function dumpLine($depth)
    {
        call_user_func($this->lineDumper, $this->line, $depth, $this->indentPad);
=======
     * @param int $depth The recursive depth in the dumped structure for the line being dumped,
     *                   or -1 to signal the end-of-dump to the line dumper callable
     */
    protected function dumpLine(int $depth)
    {
        ($this->lineDumper)($this->line, $depth, $this->indentPad);
>>>>>>> v2-test
        $this->line = '';
    }

    /**
     * Generic line dumper callback.
<<<<<<< HEAD
     *
     * @param string $line      The line to write
     * @param int    $depth     The recursive depth in the dumped structure
     * @param string $indentPad The line indent pad
     */
    protected function echoLine($line, $depth, $indentPad)
=======
     */
    protected function echoLine(string $line, int $depth, string $indentPad)
>>>>>>> v2-test
    {
        if (-1 !== $depth) {
            fwrite($this->outputStream, str_repeat($indentPad, $depth).$line."\n");
        }
    }

    /**
     * Converts a non-UTF-8 string to UTF-8.
     *
<<<<<<< HEAD
     * @param string $s The non-UTF-8 string to convert
     *
     * @return string The string converted to UTF-8
     */
    protected function utf8Encode($s)
    {
        if ('mbstring' === $this->charsetConverter) {
            return mb_convert_encoding($s, 'UTF-8', mb_check_encoding($s, $this->charset) ? $this->charset : '8bit');
        }
        if ('iconv' === $this->charsetConverter) {
            $valid = true;
            set_error_handler(function () use (&$valid) {$valid = false;});
            $c = iconv($this->charset, 'UTF-8', $s);
            restore_error_handler();
            if ($valid) {
                return $c;
            }
        }

        $s .= $s;
        $len = strlen($s);

        for ($i = $len >> 1, $j = 0; $i < $len; ++$i, ++$j) {
            switch (true) {
                case $s[$i] < "\x80":
                    $s[$j] = $s[$i];
                    break;

                case $s[$i] < "\xC0":
                    $s[$j] = "\xC2";
                    $s[++$j] = $s[$i];
                    break;

                default:
                    $s[$j] = "\xC3";
                    $s[++$j] = chr(ord($s[$i]) - 64);
                    break;
            }
        }

        return substr($s, 0, $j);
=======
     * @return string|null The string converted to UTF-8
     */
    protected function utf8Encode(?string $s)
    {
        if (null === $s || preg_match('//u', $s)) {
            return $s;
        }

        if (!\function_exists('iconv')) {
            throw new \RuntimeException('Unable to convert a non-UTF-8 string to UTF-8: required function iconv() does not exist. You should install ext-iconv or symfony/polyfill-iconv.');
        }

        if (false !== $c = @iconv($this->charset, 'UTF-8', $s)) {
            return $c;
        }
        if ('CP1252' !== $this->charset && false !== $c = @iconv('CP1252', 'UTF-8', $s)) {
            return $c;
        }

        return iconv('CP850', 'UTF-8', $s);
>>>>>>> v2-test
    }
}
