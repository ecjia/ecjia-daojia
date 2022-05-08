<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\VarDumper\Cloner;

<<<<<<< HEAD
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class Data
{
    private $data;
    private $maxDepth = 20;
    private $maxItemsPerDepth = -1;
    private $useRefHandles = -1;

    /**
     * @param array $data A array as returned by ClonerInterface::cloneVar()
=======
use Symfony\Component\VarDumper\Caster\Caster;
use Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class Data implements \ArrayAccess, \Countable, \IteratorAggregate
{
    private $data;
    private $position = 0;
    private $key = 0;
    private $maxDepth = 20;
    private $maxItemsPerDepth = -1;
    private $useRefHandles = -1;
    private $context = [];

    /**
     * @param array $data An array as returned by ClonerInterface::cloneVar()
>>>>>>> v2-test
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
<<<<<<< HEAD
     * @return array The raw data structure
     */
    public function getRawData()
    {
        return $this->data;
    }

    /**
     * Returns a depth limited clone of $this.
     *
     * @param int $maxDepth The max dumped depth level
     *
     * @return self A clone of $this
     */
    public function withMaxDepth($maxDepth)
=======
     * @return string|null The type of the value
     */
    public function getType()
    {
        $item = $this->data[$this->position][$this->key];

        if ($item instanceof Stub && Stub::TYPE_REF === $item->type && !$item->position) {
            $item = $item->value;
        }
        if (!$item instanceof Stub) {
            return \gettype($item);
        }
        if (Stub::TYPE_STRING === $item->type) {
            return 'string';
        }
        if (Stub::TYPE_ARRAY === $item->type) {
            return 'array';
        }
        if (Stub::TYPE_OBJECT === $item->type) {
            return $item->class;
        }
        if (Stub::TYPE_RESOURCE === $item->type) {
            return $item->class.' resource';
        }

        return null;
    }

    /**
     * @param array|bool $recursive Whether values should be resolved recursively or not
     *
     * @return string|int|float|bool|array|Data[]|null A native representation of the original value
     */
    public function getValue($recursive = false)
    {
        $item = $this->data[$this->position][$this->key];

        if ($item instanceof Stub && Stub::TYPE_REF === $item->type && !$item->position) {
            $item = $item->value;
        }
        if (!($item = $this->getStub($item)) instanceof Stub) {
            return $item;
        }
        if (Stub::TYPE_STRING === $item->type) {
            return $item->value;
        }

        $children = $item->position ? $this->data[$item->position] : [];

        foreach ($children as $k => $v) {
            if ($recursive && !($v = $this->getStub($v)) instanceof Stub) {
                continue;
            }
            $children[$k] = clone $this;
            $children[$k]->key = $k;
            $children[$k]->position = $item->position;

            if ($recursive) {
                if (Stub::TYPE_REF === $v->type && ($v = $this->getStub($v->value)) instanceof Stub) {
                    $recursive = (array) $recursive;
                    if (isset($recursive[$v->position])) {
                        continue;
                    }
                    $recursive[$v->position] = true;
                }
                $children[$k] = $children[$k]->getValue($recursive);
            }
        }

        return $children;
    }

    /**
     * @return int
     */
    public function count()
    {
        return \count($this->getValue());
    }

    /**
     * @return \Traversable
     */
    public function getIterator()
    {
        if (!\is_array($value = $this->getValue())) {
            throw new \LogicException(sprintf('"%s" object holds non-iterable type "%s".', self::class, get_debug_type($value)));
        }

        yield from $value;
    }

    public function __get(string $key)
    {
        if (null !== $data = $this->seek($key)) {
            $item = $this->getStub($data->data[$data->position][$data->key]);

            return $item instanceof Stub || [] === $item ? $data : $item;
        }

        return null;
    }

    /**
     * @return bool
     */
    public function __isset(string $key)
    {
        return null !== $this->seek($key);
    }

    /**
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->__isset($key);
    }

    public function offsetGet($key)
    {
        return $this->__get($key);
    }

    public function offsetSet($key, $value)
    {
        throw new \BadMethodCallException(self::class.' objects are immutable.');
    }

    public function offsetUnset($key)
    {
        throw new \BadMethodCallException(self::class.' objects are immutable.');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $value = $this->getValue();

        if (!\is_array($value)) {
            return (string) $value;
        }

        return sprintf('%s (count=%d)', $this->getType(), \count($value));
    }

    /**
     * Returns a depth limited clone of $this.
     *
     * @return static
     */
    public function withMaxDepth(int $maxDepth)
>>>>>>> v2-test
    {
        $data = clone $this;
        $data->maxDepth = (int) $maxDepth;

        return $data;
    }

    /**
     * Limits the number of elements per depth level.
     *
<<<<<<< HEAD
     * @param int $maxItemsPerDepth The max number of items dumped per depth level
     *
     * @return self A clone of $this
     */
    public function withMaxItemsPerDepth($maxItemsPerDepth)
=======
     * @return static
     */
    public function withMaxItemsPerDepth(int $maxItemsPerDepth)
>>>>>>> v2-test
    {
        $data = clone $this;
        $data->maxItemsPerDepth = (int) $maxItemsPerDepth;

        return $data;
    }

    /**
     * Enables/disables objects' identifiers tracking.
     *
     * @param bool $useRefHandles False to hide global ref. handles
     *
<<<<<<< HEAD
     * @return self A clone of $this
     */
    public function withRefHandles($useRefHandles)
=======
     * @return static
     */
    public function withRefHandles(bool $useRefHandles)
>>>>>>> v2-test
    {
        $data = clone $this;
        $data->useRefHandles = $useRefHandles ? -1 : 0;

        return $data;
    }

    /**
<<<<<<< HEAD
     * Returns a depth limited clone of $this.
     *
     * @param int  $maxDepth         The max dumped depth level
     * @param int  $maxItemsPerDepth The max number of items dumped per depth level
     * @param bool $useRefHandles    False to hide ref. handles
     *
     * @return self A depth limited clone of $this
     *
     * @deprecated since Symfony 2.7, to be removed in 3.0. Use withMaxDepth, withMaxItemsPerDepth or withRefHandles instead.
     */
    public function getLimitedClone($maxDepth, $maxItemsPerDepth, $useRefHandles = true)
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since Symfony 2.7 and will be removed in 3.0. Use withMaxDepth, withMaxItemsPerDepth or withRefHandles methods instead.', E_USER_DEPRECATED);

        $data = clone $this;
        $data->maxDepth = (int) $maxDepth;
        $data->maxItemsPerDepth = (int) $maxItemsPerDepth;
        $data->useRefHandles = $useRefHandles ? -1 : 0;
=======
     * @return static
     */
    public function withContext(array $context)
    {
        $data = clone $this;
        $data->context = $context;

        return $data;
    }

    /**
     * Seeks to a specific key in nested data structures.
     *
     * @param string|int $key The key to seek to
     *
     * @return static|null Null if the key is not set
     */
    public function seek($key)
    {
        $item = $this->data[$this->position][$this->key];

        if ($item instanceof Stub && Stub::TYPE_REF === $item->type && !$item->position) {
            $item = $item->value;
        }
        if (!($item = $this->getStub($item)) instanceof Stub || !$item->position) {
            return null;
        }
        $keys = [$key];

        switch ($item->type) {
            case Stub::TYPE_OBJECT:
                $keys[] = Caster::PREFIX_DYNAMIC.$key;
                $keys[] = Caster::PREFIX_PROTECTED.$key;
                $keys[] = Caster::PREFIX_VIRTUAL.$key;
                $keys[] = "\0$item->class\0$key";
                // no break
            case Stub::TYPE_ARRAY:
            case Stub::TYPE_RESOURCE:
                break;
            default:
                return null;
        }

        $data = null;
        $children = $this->data[$item->position];

        foreach ($keys as $key) {
            if (isset($children[$key]) || \array_key_exists($key, $children)) {
                $data = clone $this;
                $data->key = $key;
                $data->position = $item->position;
                break;
            }
        }
>>>>>>> v2-test

        return $data;
    }

    /**
     * Dumps data with a DumperInterface dumper.
     */
    public function dump(DumperInterface $dumper)
    {
<<<<<<< HEAD
        $refs = array(0);
        $this->dumpItem($dumper, new Cursor(), $refs, $this->data[0][0]);
=======
        $refs = [0];
        $cursor = new Cursor();

        if ($cursor->attr = $this->context[SourceContextProvider::class] ?? []) {
            $cursor->attr['if_links'] = true;
            $cursor->hashType = -1;
            $dumper->dumpScalar($cursor, 'default', '^');
            $cursor->attr = ['if_links' => true];
            $dumper->dumpScalar($cursor, 'default', ' ');
            $cursor->hashType = 0;
        }

        $this->dumpItem($dumper, $cursor, $refs, $this->data[$this->position][$this->key]);
>>>>>>> v2-test
    }

    /**
     * Depth-first dumping of items.
     *
<<<<<<< HEAD
     * @param DumperInterface $dumper The dumper being used for dumping
     * @param Cursor          $cursor A cursor used for tracking dumper state position
     * @param array           &$refs  A map of all references discovered while dumping
     * @param mixed           $item   A Stub object or the original value being dumped
     */
    private function dumpItem($dumper, $cursor, &$refs, $item)
=======
     * @param mixed $item A Stub object or the original value being dumped
     */
    private function dumpItem(DumperInterface $dumper, Cursor $cursor, array &$refs, $item)
>>>>>>> v2-test
    {
        $cursor->refIndex = 0;
        $cursor->softRefTo = $cursor->softRefHandle = $cursor->softRefCount = 0;
        $cursor->hardRefTo = $cursor->hardRefHandle = $cursor->hardRefCount = 0;
        $firstSeen = true;

        if (!$item instanceof Stub) {
<<<<<<< HEAD
            $type = gettype($item);
        } elseif (Stub::TYPE_REF === $item->type) {
            if ($item->handle) {
                if (!isset($refs[$r = $item->handle - (PHP_INT_MAX >> 1)])) {
=======
            $cursor->attr = [];
            $type = \gettype($item);
            if ($item && 'array' === $type) {
                $item = $this->getStub($item);
            }
        } elseif (Stub::TYPE_REF === $item->type) {
            if ($item->handle) {
                if (!isset($refs[$r = $item->handle - (\PHP_INT_MAX >> 1)])) {
>>>>>>> v2-test
                    $cursor->refIndex = $refs[$r] = $cursor->refIndex ?: ++$refs[0];
                } else {
                    $firstSeen = false;
                }
                $cursor->hardRefTo = $refs[$r];
                $cursor->hardRefHandle = $this->useRefHandles & $item->handle;
<<<<<<< HEAD
                $cursor->hardRefCount = $item->refCount;
            }
            $type = $item->class ?: gettype($item->value);
            $item = $item->value;
=======
                $cursor->hardRefCount = 0 < $item->handle ? $item->refCount : 0;
            }
            $cursor->attr = $item->attr;
            $type = $item->class ?: \gettype($item->value);
            $item = $this->getStub($item->value);
>>>>>>> v2-test
        }
        if ($item instanceof Stub) {
            if ($item->refCount) {
                if (!isset($refs[$r = $item->handle])) {
                    $cursor->refIndex = $refs[$r] = $cursor->refIndex ?: ++$refs[0];
                } else {
                    $firstSeen = false;
                }
                $cursor->softRefTo = $refs[$r];
            }
            $cursor->softRefHandle = $this->useRefHandles & $item->handle;
            $cursor->softRefCount = $item->refCount;
<<<<<<< HEAD
=======
            $cursor->attr = $item->attr;
>>>>>>> v2-test
            $cut = $item->cut;

            if ($item->position && $firstSeen) {
                $children = $this->data[$item->position];

                if ($cursor->stop) {
                    if ($cut >= 0) {
<<<<<<< HEAD
                        $cut += count($children);
                    }
                    $children = array();
                }
            } else {
                $children = array();
=======
                        $cut += \count($children);
                    }
                    $children = [];
                }
            } else {
                $children = [];
>>>>>>> v2-test
            }
            switch ($item->type) {
                case Stub::TYPE_STRING:
                    $dumper->dumpString($cursor, $item->value, Stub::STRING_BINARY === $item->class, $cut);
                    break;

                case Stub::TYPE_ARRAY:
                    $item = clone $item;
                    $item->type = $item->class;
                    $item->class = $item->value;
<<<<<<< HEAD
                    // No break;
=======
                    // no break
>>>>>>> v2-test
                case Stub::TYPE_OBJECT:
                case Stub::TYPE_RESOURCE:
                    $withChildren = $children && $cursor->depth !== $this->maxDepth && $this->maxItemsPerDepth;
                    $dumper->enterHash($cursor, $item->type, $item->class, $withChildren);
                    if ($withChildren) {
<<<<<<< HEAD
                        $cut = $this->dumpChildren($dumper, $cursor, $refs, $children, $cut, $item->type);
                    } elseif ($children && 0 <= $cut) {
                        $cut += count($children);
                    }
=======
                        if ($cursor->skipChildren) {
                            $withChildren = false;
                            $cut = -1;
                        } else {
                            $cut = $this->dumpChildren($dumper, $cursor, $refs, $children, $cut, $item->type, null !== $item->class);
                        }
                    } elseif ($children && 0 <= $cut) {
                        $cut += \count($children);
                    }
                    $cursor->skipChildren = false;
>>>>>>> v2-test
                    $dumper->leaveHash($cursor, $item->type, $item->class, $withChildren, $cut);
                    break;

                default:
<<<<<<< HEAD
                    throw new \RuntimeException(sprintf('Unexpected Stub type: %s', $item->type));
=======
                    throw new \RuntimeException(sprintf('Unexpected Stub type: "%s".', $item->type));
>>>>>>> v2-test
            }
        } elseif ('array' === $type) {
            $dumper->enterHash($cursor, Cursor::HASH_INDEXED, 0, false);
            $dumper->leaveHash($cursor, Cursor::HASH_INDEXED, 0, false, 0);
        } elseif ('string' === $type) {
            $dumper->dumpString($cursor, $item, false, 0);
        } else {
            $dumper->dumpScalar($cursor, $type, $item);
        }
    }

    /**
     * Dumps children of hash structures.
     *
<<<<<<< HEAD
     * @param DumperInterface $dumper
     * @param Cursor          $parentCursor The cursor of the parent hash
     * @param array           &$refs        A map of all references discovered while dumping
     * @param array           $children     The children to dump
     * @param int             $hashCut      The number of items removed from the original hash
     * @param string          $hashType     A Cursor::HASH_* const
     *
     * @return int The final number of removed items
     */
    private function dumpChildren($dumper, $parentCursor, &$refs, $children, $hashCut, $hashType)
