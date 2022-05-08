<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Input;

use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\InvalidOptionException;

/**
 * ArrayInput represents an input provided as an array.
 *
 * Usage:
 *
<<<<<<< HEAD
 *     $input = new ArrayInput(array('name' => 'foo', '--bar' => 'foobar'));
=======
 *     $input = new ArrayInput(['command' => 'foo:bar', 'foo' => 'bar', '--bar' => 'foobar']);
>>>>>>> v2-test
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ArrayInput extends Input
{
    private $parameters;

    public function __construct(array $parameters, InputDefinition $definition = null)
    {
        $this->parameters = $parameters;

        parent::__construct($definition);
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstArgument()
    {
<<<<<<< HEAD
        foreach ($this->parameters as $key => $value) {
            if ($key && '-' === $key[0]) {
=======
        foreach ($this->parameters as $param => $value) {
            if ($param && \is_string($param) && '-' === $param[0]) {
>>>>>>> v2-test
                continue;
            }

            return $value;
        }
<<<<<<< HEAD
=======

        return null;
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function hasParameterOption($values, $onlyParams = false)
=======
    public function hasParameterOption($values, bool $onlyParams = false)
>>>>>>> v2-test
    {
        $values = (array) $values;

        foreach ($this->parameters as $k => $v) {
            if (!\is_int($k)) {
                $v = $k;
            }

            if ($onlyParams && '--' === $v) {
                return false;
            }

            if (\in_array($v, $values)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getParameterOption($values, $default = false, $onlyParams = false)
=======
    public function getParameterOption($values, $default = false, bool $onlyParams = false)
>>>>>>> v2-test
    {
        $values = (array) $values;

        foreach ($this->parameters as $k => $v) {
            if ($onlyParams && ('--' === $k || (\is_int($k) && '--' === $v))) {
                return $default;
            }

            if (\is_int($k)) {
                if (\in_array($v, $values)) {
                    return true;
                }
            } elseif (\in_array($k, $values)) {
                return $v;
            }
        }

        return $default;
    }

    /**
     * Returns a stringified representation of the args passed to the command.
     *
     * @return string
     */
    public function __toString()
    {
<<<<<<< HEAD
        $params = array();
        foreach ($this->parameters as $param => $val) {
            if ($param && '-' === $param[0]) {
=======
        $params = [];
        foreach ($this->parameters as $param => $val) {
            if ($param && \is_string($param) && '-' === $param[0]) {
>>>>>>> v2-test
                if (\is_array($val)) {
                    foreach ($val as $v) {
                        $params[] = $param.('' != $v ? '='.$this->escapeToken($v) : '');
                    }
                } else {
                    $params[] = $param.('' != $val ? '='.$this->escapeToken($val) : '');
                }
            } else {
<<<<<<< HEAD
                $params[] = \is_array($val) ? implode(' ', array_map(array($this, 'escapeToken'), $val)) : $this->escapeToken($val);
=======
                $params[] = \is_array($val) ? implode(' ', array_map([$this, 'escapeToken'], $val)) : $this->escapeToken($val);
>>>>>>> v2-test
            }
        }

        return implode(' ', $params);
    }

    /**
     * {@inheritdoc}
     */
    protected function parse()
    {
        foreach ($this->parameters as $key => $value) {
            if ('--' === $key) {
                return;
            }
            if (0 === strpos($key, '--')) {
                $this->addLongOption(substr($key, 2), $value);
<<<<<<< HEAD
            } elseif ('-' === $key[0]) {
=======
            } elseif (0 === strpos($key, '-')) {
>>>>>>> v2-test
                $this->addShortOption(substr($key, 1), $value);
            } else {
                $this->addArgument($key, $value);
            }
        }
    }

    /**
     * Adds a short option value.
     *
<<<<<<< HEAD
     * @param string $shortcut The short option key
     * @param mixed  $value    The value for the option
     *
     * @throws InvalidOptionException When option given doesn't exist
     */
    private function addShortOption($shortcut, $value)
=======
     * @throws InvalidOptionException When option given doesn't exist
     */
    private function addShortOption(string $shortcut, $value)
>>>>>>> v2-test
    {
        if (!$this->definition->hasShortcut($shortcut)) {
            throw new InvalidOptionException(sprintf('The "-%s" option does not exist.', $shortcut));
        }

        $this->addLongOption($this->definition->getOptionForShortcut($shortcut)->getName(), $value);
    }

    /**
     * Adds a long option value.
     *
<<<<<<< HEAD
     * @param string $name  The long option key
     * @param mixed  $value The value for the option
     *
     * @throws InvalidOptionException When option given doesn't exist
     * @throws InvalidOptionException When a required value is missing
     */
    private function addLongOption($name, $value)
=======
     * @throws InvalidOptionException When option given doesn't exist
     * @throws InvalidOptionException When a required value is missing
     */
    private function addLongOption(string $name, $value)
>>>>>>> v2-test
    {
        if (!$this->definition->hasOption($name)) {
            throw new InvalidOptionException(sprintf('The "--%s" option does not exist.', $name));
        }

        $option = $this->definition->getOption($name);

        if (null === $value) {
            if ($option->isValueRequired()) {
                throw new InvalidOptionException(sprintf('The "--%s" option requires a value.', $name));
            }

            if (!$option->isValueOptional()) {
                $value = true;
            }
        }

        $this->options[$name] = $value;
    }

    /**
     * Adds an argument value.
     *
<<<<<<< HEAD
     * @param string $name  The argument name
     * @param mixed  $value The value for the argument
=======
     * @param string|int $name  The argument name
     * @param mixed      $value The value for the argument
>>>>>>> v2-test
     *
     * @throws InvalidArgumentException When argument given doesn't exist
     */
    private function addArgument($name, $value)
    {
        if (!$this->definition->hasArgument($name)) {
            throw new InvalidArgumentException(sprintf('The "%s" argument does not exist.', $name));
        }

        $this->arguments[$name] = $value;
    }
}
