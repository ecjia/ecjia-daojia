<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation;

/**
 * Represents an Accept-* header item.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class AcceptHeaderItem
{
<<<<<<< HEAD
    /**
     * @var string
     */
    private $value;

    /**
     * @var float
     */
    private $quality = 1.0;

    /**
     * @var int
     */
    private $index = 0;

    /**
     * @var array
     */
    private $attributes = array();

    /**
     * Constructor.
     *
     * @param string $value
     * @param array  $attributes
     */
    public function __construct($value, array $attributes = array())
=======
    private $value;
    private $quality = 1.0;
    private $index = 0;
    private $attributes = [];

    public function __construct(string $value, array $attributes = [])
>>>>>>> v2-test
    {
        $this->value = $value;
        foreach ($attributes as $name => $value) {
            $this->setAttribute($name, $value);
        }
    }

    /**
     * Builds an AcceptHeaderInstance instance from a string.
     *
<<<<<<< HEAD
     * @param string $itemValue
     *
     * @return AcceptHeaderItem
     */
    public static function fromString($itemValue)
    {
        $bits = preg_split('/\s*(?:;*("[^"]+");*|;*(\'[^\']+\');*|;+)\s*/', $itemValue, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        $value = array_shift($bits);
        $attributes = array();

        $lastNullAttribute = null;
        foreach ($bits as $bit) {
            if (($start = substr($bit, 0, 1)) === ($end = substr($bit, -1)) && ($start === '"' || $start === '\'')) {
                $attributes[$lastNullAttribute] = substr($bit, 1, -1);
            } elseif ('=' === $end) {
                $lastNullAttribute = $bit = substr($bit, 0, -1);
                $attributes[$bit] = null;
            } else {
                $parts = explode('=', $bit);
                $attributes[$parts[0]] = isset($parts[1]) && strlen($parts[1]) > 0 ? $parts[1] : '';
            }
        }

        return new self(($start = substr($value, 0, 1)) === ($end = substr($value, -1)) && ($start === '"' || $start === '\'') ? substr($value, 1, -1) : $value, $attributes);
    }

    /**
     * Returns header  value's string representation.
=======
     * @return self
     */
    public static function fromString(?string $itemValue)
    {
        $parts = HeaderUtils::split($itemValue ?? '', ';=');

        $part = array_shift($parts);
        $attributes = HeaderUtils::combine($parts);

        return new self($part[0], $attributes);
    }

    /**
     * Returns header value's string representation.
>>>>>>> v2-test
     *
     * @return string
     */
    public function __toString()
    {
        $string = $this->value.($this->quality < 1 ? ';q='.$this->quality : '');
<<<<<<< HEAD
        if (count($this->attributes) > 0) {
            $string .= ';'.implode(';', array_map(function ($name, $value) {
                return sprintf(preg_match('/[,;=]/', $value) ? '%s="%s"' : '%s=%s', $name, $value);
            }, array_keys($this->attributes), $this->attributes));
=======
        if (\count($this->attributes) > 0) {
            $string .= '; '.HeaderUtils::toString($this->attributes, ';');
>>>>>>> v2-test
        }

        return $string;
    }

    /**
     * Set the item value.
     *
<<<<<<< HEAD
     * @param string $value
     *
     * @return AcceptHeaderItem
     */
    public function setValue($value)
=======
     * @return $this
     */
    public function setValue(string $value)
>>>>>>> v2-test
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Returns the item value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the item quality.
     *
<<<<<<< HEAD
     * @param float $quality
     *
     * @return AcceptHeaderItem
     */
    public function setQuality($quality)
=======
     * @return $this
     */
    public function setQuality(float $quality)
>>>>>>> v2-test
    {
        $this->quality = $quality;

        return $this;
    }

    /**
     * Returns the item quality.
     *
     * @return float
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * Set the item index.
     *
<<<<<<< HEAD
     * @param int $index
     *
     * @return AcceptHeaderItem
     */
    public function setIndex($index)
=======
     * @return $this
     */
    public function setIndex(int $index)
>>>>>>> v2-test
    {
        $this->index = $index;

        return $this;
    }

    /**
     * Returns the item index.
     *
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Tests if an attribute exists.
     *
<<<<<<< HEAD
     * @param string $name
     *
     * @return bool
     */
    public function hasAttribute($name)
=======
     * @return bool
     */
    public function hasAttribute(string $name)
>>>>>>> v2-test
    {
        return isset($this->attributes[$name]);
    }

    /**
     * Returns an attribute by its name.
     *
<<<<<<< HEAD
     * @param string $name
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getAttribute($name, $default = null)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : $default;
=======
     * @param mixed $default
     *
     * @return mixed
     */
    public function getAttribute(string $name, $default = null)
    {
        return $this->attributes[$name] ?? $default;
>>>>>>> v2-test
    }

    /**
     * Returns all attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set an attribute.
     *
<<<<<<< HEAD
     * @param string $name
     * @param string $value
     *
     * @return AcceptHeaderItem
     */
    public function setAttribute($name, $value)
=======
     * @return $this
     */
    public function setAttribute(string $name, string $value)
>>>>>>> v2-test
    {
        if ('q' === $name) {
            $this->quality = (float) $value;
        } else {
<<<<<<< HEAD
            $this->attributes[$name] = (string) $value;
=======
            $this->attributes[$name] = $value;
>>>>>>> v2-test
        }

        return $this;
    }
}
