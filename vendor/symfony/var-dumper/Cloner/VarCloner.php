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

/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class VarCloner extends AbstractCloner
{
<<<<<<< HEAD
    private static $hashMask = 0;
    private static $hashOffset = 0;
=======
    private static $gid;
    private static $arrayCache = [];
>>>>>>> v2-test

    /**
     * {@inheritdoc}
     */
    protected function doClone($var)
    {
<<<<<<< HEAD
        $useExt = $this->useExt;
        $len = 1;                       // Length of $queue
        $pos = 0;                       // Number of cloned items past the first level
        $refsCounter = 0;               // Hard references counter
        $queue = array(array($var));    // This breadth-first queue is the return value
        $arrayRefs = array();           // Map of queue indexes to stub array objects
        $hardRefs = array();            // Map of original zval hashes to stub objects
        $objRefs = array();             // Map of original object handles to their stub object couterpart
        $resRefs = array();             // Map of original resource handles to their stub object couterpart
        $values = array();              // Map of stub objects' hashes to original values
        $maxItems = $this->maxItems;
        $maxString = $this->maxString;
        $cookie = (object) array();     // Unique object used to detect hard references
        $gid = uniqid(mt_rand(), true); // Unique string used to detect the special $GLOBALS variable
        $a = null;                      // Array cast for nested structures
        $stub = null;                   // Stub capturing the main properties of an original item value
                                        // or null if the original value is used directly
        $zval = array(                  // Main properties of the current value
            'type' => null,
            'zval_isref' => null,
            'zval_hash' => null,
            'array_count' => null,
            'object_class' => null,
            'object_handle' => null,
            'resource_type' => null,
        );
        if (!self::$hashMask) {
            self::initHashMask();
        }
        $hashMask = self::$hashMask;
        $hashOffset = self::$hashOffset;

        for ($i = 0; $i < $len; ++$i) {
            $indexed = true;            // Whether the currently iterated array is numerically indexed or not
            $j = -1;                    // Position in the currently iterated array
            $fromObjCast = array_keys($queue[$i]);
            $fromObjCast = array_keys(array_flip($fromObjCast)) !== $fromObjCast;
            $refs = $vals = $fromObjCast ? array_values($queue[$i]) : $queue[$i];
            foreach ($queue[$i] as $k => $v) {
                // $k is the original key
                // $v is the original value or a stub object in case of hard references
                if ($k !== ++$j) {
                    $indexed = false;
                }
                if ($fromObjCast) {
                    $k = $j;
                }
                if ($useExt) {
                    $zval = symfony_zval_info($k, $refs);
                } else {
                    $refs[$k] = $cookie;
                    if ($zval['zval_isref'] = $vals[$k] === $cookie) {
                        $zval['zval_hash'] = $v instanceof Stub ? spl_object_hash($v) : null;
                    }
                    $zval['type'] = gettype($v);
                }
                if ($zval['zval_isref']) {
                    $vals[$k] = &$stub;         // Break hard references to make $queue completely
                    unset($stub);               // independent from the original structure
                    if (isset($hardRefs[$zval['zval_hash']])) {
                        $vals[$k] = $useExt ? ($v = $hardRefs[$zval['zval_hash']]) : ($refs[$k] = $v);
=======
        $len = 1;                       // Length of $queue
        $pos = 0;                       // Number of cloned items past the minimum depth
        $refsCounter = 0;               // Hard references counter
        $queue = [[$var]];    // This breadth-first queue is the return value
        $hardRefs = [];            // Map of original zval ids to stub objects
        $objRefs = [];             // Map of original object handles to their stub object counterpart
        $objects = [];             // Keep a ref to objects to ensure their handle cannot be reused while cloning
        $resRefs = [];             // Map of original resource handles to their stub object counterpart
        $values = [];              // Map of stub objects' ids to original values
        $maxItems = $this->maxItems;
        $maxString = $this->maxString;
        $minDepth = $this->minDepth;
        $currentDepth = 0;              // Current tree depth
        $currentDepthFinalIndex = 0;    // Final $queue index for current tree depth
        $minimumDepthReached = 0 === $minDepth; // Becomes true when minimum tree depth has been reached
        $cookie = (object) [];          // Unique object used to detect hard references
        $a = null;                      // Array cast for nested structures
        $stub = null;                   // Stub capturing the main properties of an original item value
                                        // or null if the original value is used directly

        if (!$gid = self::$gid) {
            $gid = self::$gid = md5(random_bytes(6)); // Unique string used to detect the special $GLOBALS variable
        }
        $arrayStub = new Stub();
        $arrayStub->type = Stub::TYPE_ARRAY;
        $fromObjCast = false;

        for ($i = 0; $i < $len; ++$i) {
            // Detect when we move on to the next tree depth
            if ($i > $currentDepthFinalIndex) {
                ++$currentDepth;
                $currentDepthFinalIndex = $len - 1;
                if ($currentDepth >= $minDepth) {
                    $minimumDepthReached = true;
                }
            }

            $refs = $vals = $queue[$i];
            foreach ($vals as $k => $v) {
                // $v is the original value or a stub object in case of hard references

                if (\PHP_VERSION_ID >= 70400) {
                    $zvalIsRef = null !== \ReflectionReference::fromArrayElement($vals, $k);
                } else {
                    $refs[$k] = $cookie;
                    $zvalIsRef = $vals[$k] === $cookie;
                }

                if ($zvalIsRef) {
                    $vals[$k] = &$stub;         // Break hard references to make $queue completely
                    unset($stub);               // independent from the original structure
                    if ($v instanceof Stub && isset($hardRefs[spl_object_id($v)])) {
                        $vals[$k] = $refs[$k] = $v;
>>>>>>> v2-test
                        if ($v->value instanceof Stub && (Stub::TYPE_OBJECT === $v->value->type || Stub::TYPE_RESOURCE === $v->value->type)) {
                            ++$v->value->refCount;
                        }
                        ++$v->refCount;
                        continue;
                    }
<<<<<<< HEAD
                }
                // Create $stub when the original value $v can not be used directly
                // If $v is a nested structure, put that structure in array $a
                switch ($zval['type']) {
                    case 'string':
                        if (isset($v[0]) && !preg_match('//u', $v)) {
                            $stub = new Stub();
                            $stub->type = Stub::TYPE_STRING;
                            $stub->class = Stub::STRING_BINARY;
                            if (0 <= $maxString && 0 < $cut = strlen($v) - $maxString) {
=======
                    $refs[$k] = $vals[$k] = new Stub();
                    $refs[$k]->value = $v;
                    $h = spl_object_id($refs[$k]);
                    $hardRefs[$h] = &$refs[$k];
                    $values[$h] = $v;
                    $vals[$k]->handle = ++$refsCounter;
                }
                // Create $stub when the original value $v can not be used directly
                // If $v is a nested structure, put that structure in array $a
                switch (true) {
                    case null === $v:
                    case \is_bool($v):
                    case \is_int($v):
                    case \is_float($v):
                        continue 2;
                    case \is_string($v):
                        if ('' === $v) {
                            continue 2;
                        }
                        if (!preg_match('//u', $v)) {
                            $stub = new Stub();
                            $stub->type = Stub::TYPE_STRING;
                            $stub->class = Stub::STRING_BINARY;
                            if (0 <= $maxString && 0 < $cut = \strlen($v) - $maxString) {
>>>>>>> v2-test
                                $stub->cut = $cut;
                                $stub->value = substr($v, 0, -$cut);
                            } else {
                                $stub->value = $v;
                            }
<<<<<<< HEAD
                        } elseif (0 <= $maxString && isset($v[1 + ($maxString >> 2)]) && 0 < $cut = iconv_strlen($v, 'UTF-8') - $maxString) {
=======
                        } elseif (0 <= $maxString && isset($v[1 + ($maxString >> 2)]) && 0 < $cut = mb_strlen($v, 'UTF-8') - $maxString) {
>>>>>>> v2-test
                            $stub = new Stub();
                            $stub->type = Stub::TYPE_STRING;
                            $stub->class = Stub::STRING_UTF8;
                            $stub->cut = $cut;
<<<<<<< HEAD
                            $stub->value = iconv_substr($v, 0, $maxString, 'UTF-8');
                        }
                        break;

                    case 'integer':
                        break;

                    case 'array':
                        if ($v) {
                            $stub = $arrayRefs[$len] = new Stub();
                            $stub->type = Stub::TYPE_ARRAY;
                            $stub->class = Stub::ARRAY_ASSOC;

                            // Copies of $GLOBALS have very strange behavior,
                            // let's detect them with some black magic
                            $a = $v;
                            $a[$gid] = true;

                            // Happens with copies of $GLOBALS
                            if (isset($v[$gid])) {
                                unset($v[$gid]);
                                $a = array();
                                foreach ($v as $gk => &$gv) {
                                    $a[$gk] = &$gv;
                                }
                            } else {
                                $a = $v;
                            }

                            $stub->value = $zval['array_count'] ?: count($a);
                        }
                        break;

                    case 'object':
                        if (empty($objRefs[$h = $zval['object_handle'] ?: ($hashMask ^ hexdec(substr(spl_object_hash($v), $hashOffset, PHP_INT_SIZE)))])) {
                            $stub = new Stub();
                            $stub->type = Stub::TYPE_OBJECT;
                            $stub->class = $zval['object_class'] ?: get_class($v);
=======
                            $stub->value = mb_substr($v, 0, $maxString, 'UTF-8');
                        } else {
                            continue 2;
                        }
                        $a = null;
                        break;

                    case \is_array($v):
                        if (!$v) {
                            continue 2;
                        }
                        $stub = $arrayStub;
                        $stub->class = Stub::ARRAY_INDEXED;

                        $j = -1;
                        foreach ($v as $gk => $gv) {
                            if ($gk !== ++$j) {
                                $stub->class = Stub::ARRAY_ASSOC;
                                break;
                            }
                        }
                        $a = $v;

                        if (Stub::ARRAY_ASSOC === $stub->class) {
                            // Copies of $GLOBALS have very strange behavior,
                            // let's detect them with some black magic
                            if (\PHP_VERSION_ID < 80100 && ($a[$gid] = true) && isset($v[$gid])) {
                                unset($v[$gid]);
                                $a = [];
                                foreach ($v as $gk => &$gv) {
                                    if ($v === $gv) {
                                        unset($v);
                                        $v = new Stub();
                                        $v->value = [$v->cut = \count($gv), Stub::TYPE_ARRAY => 0];
                                        $v->handle = -1;
                                        $gv = &$hardRefs[spl_object_id($v)];
                                        $gv = $v;
                                    }

                                    $a[$gk] = &$gv;
                                }
                                unset($gv);
                            } else {
                                $a = $v;
                            }
                        }
                        break;

                    case \is_object($v):
                    case $v instanceof \__PHP_Incomplete_Class:
                        if (empty($objRefs[$h = spl_object_id($v)])) {
                            $stub = new Stub();
                            $stub->type = Stub::TYPE_OBJECT;
                            $stub->class = \get_class($v);
>>>>>>> v2-test
                            $stub->value = $v;
                            $stub->handle = $h;
                            $a = $this->castObject($stub, 0 < $i);
                            if ($v !== $stub->value) {
<<<<<<< HEAD
                                if (Stub::TYPE_OBJECT !== $stub->type) {
                                    break;
                                }
                                if ($useExt) {
                                    $zval['type'] = $stub->value;
                                    $zval = symfony_zval_info('type', $zval);
                                    $h = $zval['object_handle'];
                                } else {
                                    $h = $hashMask ^ hexdec(substr(spl_object_hash($stub->value), $hashOffset, PHP_INT_SIZE));
                                }
                                $stub->handle = $h;
                            }
                            $stub->value = null;
                            if (0 <= $maxItems && $maxItems <= $pos) {
                                $stub->cut = count($a);
=======
                                if (Stub::TYPE_OBJECT !== $stub->type || null === $stub->value) {
                                    break;
                                }
                                $stub->handle = $h = spl_object_id($stub->value);
                            }
                            $stub->value = null;
                            if (0 <= $maxItems && $maxItems <= $pos && $minimumDepthReached) {
                                $stub->cut = \count($a);
>>>>>>> v2-test
                                $a = null;
                            }
                        }
                        if (empty($objRefs[$h])) {
                            $objRefs[$h] = $stub;
<<<<<<< HEAD
=======
                            $objects[] = $v;
>>>>>>> v2-test
                        } else {
                            $stub = $objRefs[$h];
                            ++$stub->refCount;
                            $a = null;
                        }
                        break;

<<<<<<< HEAD
                    case 'resource':
                    case 'unknown type':
                    case 'resource (closed)':
                        if (empty($resRefs[$h = (int) $v])) {
                            $stub = new Stub();
                            $stub->type = Stub::TYPE_RESOURCE;
                            if ('Unknown' === $stub->class = $zval['resource_type'] ?: @get_resource_type($v)) {
=======
                    default: // resource
                        if (empty($resRefs[$h = (int) $v])) {
                            $stub = new Stub();
                            $stub->type = Stub::TYPE_RESOURCE;
                            if ('Unknown' === $stub->class = @get_resource_type($v)) {
>>>>>>> v2-test
                                $stub->class = 'Closed';
                            }
                            $stub->value = $v;
                            $stub->handle = $h;
                            $a = $this->castResource($stub, 0 < $i);
                            $stub->value = null;
<<<<<<< HEAD
                            if (0 <= $maxItems && $maxItems <= $pos) {
                                $stub->cut = count($a);
=======
                            if (0 <= $maxItems && $maxItems <= $pos && $minimumDepthReached) {
                                $stub->cut = \count($a);
>>>>>>> v2-test
                                $a = null;
                            }
                        }
                        if (empty($resRefs[$h])) {
                            $resRefs[$h] = $stub;
                        } else {
                            $stub = $resRefs[$h];
                            ++$stub->refCount;
                            $a = null;
                        }
                        break;
                }

<<<<<<< HEAD
                if (isset($stub)) {
                    if ($zval['zval_isref']) {
                        if ($useExt) {
                            $vals[$k] = $hardRefs[$zval['zval_hash']] = $v = new Stub();
                            $v->value = $stub;
                        } else {
                            $refs[$k] = new Stub();
                            $refs[$k]->value = $stub;
                            $h = spl_object_hash($refs[$k]);
                            $vals[$k] = $hardRefs[$h] = &$refs[$k];
                            $values[$h] = $v;
                        }
                        $vals[$k]->handle = ++$refsCounter;
                    } else {
                        $vals[$k] = $stub;
                    }

                    if ($a) {
                        if ($i && 0 <= $maxItems) {
                            $k = count($a);
                            if ($pos < $maxItems) {
                                if ($maxItems < $pos += $k) {
                                    $a = array_slice($a, 0, $maxItems - $pos);
                                    if ($stub->cut >= 0) {
                                        $stub->cut += $pos - $maxItems;
                                    }
                                }
                            } else {
                                if ($stub->cut >= 0) {
                                    $stub->cut += $k;
                                }
                                $stub = $a = null;
                                unset($arrayRefs[$len]);
                                continue;
=======
                if ($a) {
                    if (!$minimumDepthReached || 0 > $maxItems) {
                        $queue[$len] = $a;
                        $stub->position = $len++;
                    } elseif ($pos < $maxItems) {
                        if ($maxItems < $pos += \count($a)) {
                            $a = \array_slice($a, 0, $maxItems - $pos, true);
                            if ($stub->cut >= 0) {
                                $stub->cut += $pos - $maxItems;
>>>>>>> v2-test
                            }
                        }
                        $queue[$len] = $a;
                        $stub->position = $len++;
<<<<<<< HEAD
                    }
                    $stub = $a = null;
                } elseif ($zval['zval_isref']) {
                    if ($useExt) {
                        $vals[$k] = $hardRefs[$zval['zval_hash']] = new Stub();
                        $vals[$k]->value = $v;
                    } else {
                        $refs[$k] = $vals[$k] = new Stub();
                        $refs[$k]->value = $v;
                        $h = spl_object_hash($refs[$k]);
                        $hardRefs[$h] = &$refs[$k];
                        $values[$h] = $v;
                    }
                    $vals[$k]->handle = ++$refsCounter;
=======
                    } elseif ($stub->cut >= 0) {
                        $stub->cut += \count($a);
                        $stub->position = 0;
                    }
                }

                if ($arrayStub === $stub) {
                    if ($arrayStub->cut) {
                        $stub = [$arrayStub->cut, $arrayStub->class => $arrayStub->position];
                        $arrayStub->cut = 0;
                    } elseif (isset(self::$arrayCache[$arrayStub->class][$arrayStub->position])) {
                        $stub = self::$arrayCache[$arrayStub->class][$arrayStub->position];
                    } else {
                        self::$arrayCache[$arrayStub->class][$arrayStub->position] = $stub = [$arrayStub->class => $arrayStub->position];
                    }
                }

                if ($zvalIsRef) {
                    $refs[$k]->value = $stub;
                } else {
                    $vals[$k] = $stub;
>>>>>>> v2-test
                }
            }

            if ($fromObjCast) {
<<<<<<< HEAD
                $refs = $vals;
                $vals = array();
                $j = -1;
                foreach ($queue[$i] as $k => $v) {
                    foreach (array($k => $v) as $a => $v) {
                    }
                    if ($a !== $k) {
=======
                $fromObjCast = false;
                $refs = $vals;
                $vals = [];
                $j = -1;
                foreach ($queue[$i] as $k => $v) {
                    foreach ([$k => true] as $gk => $gv) {
                    }
                    if ($gk !== $k) {
>>>>>>> v2-test
                        $vals = (object) $vals;
                        $vals->{$k} = $refs[++$j];
                        $vals = (array) $vals;
                    } else {
                        $vals[$k] = $refs[++$j];
                    }
                }
            }

            $queue[$i] = $vals;
<<<<<<< HEAD

            if (isset($arrayRefs[$i])) {
                if ($indexed) {
                    $arrayRefs[$i]->class = Stub::ARRAY_INDEXED;
                }
                unset($arrayRefs[$i]);
            }
=======
>>>>>>> v2-test
        }

        foreach ($values as $h => $v) {
            $hardRefs[$h] = $v;
        }

        return $queue;
    }
<<<<<<< HEAD

    private static function initHashMask()
    {
        $obj = (object) array();
        self::$hashOffset = 16 - PHP_INT_SIZE;
        self::$hashMask = -1;

        if (defined('HHVM_VERSION')) {
            self::$hashOffset += 16;
        } else {
            // check if we are nested in an output buffering handler to prevent a fatal error with ob_start() below
            $obFuncs = array('ob_clean', 'ob_end_clean', 'ob_flush', 'ob_end_flush', 'ob_get_contents', 'ob_get_flush');
            foreach (debug_backtrace(PHP_VERSION_ID >= 50400 ? DEBUG_BACKTRACE_IGNORE_ARGS : false) as $frame) {
                if (isset($frame['function'][0]) && !isset($frame['class']) && 'o' === $frame['function'][0] && in_array($frame['function'], $obFuncs)) {
                    $frame['line'] = 0;
                    break;
                }
            }
            if (!empty($frame['line'])) {
                ob_start();
                debug_zval_dump($obj);
                self::$hashMask = (int) substr(ob_get_clean(), 17);
            }
        }

        self::$hashMask ^= hexdec(substr(spl_object_hash($obj), self::$hashOffset, PHP_INT_SIZE));
    }
=======
>>>>>>> v2-test
}
