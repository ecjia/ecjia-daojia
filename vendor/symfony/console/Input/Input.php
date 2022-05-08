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
use Symfony\Component\Console\Exception\RuntimeException;

/**
 * Input is the base class for all concrete Input classes.
 *
 * Three concrete classes are provided by default:
 *
 *  * `ArgvInput`: The input comes from the CLI arguments (argv)
 *  * `StringInput`: The input is provided as a string
 *  * `ArrayInput`: The input is provided as an array
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class Input implements InputInterface, StreamableInputInterface
{
    protected $definition;
    protected $stream;
<<<<<<< HEAD
    protected $options = array();
    protected $arguments = array();
=======
    protected $options = [];
    protected $arguments = [];
>>>>>>> v2-test
    protected $interactive = true;

    public function __construct(InputDefinition $definition = null)
    {
        if (null === $definition) {
            $this->definition = new InputDefinition();
        } else {
            $this->bind($definition);
            $this->validate();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function bind(InputDefinition $definition)
    {
<<<<<<< HEAD
        $this->arguments = array();
        $this->options = array();
=======
        $this->arguments = [];
        $this->options = [];
>>>>>>> v2-test
        $this->definition = $definition;

        $this->parse();
    }

    /**
     * Processes command line arguments.
     */
    abstract protected function parse();

    /**
     * {@inheritdoc}
     */
    public function validate()
    {
        $definition = $this->definition;
        $givenArguments = $this->arguments;

        $missingArguments = array_filter(array_keys($definition->getArguments()), function ($argument) use ($definition, $givenArguments) {
<<<<<<< HEAD
            return !array_key_exists($argument, $givenArguments) && $definition->getArgument($argument)->isRequired();
=======
            return !\array_key_exists($argument, $givenArguments) && $definition->getArgument($argument)->isRequired();
>>>>>>> v2-test
        });

        if (\count($missingArguments) > 0) {
            throw new RuntimeException(sprintf('Not enough arguments (missing: "%s").', implode(', ', $missingArguments)));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isInteractive()
    {
        return $this->interactive;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function setInteractive($interactive)
    {
        $this->interactive = (bool) $interactive;
=======
    public function setInteractive(bool $interactive)
    {
        $this->interactive = $interactive;
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
    public function getArguments()
    {
        return array_merge($this->definition->getArgumentDefaults(), $this->arguments);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getArgument($name)
=======
    public function getArgument(string $name)
>>>>>>> v2-test
    {
        if (!$this->definition->hasArgument($name)) {
            throw new InvalidArgumentException(sprintf('The "%s" argument does not exist.', $name));
        }

<<<<<<< HEAD
        return isset($this->arguments[$name]) ? $this->arguments[$name] : $this->definition->getArgument($name)->getDefault();
=======
        return $this->arguments[$name] ?? $this->definition->getArgument($name)->getDefault();
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function setArgument($name, $value)
=======
    public function setArgument(string $name, $value)
>>>>>>> v2-test
    {
        if (!$this->definition->hasArgument($name)) {
            throw new InvalidArgumentException(sprintf('The "%s" argument does not exist.', $name));
        }

        $this->arguments[$name] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function hasArgument($name)
    {
        return $this->definition->hasArgument($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return array_merge($this->definition->getOptionDefaults(), $this->options);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getOption($name)
=======
    public function getOption(string $name)
>>>>>>> v2-test
    {
        if (!$this->definition->hasOption($name)) {
            throw new InvalidArgumentException(sprintf('The "%s" option does not exist.', $name));
        }

<<<<<<< HEAD
        return array_key_exists($name, $this->options) ? $this->options[$name] : $this->definition->getOption($name)->getDefault();
=======
        return \array_key_exists($name, $this->options) ? $this->options[$name] : $this->definition->getOption($name)->getDefault();
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function setOption($name, $value)
=======
    public function setOption(string $name, $value)
>>>>>>> v2-test
    {
        if (!$this->definition->hasOption($name)) {
            throw new InvalidArgumentException(sprintf('The "%s" option does not exist.', $name));
        }

        $this->options[$name] = $value;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function hasOption($name)
=======
    public function hasOption(string $name)
>>>>>>> v2-test
    {
        return $this->definition->hasOption($name);
    }

    /**
     * Escapes a token through escapeshellarg if it contains unsafe chars.
     *
<<<<<<< HEAD
     * @param string $token
     *
     * @return string
     */
    public function escapeToken($token)
=======
     * @return string
     */
    public function escapeToken(string $token)
>>>>>>> v2-test
    {
        return preg_match('{^[\w-]+$}', $token) ? $token : escapeshellarg($token);
    }

    /**
     * {@inheritdoc}
     */
    public function setStream($stream)
    {
        $this->stream = $stream;
    }

    /**
     * {@inheritdoc}
     */
    public function getStream()
    {
        return $this->stream;
    }
}
