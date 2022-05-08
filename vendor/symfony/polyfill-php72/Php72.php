<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Polyfill\Php72;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * @internal
 */
final class Php72
{
    private static $hashMask;

    public static function utf8_encode($s)
    {
        $s .= $s;
        $len = \strlen($s);

        for ($i = $len >> 1, $j = 0; $i < $len; ++$i, ++$j) {
            switch (true) {
                case $s[$i] < "\x80": $s[$j] = $s[$i]; break;
                case $s[$i] < "\xC0": $s[$j] = "\xC2"; $s[++$j] = $s[$i]; break;
                default: $s[$j] = "\xC3"; $s[++$j] = \chr(\ord($s[$i]) - 64); break;
            }
        }

        return substr($s, 0, $j);
    }

    public static function utf8_decode($s)
    {
        $s = (string) $s;
        $len = \strlen($s);

        for ($i = 0, $j = 0; $i < $len; ++$i, ++$j) {
            switch ($s[$i] & "\xF0") {
                case "\xC0":
                case "\xD0":
                    $c = (\ord($s[$i] & "\x1F") << 6) | \ord($s[++$i] & "\x3F");
                    $s[$j] = $c < 256 ? \chr($c) : '?';
                    break;

<<<<<<< HEAD
                case "\xF0": ++$i;
=======
                case "\xF0":
                    ++$i;
                    // no break

>>>>>>> v2-test
                case "\xE0":
                    $s[$j] = '?';
                    $i += 2;
                    break;

                default:
                    $s[$j] = $s[$i];
            }
        }

        return substr($s, 0, $j);
    }

    public static function php_os_family()
    {
<<<<<<< HEAD
        if ('\\' === DIRECTORY_SEPARATOR) {
            return 'Windows';
        }

        $map = array(
=======
        if ('\\' === \DIRECTORY_SEPARATOR) {
            return 'Windows';
        }

        $map = [
>>>>>>> v2-test
            'Darwin' => 'Darwin',
            'DragonFly' => 'BSD',
            'FreeBSD' => 'BSD',
            'NetBSD' => 'BSD',
            'OpenBSD' => 'BSD',
            'Linux' => 'Linux',
            'SunOS' => 'Solaris',
<<<<<<< HEAD
        );

        return isset($map[PHP_OS]) ? $map[PHP_OS] : 'Unknown';
=======
        ];

        return isset($map[\PHP_OS]) ? $map[\PHP_OS] : 'Unknown';
>>>>>>> v2-test
    }

    public static function spl_object_id($object)
    {
        if (null === self::$hashMask) {
            self::initHashMask();
        }
        if (null === $hash = spl_object_hash($object)) {
            return;
        }

<<<<<<< HEAD
        return self::$hashMask ^ hexdec(substr($hash, 16 - \PHP_INT_SIZE, \PHP_INT_SIZE));
=======
        // On 32-bit systems, PHP_INT_SIZE is 4,
        return self::$hashMask ^ hexdec(substr($hash, 16 - (\PHP_INT_SIZE * 2 - 1), (\PHP_INT_SIZE * 2 - 1)));
>>>>>>> v2-test
    }

    public static function sapi_windows_vt100_support($stream, $enable = null)
    {
        if (!\is_resource($stream)) {
<<<<<<< HEAD
            trigger_error('sapi_windows_vt100_support() expects parameter 1 to be resource, '.gettype($stream).' given', E_USER_WARNING);
=======
            trigger_error('sapi_windows_vt100_support() expects parameter 1 to be resource, '.\gettype($stream).' given', \E_USER_WARNING);

>>>>>>> v2-test
            return false;
        }

        $meta = stream_get_meta_data($stream);

        if ('STDIO' !== $meta['stream_type']) {
<<<<<<< HEAD
            trigger_error('sapi_windows_vt100_support() was not able to analyze the specified stream', E_USER_WARNING);
=======
            trigger_error('sapi_windows_vt100_support() was not able to analyze the specified stream', \E_USER_WARNING);

>>>>>>> v2-test
            return false;
        }

        // We cannot actually disable vt100 support if it is set
        if (false === $enable || !self::stream_isatty($stream)) {
            return false;
        }

        // The native function does not apply to stdin
        $meta = array_map('strtolower', $meta);
        $stdin = 'php://stdin' === $meta['uri'] || 'php://fd/0' === $meta['uri'];

        return !$stdin
            && (false !== getenv('ANSICON')
            || 'ON' === getenv('ConEmuANSI')
            || 'xterm' === getenv('TERM')
            || 'Hyper' === getenv('TERM_PROGRAM'));
    }

