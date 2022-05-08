<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Processes bytes as they pass through a buffer and replaces sequences in it.
 *
 * This stream filter deals with Byte arrays rather than simple strings.
 *
<<<<<<< HEAD
 * @author Chris Corbyn
 */
class Swift_StreamFilters_ByteArrayReplacementFilter implements Swift_StreamFilter
{
    /** The needle(s) to search for */
    private $_search;

    /** The replacement(s) to make */
    private $_replace;

    /** The Index for searching */
    private $_index;

    /** The Search Tree */
    private $_tree = array();

    /**  Gives the size of the largest search */
    private $_treeMaxLen = 0;

    private $_repSize;
=======
 * @author  Chris Corbyn
 */
class Swift_StreamFilters_ByteArrayReplacementFilter implements Swift_StreamFilter
{
    /** The replacement(s) to make */
    private $replace;

    /** The Index for searching */
    private $index;

    /** The Search Tree */
    private $tree = [];

    /**  Gives the size of the largest search */
    private $treeMaxLen = 0;

    private $repSize;
>>>>>>> v2-test

    /**
     * Create a new ByteArrayReplacementFilter with $search and $replace.
     *
     * @param array $search
     * @param array $replace
     */
    public function __construct($search, $replace)
    {
<<<<<<< HEAD
        $this->_search = $search;
        $this->_index = array();
        $this->_tree = array();
        $this->_replace = array();
        $this->_repSize = array();
=======
        $this->index = [];
        $this->tree = [];
        $this->replace = [];
        $this->repSize = [];
>>>>>>> v2-test

        $tree = null;
        $i = null;
        $last_size = $size = 0;
        foreach ($search as $i => $search_element) {
<<<<<<< HEAD
            if ($tree !== null) {
                $tree[-1] = min(count($replace) - 1, $i - 1);
                $tree[-2] = $last_size;
            }
            $tree = &$this->_tree;
            if (is_array($search_element)) {
                foreach ($search_element as $k => $char) {
                    $this->_index[$char] = true;
                    if (!isset($tree[$char])) {
                        $tree[$char] = array();
=======
            if (null !== $tree) {
                $tree[-1] = min(\count($replace) - 1, $i - 1);
                $tree[-2] = $last_size;
            }
            $tree = &$this->tree;
            if (\is_array($search_element)) {
                foreach ($search_element as $k => $char) {
                    $this->index[$char] = true;
                    if (!isset($tree[$char])) {
                        $tree[$char] = [];
>>>>>>> v2-test
                    }
                    $tree = &$tree[$char];
                }
                $last_size = $k + 1;
                $size = max($size, $last_size);
            } else {
                $last_size = 1;
                if (!isset($tree[$search_element])) {
<<<<<<< HEAD
                    $tree[$search_element] = array();
                }
                $tree = &$tree[$search_element];
                $size = max($last_size, $size);
                $this->_index[$search_element] = true;
            }
        }
        if ($i !== null) {
            $tree[-1] = min(count($replace) - 1, $i);
            $tree[-2] = $last_size;
            $this->_treeMaxLen = $size;
        }
        foreach ($replace as $rep) {
            if (!is_array($rep)) {
                $rep = array($rep);
            }
            $this->_replace[] = $rep;
        }
        for ($i = count($this->_replace) - 1; $i >= 0; --$i) {
            $this->_replace[$i] = $rep = $this->filter($this->_replace[$i], $i);
            $this->_repSize[$i] = count($rep);
=======
                    $tree[$search_element] = [];
                }
                $tree = &$tree[$search_element];
                $size = max($last_size, $size);
                $this->index[$search_element] = true;
            }
        }
        if (null !== $i) {
            $tree[-1] = min(\count($replace) - 1, $i);
            $tree[-2] = $last_size;
            $this->treeMaxLen = $size;
        }
        foreach ($replace as $rep) {
            if (!\is_array($rep)) {
                $rep = [$rep];
            }
            $this->replace[] = $rep;
        }
        for ($i = \count($this->replace) - 1; $i >= 0; --$i) {
            $this->replace[$i] = $rep = $this->filter($this->replace[$i], $i);
            $this->repSize[$i] = \count($rep);
>>>>>>> v2-test
        }
    }

    /**
     * Returns true if based on the buffer passed more bytes should be buffered.
     *
     * @param array $buffer
     *
     * @return bool
     */
    public function shouldBuffer($buffer)
    {
        $endOfBuffer = end($buffer);

<<<<<<< HEAD
        return isset($this->_index[$endOfBuffer]);
=======
        return isset($this->index[$endOfBuffer]);
>>>>>>> v2-test
    }

    /**
     * Perform the actual replacements on $buffer and return the result.
     *
     * @param array $buffer
<<<<<<< HEAD
     * @param int   $_minReplaces
     *
     * @return array
     */
    public function filter($buffer, $_minReplaces = -1)
    {
        if ($this->_treeMaxLen == 0) {
            return $buffer;
        }

        $newBuffer = array();
        $buf_size = count($buffer);
        for ($i = 0; $i < $buf_size; ++$i) {
            $search_pos = $this->_tree;
            $last_found = PHP_INT_MAX;
            // We try to find if the next byte is part of a search pattern
            for ($j = 0; $j <= $this->_treeMaxLen; ++$j) {
                // We have a new byte for a search pattern
                if (isset($buffer [$p = $i + $j]) && isset($search_pos[$buffer[$p]])) {
                    $search_pos = $search_pos[$buffer[$p]];
                    // We have a complete pattern, save, in case we don't find a better match later
                    if (isset($search_pos[-1]) && $search_pos[-1] < $last_found
                        && $search_pos[-1] > $_minReplaces) {
=======
     * @param int   $minReplaces
     *
     * @return array
     */
    public function filter($buffer, $minReplaces = -1)
    {
        if (0 == $this->treeMaxLen) {
            return $buffer;
        }

        $newBuffer = [];
        $buf_size = \count($buffer);
        $last_size = 0;
        for ($i = 0; $i < $buf_size; ++$i) {
            $search_pos = $this->tree;
            $last_found = PHP_INT_MAX;
            // We try to find if the next byte is part of a search pattern
            for ($j = 0; $j <= $this->treeMaxLen; ++$j) {
                // We have a new byte for a search pattern
                if (isset($buffer[$p = $i + $j]) && isset($search_pos[$buffer[$p]])) {
                    $search_pos = $search_pos[$buffer[$p]];
                    // We have a complete pattern, save, in case we don't find a better match later
                    if (isset($search_pos[-1]) && $search_pos[-1] < $last_found
                        && $search_pos[-1] > $minReplaces) {
>>>>>>> v2-test
                        $last_found = $search_pos[-1];
                        $last_size = $search_pos[-2];
                    }
                }
                // We got a complete pattern
<<<<<<< HEAD
                elseif ($last_found !== PHP_INT_MAX) {
                    // Adding replacement datas to output buffer
                    $rep_size = $this->_repSize[$last_found];
                    for ($j = 0; $j < $rep_size; ++$j) {
                        $newBuffer[] = $this->_replace[$last_found][$j];
=======
                elseif (PHP_INT_MAX !== $last_found) {
                    // Adding replacement datas to output buffer
                    $rep_size = $this->repSize[$last_found];
                    for ($j = 0; $j < $rep_size; ++$j) {
                        $newBuffer[] = $this->replace[$last_found][$j];
>>>>>>> v2-test
                    }
                    // We Move cursor forward
                    $i += $last_size - 1;
                    // Edge Case, last position in buffer
                    if ($i >= $buf_size) {
                        $newBuffer[] = $buffer[$i];
                    }

                    // We start the next loop
                    continue 2;
                } else {
                    // this byte is not in a pattern and we haven't found another pattern
                    break;
                }
            }
            // Normal byte, move it to output buffer
            $newBuffer[] = $buffer[$i];
        }

        return $newBuffer;
    }
}
