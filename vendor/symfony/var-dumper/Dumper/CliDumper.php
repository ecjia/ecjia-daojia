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

use Symfony\Component\VarDumper\Cloner\Cursor;
<<<<<<< HEAD
=======
use Symfony\Component\VarDumper\Cloner\Stub;
>>>>>>> v2-test

/**
 * CliDumper dumps variables for command line output.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class CliDumper extends AbstractDumper
{
    public static $defaultColors;
    public static $defaultOutput = 'php://stdout';

    protected $colors;
    protected $maxStringWidth = 0;
<<<<<<< HEAD
    protected $styles = array(
        // See http://en.wikipedia.org/wiki/ANSI_escape_code#graphics
        'default' => '38;5;208',
=======
    protected $styles = [
        // See http://en.wikipedia.org/wiki/ANSI_escape_code#graphics
        'default' => '0;38;5;208',
>>>>>>> v2-test
        'num' => '1;38;5;38',
        'const' => '1;38;5;208',
        'str' => '1;38;5;113',
        'note' => '38;5;38',
        'ref' => '38;5;247',
        'public' => '',
        'protected' => '',
        'private' => '',
        'meta' => '38;5;170',
        'key' => '38;5;113',
        'index' => '38;5;38',
<<<<<<< HEAD
    );

    protected static $controlCharsRx = '/[\x00-\x1F\x7F]+/';
    protected static $controlCharsMap = array(
=======
    ];

    protected static $controlCharsRx = '/[\x00-\x1F\x7F]+/';
    protected static $controlCharsMap = [
>>>>>>> v2-test
        "\t" => '\t',
        "\n" => '\n',
        "\v" => '\v',
        "\f" => '\f',
        "\r" => '\r',
        "\033" => '\e',
<<<<<<< HEAD
    );
=======
    ];

    protected $collapseNextHash = false;
    protected $expandNextHash = false;

    private $displayOptions = [
        'fileLinkFormat' => null,
    ];

    private $handlesHrefGracefully;
>>>>>>> v2-test

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function __construct($output = null, $charset = null)
    {
        parent::__construct($output, $charset);

        if ('\\' === DIRECTORY_SEPARATOR && 'ON' !== @getenv('ConEmuANSI') && 'xterm' !== @getenv('TERM')) {
            // Use only the base 16 xterm colors when using ANSICON or standard Windows 10 CLI 
            $this->setStyles(array(
=======
    public function __construct($output = null, string $charset = null, int $flags = 0)
    {
        parent::__construct($output, $charset, $flags);

        if ('\\' === \DIRECTORY_SEPARATOR && !$this->isWindowsTrueColor()) {
            // Use only the base 16 xterm colors when using ANSICON or standard Windows 10 CLI
            $this->setStyles([
>>>>>>> v2-test
                'default' => '31',
                'num' => '1;34',
                'const' => '1;31',
                'str' => '1;32',
                'note' => '34',
                'ref' => '1;30',
                'meta' => '35',
                'key' => '32',
                'index' => '34',
<<<<<<< HEAD
            ));
        }
=======
            ]);
        }

        $this->displayOptions['fileLinkFormat'] = ini_get('xdebug.file_link_format') ?: get_cfg_var('xdebug.file_link_format') ?: 'file://%f#L%l';
>>>>>>> v2-test
    }

    /**
     * Enables/disables colored output.
<<<<<<< HEAD
     *
     * @param bool $colors
     */
    public function setColors($colors)
    {
        $this->colors = (bool) $colors;
=======
     */
    public function setColors(bool $colors)
    {
        $this->colors = $colors;
>>>>>>> v2-test
    }

    /**
     * Sets the maximum number of characters per line for dumped strings.
<<<<<<< HEAD
     *
     * @param int $maxStringWidth
     */
    public function setMaxStringWidth($maxStringWidth)
    {
        if (function_exists('iconv')) {
            $this->maxStringWidth = (int) $maxStringWidth;
        }
=======
     */
    public function setMaxStringWidth(int $maxStringWidth)
    {
        $this->maxStringWidth = $maxStringWidth;
>>>>>>> v2-test
    }

    /**
     * Configures styles.
     *
     * @param array $styles A map of style names to style definitions
     */
    public function setStyles(array $styles)
    {
        $this->styles = $styles + $this->styles;
    }

    /**
<<<<<<< HEAD
     * {@inheritdoc}
     */
    public function dumpScalar(Cursor $cursor, $type, $value)
=======
     * Configures display options.
     *
     * @param array $displayOptions A map of display options to customize the behavior
     */
    public function setDisplayOptions(array $displayOptions)
    {
        $this->displayOptions = $displayOptions + $this->displayOptions;
    }

    /**
     * {@inheritdoc}
     */
    public function dumpScalar(Cursor $cursor, string $type, $value)
>>>>>>> v2-test
    {
        $this->dumpKey($cursor);

        $style = 'const';
<<<<<<< HEAD
        $attr = array();

        switch ($type) {
=======
        $attr = $cursor->attr;

        switch ($type) {
            case 'default':
                $style = 'default';
                break;

>>>>>>> v2-test
            case 'integer':
                $style = 'num';
                break;

            case 'double':
                $style = 'num';

                switch (true) {
<<<<<<< HEAD
                    case INF === $value:  $value = 'INF';  break;
                    case -INF === $value: $value = '-INF'; break;
                    case is_nan($value):  $value = 'NAN';  break;
=======
                    case \INF === $value:  $value = 'INF'; break;
                    case -\INF === $value: $value = '-INF'; break;
                    case is_nan($value):  $value = 'NAN'; break;
>>>>>>> v2-test
                    default:
                        $value = (string) $value;
                        if (false === strpos($value, $this->decimalPoint)) {
                            $value .= $this->decimalPoint.'0';
                        }
                        break;
                }
                break;

            case 'NULL':
                $value = 'null';
                break;

            case 'boolean':
                $value = $value ? 'true' : 'false';
                break;

            default:
<<<<<<< HEAD
                $attr['value'] = isset($value[0]) && !preg_match('//u', $value) ? $this->utf8Encode($value) : $value;
                $value = isset($type[0]) && !preg_match('//u', $type) ? $this->utf8Encode($type) : $type;
=======
                $attr += ['value' => $this->utf8Encode($value)];
                $value = $this->utf8Encode($type);
>>>>>>> v2-test
                break;
        }

        $this->line .= $this->style($style, $value, $attr);

<<<<<<< HEAD
        $this->dumpLine($cursor->depth, true);
=======
        $this->endValue($cursor);
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function dumpString(Cursor $cursor, $str, $bin, $cut)
    {
        $this->dumpKey($cursor);
=======
    public function dumpString(Cursor $cursor, string $str, bool $bin, int $cut)
    {
        $this->dumpKey($cursor);
        $attr = $cursor->attr;
>>>>>>> v2-test

        if ($bin) {
            $str = $this->utf8Encode($str);
        }
        if ('' === $str) {
            $this->line .= '""';
<<<<<<< HEAD
            $this->dumpLine($cursor->depth, true);
        } else {
            $attr = array(
                'length' => 0 <= $cut && function_exists('iconv_strlen') ? iconv_strlen($str, 'UTF-8') + $cut : 0,
                'binary' => $bin,
            );
            $str = explode("\n", $str);
=======
            $this->endValue($cursor);
        } else {
            $attr += [
                'length' => 0 <= $cut ? mb_strlen($str, 'UTF-8') + $cut : 0,
                'binary' => $bin,
            ];
            $str = $bin && false !== strpos($str, "\0") ? [$str] : explode("\n", $str);
>>>>>>> v2-test
            if (isset($str[1]) && !isset($str[2]) && !isset($str[1][0])) {
                unset($str[1]);
                $str[0] .= "\n";
            }
<<<<<<< HEAD
            $m = count($str) - 1;
            $i = $lineCut = 0;

=======
            $m = \count($str) - 1;
            $i = $lineCut = 0;

            if (self::DUMP_STRING_LENGTH & $this->flags) {
                $this->line .= '('.$attr['length'].') ';
            }
>>>>>>> v2-test
            if ($bin) {
                $this->line .= 'b';
            }

            if ($m) {
                $this->line .= '"""';
                $this->dumpLine($cursor->depth);
            } else {
                $this->line .= '"';
            }

            foreach ($str as $str) {
                if ($i < $m) {
                    $str .= "\n";
                }
<<<<<<< HEAD
                if (0 < $this->maxStringWidth && $this->maxStringWidth < $len = iconv_strlen($str, 'UTF-8')) {
                    $str = iconv_substr($str, 0, $this->maxStringWidth, 'UTF-8');
=======
                if (0 < $this->maxStringWidth && $this->maxStringWidth < $len = mb_strlen($str, 'UTF-8')) {
                    $str = mb_substr($str, 0, $this->maxStringWidth, 'UTF-8');
>>>>>>> v2-test
                    $lineCut = $len - $this->maxStringWidth;
                }
                if ($m && 0 < $cursor->depth) {
                    $this->line .= $this->indentPad;
                }
                if ('' !== $str) {
                    $this->line .= $this->style('str', $str, $attr);
                }
                if ($i++ == $m) {
                    if ($m) {
                        if ('' !== $str) {
                            $this->dumpLine($cursor->depth);
                            if (0 < $cursor->depth) {
                                $this->line .= $this->indentPad;
                            }
                        }
                        $this->line .= '"""';
                    } else {
                        $this->line .= '"';
                    }
                    if ($cut < 0) {
                        $this->line .= '…';
                        $lineCut = 0;
                    } elseif ($cut) {
                        $lineCut += $cut;
                    }
                }
                if ($lineCut) {
                    $this->line .= '…'.$lineCut;
                    $lineCut = 0;
                }

<<<<<<< HEAD
                $this->dumpLine($cursor->depth, $i > $m);
=======
                if ($i > $m) {
                    $this->endValue($cursor);
                } else {
                    $this->dumpLine($cursor->depth);
                }
>>>>>>> v2-test
            }
        }
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function enterHash(Cursor $cursor, $type, $class, $hasChild)
    {
        $this->dumpKey($cursor);

        if (!preg_match('//u', $class)) {
            $class = $this->utf8Encode($class);
        }
        if (Cursor::HASH_OBJECT === $type) {
            $prefix = 'stdClass' !== $class ? $this->style('note', $class).' {' : '{';
        } elseif (Cursor::HASH_RESOURCE === $type) {
            $prefix = $this->style('note', $class.' resource').($hasChild ? ' {' : ' ');
        } else {
            $prefix = $class ? $this->style('note', 'array:'.$class).' [' : '[';
        }

        if ($cursor->softRefCount || 0 < $cursor->softRefHandle) {
            $prefix .= $this->style('ref', (Cursor::HASH_RESOURCE === $type ? '@' : '#').(0 < $cursor->softRefHandle ? $cursor->softRefHandle : $cursor->softRefTo), array('count' => $cursor->softRefCount));
        } elseif ($cursor->hardRefTo && !$cursor->refIndex && $class) {
            $prefix .= $this->style('ref', '&'.$cursor->hardRefTo, array('count' => $cursor->hardRefCount));
=======
    public function enterHash(Cursor $cursor, int $type, $class, bool $hasChild)
    {
        if (null === $this->colors) {
            $this->colors = $this->supportsColors();
        }

        $this->dumpKey($cursor);
        $attr = $cursor->attr;

        if ($this->collapseNextHash) {
            $cursor->skipChildren = true;
            $this->collapseNextHash = $hasChild = false;
        }

        $class = $this->utf8Encode($class);
        if (Cursor::HASH_OBJECT === $type) {
            $prefix = $class && 'stdClass' !== $class ? $this->style('note', $class, $attr).(empty($attr['cut_hash']) ? ' {' : '') : '{';
        } elseif (Cursor::HASH_RESOURCE === $type) {
            $prefix = $this->style('note', $class.' resource', $attr).($hasChild ? ' {' : ' ');
        } else {
            $prefix = $class && !(self::DUMP_LIGHT_ARRAY & $this->flags) ? $this->style('note', 'array:'.$class).' [' : '[';
        }

        if (($cursor->softRefCount || 0 < $cursor->softRefHandle) && empty($attr['cut_hash'])) {
            $prefix .= $this->style('ref', (Cursor::HASH_RESOURCE === $type ? '@' : '#').(0 < $cursor->softRefHandle ? $cursor->softRefHandle : $cursor->softRefTo), ['count' => $cursor->softRefCount]);
        } elseif ($cursor->hardRefTo && !$cursor->refIndex && $class) {
            $prefix .= $this->style('ref', '&'.$cursor->hardRefTo, ['count' => $cursor->hardRefCount]);
>>>>>>> v2-test
        } elseif (!$hasChild && Cursor::HASH_RESOURCE === $type) {
            $prefix = substr($prefix, 0, -1);
        }

        $this->line .= $prefix;

        if ($hasChild) {
            $this->dumpLine($cursor->depth);
        }
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function leaveHash(Cursor $cursor, $type, $class, $hasChild, $cut)
    {
        $this->dumpEllipsis($cursor, $hasChild, $cut);
        $this->line .= Cursor::HASH_OBJECT === $type ? '}' : (Cursor::HASH_RESOURCE !== $type ? ']' : ($hasChild ? '}' : ''));
        $this->dumpLine($cursor->depth, true);
=======
    public function leaveHash(Cursor $cursor, int $type, $class, bool $hasChild, int $cut)
    {
        if (empty($cursor->attr['cut_hash'])) {
            $this->dumpEllipsis($cursor, $hasChild, $cut);
            $this->line .= Cursor::HASH_OBJECT === $type ? '}' : (Cursor::HASH_RESOURCE !== $type ? ']' : ($hasChild ? '}' : ''));
        }

        $this->endValue($cursor);
>>>>>>> v2-test
    }

    /**
     * Dumps an ellipsis for cut children.
     *
<<<<<<< HEAD
     * @param Cursor $cursor   The Cursor position in the dump
     * @param bool   $hasChild When the dump of the hash has child item
     * @param int    $cut      The number of items the hash has been cut by
=======
     * @param bool $hasChild When the dump of the hash has child item
     * @param int  $cut      The number of items the hash has been cut by
>>>>>>> v2-test
     */
    protected function dumpEllipsis(Cursor $cursor, $hasChild, $cut)
    {
        if ($cut) {
            $this->line .= ' …';
            if (0 < $cut) {
                $this->line .= $cut;
            }
            if ($hasChild) {
                $this->dumpLine($cursor->depth + 1);
            }
        }
    }

    /**
     * Dumps a key in a hash structure.
<<<<<<< HEAD
     *
     * @param Cursor $cursor The Cursor position in the dump
=======
>>>>>>> v2-test
     */
    protected function dumpKey(Cursor $cursor)
    {
        if (null !== $key = $cursor->hashKey) {
            if ($cursor->hashKeyIsBinary) {
                $key = $this->utf8Encode($key);
            }
<<<<<<< HEAD
            $attr = array('binary' => $cursor->hashKeyIsBinary);
=======
            $attr = ['binary' => $cursor->hashKeyIsBinary];
>>>>>>> v2-test
            $bin = $cursor->hashKeyIsBinary ? 'b' : '';
            $style = 'key';
            switch ($cursor->hashType) {
                default:
                case Cursor::HASH_INDEXED:
<<<<<<< HEAD
                    $style = 'index';
                case Cursor::HASH_ASSOC:
                    if (is_int($key)) {
=======
                    if (self::DUMP_LIGHT_ARRAY & $this->flags) {
                        break;
                    }
                    $style = 'index';
                    // no break
                case Cursor::HASH_ASSOC:
                    if (\is_int($key)) {
>>>>>>> v2-test
                        $this->line .= $this->style($style, $key).' => ';
                    } else {
                        $this->line .= $bin.'"'.$this->style($style, $key).'" => ';
                    }
                    break;

                case Cursor::HASH_RESOURCE:
                    $key = "\0~\0".$key;
<<<<<<< HEAD
                    // No break;
=======
                    // no break
>>>>>>> v2-test
                case Cursor::HASH_OBJECT:
                    if (!isset($key[0]) || "\0" !== $key[0]) {
                        $this->line .= '+'.$bin.$this->style('public', $key).': ';
                    } elseif (0 < strpos($key, "\0", 1)) {
                        $key = explode("\0", substr($key, 1), 2);

<<<<<<< HEAD
                        switch ($key[0]) {
=======
                        switch ($key[0][0]) {
>>>>>>> v2-test
                            case '+': // User inserted keys
                                $attr['dynamic'] = true;
                                $this->line .= '+'.$bin.'"'.$this->style('public', $key[1], $attr).'": ';
                                break 2;
                            case '~':
                                $style = 'meta';
<<<<<<< HEAD
=======
                                if (isset($key[0][1])) {
                                    parse_str(substr($key[0], 1), $attr);
                                    $attr += ['binary' => $cursor->hashKeyIsBinary];
                                }
>>>>>>> v2-test
                                break;
                            case '*':
                                $style = 'protected';
                                $bin = '#'.$bin;
                                break;
                            default:
                                $attr['class'] = $key[0];
                                $style = 'private';
                                $bin = '-'.$bin;
                                break;
                        }

<<<<<<< HEAD
                        $this->line .= $bin.$this->style($style, $key[1], $attr).': ';
                    } else {
                        // This case should not happen
                        $this->line .= '-'.$bin.'"'.$this->style('private', $key, array('class' => '')).'": ';
=======
                        if (isset($attr['collapse'])) {
                            if ($attr['collapse']) {
                                $this->collapseNextHash = true;
                            } else {
                                $this->expandNextHash = true;
                            }
                        }

                        $this->line .= $bin.$this->style($style, $key[1], $attr).($attr['separator'] ?? ': ');
                    } else {
                        // This case should not happen
                        $this->line .= '-'.$bin.'"'.$this->style('private', $key, ['class' => '']).'": ';
>>>>>>> v2-test
                    }
                    break;
            }

            if ($cursor->hardRefTo) {
<<<<<<< HEAD
                $this->line .= $this->style('ref', '&'.($cursor->hardRefCount ? $cursor->hardRefTo : ''), array('count' => $cursor->hardRefCount)).' ';
=======
                $this->line .= $this->style('ref', '&'.($cursor->hardRefCount ? $cursor->hardRefTo : ''), ['count' => $cursor->hardRefCount]).' ';
>>>>>>> v2-test
            }
        }
    }

    /**
     * Decorates a value with some style.
     *
     * @param string $style The type of style being applied
     * @param string $value The value being styled
     * @param array  $attr  Optional context information
     *
     * @return string The value with style decoration
     */
<<<<<<< HEAD
    protected function style($style, $value, $attr = array())
=======
    protected function style($style, $value, $attr = [])
>>>>>>> v2-test
    {
        if (null === $this->colors) {
            $this->colors = $this->supportsColors();
        }

<<<<<<< HEAD
        $style = $this->styles[$style];

        $map = static::$controlCharsMap;
        $startCchr = $this->colors ? "\033[m\033[{$this->styles['default']}m" : '';
        $endCchr = $this->colors ? "\033[m\033[{$style}m" : '';
=======
        if (null === $this->handlesHrefGracefully) {
            $this->handlesHrefGracefully = 'JetBrains-JediTerm' !== getenv('TERMINAL_EMULATOR')
                && (!getenv('KONSOLE_VERSION') || (int) getenv('KONSOLE_VERSION') > 201100);
        }

        if (isset($attr['ellipsis'], $attr['ellipsis-type'])) {
            $prefix = substr($value, 0, -$attr['ellipsis']);
            if ('cli' === \PHP_SAPI && 'path' === $attr['ellipsis-type'] && isset($_SERVER[$pwd = '\\' === \DIRECTORY_SEPARATOR ? 'CD' : 'PWD']) && 0 === strpos($prefix, $_SERVER[$pwd])) {
                $prefix = '.'.substr($prefix, \strlen($_SERVER[$pwd]));
            }
            if (!empty($attr['ellipsis-tail'])) {
                $prefix .= substr($value, -$attr['ellipsis'], $attr['ellipsis-tail']);
                $value = substr($value, -$attr['ellipsis'] + $attr['ellipsis-tail']);
            } else {
                $value = substr($value, -$attr['ellipsis']);
            }

            $value = $this->style('default', $prefix).$this->style($style, $value);

            goto href;
        }

        $map = static::$controlCharsMap;
        $startCchr = $this->colors ? "\033[m\033[{$this->styles['default']}m" : '';
        $endCchr = $this->colors ? "\033[m\033[{$this->styles[$style]}m" : '';
>>>>>>> v2-test
        $value = preg_replace_callback(static::$controlCharsRx, function ($c) use ($map, $startCchr, $endCchr) {
            $s = $startCchr;
            $c = $c[$i = 0];
            do {
<<<<<<< HEAD
                $s .= isset($map[$c[$i]]) ? $map[$c[$i]] : sprintf('\x%02X', ord($c[$i]));
=======
                $s .= $map[$c[$i]] ?? sprintf('\x%02X', \ord($c[$i]));
>>>>>>> v2-test
            } while (isset($c[++$i]));

            return $s.$endCchr;
        }, $value, -1, $cchrCount);

        if ($this->colors) {
            if ($cchrCount && "\033" === $value[0]) {
<<<<<<< HEAD
                $value = substr($value, strlen($startCchr));
            } else {
                $value = "\033[{$style}m".$value;
            }
            if ($cchrCount && $endCchr === substr($value, -strlen($endCchr))) {
                $value = substr($value, 0, -strlen($endCchr));
=======
                $value = substr($value, \strlen($startCchr));
            } else {
                $value = "\033[{$this->styles[$style]}m".$value;
            }
            if ($cchrCount && $endCchr === substr($value, -\strlen($endCchr))) {
                $value = substr($value, 0, -\strlen($endCchr));
>>>>>>> v2-test
            } else {
                $value .= "\033[{$this->styles['default']}m";
            }
        }

<<<<<<< HEAD
=======
        href:
        if ($this->colors && $this->handlesHrefGracefully) {
            if (isset($attr['file']) && $href = $this->getSourceLink($attr['file'], $attr['line'] ?? 0)) {
                if ('note' === $style) {
                    $value .= "\033]8;;{$href}\033\\^\033]8;;\033\\";
                } else {
                    $attr['href'] = $href;
                }
            }
            if (isset($attr['href'])) {
                $value = "\033]8;;{$attr['href']}\033\\{$value}\033]8;;\033\\";
            }
        } elseif ($attr['if_links'] ?? false) {
            return '';
        }

>>>>>>> v2-test
        return $value;
    }

    /**
     * @return bool Tells if the current output stream supports ANSI colors or not
     */
    protected function supportsColors()
    {
        if ($this->outputStream !== static::$defaultOutput) {
<<<<<<< HEAD
            return @(is_resource($this->outputStream) && function_exists('posix_isatty') && posix_isatty($this->outputStream));
=======
            return $this->hasColorSupport($this->outputStream);
>>>>>>> v2-test
        }
        if (null !== static::$defaultColors) {
            return static::$defaultColors;
        }
        if (isset($_SERVER['argv'][1])) {
            $colors = $_SERVER['argv'];
<<<<<<< HEAD
            $i = count($colors);
=======
            $i = \count($colors);
>>>>>>> v2-test
            while (--$i > 0) {
                if (isset($colors[$i][5])) {
                    switch ($colors[$i]) {
                        case '--ansi':
                        case '--color':
                        case '--color=yes':
                        case '--color=force':
                        case '--color=always':
<<<<<<< HEAD
=======
                        case '--colors=always':
>>>>>>> v2-test
                            return static::$defaultColors = true;

                        case '--no-ansi':
                        case '--color=no':
                        case '--color=none':
                        case '--color=never':
<<<<<<< HEAD
=======
                        case '--colors=never':
>>>>>>> v2-test
                            return static::$defaultColors = false;
                    }
                }
            }
        }

<<<<<<< HEAD
        if ('\\' === DIRECTORY_SEPARATOR) {
            static::$defaultColors = @(
                '10.0.10586' === PHP_WINDOWS_VERSION_MAJOR.'.'.PHP_WINDOWS_VERSION_MINOR.'.'.PHP_WINDOWS_VERSION_BUILD
                || false !== getenv('ANSICON')
                || 'ON' === getenv('ConEmuANSI')
                || 'xterm' === getenv('TERM')
            );
        } elseif (function_exists('posix_isatty')) {
            $h = stream_get_meta_data($this->outputStream) + array('wrapper_type' => null);
            $h = 'Output' === $h['stream_type'] && 'PHP' === $h['wrapper_type'] ? fopen('php://stdout', 'wb') : $this->outputStream;
            static::$defaultColors = @posix_isatty($h);
        } else {
            static::$defaultColors = false;
        }

        return static::$defaultColors;
=======
        $h = stream_get_meta_data($this->outputStream) + ['wrapper_type' => null];
        $h = 'Output' === $h['stream_type'] && 'PHP' === $h['wrapper_type'] ? fopen('php://stdout', 'w') : $this->outputStream;

        return static::$defaultColors = $this->hasColorSupport($h);
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    protected function dumpLine($depth, $endOfValue = false)
=======
    protected function dumpLine(int $depth, bool $endOfValue = false)
>>>>>>> v2-test
    {
        if ($this->colors) {
            $this->line = sprintf("\033[%sm%s\033[m", $this->styles['default'], $this->line);
        }
        parent::dumpLine($depth);
    }
<<<<<<< HEAD
=======

    protected function endValue(Cursor $cursor)
    {
        if (-1 === $cursor->hashType) {
            return;
        }

        if (Stub::ARRAY_INDEXED === $cursor->hashType || Stub::ARRAY_ASSOC === $cursor->hashType) {
            if (self::DUMP_TRAILING_COMMA & $this->flags && 0 < $cursor->depth) {
                $this->line .= ',';
            } elseif (self::DUMP_COMMA_SEPARATOR & $this->flags && 1 < $cursor->hashLength - $cursor->hashIndex) {
                $this->line .= ',';
            }
        }

        $this->dumpLine($cursor->depth, true);
    }

    /**
     * Returns true if the stream supports colorization.
     *
     * Reference: Composer\XdebugHandler\Process::supportsColor
     * https://github.com/composer/xdebug-handler
     *
     * @param mixed $stream A CLI output stream
     */
    private function hasColorSupport($stream): bool
    {
        if (!\is_resource($stream) || 'stream' !== get_resource_type($stream)) {
            return false;
        }

        // Follow https://no-color.org/
        if (isset($_SERVER['NO_COLOR']) || false !== getenv('NO_COLOR')) {
            return false;
        }

        if ('Hyper' === getenv('TERM_PROGRAM')) {
            return true;
        }

        if (\DIRECTORY_SEPARATOR === '\\') {
            return (\function_exists('sapi_windows_vt100_support')
                && @sapi_windows_vt100_support($stream))
                || false !== getenv('ANSICON')
                || 'ON' === getenv('ConEmuANSI')
                || 'xterm' === getenv('TERM');
        }

        return stream_isatty($stream);
    }

    /**
     * Returns true if the Windows terminal supports true color.
     *
     * Note that this does not check an output stream, but relies on environment
     * variables from known implementations, or a PHP and Windows version that
     * supports true color.
     */
    private function isWindowsTrueColor(): bool
    {
        $result = 183 <= getenv('ANSICON_VER')
            || 'ON' === getenv('ConEmuANSI')
            || 'xterm' === getenv('TERM')
            || 'Hyper' === getenv('TERM_PROGRAM');

        if (!$result) {
            $version = sprintf(
                '%s.%s.%s',
                PHP_WINDOWS_VERSION_MAJOR,
                PHP_WINDOWS_VERSION_MINOR,
                PHP_WINDOWS_VERSION_BUILD
            );
            $result = $version >= '10.0.15063';
        }

        return $result;
    }

    private function getSourceLink(string $file, int $line)
    {
        if ($fmt = $this->displayOptions['fileLinkFormat']) {
            return \is_string($fmt) ? strtr($fmt, ['%f' => $file, '%l' => $line]) : ($fmt->format($file, $line) ?: 'file://'.$file.'#L'.$line);
        }

        return false;
    }
>>>>>>> v2-test
}
