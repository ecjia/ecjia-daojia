<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
<<<<<<< HEAD
 * ControllerResolver.
 *
 * This implementation uses the '_controller' request attribute to determine
 * the controller to execute and uses the request attributes to determine
 * the controller method arguments.
 *
 * @author Fabien Potencier <fabien@symfony.com>
=======
 * This implementation uses the '_controller' request attribute to determine
 * the controller to execute.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Tobias Schultze <http://tobion.de>
>>>>>>> v2-test
 */
class ControllerResolver implements ControllerResolverInterface
{
    private $logger;

<<<<<<< HEAD
    /**
     * Constructor.
     *
     * @param LoggerInterface $logger A LoggerInterface instance
     */
=======
>>>>>>> v2-test
    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
<<<<<<< HEAD
     *
     * This method looks for a '_controller' request attribute that represents
     * the controller name (a string like ClassName::MethodName).
=======
>>>>>>> v2-test
     */
    public function getController(Request $request)
    {
        if (!$controller = $request->attributes->get('_controller')) {
            if (null !== $this->logger) {
                $this->logger->warning('Unable to look for the controller as the "_controller" parameter is missing.');
            }

            return false;
        }

<<<<<<< HEAD
        if (is_array($controller)) {
            return $controller;
        }

        if (is_object($controller)) {
            if (method_exists($controller, '__invoke')) {
                return $controller;
            }

            throw new \InvalidArgumentException(sprintf('Controller "%s" for URI "%s" is not callable.', get_class($controller), $request->getPathInfo()));
        }

        if (false === strpos($controller, ':')) {
            if (method_exists($controller, '__invoke')) {
                return $this->instantiateController($controller);
            } elseif (function_exists($controller)) {
                return $controller;
            }
        }

        $callable = $this->createController($controller);

        if (!is_callable($callable)) {
            throw new \InvalidArgumentException(sprintf('Controller "%s" for URI "%s" is not callable.', $controller, $request->getPathInfo()));
=======
        if (\is_array($controller)) {
            if (isset($controller[0]) && \is_string($controller[0]) && isset($controller[1])) {
                try {
                    $controller[0] = $this->instantiateController($controller[0]);
                } catch (\Error | \LogicException $e) {
                    try {
                        // We cannot just check is_callable but have to use reflection because a non-static method
                        // can still be called statically in PHP but we don't want that. This is deprecated in PHP 7, so we
                        // could simplify this with PHP 8.
                        if ((new \ReflectionMethod($controller[0], $controller[1]))->isStatic()) {
                            return $controller;
                        }
                    } catch (\ReflectionException $reflectionException) {
                        throw $e;
                    }

                    throw $e;
                }
            }

            if (!\is_callable($controller)) {
                throw new \InvalidArgumentException(sprintf('The controller for URI "%s" is not callable: ', $request->getPathInfo()).$this->getControllerError($controller));
            }

            return $controller;
        }

        if (\is_object($controller)) {
            if (!\is_callable($controller)) {
                throw new \InvalidArgumentException(sprintf('The controller for URI "%s" is not callable: ', $request->getPathInfo()).$this->getControllerError($controller));
            }

            return $controller;
        }

        if (\function_exists($controller)) {
            return $controller;
        }

        try {
            $callable = $this->createController($controller);
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException(sprintf('The controller for URI "%s" is not callable: ', $request->getPathInfo()).$e->getMessage(), 0, $e);
        }

        if (!\is_callable($callable)) {
            throw new \InvalidArgumentException(sprintf('The controller for URI "%s" is not callable: ', $request->getPathInfo()).$this->getControllerError($callable));
>>>>>>> v2-test
        }

        return $callable;
    }

    /**
<<<<<<< HEAD
     * {@inheritdoc}
     */
    public function getArguments(Request $request, $controller)
    {
        if (is_array($controller)) {
            $r = new \ReflectionMethod($controller[0], $controller[1]);
        } elseif (is_object($controller) && !$controller instanceof \Closure) {
            $r = new \ReflectionObject($controller);
            $r = $r->getMethod('__invoke');
        } else {
            $r = new \ReflectionFunction($controller);
        }

        return $this->doGetArguments($request, $controller, $r->getParameters());
    }

    protected function doGetArguments(Request $request, $controller, array $parameters)
    {
        $attributes = $request->attributes->all();
        $arguments = array();
        foreach ($parameters as $param) {
            if (array_key_exists($param->name, $attributes)) {
                if (PHP_VERSION_ID >= 50600 && $param->isVariadic() && is_array($attributes[$param->name])) {
                    $arguments = array_merge($arguments, array_values($attributes[$param->name]));
                } else {
                    $arguments[] = $attributes[$param->name];
                }
            } elseif ($param->getClass() && $param->getClass()->isInstance($request)) {
                $arguments[] = $request;
            } elseif ($param->isDefaultValueAvailable()) {
                $arguments[] = $param->getDefaultValue();
            } else {
                if (is_array($controller)) {
                    $repr = sprintf('%s::%s()', get_class($controller[0]), $controller[1]);
                } elseif (is_object($controller)) {
                    $repr = get_class($controller);
                } else {
                    $repr = $controller;
                }

                throw new \RuntimeException(sprintf('Controller "%s" requires that you provide a value for the "$%s" argument (because there is no default value or because there is a non optional argument after this one).', $repr, $param->name));
            }
        }

        return $arguments;
    }

    /**
     * Returns a callable for the given controller.
     *
     * @param string $controller A Controller string
     *
     * @return callable A PHP callable
     *
     * @throws \InvalidArgumentException
     */
    protected function createController($controller)
    {
        if (false === strpos($controller, '::')) {
            throw new \InvalidArgumentException(sprintf('Unable to find controller "%s".', $controller));
        }

        list($class, $method) = explode('::', $controller, 2);

        if (!class_exists($class)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" does not exist.', $class));
        }

        return array($this->instantiateController($class), $method);
    }

    /**
     * Returns an instantiated controller.
     *
     * @param string $class A class name
     *
     * @return object
     */
    protected function instantiateController($class)
    {
        return new $class();
=======
     * Returns a callable for the given controller.
     *
     * @return callable A PHP callable
     *
     * @throws \InvalidArgumentException When the controller cannot be created
     */
    protected function createController(string $controller)
    {
        if (false === strpos($controller, '::')) {
            $controller = $this->instantiateController($controller);

            if (!\is_callable($controller)) {
                throw new \InvalidArgumentException($this->getControllerError($controller));
            }

            return $controller;
        }

        [$class, $method] = explode('::', $controller, 2);

        try {
            $controller = [$this->instantiateController($class), $method];
        } catch (\Error | \LogicException $e) {
            try {
                if ((new \ReflectionMethod($class, $method))->isStatic()) {
                    return $class.'::'.$method;
                }
            } catch (\ReflectionException $reflectionException) {
                throw $e;
            }

            throw $e;
        }

        if (!\is_callable($controller)) {
            throw new \InvalidArgumentException($this->getControllerError($controller));
        }

        return $controller;
    }

    /**
     * Returns an instantiated controller.
     *
     * @return object
     */
    protected function instantiateController(string $class)
    {
        return new $class();
    }

    private function getControllerError($callable): string
    {
        if (\is_string($callable)) {
            if (false !== strpos($callable, '::')) {
                $callable = explode('::', $callable, 2);
            } else {
                return sprintf('Function "%s" does not exist.', $callable);
            }
        }

        if (\is_object($callable)) {
            $availableMethods = $this->getClassMethodsWithoutMagicMethods($callable);
            $alternativeMsg = $availableMethods ? sprintf(' or use one of the available methods: "%s"', implode('", "', $availableMethods)) : '';

            return sprintf('Controller class "%s" cannot be called without a method name. You need to implement "__invoke"%s.', get_debug_type($callable), $alternativeMsg);
        }

        if (!\is_array($callable)) {
            return sprintf('Invalid type for controller given, expected string, array or object, got "%s".', get_debug_type($callable));
        }

        if (!isset($callable[0]) || !isset($callable[1]) || 2 !== \count($callable)) {
            return 'Invalid array callable, expected [controller, method].';
        }

        [$controller, $method] = $callable;

        if (\is_string($controller) && !class_exists($controller)) {
            return sprintf('Class "%s" does not exist.', $controller);
        }

        $className = \is_object($controller) ? get_debug_type($controller) : $controller;

        if (method_exists($controller, $method)) {
            return sprintf('Method "%s" on class "%s" should be public and non-abstract.', $method, $className);
        }

        $collection = $this->getClassMethodsWithoutMagicMethods($controller);

        $alternatives = [];

        foreach ($collection as $item) {
            $lev = levenshtein($method, $item);

            if ($lev <= \strlen($method) / 3 || false !== strpos($item, $method)) {
                $alternatives[] = $item;
            }
        }

        asort($alternatives);

        $message = sprintf('Expected method "%s" on class "%s"', $method, $className);

        if (\count($alternatives) > 0) {
            $message .= sprintf(', did you mean "%s"?', implode('", "', $alternatives));
        } else {
            $message .= sprintf('. Available methods: "%s".', implode('", "', $collection));
        }

        return $message;
    }

    private function getClassMethodsWithoutMagicMethods($classOrObject): array
    {
        $methods = get_class_methods($classOrObject);

        return array_filter($methods, function (string $method) {
            return 0 !== strncmp($method, '__', 2);
        });
>>>>>>> v2-test
    }
}
