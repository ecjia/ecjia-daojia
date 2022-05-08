<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing;

use Symfony\Component\Config\Resource\ResourceInterface;

/**
 * A RouteCollection represents a set of Route instances.
 *
 * When adding a route at the end of the collection, an existing route
 * with the same name is removed first. So there can only be one route
 * with a given name.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Tobias Schultze <http://tobion.de>
 */
class RouteCollection implements \IteratorAggregate, \Countable
{
    /**
     * @var Route[]
     */
<<<<<<< HEAD
    private $routes = array();
=======
    private $routes = [];
>>>>>>> v2-test

    /**
     * @var array
     */
<<<<<<< HEAD
    private $resources = array();
=======
    private $resources = [];

    /**
     * @var int[]
     */
    private $priorities = [];
>>>>>>> v2-test

    public function __clone()
    {
        foreach ($this->routes as $name => $route) {
            $this->routes[$name] = clone $route;
        }
    }

    /**
     * Gets the current RouteCollection as an Iterator that includes all routes.
     *
     * It implements \IteratorAggregate.
     *
     * @see all()
     *
     * @return \ArrayIterator|Route[] An \ArrayIterator object for iterating over routes
     */
    public function getIterator()
    {
<<<<<<< HEAD
        return new \ArrayIterator($this->routes);
=======
        return new \ArrayIterator($this->all());
>>>>>>> v2-test
    }

    /**
     * Gets the number of Routes in this collection.
     *
     * @return int The number of routes
     */
    public function count()
    {
<<<<<<< HEAD
        return count($this->routes);
    }

    /**
     * Adds a route.
     *
     * @param string $name  The route name
     * @param Route  $route A Route instance
     */
    public function add($name, Route $route)
    {
        unset($this->routes[$name]);

        $this->routes[$name] = $route;
=======
        return \count($this->routes);
    }

    /**
     * @param int $priority
     */
    public function add(string $name, Route $route/*, int $priority = 0*/)
    {
        if (\func_num_args() < 3 && __CLASS__ !== static::class && __CLASS__ !== (new \ReflectionMethod($this, __FUNCTION__))->getDeclaringClass()->getName() && !$this instanceof \PHPUnit\Framework\MockObject\MockObject && !$this instanceof \Prophecy\Prophecy\ProphecySubjectInterface && !$this instanceof \Mockery\MockInterface) {
            trigger_deprecation('symfony/routing', '5.1', 'The "%s()" method will have a new "int $priority = 0" argument in version 6.0, not defining it is deprecated.', __METHOD__);
        }

        unset($this->routes[$name], $this->priorities[$name]);

        $this->routes[$name] = $route;

        if ($priority = 3 <= \func_num_args() ? func_get_arg(2) : 0) {
            $this->priorities[$name] = $priority;
        }
>>>>>>> v2-test
    }

    /**
     * Returns all routes in this collection.
     *
     * @return Route[] An array of routes
     */
    public function all()
    {
<<<<<<< HEAD
=======
        if ($this->priorities) {
            $priorities = $this->priorities;
            $keysOrder = array_flip(array_keys($this->routes));
            uksort($this->routes, static function ($n1, $n2) use ($priorities, $keysOrder) {
                return (($priorities[$n2] ?? 0) <=> ($priorities[$n1] ?? 0)) ?: ($keysOrder[$n1] <=> $keysOrder[$n2]);
            });
        }

>>>>>>> v2-test
        return $this->routes;
    }

    /**
     * Gets a route by name.
     *
<<<<<<< HEAD
     * @param string $name The route name
     *
     * @return Route|null A Route instance or null when not found
     */
    public function get($name)
    {
        return isset($this->routes[$name]) ? $this->routes[$name] : null;
=======
     * @return Route|null A Route instance or null when not found
     */
    public function get(string $name)
    {
        return $this->routes[$name] ?? null;
>>>>>>> v2-test
    }

    /**
     * Removes a route or an array of routes by name from the collection.
     *
<<<<<<< HEAD
     * @param string|array $name The route name or an array of route names
=======
     * @param string|string[] $name The route name or an array of route names
>>>>>>> v2-test
     */
    public function remove($name)
    {
        foreach ((array) $name as $n) {
<<<<<<< HEAD
            unset($this->routes[$n]);
=======
            unset($this->routes[$n], $this->priorities[$n]);
>>>>>>> v2-test
        }
    }

    /**
     * Adds a route collection at the end of the current set by appending all
     * routes of the added collection.
<<<<<<< HEAD
     *
     * @param RouteCollection $collection A RouteCollection instance
     */
    public function addCollection(RouteCollection $collection)
=======
     */
    public function addCollection(self $collection)
>>>>>>> v2-test
    {
        // we need to remove all routes with the same names first because just replacing them
        // would not place the new route at the end of the merged array
        foreach ($collection->all() as $name => $route) {
<<<<<<< HEAD
            unset($this->routes[$name]);
            $this->routes[$name] = $route;
        }

        $this->resources = array_merge($this->resources, $collection->getResources());
=======
            unset($this->routes[$name], $this->priorities[$name]);
            $this->routes[$name] = $route;

            if (isset($collection->priorities[$name])) {
                $this->priorities[$name] = $collection->priorities[$name];
            }
        }

        foreach ($collection->getResources() as $resource) {
            $this->addResource($resource);
        }
>>>>>>> v2-test
    }