    public static function stream_isatty($stream)
    {
        if (!\is_resource($stream)) {
<<<<<<< HEAD
            trigger_error('stream_isatty() expects parameter 1 to be resource, '.gettype($stream).' given', E_USER_WARNING);
            return false;
        }

        if ('\\' === DIRECTORY_SEPARATOR) {
=======
            trigger_error('stream_isatty() expects parameter 1 to be resource, '.\gettype($stream).' given', \E_USER_WARNING);

            return false;
        }

        if ('\\' === \DIRECTORY_SEPARATOR) {
>>>>>>> v2-test
            $stat = @fstat($stream);
            // Check if formatted mode is S_IFCHR
            return $stat ? 0020000 === ($stat['mode'] & 0170000) : false;
        }

<<<<<<< HEAD
        return function_exists('posix_isatty') && @posix_isatty($stream);
=======
        return \function_exists('posix_isatty') && @posix_isatty($stream);
>>>>>>> v2-test
    }

    private static function initHashMask()
    {
<<<<<<< HEAD
        $obj = (object) array();
        self::$hashMask = -1;

        // check if we are nested in an output buffering handler to prevent a fatal error with ob_start() below
        $obFuncs = array('ob_clean', 'ob_end_clean', 'ob_flush', 'ob_end_flush', 'ob_get_contents', 'ob_get_flush');
        foreach (debug_backtrace(\PHP_VERSION_ID >= 50400 ? DEBUG_BACKTRACE_IGNORE_ARGS : false) as $frame) {
=======
        $obj = (object) [];
        self::$hashMask = -1;

        // check if we are nested in an output buffering handler to prevent a fatal error with ob_start() below
        $obFuncs = ['ob_clean', 'ob_end_clean', 'ob_flush', 'ob_end_flush', 'ob_get_contents', 'ob_get_flush'];
        foreach (debug_backtrace(\PHP_VERSION_ID >= 50400 ? \DEBUG_BACKTRACE_IGNORE_ARGS : false) as $frame) {
>>>>>>> v2-test
            if (isset($frame['function'][0]) && !isset($frame['class']) && 'o' === $frame['function'][0] && \in_array($frame['function'], $obFuncs)) {
                $frame['line'] = 0;
                break;
            }
        }
        if (!empty($frame['line'])) {
            ob_start();
            debug_zval_dump($obj);
            self::$hashMask = (int) substr(ob_get_clean(), 17);
        }

<<<<<<< HEAD
        self::$hashMask ^= hexdec(substr(spl_object_hash($obj), 16 - \PHP_INT_SIZE, \PHP_INT_SIZE));
=======
        self::$hashMask ^= hexdec(substr(spl_object_hash($obj), 16 - (\PHP_INT_SIZE * 2 - 1), (\PHP_INT_SIZE * 2 - 1)));
    }

    public static function mb_chr($code, $encoding = null)
    {
        if (0x80 > $code %= 0x200000) {
            $s = \chr($code);
        } elseif (0x800 > $code) {
            $s = \chr(0xC0 | $code >> 6).\chr(0x80 | $code & 0x3F);
        } elseif (0x10000 > $code) {
            $s = \chr(0xE0 | $code >> 12).\chr(0x80 | $code >> 6 & 0x3F).\chr(0x80 | $code & 0x3F);
        } else {
            $s = \chr(0xF0 | $code >> 18).\chr(0x80 | $code >> 12 & 0x3F).\chr(0x80 | $code >> 6 & 0x3F).\chr(0x80 | $code & 0x3F);
        }

        if ('UTF-8' !== $encoding) {
            $s = mb_convert_encoding($s, $encoding, 'UTF-8');
        }

        return $s;
    }

    public static function mb_ord($s, $encoding = null)
    {
        if (null === $encoding) {
            $s = mb_convert_encoding($s, 'UTF-8');
        } elseif ('UTF-8' !== $encoding) {
            $s = mb_convert_encoding($s, 'UTF-8', $encoding);
        }

        if (1 === \strlen($s)) {
            return \ord($s);
        }

        $code = ($s = unpack('C*', substr($s, 0, 4))) ? $s[1] : 0;
        if (0xF0 <= $code) {
            return (($code - 0xF0) << 18) + (($s[2] - 0x80) << 12) + (($s[3] - 0x80) << 6) + $s[4] - 0x80;
        }
        if (0xE0 <= $code) {
            return (($code - 0xE0) << 12) + (($s[2] - 0x80) << 6) + $s[3] - 0x80;
        }
        if (0xC0 <= $code) {
            return (($code - 0xC0) << 6) + $s[2] - 0x80;
        }

        return $code;
>>>>>>> v2-test
    }
}
