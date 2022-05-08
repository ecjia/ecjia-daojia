<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Question;

use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\LogicException;

/**
 * Represents a Question.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Question
{
    private $question;
    private $attempts;
    private $hidden = false;
    private $hiddenFallback = true;
<<<<<<< HEAD
    private $autocompleterValues;
    private $validator;
    private $default;
    private $normalizer;
=======
    private $autocompleterCallback;
    private $validator;
    private $default;
    private $normalizer;
    private $trimmable = true;
    private $multiline = false;
>>>>>>> v2-test

    /**
     * @param string $question The question to ask to the user
     * @param mixed  $default  The default answer to return if the user enters nothing
     */
<<<<<<< HEAD
    public function __construct($question, $default = null)
=======
    public function __construct(string $question, $default = null)
>>>>>>> v2-test
    {
        $this->question = $question;
        $this->default = $default;
    }

    /**
     * Returns the question.
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Returns the default answer.
     *
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
<<<<<<< HEAD
=======
     * Returns whether the user response accepts newline characters.
     */
    public function isMultiline(): bool
    {
        return $this->multiline;
    }

    /**
     * Sets whether the user response should accept newline characters.
     *
     * @return $this
     */
    public function setMultiline(bool $multiline): self
    {
        $this->multiline = $multiline;

        return $this;
    }

    /**
>>>>>>> v2-test
     * Returns whether the user response must be hidden.
     *
     * @return bool
     */
    public function isHidden()
    {
        return $this->hidden;
    }

    /**
     * Sets whether the user response must be hidden or not.
     *
     * @param bool $hidden
     *
     * @return $this
     *
     * @throws LogicException In case the autocompleter is also used
     */
    public function setHidden($hidden)
    {
<<<<<<< HEAD
        if ($this->autocompleterValues) {
=======
        if ($this->autocompleterCallback) {
>>>>>>> v2-test
            throw new LogicException('A hidden question cannot use the autocompleter.');
        }

        $this->hidden = (bool) $hidden;

        return $this;
    }

    /**
     * In case the response can not be hidden, whether to fallback on non-hidden question or not.
     *
     * @return bool
     */
    public function isHiddenFallback()
    {
        return $this->hiddenFallback;
    }

    /**
     * Sets whether to fallback on non-hidden question if the response can not be hidden.
     *
     * @param bool $fallback
     *
     * @return $this
     */
    public function setHiddenFallback($fallback)
    {
        $this->hiddenFallback = (bool) $fallback;

        return $this;
    }

    /**
     * Gets values for the autocompleter.
     *
<<<<<<< HEAD
     * @return null|iterable
     */
    public function getAutocompleterValues()
    {
        return $this->autocompleterValues;
=======
     * @return iterable|null
     */
    public function getAutocompleterValues()
    {
        $callback = $this->getAutocompleterCallback();

        return $callback ? $callback('') : null;
>>>>>>> v2-test
    }

    /**
     * Sets values for the autocompleter.
     *
<<<<<<< HEAD
     * @param null|iterable $values
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     * @throws LogicException
     */
    public function setAutocompleterValues($values)
    {
        if (\is_array($values)) {
            $values = $this->isAssoc($values) ? array_merge(array_keys($values), array_values($values)) : array_values($values);
        }

        if (null !== $values && !\is_array($values) && !$values instanceof \Traversable) {
            throw new InvalidArgumentException('Autocompleter values can be either an array, `null` or a `Traversable` object.');
        }

        if ($this->hidden) {
            throw new LogicException('A hidden question cannot use the autocompleter.');
        }

        $this->autocompleterValues = $values;
=======
     * @return $this
     *
     * @throws LogicException
     */
    public function setAutocompleterValues(?iterable $values)
    {
        if (\is_array($values)) {
            $values = $this->isAssoc($values) ? array_merge(array_keys($values), array_values($values)) : array_values($values);

            $callback = static function () use ($values) {
                return $values;
            };
        } elseif ($values instanceof \Traversable) {
            $valueCache = null;
            $callback = static function () use ($values, &$valueCache) {
                return $valueCache ?? $valueCache = iterator_to_array($values, false);
            };
        } else {
            $callback = null;
        }

        return $this->setAutocompleterCallback($callback);
    }

    /**
     * Gets the callback function used for the autocompleter.
     */
    public function getAutocompleterCallback(): ?callable
    {
        return $this->autocompleterCallback;
    }

    /**
     * Sets the callback function used for the autocompleter.
     *
     * The callback is passed the user input as argument and should return an iterable of corresponding suggestions.
     *
     * @return $this
     */
    public function setAutocompleterCallback(callable $callback = null): self
    {
        if ($this->hidden && null !== $callback) {
            throw new LogicException('A hidden question cannot use the autocompleter.');
        }

        $this->autocompleterCallback = $callback;
>>>>>>> v2-test

        return $this;
    }

    /**
     * Sets a validator for the question.
     *
<<<<<<< HEAD
     * @param null|callable $validator
     *
=======
>>>>>>> v2-test
     * @return $this
     */
    public function setValidator(callable $validator = null)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Gets the validator for the question.
     *
<<<<<<< HEAD
     * @return null|callable
=======
     * @return callable|null
>>>>>>> v2-test
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * Sets the maximum number of attempts.
     *
     * Null means an unlimited number of attempts.
     *
<<<<<<< HEAD
     * @param null|int $attempts
     *
=======
>>>>>>> v2-test
     * @return $this
     *
     * @throws InvalidArgumentException in case the number of attempts is invalid
     */
<<<<<<< HEAD
    public function setMaxAttempts($attempts)
    {
        if (null !== $attempts && $attempts < 1) {
            throw new InvalidArgumentException('Maximum number of attempts must be a positive value.');
=======
    public function setMaxAttempts(?int $attempts)
    {
        if (null !== $attempts) {
            $attempts = (int) $attempts;
            if ($attempts < 1) {
                throw new InvalidArgumentException('Maximum number of attempts must be a positive value.');
            }
>>>>>>> v2-test
        }

        $this->attempts = $attempts;

        return $this;
    }

    /**
     * Gets the maximum number of attempts.
     *
     * Null means an unlimited number of attempts.
     *
<<<<<<< HEAD
     * @return null|int
=======
     * @return int|null
>>>>>>> v2-test
     */
    public function getMaxAttempts()
    {
        return $this->attempts;
    }

    /**
     * Sets a normalizer for the response.
     *
     * The normalizer can be a callable (a string), a closure or a class implementing __invoke.
     *
<<<<<<< HEAD
     * @param callable $normalizer
     *
=======
>>>>>>> v2-test
     * @return $this
     */
    public function setNormalizer(callable $normalizer)
    {
        $this->normalizer = $normalizer;

        return $this;
    }

    /**
     * Gets the normalizer for the response.
     *
     * The normalizer can ba a callable (a string), a closure or a class implementing __invoke.
     *
<<<<<<< HEAD
     * @return callable
=======
     * @return callable|null
>>>>>>> v2-test
     */
    public function getNormalizer()
    {
        return $this->normalizer;
    }

<<<<<<< HEAD
    protected function isAssoc($array)
    {
        return (bool) \count(array_filter(array_keys($array), 'is_string'));
    }
=======
    protected function isAssoc(array $array)
    {
        return (bool) \count(array_filter(array_keys($array), 'is_string'));
    }

    public function isTrimmable(): bool
    {
        return $this->trimmable;
    }

    /**
     * @return $this
     */
    public function setTrimmable(bool $trimmable): self
    {
        $this->trimmable = $trimmable;

        return $this;
    }
>>>>>>> v2-test
}
