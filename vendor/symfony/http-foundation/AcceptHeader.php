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

<<<<<<< HEAD
=======
// Help opcache.preload discover always-needed symbols
class_exists(AcceptHeaderItem::class);

>>>>>>> v2-test
/**
 * Represents an Accept-* header.
 *
 * An accept header is compound with a list of items,
 * sorted by descending quality.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class AcceptHeader
{
    /**
     * @var AcceptHeaderItem[]
     */
<<<<<<< HEAD
    private $items = array();
=======
    private $items = [];
>>>>>>> v2-test

    /**
     * @var bool
     */
    private $sorted = true;

    /**
<<<<<<< HEAD
     * Constructor.
     *
=======
>>>>>>> v2-test
     * @param AcceptHeaderItem[] $items
     */
    public function __construct(array $items)
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    /**
     * Builds an AcceptHeader instance from a string.
     *
<<<<<<< HEAD
     * @param string $headerValue
     *
     * @return AcceptHeader
     */
    public static function fromString($headerValue)
    {
        $index = 0;

        return new self(array_map(function ($itemValue) use (&$index) {
            $item = AcceptHeaderItem::fromString($itemValue);
            $item->setIndex($index++);

            return $item;
        }, preg_split('/\s*(?:,*("[^"]+"),*|,*(\'[^\']+\'),*|,+)\s*/', $headerValue, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE)));
=======
     * @return self
     */
    public static function fromString(?string $headerValue)
    {
        $index = 0;

        $parts = HeaderUtils::split($headerValue ?? '', ',;=');

        return new self(array_map(function ($subParts) use (&$index) {
            $part = array_shift($subParts);
            $attributes = HeaderUtils::combine($subParts);

            $item = new AcceptHeaderItem($part[0], $attributes);
            $item->setIndex($index++);

            return $item;
        }, $parts));
>>>>>>> v2-test
    }

    /**
     * Returns header value's string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return implode(',', $this->items);
    }

    /**
     * Tests if header has given value.
     *
<<<<<<< HEAD
     * @param string $value
     *
     * @return bool
     */
    public function has($value)
=======
     * @return bool
     */
    public function has(string $value)
>>>>>>> v2-test
    {
        return isset($this->items[$value]);
    }

    /**
     * Returns given value's item, if exists.
     *
<<<<<<< HEAD
     * @param string $value
     *
     * @return AcceptHeaderItem|null
     */
    public function get($value)
    {
        return isset($this->items[$value]) ? $this->items[$value] : null;
=======
     * @return AcceptHeaderItem|null
     */
    public function get(string $value)
    {
        return $this->items[$value] ?? $this->items[explode('/', $value)[0].'/*'] ?? $this->items['*/*'] ?? $this->items['*'] ?? null;
>>>>>>> v2-test
    }

    /**
     * Adds an item.
     *
<<<<<<< HEAD
     * @param AcceptHeaderItem $item
     *
     * @return AcceptHeader
=======
     * @return $this
>>>>>>> v2-test
     */
    public function add(AcceptHeaderItem $item)
    {
        $this->items[$item->getValue()] = $item;
        $this->sorted = false;

        return $this;
    }

    /**
     * Returns all items.
     *
     * @return AcceptHeaderItem[]
     */
    public function all()
    {
        $this->sort();

        return $this->items;
    }

    /**
     * Filters items on their value using given regex.
     *
<<<<<<< HEAD
     * @param string $pattern
     *
     * @return AcceptHeader
     */
    public function filter($pattern)
=======
     * @return self
     */
    public function filter(string $pattern)
>>>>>>> v2-test
    {
        return new self(array_filter($this->items, function (AcceptHeaderItem $item) use ($pattern) {
            return preg_match($pattern, $item->getValue());
        }));
    }

    /**
     * Returns first item.
     *
     * @return AcceptHeaderItem|null
     */
    public function first()
    {
        $this->sort();

        return !empty($this->items) ? reset($this->items) : null;
    }

    /**
     * Sorts items by descending quality.
     */
<<<<<<< HEAD
    private function sort()
    {
        if (!$this->sorted) {
            uasort($this->items, function ($a, $b) {
=======
    private function sort(): void
    {
        if (!$this->sorted) {
            uasort($this->items, function (AcceptHeaderItem $a, AcceptHeaderItem $b) {
>>>>>>> v2-test
                $qA = $a->getQuality();
                $qB = $b->getQuality();

                if ($qA === $qB) {
                    return $a->getIndex() > $b->getIndex() ? 1 : -1;
                }

                return $qA > $qB ? -1 : 1;
            });

            $this->sorted = true;
        }
    }
}