=======
     * @return int The final number of removed items
     */
    private function dumpChildren(DumperInterface $dumper, Cursor $parentCursor, array &$refs, array $children, int $hashCut, int $hashType, bool $dumpKeys): int
>>>>>>> v2-test
    {
        $cursor = clone $parentCursor;
        ++$cursor->depth;
        $cursor->hashType = $hashType;
        $cursor->hashIndex = 0;
<<<<<<< HEAD
        $cursor->hashLength = count($children);
        $cursor->hashCut = $hashCut;
        foreach ($children as $key => $child) {
            $cursor->hashKeyIsBinary = isset($key[0]) && !preg_match('//u', $key);
            $cursor->hashKey = $key;
=======
        $cursor->hashLength = \count($children);
        $cursor->hashCut = $hashCut;
        foreach ($children as $key => $child) {
            $cursor->hashKeyIsBinary = isset($key[0]) && !preg_match('//u', $key);
            $cursor->hashKey = $dumpKeys ? $key : null;
>>>>>>> v2-test
            $this->dumpItem($dumper, $cursor, $refs, $child);
            if (++$cursor->hashIndex === $this->maxItemsPerDepth || $cursor->stop) {
                $parentCursor->stop = true;

                return $hashCut >= 0 ? $hashCut + $cursor->hashLength - $cursor->hashIndex : $hashCut;
            }
        }

        return $hashCut;
    }
<<<<<<< HEAD
=======

    private function getStub($item)
    {
        if (!$item || !\is_array($item)) {
            return $item;
        }

        $stub = new Stub();
        $stub->type = Stub::TYPE_ARRAY;
        foreach ($item as $stub->class => $stub->position) {
        }
        if (isset($item[0])) {
            $stub->cut = $item[0];
        }
        $stub->value = $stub->cut + ($stub->position ? \count($this->data[$stub->position]) : 0);

        return $stub;
    }
>>>>>>> v2-test
}
