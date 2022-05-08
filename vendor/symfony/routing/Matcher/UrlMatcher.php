<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Matcher;

<<<<<<< HEAD
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
=======
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\NoConfigurationException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
>>>>>>> v2-test

/**
 * UrlMatcher matches URL based on a set of routes.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class UrlMatcher implements UrlMatcherInterface, RequestMatcherInterface
{
<<<<<<< HEAD
    const REQUIREMENT_MATCH = 0;
    const REQUIREMENT_MISMATCH = 1;
    const ROUTE_MATCH = 2;

    /**
     * @var RequestContext
     */
    protected $context;

    /**
     * @var array
     */
    protected $allow = array();

    /**
     * @var RouteCollection
     */
    protected $routes;

=======
    public const REQUIREMENT_MATCH = 0;
    public const REQUIREMENT_MISMATCH = 1;
    public const ROUTE_MATCH = 2;

    /** @var RequestContext */
    protected $context;

    /**
     * Collects HTTP methods that would be allowed for the request.
     */
    protected $allow = [];

    /**
     * Collects URI schemes that would be allowed for the request.
     *
     * @internal
     */
    protected $allowSchemes = [];

    protected $routes;
>>>>>>> v2-test
    protected $request;
    protected $expressionLanguage;

    /**
     * @var ExpressionFunctionProviderInterface[]
     */
<<<<<<< HEAD
    protected $expressionLanguageProviders = array();

    /**
     * Constructor.
     *
     * @param RouteCollection $routes  A RouteCollection instance
     * @param RequestContext  $context The context
     */
=======
    protected $expressionLanguageProviders = [];