    /**
     * Adds a prefix to the path of all child routes.
<<<<<<< HEAD
     *
     * @param string $prefix       An optional prefix to add before each pattern of the route collection
     * @param array  $defaults     An array of default values
     * @param array  $requirements An array of requirements
     */
    public function addPrefix($prefix, array $defaults = array(), array $requirements = array())
=======
     */
    public function addPrefix(string $prefix, array $defaults = [], array $requirements = [])
>>>>>>> v2-test
    {
        $prefix = trim(trim($prefix), '/');

        if ('' === $prefix) {
            return;
        }

        foreach ($this->routes as $route) {
            $route->setPath('/'.$prefix.$route->getPath());
            $route->addDefaults($defaults);
            $route->addRequirements($requirements);
        }
    }

    /**
<<<<<<< HEAD
     * Sets the host pattern on all routes.
     *
     * @param string $pattern      The pattern
     * @param array  $defaults     An array of default values
     * @param array  $requirements An array of requirements
     */
    public function setHost($pattern, array $defaults = array(), array $requirements = array())
=======
     * Adds a prefix to the name of all the routes within in the collection.
     */
    public function addNamePrefix(string $prefix)
    {
        $prefixedRoutes = [];
        $prefixedPriorities = [];

        foreach ($this->routes as $name => $route) {
            $prefixedRoutes[$prefix.$name] = $route;
            if (null !== $canonicalName = $route->getDefault('_canonical_route')) {
                $route->setDefault('_canonical_route', $prefix.$canonicalName);
            }
            if (isset($this->priorities[$name])) {
                $prefixedPriorities[$prefix.$name] = $this->priorities[$name];
            }
        }

        $this->routes = $prefixedRoutes;
        $this->priorities = $prefixedPriorities;
    }

    /**
     * Sets the host pattern on all routes.
     */
    public function setHost(?string $pattern, array $defaults = [], array $requirements = [])
>>>>>>> v2-test
    {
        foreach ($this->routes as $route) {
            $route->setHost($pattern);
            $route->addDefaults($defaults);
            $route->addRequirements($requirements);
        }
    }

    /**
     * Sets a condition on all routes.
     *
     * Existing conditions will be overridden.
<<<<<<< HEAD
     *
     * @param string $condition The condition
     */
    public function setCondition($condition)
=======
     */
    public function setCondition(?string $condition)
>>>>>>> v2-test
    {
        foreach ($this->routes as $route) {
            $route->setCondition($condition);
        }
    }

    /**
     * Adds defaults to all routes.
     *
     * An existing default value under the same name in a route will be overridden.
<<<<<<< HEAD
     *
     * @param array $defaults An array of default values
=======
>>>>>>> v2-test
     */
    public function addDefaults(array $defaults)
    {
        if ($defaults) {
            foreach ($this->routes as $route) {
                $route->addDefaults($defaults);
            }
        }
    }

    /**
     * Adds requirements to all routes.
     *
     * An existing requirement under the same name in a route will be overridden.
<<<<<<< HEAD
     *
     * @param array $requirements An array of requirements
=======
>>>>>>> v2-test
     */
    public function addRequirements(array $requirements)
    {
        if ($requirements) {
            foreach ($this->routes as $route) {
                $route->addRequirements($requirements);
            }
        }
    }

    /**
     * Adds options to all routes.
     *
     * An existing option value under the same name in a route will be overridden.
<<<<<<< HEAD
     *
     * @param array $options An array of options
=======
>>>>>>> v2-test
     */
    public function addOptions(array $options)
    {
        if ($options) {
            foreach ($this->routes as $route) {
                $route->addOptions($options);
            }
        }
    }

    /**
     * Sets the schemes (e.g. 'https') all child routes are restricted to.
     *
<<<<<<< HEAD
     * @param string|array $schemes The scheme or an array of schemes
=======
     * @param string|string[] $schemes The scheme or an array of schemes
>>>>>>> v2-test
     */
    public function setSchemes($schemes)
    {
        foreach ($this->routes as $route) {
            $route->setSchemes($schemes);
        }
    }

    /**
     * Sets the HTTP methods (e.g. 'POST') all child routes are restricted to.
     *
<<<<<<< HEAD
     * @param string|array $methods The method or an array of methods
=======
     * @param string|string[] $methods The method or an array of methods
>>>>>>> v2-test
     */
    public function setMethods($methods)
    {
        foreach ($this->routes as $route) {
            $route->setMethods($methods);
        }
    }

    /**
     * Returns an array of resources loaded to build this collection.
     *
     * @return ResourceInterface[] An array of resources
     */
    public function getResources()
    {
<<<<<<< HEAD
        return array_unique($this->resources);
    }

    /**
     * Adds a resource for this collection.
     *
     * @param ResourceInterface $resource A resource instance
     */
    public function addResource(ResourceInterface $resource)
    {
        $this->resources[] = $resource;
=======
        return array_values($this->resources);
    }

    /**
     * Adds a resource for this collection. If the resource already exists
     * it is not added.
     */
    public function addResource(ResourceInterface $resource)
    {
        $key = (string) $resource;

        if (!isset($this->resources[$key])) {
            $this->resources[$key] = $resource;
        }
>>>>>>> v2-test
    }
}
