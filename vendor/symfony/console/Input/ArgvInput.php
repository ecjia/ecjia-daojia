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

use Symfony\Component\Console\Exception\RuntimeException;

/**
 * ArgvInput represents an input coming from the CLI arguments.
 *
 * Usage:
 *
 *     $input = new ArgvInput();
 *
 * By default, the `$_SERVER['argv']` array is used for the input values.
 *
 * This can be overridden by explicitly passing the input values in the constructor:
 *
 *     $input = new ArgvInput($_SERVER['argv']);
 *
 * If you pass it yourself, don't forget that the first element of the array
 * is the name of the running application.
 *
 * When passing an argument to the constructor, be sure that it respects
 * the same rules as the argv one. It's almost always better to use the
 * `StringInput` when you want to provide your own input.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @see http://www.gnu.org/software/libc/manual/html_node/Argument-Syntax.html
 * @see http://www.opengroup.org/onlinepubs/009695399/basedefs/xbd_chap12.html#tag_12_02
 */
class ArgvInput extends Input
{
    private $tokens;
    private $parsed;

<<<<<<< HEAD
    /**
     * @param array|null           $argv       An array of parameters from the CLI (in the argv format)
     * @param InputDefinition|null $definition A InputDefinition instance
     */
    public function __construct(array $argv = null, InputDefinition $definition = null)
    {
        if (null === $argv) {
            $argv = $_SERVER['argv'];
        }
=======
    public function __construct(array $argv = null, InputDefinition $definition = null)
    {
        $argv = $argv ?? $_SERVER['argv'] ?? [];
>>>>>>> v2-test

        // strip the application name
        array_shift($argv);

        $this->tokens = $argv;

        parent::__construct($definition);
    }

    protected function setTokens(array $tokens)
    {
        $this->tokens = $tokens;
    }

    /**
     * {@inheritdoc}
     */
    protected function parse()
    {
        $parseOptions = true;
        $this->parsed = $this->tokens;
        while (null !== $token = array_shift($this->parsed)) {
            if ($parseOptions && '' == $token) {
                $this->parseArgument($token);
            } elseif ($parseOptions && '--' == $token) {
                $parseOptions = false;
            } elseif ($parseOptions && 0 === strpos($token, '--')) {
                $this->parseLongOption($token);
            } elseif ($parseOptions && '-' === $token[0] && '-' !== $token) {
                $this->parseShortOption($token);
            } else {
                $this->parseArgument($token);
            }
        }
    }

    /**
     * Parses a short option.
<<<<<<< HEAD
     *
     * @param string $token The current token
     */
    private function parseShortOption($token)
=======
     */
    private function parseShortOption(string $token)
>>>>>>> v2-test
    {
        $name = substr($token, 1);

        if (\strlen($name) > 1) {
            if ($this->definition->hasShortcut($name[0]) && $this->definition->getOptionForShortcut($name[0])->acceptValue()) {
                // an option with a value (with no space)
                $this->addShortOption($name[0], substr($name, 1));
            } else {
                $this->parseShortOptionSet($name);
            }
        } else {
            $this->addShortOption($name, null);
        }
    }

    /**
     * Parses a short option set.
     *
<<<<<<< HEAD
     * @param string $name The current token
     *
     * @throws RuntimeException When option given doesn't exist
     */
    private function parseShortOptionSet($name)
=======
     * @throws RuntimeException When option given doesn't exist
     */
    private function parseShortOptionSet(string $name)
>>>>>>> v2-test
    {
        $len = \strlen($name);
        for ($i = 0; $i < $len; ++$i) {
            if (!$this->definition->hasShortcut($name[$i])) {
<<<<<<< HEAD
                throw new RuntimeException(sprintf('The "-%s" option does not exist.', $name[$i]));
=======
                $encoding = mb_detect_encoding($name, null, true);
                throw new RuntimeException(sprintf('The "-%s" option does not exist.', false === $encoding ? $name[$i] : mb_substr($name, $i, 1, $encoding)));
>>>>>>> v2-test
            }

            $option = $this->definition->getOptionForShortcut($name[$i]);
            if ($option->acceptValue()) {
                $this->addLongOption($option->getName(), $i === $len - 1 ? null : substr($name, $i + 1));

                break;
            } else {
                $this->addLongOption($option->getName(), null);
            }
        }
    }

    /**
     * Parses a long option.
<<<<<<< HEAD
     *
     * @param string $token The current token
     */
    private function parseLongOption($token)
=======
     */
    private function parseLongOption(string $token)
>>>>>>> v2-test
    {
        $name = substr($token, 2);

        if (false !== $pos = strpos($name, '=')) {
            if (0 === \strlen($value = substr($name, $pos + 1))) {
<<<<<<< HEAD
                // if no value after "=" then substr() returns "" since php7 only, false before
                // see http://php.net/manual/fr/migration70.incompatible.php#119151
                if (\PHP_VERSION_ID < 70000 && false === $value) {
                    $value = '';
                }
=======
>>>>>>> v2-test
                array_unshift($this->parsed, $value);
            }
            $this->addLongOption(substr($name, 0, $pos), $value);
        } else {
            $this->addLongOption($name, null);
        }
    }

    /**
     * Parses an argument.
     *
<<<<<<< HEAD
     * @param string $token The current token
     *
     * @throws RuntimeException When too many arguments are given
     */
    private function parseArgument($token)
=======
     * @throws RuntimeException When too many arguments are given
     */
    private function parseArgument(string $token)
>>>>>>> v2-test
    {
        $c = \count($this->arguments);

        // if input is expecting another argument, add it
        if ($this->definition->hasArgument($c)) {
            $arg = $this->definition->getArgument($c);
<<<<<<< HEAD
            $this->arguments[$arg->getName()] = $arg->isArray() ? array($token) : $token;
=======
            $this->arguments[$arg->getName()] = $arg->isArray() ? [$token] : $token;
>>>>>>> v2-test

        // if last argument isArray(), append token to last argument
        } elseif ($this->definition->hasArgument($c - 1) && $this->definition->getArgument($c - 1)->isArray()) {
            $arg = $this->definition->getArgument($c - 1);
            $this->arguments[$arg->getName()][] = $token;

        // unexpected argument
        } else {
            $all = $this->definition->getArguments();
<<<<<<< HEAD
            if (\count($all)) {
                throw new RuntimeException(sprintf('Too many arguments, expected arguments "%s".', implode('" "', array_keys($all))));
            }

            throw new RuntimeException(sprintf('No arguments expected, got "%s".', $token));
=======
            $symfonyCommandName = null;
            if (($inputArgument = $all[$key = array_key_first($all)] ?? null) && 'command' === $inputArgument->getName()) {
                $symfonyCommandName = $this->arguments['command'] ?? null;
                unset($all[$key]);
            }

            if (\count($all)) {
                if ($symfonyCommandName) {
                    $message = sprintf('Too many arguments to "%s" command, expected arguments "%s".', $symfonyCommandName, implode('" "', array_keys($all)));
                } else {
                    $message = sprintf('Too many arguments, expected arguments "%s".', implode('" "', array_keys($all)));
                }
            } elseif ($symfonyCommandName) {
                $message = sprintf('No arguments expected for "%s" command, got "%s".', $symfonyCommandName, $token);
            } else {
                $message = sprintf('No arguments expected, got "%s".', $token);
            }

            throw new RuntimeException($message);
>>>>>>> v2-test
        }
    }

    /**
     * Adds a short option value.
     *
<<<<<<< HEAD
     * @param string $shortcut The short option key
     * @param mixed  $value    The value for the option
     *
     * @throws RuntimeException When option given doesn't exist
     */
    private function addShortOption($shortcut, $value)
=======
     * @throws RuntimeException When option given doesn't exist
     */
    private function addShortOption(string $shortcut, $value)
>>>>>>> v2-test
    {
        if (!$this->definition->hasShortcut($shortcut)) {
            throw new RuntimeException(sprintf('The "-%s" option does not exist.', $shortcut));
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
     * @throws RuntimeException When option given doesn't exist
     */
    private function addLongOption($name, $value)
=======
     * @throws RuntimeException When option given doesn't exist
     */
    private function addLongOption(string $name, $value)
>>>>>>> v2-test
    {
        if (!$this->definition->hasOption($name)) {
            throw new RuntimeException(sprintf('The "--%s" option does not exist.', $name));
        }

        $option = $this->definition->getOption($name);

        if (null !== $value && !$option->acceptValue()) {
            throw new RuntimeException(sprintf('The "--%s" option does not accept a value.', $name));
        }

<<<<<<< HEAD
        if (\in_array($value, array('', null), true) && $option->acceptValue() && \count($this->parsed)) {
            // if option accepts an optional or mandatory argument
            // let's see if there is one provided
            $next = array_shift($this->parsed);
            if ((isset($next[0]) && '-' !== $next[0]) || \in_array($next, array('', null), true)) {
=======
        if (\in_array($value, ['', null], true) && $option->acceptValue() && \count($this->parsed)) {
            // if option accepts an optional or mandatory argument
            // let's see if there is one provided
            $next = array_shift($this->parsed);
            if ((isset($next[0]) && '-' !== $next[0]) || \in_array($next, ['', null], true)) {
>>>>>>> v2-test
                $value = $next;
            } else {
                array_unshift($this->parsed, $next);
            }
        }

        if (null === $value) {
            if ($option->isValueRequired()) {
                throw new RuntimeException(sprintf('The "--%s" option requires a value.', $name));
            }

            if (!$option->isArray() && !$option->isValueOptional()) {
                $value = true;
            }
        }

        if ($option->isArray()) {
            $this->options[$name][] = $value;
        } else {
            $this->options[$name] = $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstArgument()
    {
<<<<<<< HEAD
        foreach ($this->tokens as $token) {
            if ($token && '-' === $token[0]) {
=======
        $isOption = false;
        foreach ($this->tokens as $i => $token) {
            if ($token && '-' === $token[0]) {
                if (false !== strpos($token, '=') || !isset($this->tokens[$i + 1])) {
                    continue;
                }

                // If it's a long option, consider that everything after "--" is the option name.
                // Otherwise, use the last char (if it's a short option set, only the last one can take a value with space separator)
                $name = '-' === $token[1] ? substr($token, 2) : substr($token, -1);
                if (!isset($this->options[$name]) && !$this->definition->hasShortcut($name)) {
                    // noop
                } elseif ((isset($this->options[$name]) || isset($this->options[$name = $this->definition->shortcutToName($name)])) && $this->tokens[$i + 1] === $this->options[$name]) {
                    $isOption = true;
                }

                continue;
            }

            if ($isOption) {
                $isOption = false;
>>>>>>> v2-test
                continue;
            }

            return $token;
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

        foreach ($this->tokens as $token) {
            if ($onlyParams && '--' === $token) {
                return false;
            }
            foreach ($values as $value) {
                // Options with values:
                //   For long options, test for '--option=' at beginning
                //   For short options, test for '-o' at beginning
                $leading = 0 === strpos($value, '--') ? $value.'=' : $value;
                if ($token === $value || '' !== $leading && 0 === strpos($token, $leading)) {
                    return true;
                }
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
        $tokens = $this->tokens;

        while (0 < \count($tokens)) {
            $token = array_shift($tokens);
            if ($onlyParams && '--' === $token) {
                return $default;
            }

            foreach ($values as $value) {
                if ($token === $value) {
                    return array_shift($tokens);
                }
                // Options with values:
                //   For long options, test for '--option=' at beginning
                //   For short options, test for '-o' at beginning
                $leading = 0 === strpos($value, '--') ? $value.'=' : $value;
                if ('' !== $leading && 0 === strpos($token, $leading)) {
                    return substr($token, \strlen($leading));
                }
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
        $tokens = array_map(function ($token) {
            if (preg_match('{^(-[^=]+=)(.+)}', $token, $match)) {
                return $match[1].$this->escapeToken($match[2]);
            }

            if ($token && '-' !== $token[0]) {
                return $this->escapeToken($token);
            }

            return $token;
        }, $this->tokens);

        return implode(' ', $tokens);
    }
}