>>>>>>> v2-test
    public function __construct(RouteCollection $routes, RequestContext $context)
    {
        $this->routes = $routes;
        $this->context = $context;
    }

    /**
     * {@inheritdoc}
     */
    public function setContext(RequestContext $context)
    {
        $this->context = $context;
    }

    /**
     * {@inheritdoc}
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function match($pathinfo)
    {
        $this->allow = array();

        if ($ret = $this->matchCollection(rawurldecode($pathinfo), $this->routes)) {
            return $ret;
        }

        throw 0 < count($this->allow)
            ? new MethodNotAllowedException(array_unique($this->allow))
            : new ResourceNotFoundException(sprintf('No routes found for "%s".', $pathinfo));
=======
    public function match(string $pathinfo)
    {
        $this->allow = $this->allowSchemes = [];

        if ($ret = $this->matchCollection(rawurldecode($pathinfo) ?: '/', $this->routes)) {
            return $ret;
        }

        if ('/' === $pathinfo && !$this->allow && !$this->allowSchemes) {
            throw new NoConfigurationException();
        }

        throw 0 < \count($this->allow) ? new MethodNotAllowedException(array_unique($this->allow)) : new ResourceNotFoundException(sprintf('No routes found for "%s".', $pathinfo));
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
    public function matchRequest(Request $request)
    {
        $this->request = $request;

        $ret = $this->match($request->getPathInfo());

        $this->request = null;

        return $ret;
    }

    public function addExpressionLanguageProvider(ExpressionFunctionProviderInterface $provider)
    {
        $this->expressionLanguageProviders[] = $provider;
    }

    /**
     * Tries to match a URL with a set of routes.
     *
<<<<<<< HEAD
     * @param string          $pathinfo The path info to be parsed
     * @param RouteCollection $routes   The set of routes
     *
     * @return array An array of parameters
     *
     * @throws ResourceNotFoundException If the resource could not be found
     * @throws MethodNotAllowedException If the resource was found but the request method is not allowed
     */
    protected function matchCollection($pathinfo, RouteCollection $routes)
    {
        foreach ($routes as $name => $route) {
            $compiledRoute = $route->compile();

            // check the static prefix of the URL first. Only use the more expensive preg_match when it matches
            if ('' !== $compiledRoute->getStaticPrefix() && 0 !== strpos($pathinfo, $compiledRoute->getStaticPrefix())) {
                continue;
            }

            if (!preg_match($compiledRoute->getRegex(), $pathinfo, $matches)) {
                continue;
            }

            $hostMatches = array();
=======
     * @param string $pathinfo The path info to be parsed
     *
     * @return array An array of parameters
     *
     * @throws NoConfigurationException  If no routing configuration could be found
     * @throws ResourceNotFoundException If the resource could not be found
     * @throws MethodNotAllowedException If the resource was found but the request method is not allowed
     */
    protected function matchCollection(string $pathinfo, RouteCollection $routes)
    {
        // HEAD and GET are equivalent as per RFC
        if ('HEAD' === $method = $this->context->getMethod()) {
            $method = 'GET';
        }
        $supportsTrailingSlash = 'GET' === $method && $this instanceof RedirectableUrlMatcherInterface;
        $trimmedPathinfo = rtrim($pathinfo, '/') ?: '/';

        foreach ($routes as $name => $route) {
            $compiledRoute = $route->compile();
            $staticPrefix = rtrim($compiledRoute->getStaticPrefix(), '/');
            $requiredMethods = $route->getMethods();

            // check the static prefix of the URL first. Only use the more expensive preg_match when it matches
            if ('' !== $staticPrefix && 0 !== strpos($trimmedPathinfo, $staticPrefix)) {
                continue;
            }
            $regex = $compiledRoute->getRegex();

            $pos = strrpos($regex, '$');
            $hasTrailingSlash = '/' === $regex[$pos - 1];
            $regex = substr_replace($regex, '/?$', $pos - $hasTrailingSlash, 1 + $hasTrailingSlash);

            if (!preg_match($regex, $pathinfo, $matches)) {
                continue;
            }

            $hasTrailingVar = $trimmedPathinfo !== $pathinfo && preg_match('#\{\w+\}/?$#', $route->getPath());

            if ($hasTrailingVar && ($hasTrailingSlash || (null === $m = $matches[\count($compiledRoute->getPathVariables())] ?? null) || '/' !== ($m[-1] ?? '/')) && preg_match($regex, $trimmedPathinfo, $m)) {
                if ($hasTrailingSlash) {
                    $matches = $m;
                } else {
                    $hasTrailingVar = false;
                }
            }

            $hostMatches = [];
>>>>>>> v2-test
            if ($compiledRoute->getHostRegex() && !preg_match($compiledRoute->getHostRegex(), $this->context->getHost(), $hostMatches)) {
                continue;
            }

<<<<<<< HEAD
            // check HTTP method requirement
            if ($requiredMethods = $route->getMethods()) {
                // HEAD and GET are equivalent as per RFC
                if ('HEAD' === $method = $this->context->getMethod()) {
                    $method = 'GET';
                }

                if (!in_array($method, $requiredMethods)) {
                    $this->allow = array_merge($this->allow, $requiredMethods);

                    continue;
                }
            }

            $status = $this->handleRouteRequirements($pathinfo, $name, $route);

            if (self::ROUTE_MATCH === $status[0]) {
                return $status[1];
            }

            if (self::REQUIREMENT_MISMATCH === $status[0]) {
                continue;
            }

            return $this->getAttributes($route, $name, array_replace($matches, $hostMatches));
        }
=======
            $status = $this->handleRouteRequirements($pathinfo, $name, $route);

            if (self::REQUIREMENT_MISMATCH === $status[0]) {
                continue;
            }

            if ('/' !== $pathinfo && !$hasTrailingVar && $hasTrailingSlash === ($trimmedPathinfo === $pathinfo)) {
                if ($supportsTrailingSlash && (!$requiredMethods || \in_array('GET', $requiredMethods))) {
                    return $this->allow = $this->allowSchemes = [];
                }
                continue;
            }

            if ($route->getSchemes() && !$route->hasScheme($this->context->getScheme())) {
                $this->allowSchemes = array_merge($this->allowSchemes, $route->getSchemes());
                continue;
            }

            if ($requiredMethods && !\in_array($method, $requiredMethods)) {
                $this->allow = array_merge($this->allow, $requiredMethods);
                continue;
            }

            return $this->getAttributes($route, $name, array_replace($matches, $hostMatches, $status[1] ?? []));
        }

        return [];
>>>>>>> v2-test
    }

    /**
     * Returns an array of values to use as request attributes.
     *
     * As this method requires the Route object, it is not available
     * in matchers that do not have access to the matched Route instance
     * (like the PHP and Apache matcher dumpers).
     *
<<<<<<< HEAD
     * @param Route  $route      The route we are matching against
     * @param string $name       The name of the route
     * @param array  $attributes An array of attributes from the matcher
     *
     * @return array An array of parameters
     */
    protected function getAttributes(Route $route, $name, array $attributes)
    {
        $attributes['_route'] = $name;

        return $this->mergeDefaults($attributes, $route->getDefaults());
=======
     * @return array An array of parameters
     */
    protected function getAttributes(Route $route, string $name, array $attributes)
    {
        $defaults = $route->getDefaults();
        if (isset($defaults['_canonical_route'])) {
            $name = $defaults['_canonical_route'];
            unset($defaults['_canonical_route']);
        }
        $attributes['_route'] = $name;

        return $this->mergeDefaults($attributes, $defaults);
>>>>>>> v2-test
    }

    /**
     * Handles specific route requirements.
     *
<<<<<<< HEAD
     * @param string $pathinfo The path
     * @param string $name     The route name
     * @param Route  $route    The route
     *
     * @return array The first element represents the status, the second contains additional information
     */
    protected function handleRouteRequirements($pathinfo, $name, Route $route)
    {
        // expression condition
        if ($route->getCondition() && !$this->getExpressionLanguage()->evaluate($route->getCondition(), array('context' => $this->context, 'request' => $this->request))) {
            return array(self::REQUIREMENT_MISMATCH, null);
        }

        // check HTTP scheme requirement
        $scheme = $this->context->getScheme();
        $status = $route->getSchemes() && !$route->hasScheme($scheme) ? self::REQUIREMENT_MISMATCH : self::REQUIREMENT_MATCH;

        return array($status, null);
=======
     * @return array The first element represents the status, the second contains additional information
     */
    protected function handleRouteRequirements(string $pathinfo, string $name, Route $route)
    {
        // expression condition
        if ($route->getCondition() && !$this->getExpressionLanguage()->evaluate($route->getCondition(), ['context' => $this->context, 'request' => $this->request ?: $this->createRequest($pathinfo)])) {
            return [self::REQUIREMENT_MISMATCH, null];
        }

        return [self::REQUIREMENT_MATCH, null];
>>>>>>> v2-test
    }

    /**
     * Get merged default parameters.
     *
<<<<<<< HEAD
     * @param array $params   The parameters
     * @param array $defaults The defaults
     *
     * @return array Merged default parameters
     */
    protected function mergeDefaults($params, $defaults)
    {
        foreach ($params as $key => $value) {
            if (!is_int($key)) {
=======
     * @return array Merged default parameters
     */
    protected function mergeDefaults(array $params, array $defaults)
    {
        foreach ($params as $key => $value) {
            if (!\is_int($key) && null !== $value) {
>>>>>>> v2-test
                $defaults[$key] = $value;
            }
        }

        return $defaults;
    }

    protected function getExpressionLanguage()
    {
        if (null === $this->expressionLanguage) {
<<<<<<< HEAD
            if (!class_exists('Symfony\Component\ExpressionLanguage\ExpressionLanguage')) {
                throw new \RuntimeException('Unable to use expressions as the Symfony ExpressionLanguage component is not installed.');
=======
            if (!class_exists(ExpressionLanguage::class)) {
                throw new \LogicException('Unable to use expressions as the Symfony ExpressionLanguage component is not installed.');
>>>>>>> v2-test
            }
            $this->expressionLanguage = new ExpressionLanguage(null, $this->expressionLanguageProviders);
        }

        return $this->expressionLanguage;
    }
<<<<<<< HEAD
=======

    /**
     * @internal
     */
    protected function createRequest(string $pathinfo): ?Request
    {
        if (!class_exists(Request::class)) {
            return null;
        }

        return Request::create($this->context->getScheme().'://'.$this->context->getHost().$this->context->getBaseUrl().$pathinfo, $this->context->getMethod(), $this->context->getParameters(), [], [], [
            'SCRIPT_FILENAME' => $this->context->getBaseUrl(),
            'SCRIPT_NAME' => $this->context->getBaseUrl(),
        ]);
    }
>>>>>>> v2-test
}
