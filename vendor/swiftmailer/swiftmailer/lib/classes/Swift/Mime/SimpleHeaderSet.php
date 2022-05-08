<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A collection of MIME headers.
 *
 * @author Chris Corbyn
 */
<<<<<<< HEAD
class Swift_Mime_SimpleHeaderSet implements Swift_Mime_HeaderSet
{
    /** HeaderFactory */
    private $_factory;

    /** Collection of set Headers */
    private $_headers = array();

    /** Field ordering details */
    private $_order = array();

    /** List of fields which are required to be displayed */
    private $_required = array();

    /** The charset used by Headers */
    private $_charset;
=======
class Swift_Mime_SimpleHeaderSet implements Swift_Mime_CharsetObserver
{
    /** HeaderFactory */
    private $factory;

    /** Collection of set Headers */
    private $headers = [];

    /** Field ordering details */
    private $order = [];

    /** List of fields which are required to be displayed */
    private $required = [];

    /** The charset used by Headers */
    private $charset;
>>>>>>> v2-test

    /**
     * Create a new SimpleHeaderSet with the given $factory.
     *
<<<<<<< HEAD
     * @param Swift_Mime_HeaderFactory $factory
     * @param string                   $charset
     */
    public function __construct(Swift_Mime_HeaderFactory $factory, $charset = null)
    {
        $this->_factory = $factory;
=======
     * @param string $charset
     */
    public function __construct(Swift_Mime_SimpleHeaderFactory $factory, $charset = null)
    {
        $this->factory = $factory;
>>>>>>> v2-test
        if (isset($charset)) {
            $this->setCharset($charset);
        }
    }

<<<<<<< HEAD
=======
    public function newInstance()
    {
        return new self($this->factory);
    }

>>>>>>> v2-test
    /**
     * Set the charset used by these headers.
     *
     * @param string $charset
     */
    public function setCharset($charset)
    {
<<<<<<< HEAD
        $this->_charset = $charset;
        $this->_factory->charsetChanged($charset);
        $this->_notifyHeadersOfCharset($charset);
=======
        $this->charset = $charset;
        $this->factory->charsetChanged($charset);
        $this->notifyHeadersOfCharset($charset);
>>>>>>> v2-test
    }

    /**
     * Add a new Mailbox Header with a list of $addresses.
     *
     * @param string       $name
     * @param array|string $addresses
     */
    public function addMailboxHeader($name, $addresses = null)
    {
<<<<<<< HEAD
        $this->_storeHeader($name,
        $this->_factory->createMailboxHeader($name, $addresses));
    }

    /**
     * Add a new Date header using $timestamp (UNIX time).
     *
     * @param string $name
     * @param int    $timestamp
     */
    public function addDateHeader($name, $timestamp = null)
    {
        $this->_storeHeader($name,
        $this->_factory->createDateHeader($name, $timestamp));
=======
        $this->storeHeader($name, $this->factory->createMailboxHeader($name, $addresses));
    }

    /**
     * Add a new Date header using $dateTime.
     *
     * @param string $name
     */
    public function addDateHeader($name, DateTimeInterface $dateTime = null)
    {
        $this->storeHeader($name, $this->factory->createDateHeader($name, $dateTime));
>>>>>>> v2-test
    }

    /**
     * Add a new basic text header with $name and $value.
     *
     * @param string $name
     * @param string $value
     */
    public function addTextHeader($name, $value = null)
    {
<<<<<<< HEAD
        $this->_storeHeader($name,
        $this->_factory->createTextHeader($name, $value));
=======
        $this->storeHeader($name, $this->factory->createTextHeader($name, $value));
>>>>>>> v2-test
    }

    /**
     * Add a new ParameterizedHeader with $name, $value and $params.
     *
     * @param string $name
     * @param string $value
     * @param array  $params
     */
<<<<<<< HEAD
    public function addParameterizedHeader($name, $value = null, $params = array())
    {
        $this->_storeHeader($name, $this->_factory->createParameterizedHeader($name, $value, $params));
=======
    public function addParameterizedHeader($name, $value = null, $params = [])
    {
        $this->storeHeader($name, $this->factory->createParameterizedHeader($name, $value, $params));
>>>>>>> v2-test
    }

    /**
     * Add a new ID header for Message-ID or Content-ID.
     *
     * @param string       $name
     * @param string|array $ids
     */
    public function addIdHeader($name, $ids = null)
    {
<<<<<<< HEAD
        $this->_storeHeader($name, $this->_factory->createIdHeader($name, $ids));
=======
        $this->storeHeader($name, $this->factory->createIdHeader($name, $ids));
>>>>>>> v2-test
    }

    /**
     * Add a new Path header with an address (path) in it.
     *
     * @param string $name
     * @param string $path
     */
    public function addPathHeader($name, $path = null)
    {
<<<<<<< HEAD
        $this->_storeHeader($name, $this->_factory->createPathHeader($name, $path));
=======
        $this->storeHeader($name, $this->factory->createPathHeader($name, $path));
>>>>>>> v2-test
    }

    /**
     * Returns true if at least one header with the given $name exists.
     *
     * If multiple headers match, the actual one may be specified by $index.
     *
     * @param string $name
     * @param int    $index
     *
     * @return bool
     */
    public function has($name, $index = 0)
    {
        $lowerName = strtolower($name);

<<<<<<< HEAD
        if (!array_key_exists($lowerName, $this->_headers)) {
            return false;
        }

        if (func_num_args() < 2) {
            // index was not specified, so we only need to check that there is at least one header value set
            return (bool) count($this->_headers[$lowerName]);
        }

        return array_key_exists($index, $this->_headers[$lowerName]);
=======
        if (!\array_key_exists($lowerName, $this->headers)) {
            return false;
        }

        if (\func_num_args() < 2) {
            // index was not specified, so we only need to check that there is at least one header value set
            return (bool) \count($this->headers[$lowerName]);
        }

        return \array_key_exists($index, $this->headers[$lowerName]);
>>>>>>> v2-test
    }

    /**
     * Set a header in the HeaderSet.
     *
     * The header may be a previously fetched header via {@link get()} or it may
     * be one that has been created separately.
     *
     * If $index is specified, the header will be inserted into the set at this
     * offset.
     *
<<<<<<< HEAD
     * @param Swift_Mime_Header $header
     * @param int               $index
     */
    public function set(Swift_Mime_Header $header, $index = 0)
    {
        $this->_storeHeader($header->getFieldName(), $header, $index);
=======
     * @param int $index
     */
    public function set(Swift_Mime_Header $header, $index = 0)
    {
        $this->storeHeader($header->getFieldName(), $header, $index);
>>>>>>> v2-test
    }

    /**
     * Get the header with the given $name.
     *
     * If multiple headers match, the actual one may be specified by $index.
     * Returns NULL if none present.
     *
     * @param string $name
     * @param int    $index
     *
     * @return Swift_Mime_Header
     */
    public function get($name, $index = 0)
    {
        $name = strtolower($name);

<<<<<<< HEAD
        if (func_num_args() < 2) {
            if ($this->has($name)) {
                $values = array_values($this->_headers[$name]);
=======
        if (\func_num_args() < 2) {
            if ($this->has($name)) {
                $values = array_values($this->headers[$name]);
>>>>>>> v2-test

                return array_shift($values);
            }
        } else {
            if ($this->has($name, $index)) {
<<<<<<< HEAD
                return $this->_headers[$name][$index];
=======
                return $this->headers[$name][$index];
>>>>>>> v2-test
            }
        }
    }

    /**
     * Get all headers with the given $name.
     *
     * @param string $name
     *
     * @return array
     */
    public function getAll($name = null)
    {
        if (!isset($name)) {
<<<<<<< HEAD
            $headers = array();
            foreach ($this->_headers as $collection) {
=======
            $headers = [];
            foreach ($this->headers as $collection) {
>>>>>>> v2-test
                $headers = array_merge($headers, $collection);
            }

            return $headers;
        }

        $lowerName = strtolower($name);
<<<<<<< HEAD
        if (!array_key_exists($lowerName, $this->_headers)) {
            return array();
        }

        return $this->_headers[$lowerName];
=======
        if (!\array_key_exists($lowerName, $this->headers)) {
            return [];
        }

        return $this->headers[$lowerName];
>>>>>>> v2-test
    }

    /**
     * Return the name of all Headers.
     *
     * @return array
     */
    public function listAll()
    {
<<<<<<< HEAD
        $headers = $this->_headers;
        if ($this->_canSort()) {
            uksort($headers, array($this, '_sortHeaders'));
=======
        $headers = $this->headers;
        if ($this->canSort()) {
            uksort($headers, [$this, 'sortHeaders']);
>>>>>>> v2-test
        }

        return array_keys($headers);
    }

    /**
     * Remove the header with the given $name if it's set.
     *
     * If multiple headers match, the actual one may be specified by $index.
     *
     * @param string $name
     * @param int    $index
     */
    public function remove($name, $index = 0)
    {
        $lowerName = strtolower($name);
<<<<<<< HEAD
        unset($this->_headers[$lowerName][$index]);
=======
        unset($this->headers[$lowerName][$index]);
>>>>>>> v2-test
    }

    /**
     * Remove all headers with the given $name.
     *
     * @param string $name
     */
    public function removeAll($name)
    {
        $lowerName = strtolower($name);
<<<<<<< HEAD
        unset($this->_headers[$lowerName]);
    }

    /**
     * Create a new instance of this HeaderSet.
     *
     * @return Swift_Mime_HeaderSet
     */
    public function newInstance()
    {
        return new self($this->_factory);
=======
        unset($this->headers[$lowerName]);
>>>>>>> v2-test
    }

    /**
     * Define a list of Header names as an array in the correct order.
     *
     * These Headers will be output in the given order where present.
<<<<<<< HEAD
     *
     * @param array $sequence
     */
    public function defineOrdering(array $sequence)
    {
        $this->_order = array_flip(array_map('strtolower', $sequence));
=======
     */
    public function defineOrdering(array $sequence)
    {
        $this->order = array_flip(array_map('strtolower', $sequence));
>>>>>>> v2-test
    }

    /**
     * Set a list of header names which must always be displayed when set.
     *
     * Usually headers without a field value won't be output unless set here.
<<<<<<< HEAD
     *
     * @param array $names
     */
    public function setAlwaysDisplayed(array $names)
    {
        $this->_required = array_flip(array_map('strtolower', $names));
=======
     */
    public function setAlwaysDisplayed(array $names)
    {
        $this->required = array_flip(array_map('strtolower', $names));
>>>>>>> v2-test
    }

    /**
     * Notify this observer that the entity's charset has changed.
     *
     * @param string $charset
     */
    public function charsetChanged($charset)
    {
        $this->setCharset($charset);
    }

    /**
     * Returns a string with a representation of all headers.
     *
     * @return string
     */
    public function toString()
    {
        $string = '';
<<<<<<< HEAD
        $headers = $this->_headers;
        if ($this->_canSort()) {
            uksort($headers, array($this, '_sortHeaders'));
        }
        foreach ($headers as $collection) {
            foreach ($collection as $header) {
                if ($this->_isDisplayed($header) || $header->getFieldBody() != '') {
=======
        $headers = $this->headers;
        if ($this->canSort()) {
            uksort($headers, [$this, 'sortHeaders']);
        }
        foreach ($headers as $collection) {
            foreach ($collection as $header) {
                if ($this->isDisplayed($header) || '' != $header->getFieldBody()) {
>>>>>>> v2-test
                    $string .= $header->toString();
                }
            }
        }

        return $string;
    }

    /**
     * Returns a string representation of this object.
     *
     * @return string
     *
     * @see toString()
     */
    public function __toString()
    {
        return $this->toString();
    }

    /** Save a Header to the internal collection */
<<<<<<< HEAD
    private function _storeHeader($name, Swift_Mime_Header $header, $offset = null)
    {
        if (!isset($this->_headers[strtolower($name)])) {
            $this->_headers[strtolower($name)] = array();
        }
        if (!isset($offset)) {
            $this->_headers[strtolower($name)][] = $header;
        } else {
            $this->_headers[strtolower($name)][$offset] = $header;
=======
    private function storeHeader($name, Swift_Mime_Header $header, $offset = null)
    {
        if (!isset($this->headers[strtolower($name)])) {
            $this->headers[strtolower($name)] = [];
        }
        if (!isset($offset)) {
            $this->headers[strtolower($name)][] = $header;
        } else {
            $this->headers[strtolower($name)][$offset] = $header;
>>>>>>> v2-test
        }
    }

    /** Test if the headers can be sorted */
<<<<<<< HEAD
    private function _canSort()
    {
        return count($this->_order) > 0;
    }

    /** uksort() algorithm for Header ordering */
    private function _sortHeaders($a, $b)
    {
        $lowerA = strtolower($a);
        $lowerB = strtolower($b);
        $aPos = array_key_exists($lowerA, $this->_order) ? $this->_order[$lowerA] : -1;
        $bPos = array_key_exists($lowerB, $this->_order) ? $this->_order[$lowerB] : -1;
=======
    private function canSort()
    {
        return \count($this->order) > 0;
    }

    /** uksort() algorithm for Header ordering */
    private function sortHeaders($a, $b)
    {
        $lowerA = strtolower($a);
        $lowerB = strtolower($b);
        $aPos = \array_key_exists($lowerA, $this->order) ? $this->order[$lowerA] : -1;
        $bPos = \array_key_exists($lowerB, $this->order) ? $this->order[$lowerB] : -1;
>>>>>>> v2-test

        if (-1 === $aPos && -1 === $bPos) {
            // just be sure to be determinist here
            return $a > $b ? -1 : 1;
        }

<<<<<<< HEAD
        if ($aPos == -1) {
            return 1;
        } elseif ($bPos == -1) {
=======
        if (-1 == $aPos) {
            return 1;
        } elseif (-1 == $bPos) {
>>>>>>> v2-test
            return -1;
        }

        return $aPos < $bPos ? -1 : 1;
    }

    /** Test if the given Header is always displayed */
<<<<<<< HEAD
    private function _isDisplayed(Swift_Mime_Header $header)
    {
        return array_key_exists(strtolower($header->getFieldName()), $this->_required);
    }

    /** Notify all Headers of the new charset */
    private function _notifyHeadersOfCharset($charset)
    {
        foreach ($this->_headers as $headerGroup) {
=======
    private function isDisplayed(Swift_Mime_Header $header)
    {
        return \array_key_exists(strtolower($header->getFieldName()), $this->required);
    }

    /** Notify all Headers of the new charset */
    private function notifyHeadersOfCharset($charset)
    {
        foreach ($this->headers as $headerGroup) {
>>>>>>> v2-test
            foreach ($headerGroup as $header) {
                $header->setCharset($charset);
            }
        }
    }

    /**
     * Make a deep copy of object.
     */
    public function __clone()
    {
<<<<<<< HEAD
        $this->_factory = clone $this->_factory;
        foreach ($this->_headers as $groupKey => $headerGroup) {
            foreach ($headerGroup as $key => $header) {
                $this->_headers[$groupKey][$key] = clone $header;
=======
        $this->factory = clone $this->factory;
        foreach ($this->headers as $groupKey => $headerGroup) {
            foreach ($headerGroup as $key => $header) {
                $this->headers[$groupKey][$key] = clone $header;
>>>>>>> v2-test
            }
        }
    }
}
