<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Yaml;

<<<<<<< HEAD
=======
use Symfony\Component\Yaml\Tag\TaggedValue;

>>>>>>> v2-test
/**
 * Dumper dumps PHP variables to YAML strings.
 *
 * @author Fabien Potencier <fabien@symfony.com>
<<<<<<< HEAD
=======
 *
 * @final
>>>>>>> v2-test
 */
class Dumper
{
    /**
     * The amount of spaces to use for indentation of nested nodes.
     *
     * @var int
     */
    protected $indentation;

<<<<<<< HEAD
    /**
     * @param int $indentation
     */
    public function __construct($indentation = 4)
=======
    public function __construct(int $indentation = 4)
>>>>>>> v2-test
    {
        if ($indentation < 1) {
            throw new \InvalidArgumentException('The indentation must be greater than zero.');
        }

        $this->indentation = $indentation;
    }

    /**
<<<<<<< HEAD
     * Sets the indentation.
     *
     * @param int $num The amount of spaces to use for indentation of nested nodes
     */
    public function setIndentation($num)
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 3.1 and will be removed in 4.0. Pass the indentation to the constructor instead.', E_USER_DEPRECATED);

        $this->indentation = (int) $num;
    }

    /**
=======
>>>>>>> v2-test
     * Dumps a PHP value to YAML.
     *
     * @param mixed $input  The PHP value
     * @param int   $inline The level where you switch to inline YAML
     * @param int   $indent The level of indentation (used internally)
     * @param int   $flags  A bit field of Yaml::DUMP_* constants to customize the dumped YAML string
     *
     * @return string The YAML representation of the PHP value
     */
