<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Profiler;

use Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;

/**
 * Profile.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Profile
{
    private $token;

    /**
     * @var DataCollectorInterface[]
     */
<<<<<<< HEAD
    private $collectors = array();
=======
    private $collectors = [];
>>>>>>> v2-test

    private $ip;
    private $method;
    private $url;
    private $time;
    private $statusCode;

    /**
     * @var Profile
     */
    private $parent;

    /**
     * @var Profile[]
     */
<<<<<<< HEAD
    private $children = array();

    /**
     * Constructor.
     *
     * @param string $token The token
     */
    public function __construct($token)
=======
    private $children = [];

    public function __construct(string $token)
>>>>>>> v2-test
    {
        $this->token = $token;
    }

<<<<<<< HEAD
    /**
     * Sets the token.
     *
     * @param string $token The token
     */
    public function setToken($token)
=======
    public function setToken(string $token)
>>>>>>> v2-test
    {
        $this->token = $token;
    }

    /**
     * Gets the token.
     *
     * @return string The token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Sets the parent token.
<<<<<<< HEAD
     *
     * @param Profile $parent The parent Profile
     */
    public function setParent(Profile $parent)
=======
     */
    public function setParent(self $parent)
>>>>>>> v2-test
    {
        $this->parent = $parent;
    }

    /**
     * Returns the parent profile.
     *
<<<<<<< HEAD
     * @return Profile The parent profile
=======
     * @return self
>>>>>>> v2-test
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Returns the parent token.
     *
<<<<<<< HEAD
     * @return null|string The parent token
=======
     * @return string|null The parent token
>>>>>>> v2-test
     */
    public function getParentToken()
    {
        return $this->parent ? $this->parent->getToken() : null;
    }

    /**
     * Returns the IP.
     *
<<<<<<< HEAD
     * @return string The IP
=======
     * @return string|null The IP
>>>>>>> v2-test
     */
    public function getIp()
    {
        return $this->ip;
    }

<<<<<<< HEAD
    /**
     * Sets the IP.
     *
     * @param string $ip
     */
    public function setIp($ip)
=======
    public function setIp(?string $ip)
>>>>>>> v2-test
    {
        $this->ip = $ip;
    }

    /**
     * Returns the request method.
     *
<<<<<<< HEAD
     * @return string The request method
=======
     * @return string|null The request method
>>>>>>> v2-test
     */
    public function getMethod()
    {
        return $this->method;
    }

<<<<<<< HEAD
    public function setMethod($method)
=======
    public function setMethod(string $method)
>>>>>>> v2-test
    {
        $this->method = $method;
    }

    /**
     * Returns the URL.
     *
<<<<<<< HEAD
     * @return string The URL
=======
     * @return string|null The URL
>>>>>>> v2-test
     */
    public function getUrl()
    {
        return $this->url;
    }

<<<<<<< HEAD
    public function setUrl($url)
=======
    public function setUrl(?string $url)
>>>>>>> v2-test
    {
        $this->url = $url;
    }

    /**
<<<<<<< HEAD
     * Returns the time.
     *
     * @return string The time
=======
     * @return int The time
>>>>>>> v2-test
     */
    public function getTime()
    {
        if (null === $this->time) {
            return 0;
        }

        return $this->time;
    }

<<<<<<< HEAD
    public function setTime($time)
=======
    public function setTime(int $time)
>>>>>>> v2-test
    {
        $this->time = $time;
    }

<<<<<<< HEAD
    /**
     * @param int $statusCode
     */
    public function setStatusCode($statusCode)
=======
    public function setStatusCode(int $statusCode)
>>>>>>> v2-test
    {
        $this->statusCode = $statusCode;
    }

    /**
<<<<<<< HEAD
     * @return int
=======
     * @return int|null
>>>>>>> v2-test
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Finds children profilers.
     *
<<<<<<< HEAD
     * @return Profile[] An array of Profile
=======
     * @return self[]
>>>>>>> v2-test
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Sets children profiler.
     *
<<<<<<< HEAD
     * @param Profile[] $children An array of Profile
     */
    public function setChildren(array $children)
    {
        $this->children = array();
=======
     * @param Profile[] $children
     */
    public function setChildren(array $children)
    {
        $this->children = [];
>>>>>>> v2-test
        foreach ($children as $child) {
            $this->addChild($child);
        }
    }

    /**
     * Adds the child token.
<<<<<<< HEAD
     *
     * @param Profile $child The child Profile
     */
    public function addChild(Profile $child)
=======
     */
    public function addChild(self $child)
>>>>>>> v2-test
    {
        $this->children[] = $child;
        $child->setParent($this);
    }

<<<<<<< HEAD
    /**
     * Gets a Collector by name.
     *
     * @param string $name A collector name
     *
=======
    public function getChildByToken(string $token): ?self
    {
        foreach ($this->children as $child) {
            if ($token === $child->getToken()) {
                return $child;
            }
        }

        return null;
    }

    /**
     * Gets a Collector by name.
     *
>>>>>>> v2-test
     * @return DataCollectorInterface A DataCollectorInterface instance
     *
     * @throws \InvalidArgumentException if the collector does not exist
     */
<<<<<<< HEAD
    public function getCollector($name)
=======
    public function getCollector(string $name)
>>>>>>> v2-test
    {
        if (!isset($this->collectors[$name])) {
            throw new \InvalidArgumentException(sprintf('Collector "%s" does not exist.', $name));
        }

        return $this->collectors[$name];
    }

    /**
     * Gets the Collectors associated with this profile.
     *
     * @return DataCollectorInterface[]
     */
    public function getCollectors()
    {
        return $this->collectors;
    }

    /**
     * Sets the Collectors associated with this profile.
     *
     * @param DataCollectorInterface[] $collectors
     */
    public function setCollectors(array $collectors)
    {
<<<<<<< HEAD
        $this->collectors = array();
=======
        $this->collectors = [];
>>>>>>> v2-test
        foreach ($collectors as $collector) {
            $this->addCollector($collector);
        }
    }

    /**
     * Adds a Collector.
<<<<<<< HEAD
     *
     * @param DataCollectorInterface $collector A DataCollectorInterface instance
=======
>>>>>>> v2-test
     */
    public function addCollector(DataCollectorInterface $collector)
    {
        $this->collectors[$collector->getName()] = $collector;
    }

    /**
<<<<<<< HEAD
     * Returns true if a Collector for the given name exists.
     *
     * @param string $name A collector name
     *
     * @return bool
     */
    public function hasCollector($name)
=======
     * @return bool
     */
    public function hasCollector(string $name)
>>>>>>> v2-test
    {
        return isset($this->collectors[$name]);
    }

<<<<<<< HEAD
    public function __sleep()
    {
        return array('token', 'parent', 'children', 'collectors', 'ip', 'method', 'url', 'time');
=======
    /**
     * @return array
     */
    public function __sleep()
    {
        return ['token', 'parent', 'children', 'collectors', 'ip', 'method', 'url', 'time', 'statusCode'];
>>>>>>> v2-test
    }
}
