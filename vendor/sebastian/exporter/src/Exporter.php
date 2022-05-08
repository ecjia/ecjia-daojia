<<<<<<< HEAD
<?php
/*
 * This file is part of the Exporter package.
=======
<?php declare(strict_types=1);
/*
 * This file is part of sebastian/exporter.
>>>>>>> v2-test
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
<<<<<<< HEAD

namespace SebastianBergmann\Exporter;

use SebastianBergmann\RecursionContext\Context;
=======
namespace SebastianBergmann\Exporter;

use function bin2hex;
use function count;
use function function_exists;
use function get_class;
use function get_resource_type;
use function implode;
use function is_array;
use function is_float;
use function is_object;
use function is_resource;
use function is_string;
use function mb_strlen;
use function mb_substr;
use function preg_match;
use function spl_object_hash;
use function sprintf;
use function str_repeat;
use function str_replace;
use function strlen;
use function substr;
use function var_export;
use SebastianBergmann\RecursionContext\Context;
use SplObjectStorage;
>>>>>>> v2-test

/**
 * A nifty utility for visualizing PHP variables.
 *
 * <code>
 * <?php
 * use SebastianBergmann\Exporter\Exporter;
 *
 * $exporter = new Exporter;
 * print $exporter->export(new Exception);
 * </code>
 */
class Exporter
{
    /**
<<<<<<< HEAD
     * Exports a value as a string
=======
     * Exports a value as a string.
>>>>>>> v2-test
     *
     * The output of this method is similar to the output of print_r(), but
     * improved in various aspects:
     *
     *  - NULL is rendered as "null" (instead of "")
     *  - TRUE is rendered as "true" (instead of "1")
     *  - FALSE is rendered as "false" (instead of "")
     *  - Strings are always quoted with single quotes
     *  - Carriage returns and newlines are normalized to \n
     *  - Recursion and repeated rendering is treated properly
     *
<<<<<<< HEAD
     * @param  mixed  $value
     * @param  int    $indentation The indentation level of the 2nd+ line
=======
     * @param int $indentation The indentation level of the 2nd+ line
     *
>>>>>>> v2-test
     * @return string
     */
    public function export($value, $indentation = 0)
    {
        return $this->recursiveExport($value, $indentation);
    }

    /**
<<<<<<< HEAD
     * @param  mixed   $data
     * @param  Context $context
=======
     * @param array<mixed> $data
     * @param Context      $context
     *
>>>>>>> v2-test
     * @return string
     */
    public function shortenedRecursiveExport(&$data, Context $context = null)
    {
<<<<<<< HEAD
        $result   = array();
=======
        $result   = [];
>>>>>>> v2-test
        $exporter = new self();

        if (!$context) {
            $context = new Context;
        }

<<<<<<< HEAD
        $context->add($data);

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if ($context->contains($data[$key]) !== false) {
                    $result[] = '*RECURSION*';
                }

                else {
=======
        $array = $data;
        $context->add($data);

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if ($context->contains($data[$key]) !== false) {
                    $result[] = '*RECURSION*';
                } else {
>>>>>>> v2-test
                    $result[] = sprintf(
                        'array(%s)',
                        $this->shortenedRecursiveExport($data[$key], $context)
                    );
                }
<<<<<<< HEAD
            }

            else {
=======
            } else {
>>>>>>> v2-test
                $result[] = $exporter->shortenedExport($value);
            }
        }