<<<<<<< HEAD
    public function dump($input, $inline = 0, $indent = 0, $flags = 0)
    {
        if (is_bool($flags)) {
            @trigger_error('Passing a boolean flag to toggle exception handling is deprecated since version 3.1 and will be removed in 4.0. Use the Yaml::DUMP_EXCEPTION_ON_INVALID_TYPE flag instead.', E_USER_DEPRECATED);

            if ($flags) {
                $flags = Yaml::DUMP_EXCEPTION_ON_INVALID_TYPE;
            } else {
                $flags = 0;
            }
        }

        if (func_num_args() >= 5) {
            @trigger_error('Passing a boolean flag to toggle object support is deprecated since version 3.1 and will be removed in 4.0. Use the Yaml::DUMP_OBJECT flag instead.', E_USER_DEPRECATED);

            if (func_get_arg(4)) {
                $flags |= Yaml::DUMP_OBJECT;
            }
        }

        $output = '';
        $prefix = $indent ? str_repeat(' ', $indent) : '';

        if ($inline <= 0 || !is_array($input) || empty($input)) {
            $output .= $prefix.Inline::dump($input, $flags);
        } else {
            $isAHash = Inline::isHash($input);

            foreach ($input as $key => $value) {
                if ($inline > 1 && Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK & $flags && is_string($value) && false !== strpos($value, "\n")) {
                    $output .= sprintf("%s%s%s |\n", $prefix, $isAHash ? Inline::dump($key, $flags).':' : '-', '');

                    foreach (preg_split('/\n|\r\n/', $value) as $row) {
                        $output .= sprintf("%s%s%s\n", $prefix, str_repeat(' ', $this->indentation), $row);
=======
    public function dump($input, int $inline = 0, int $indent = 0, int $flags = 0): string
    {
        $output = '';
        $prefix = $indent ? str_repeat(' ', $indent) : '';
        $dumpObjectAsInlineMap = true;

        if (Yaml::DUMP_OBJECT_AS_MAP & $flags && ($input instanceof \ArrayObject || $input instanceof \stdClass)) {
            $dumpObjectAsInlineMap = empty((array) $input);
        }

        if ($inline <= 0 || (!\is_array($input) && !$input instanceof TaggedValue && $dumpObjectAsInlineMap) || empty($input)) {
            $output .= $prefix.Inline::dump($input, $flags);
        } else {
            $dumpAsMap = Inline::isHash($input);

            foreach ($input as $key => $value) {
                if ('' !== $output && "\n" !== $output[-1]) {
                    $output .= "\n";
                }

                if ($inline >= 1 && Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK & $flags && \is_string($value) && false !== strpos($value, "\n") && false === strpos($value, "\r")) {
                    // If the first line starts with a space character, the spec requires a blockIndicationIndicator
                    // http://www.yaml.org/spec/1.2/spec.html#id2793979
                    $blockIndentationIndicator = (' ' === substr($value, 0, 1)) ? (string) $this->indentation : '';

                    if (isset($value[-2]) && "\n" === $value[-2] && "\n" === $value[-1]) {
                        $blockChompingIndicator = '+';
                    } elseif ("\n" === $value[-1]) {
                        $blockChompingIndicator = '';
                    } else {
                        $blockChompingIndicator = '-';
                    }

                    $output .= sprintf('%s%s%s |%s%s', $prefix, $dumpAsMap ? Inline::dump($key, $flags).':' : '-', '', $blockIndentationIndicator, $blockChompingIndicator);

                    foreach (explode("\n", $value) as $row) {
                        if ('' === $row) {
                            $output .= "\n";
                        } else {
                            $output .= sprintf("\n%s%s%s", $prefix, str_repeat(' ', $this->indentation), $row);
                        }
>>>>>>> v2-test
                    }

                    continue;
                }

<<<<<<< HEAD
                $willBeInlined = $inline - 1 <= 0 || !is_array($value) || empty($value);

                $output .= sprintf('%s%s%s%s',
                    $prefix,
                    $isAHash ? Inline::dump($key, $flags).':' : '-',
=======
                if ($value instanceof TaggedValue) {
                    $output .= sprintf('%s%s !%s', $prefix, $dumpAsMap ? Inline::dump($key, $flags).':' : '-', $value->getTag());

                    if ($inline >= 1 && Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK & $flags && \is_string($value->getValue()) && false !== strpos($value->getValue(), "\n") && false === strpos($value->getValue(), "\r\n")) {
                        // If the first line starts with a space character, the spec requires a blockIndicationIndicator
                        // http://www.yaml.org/spec/1.2/spec.html#id2793979
                        $blockIndentationIndicator = (' ' === substr($value->getValue(), 0, 1)) ? (string) $this->indentation : '';
                        $output .= sprintf(' |%s', $blockIndentationIndicator);

                        foreach (explode("\n", $value->getValue()) as $row) {
                            $output .= sprintf("\n%s%s%s", $prefix, str_repeat(' ', $this->indentation), $row);
                        }

                        continue;
                    }

                    if ($inline - 1 <= 0 || null === $value->getValue() || is_scalar($value->getValue())) {
                        $output .= ' '.$this->dump($value->getValue(), $inline - 1, 0, $flags)."\n";
                    } else {
                        $output .= "\n";
                        $output .= $this->dump($value->getValue(), $inline - 1, $dumpAsMap ? $indent + $this->indentation : $indent + 2, $flags);
                    }

                    continue;
                }

                $dumpObjectAsInlineMap = true;

                if (Yaml::DUMP_OBJECT_AS_MAP & $flags && ($value instanceof \ArrayObject || $value instanceof \stdClass)) {
                    $dumpObjectAsInlineMap = empty((array) $value);
                }

                $willBeInlined = $inline - 1 <= 0 || !\is_array($value) && $dumpObjectAsInlineMap || empty($value);

                $output .= sprintf('%s%s%s%s',
                    $prefix,
                    $dumpAsMap ? Inline::dump($key, $flags).':' : '-',
>>>>>>> v2-test
                    $willBeInlined ? ' ' : "\n",
                    $this->dump($value, $inline - 1, $willBeInlined ? 0 : $indent + $this->indentation, $flags)
                ).($willBeInlined ? "\n" : '');
            }
        }

        return $output;
    }
}