        return implode(', ', $result);
    }

    /**
<<<<<<< HEAD
     * Exports a value into a single-line string
=======
     * Exports a value into a single-line string.
>>>>>>> v2-test
     *
     * The output of this method is similar to the output of
     * SebastianBergmann\Exporter\Exporter::export().
     *
     * Newlines are replaced by the visible string '\n'.
     * Contents of arrays and objects (if any) are replaced by '...'.
     *
<<<<<<< HEAD
     * @param  mixed  $value
     * @return string
=======
     * @return string
     *
>>>>>>> v2-test
     * @see    SebastianBergmann\Exporter\Exporter::export
     */
    public function shortenedExport($value)
    {
        if (is_string($value)) {
<<<<<<< HEAD
            $string = $this->export($value);
=======
            $string = str_replace("\n", '', $this->export($value));
>>>>>>> v2-test

            if (function_exists('mb_strlen')) {
                if (mb_strlen($string) > 40) {
                    $string = mb_substr($string, 0, 30) . '...' . mb_substr($string, -7);
                }
            } else {
                if (strlen($string) > 40) {
                    $string = substr($string, 0, 30) . '...' . substr($string, -7);
                }
            }

<<<<<<< HEAD
            return str_replace("\n", '\n', $string);
=======
            return $string;
>>>>>>> v2-test
        }

        if (is_object($value)) {
            return sprintf(
                '%s Object (%s)',
                get_class($value),
                count($this->toArray($value)) > 0 ? '...' : ''
            );
        }

        if (is_array($value)) {
            return sprintf(
                'Array (%s)',
                count($value) > 0 ? '...' : ''
            );
        }

        return $this->export($value);
    }

    /**
     * Converts an object to an array containing all of its private, protected
     * and public properties.
     *
<<<<<<< HEAD
     * @param  mixed $value
=======
>>>>>>> v2-test
     * @return array
     */
    public function toArray($value)
    {
        if (!is_object($value)) {
            return (array) $value;
        }

<<<<<<< HEAD
        $array = array();

        foreach ((array) $value as $key => $val) {
=======
        $array = [];

        foreach ((array) $value as $key => $val) {
            // Exception traces commonly reference hundreds to thousands of
            // objects currently loaded in memory. Including them in the result
            // has a severe negative performance impact.
            if ("\0Error\0trace" === $key || "\0Exception\0trace" === $key) {
                continue;
            }

>>>>>>> v2-test
            // properties are transformed to keys in the following way:
            // private   $property => "\0Classname\0property"
            // protected $property => "\0*\0property"
            // public    $property => "property"
<<<<<<< HEAD
            if (preg_match('/^\0.+\0(.+)$/', $key, $matches)) {
=======
            if (preg_match('/^\0.+\0(.+)$/', (string) $key, $matches)) {
>>>>>>> v2-test
                $key = $matches[1];
            }

            // See https://github.com/php/php-src/commit/5721132
            if ($key === "\0gcdata") {
                continue;
            }

            $array[$key] = $val;
        }

        // Some internal classes like SplObjectStorage don't work with the
        // above (fast) mechanism nor with reflection in Zend.
        // Format the output similarly to print_r() in this case
<<<<<<< HEAD
        if ($value instanceof \SplObjectStorage) {
            // However, the fast method does work in HHVM, and exposes the
            // internal implementation. Hide it again.
            if (property_exists('\SplObjectStorage', '__storage')) {
                unset($array['__storage']);
            } elseif (property_exists('\SplObjectStorage', 'storage')) {
                unset($array['storage']);
            }

            if (property_exists('\SplObjectStorage', '__key')) {
                unset($array['__key']);
            }

            foreach ($value as $key => $val) {
                $array[spl_object_hash($val)] = array(
                    'obj' => $val,
                    'inf' => $value->getInfo(),
                );
=======
        if ($value instanceof SplObjectStorage) {
            foreach ($value as $key => $val) {
                $array[spl_object_hash($val)] = [
                    'obj' => $val,
                    'inf' => $value->getInfo(),
                ];
>>>>>>> v2-test
            }
        }

        return $array;
    }

    /**
<<<<<<< HEAD
     * Recursive implementation of export
     *
     * @param  mixed                                       $value       The value to export
     * @param  int                                         $indentation The indentation level of the 2nd+ line
     * @param  \SebastianBergmann\RecursionContext\Context $processed   Previously processed objects
     * @return string
=======
     * Recursive implementation of export.
     *
     * @param mixed                                       $value       The value to export
     * @param int                                         $indentation The indentation level of the 2nd+ line
     * @param \SebastianBergmann\RecursionContext\Context $processed   Previously processed objects
     *
     * @return string
     *
>>>>>>> v2-test
     * @see    SebastianBergmann\Exporter\Exporter::export
     */
    protected function recursiveExport(&$value, $indentation, $processed = null)
    {
        if ($value === null) {
            return 'null';
        }

        if ($value === true) {
            return 'true';
        }

        if ($value === false) {
            return 'false';
        }

<<<<<<< HEAD
        if (is_float($value) && floatval(intval($value)) === $value) {
=======
        if (is_float($value) && (float) ((int) $value) === $value) {
>>>>>>> v2-test
            return "$value.0";
        }

        if (is_resource($value)) {
            return sprintf(
                'resource(%d) of type (%s)',
                $value,
                get_resource_type($value)
            );
        }

        if (is_string($value)) {
            // Match for most non printable chars somewhat taking multibyte chars into account
            if (preg_match('/[^\x09-\x0d\x1b\x20-\xff]/', $value)) {
                return 'Binary String: 0x' . bin2hex($value);
            }

            return "'" .
<<<<<<< HEAD
            str_replace(array("\r\n", "\n\r", "\r"), array("\n", "\n", "\n"), $value) .
            "'";
        }

        $whitespace = str_repeat(' ', 4 * $indentation);
=======
            str_replace(
                '<lf>',
                "\n",
                str_replace(
                    ["\r\n", "\n\r", "\r", "\n"],
                    ['\r\n<lf>', '\n\r<lf>', '\r<lf>', '\n<lf>'],
                    $value
                )
            ) .
            "'";
        }

        $whitespace = str_repeat(' ', (int) (4 * $indentation));
>>>>>>> v2-test

        if (!$processed) {
            $processed = new Context;
        }

        if (is_array($value)) {
            if (($key = $processed->contains($value)) !== false) {
                return 'Array &' . $key;
            }

<<<<<<< HEAD
            $key    = $processed->add($value);
            $values = '';

            if (count($value) > 0) {
                foreach ($value as $k => $v) {
=======
            $array  = $value;
            $key    = $processed->add($value);
            $values = '';

            if (count($array) > 0) {
                foreach ($array as $k => $v) {
>>>>>>> v2-test
                    $values .= sprintf(
                        '%s    %s => %s' . "\n",
                        $whitespace,
                        $this->recursiveExport($k, $indentation),
                        $this->recursiveExport($value[$k], $indentation + 1, $processed)
                    );
                }

                $values = "\n" . $values . $whitespace;
            }

            return sprintf('Array &%s (%s)', $key, $values);
        }

        if (is_object($value)) {
            $class = get_class($value);

            if ($hash = $processed->contains($value)) {
                return sprintf('%s Object &%s', $class, $hash);
            }

            $hash   = $processed->add($value);
            $values = '';
            $array  = $this->toArray($value);

            if (count($array) > 0) {
                foreach ($array as $k => $v) {
                    $values .= sprintf(
                        '%s    %s => %s' . "\n",
                        $whitespace,
                        $this->recursiveExport($k, $indentation),
                        $this->recursiveExport($v, $indentation + 1, $processed)
                    );
                }

                $values = "\n" . $values . $whitespace;
            }

            return sprintf('%s Object &%s (%s)', $class, $hash, $values);
        }

        return var_export($value, true);
    }
}
