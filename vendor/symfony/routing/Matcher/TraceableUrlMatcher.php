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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ExceptionInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * TraceableUrlMatcher helps debug path info matching by tracing the match.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class TraceableUrlMatcher extends UrlMatcher
{
<<<<<<< HEAD
    const ROUTE_DOES_NOT_MATCH = 0;
    const ROUTE_ALMOST_MATCHES = 1;
    const ROUTE_MATCHES = 2;

    protected $traces;

    public function getTraces($pathinfo)
    {
        $this->traces = array();
=======
    public const ROUTE_DOES_NOT_MATCH = 0;
    public const ROUTE_ALMOST_MATCHES = 1;
    public const ROUTE_MATCHES = 2;

    protected $traces;

    public function getTraces(string $pathinfo)
    {
        $this->traces = [];
>>>>>>> v2-test

        try {
            $this->match($pathinfo);
        } catch (ExceptionInterface $e) {
        }

        return $this->traces;
    }

    public function getTracesForRequest(Request $request)
    {
        $this->request = $request;
        $traces = $this->getTraces($request->getPathInfo());
        $this->request = null;

        return $traces;
    }

<<<<<<< HEAD
    protected function matchCollection($pathinfo, RouteCollection $routes)
    {
        foreach ($routes as $name => $route) {
            $compiledRoute = $route->compile();

            if (!preg_match($compiledRoute->getRegex(), $pathinfo, $matches)) {
                // does it match without any requirements?
                $r = new Route($route->getPath(), $route->getDefaults(), array(), $route->getOptions());
=======
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
                $this->addTrace(sprintf('Path "%s" does not match', $route->getPath()), self::ROUTE_DOES_NOT_MATCH, $name, $route);
                continue;
            }
            $regex = $compiledRoute->getRegex();

            $pos = strrpos($regex, '$');
            $hasTrailingSlash = '/' === $regex[$pos - 1];
            $regex = substr_replace($regex, '/?$', $pos - $hasTrailingSlash, 1 + $hasTrailingSlash);

            if (!preg_match($regex, $pathinfo, $matches)) {
                // does it match without any requirements?
                $r = new Route($route->getPath(), $route->getDefaults(), [], $route->getOptions());
>>>>>>> v2-test
                $cr = $r->compile();
                if (!preg_match($cr->getRegex(), $pathinfo)) {
                    $this->addTrace(sprintf('Path "%s" does not match', $route->getPath()), self::ROUTE_DOES_NOT_MATCH, $name, $route);

                    continue;
                }

                foreach ($route->getRequirements() as $n => $regex) {
<<<<<<< HEAD
                    $r = new Route($route->getPath(), $route->getDefaults(), array($n => $regex), $route->getOptions());
                    $cr = $r->compile();

                    if (in_array($n, $cr->getVariables()) && !preg_match($cr->getRegex(), $pathinfo)) {
=======
                    $r = new Route($route->getPath(), $route->getDefaults(), [$n => $regex], $route->getOptions());
                    $cr = $r->compile();

                    if (\in_array($n, $cr->getVariables()) && !preg_match($cr->getRegex(), $pathinfo)) {
>>>>>>> v2-test
                        $this->addTrace(sprintf('Requirement for "%s" does not match (%s)', $n, $regex), self::ROUTE_ALMOST_MATCHES, $name, $route);

                        continue 2;
                    }
                }

                continue;
            }

<<<<<<< HEAD
            // check host requirement
            $hostMatches = array();
            if ($compiledRoute->getHostRegex() && !preg_match($compiledRoute->getHostRegex(), $this->context->getHost(), $hostMatches)) {
                $this->addTrace(sprintf('Host "%s" does not match the requirement ("%s")', $this->context->getHost(), $route->getHost()), self::ROUTE_ALMOST_MATCHES, $name, $route);

                continue;
            }

            // check HTTP method requirement
            if ($requiredMethods = $route->getMethods()) {
                // HEAD and GET are equivalent as per RFC
                if ('HEAD' === $method = $this->context->getMethod()) {
                    $method = 'GET';
                }

                if (!in_array($method, $requiredMethods)) {
                    $this->allow = array_merge($this->allow, $requiredMethods);

                    $this->addTrace(sprintf('Method "%s" does not match any of the required methods (%s)', $this->context->getMethod(), implode(', ', $requiredMethods)), self::ROUTE_ALMOST_MATCHES, $name, $route);

                    continue;
                }
            }

            // check condition
            if ($condition = $route->getCondition()) {
                if (!$this->getExpressionLanguage()->evaluate($condition, array('context' => $this->context, 'request' => $this->request))) {
                    $this->addTrace(sprintf('Condition "%s" does not evaluate to "true"', $condition), self::ROUTE_ALMOST_MATCHES, $name, $route);

                    continue;
                }
            }

            // check HTTP scheme requirement
            if ($requiredSchemes = $route->getSchemes()) {
                $scheme = $this->context->getScheme();

                if (!$route->hasScheme($scheme)) {
                    $this->addTrace(sprintf('Scheme "%s" does not match any of the required schemes (%s); the user will be redirected to first required scheme', $scheme, implode(', ', $requiredSchemes)), self::ROUTE_ALMOST_MATCHES, $name, $route);

                    return true;
                }
=======
            $hasTrailingVar = $trimmedPathinfo !== $pathinfo && preg_match('#\{\w+\}/?$#', $route->getPath());

            if ($hasTrailingVar && ($hasTrailingSlash || (null === $m = $matches[\count($compiledRoute->getPathVariables())] ?? null) || '/' !== ($m[-1] ?? '/')) && preg_match($regex, $trimmedPathinfo, $m)) {
                if ($hasTrailingSlash) {
                    $matches = $m;
                } else {
                    $hasTrailingVar = false;
                }
            }

            $hostMatches = [];
            if ($compiledRoute->getHostRegex() && !preg_match($compiledRoute->getHostRegex(), $this->context->getHost(), $hostMatches)) {
                $this->addTrace(sprintf('Host "%s" does not match the requirement ("%s")', $this->context->getHost(), $route->getHost()), self::ROUTE_ALMOST_MATCHES, $name, $route);
                continue;
            }

            $status = $this->handleRouteRequirements($pathinfo, $name, $route);

            if (self::REQUIREMENT_MISMATCH === $status[0]) {
                $this->addTrace(sprintf('Condition "%s" does not evaluate to "true"', $route->getCondition()), self::ROUTE_ALMOST_MATCHES, $name, $route);
                continue;
            }

            if ('/' !== $pathinfo && !$hasTrailingVar && $hasTrailingSlash === ($trimmedPathinfo === $pathinfo)) {
                if ($supportsTrailingSlash && (!$requiredMethods || \in_array('GET', $requiredMethods))) {
                    $this->addTrace('Route matches!', self::ROUTE_MATCHES, $name, $route);

                    return $this->allow = $this->allowSchemes = [];
                }
                $this->addTrace(sprintf('Path "%s" does not match', $route->getPath()), self::ROUTE_DOES_NOT_MATCH, $name, $route);
                continue;
            }

            if ($route->getSchemes() && !$route->hasScheme($this->context->getScheme())) {
                $this->allowSchemes = array_merge($this->allowSchemes, $route->getSchemes());
                $this->addTrace(sprintf('Scheme "%s" does not match any of the required schemes (%s)', $this->context->getScheme(), implode(', ', $route->getSchemes())), self::ROUTE_ALMOST_MATCHES, $name, $route);
                continue;
            }

            if ($requiredMethods && !\in_array($method, $requiredMethods)) {
                $this->allow = array_merge($this->allow, $requiredMethods);
                $this->addTrace(sprintf('Method "%s" does not match any of the required methods (%s)', $this->context->getMethod(), implode(', ', $requiredMethods)), self::ROUTE_ALMOST_MATCHES, $name, $route);
                continue;
>>>>>>> v2-test
            }

            $this->addTrace('Route matches!', self::ROUTE_MATCHES, $name, $route);

<<<<<<< HEAD
            return true;
        }
    }

    private function addTrace($log, $level = self::ROUTE_DOES_NOT_MATCH, $name = null, $route = null)
    {
        $this->traces[] = array(
=======
            return $this->getAttributes($route, $name, array_replace($matches, $hostMatches, $status[1] ?? []));
        }

        return [];
    }

    private function addTrace(string $log, int $level = self::ROUTE_DOES_NOT_MATCH, string $name = null, Route $route = null)
    {
        $this->traces[] = [
>>>>>>> v2-test
            'log' => $log,
            'name' => $name,
            'level' => $level,
            'path' => null !== $route ? $route->getPath() : null,
<<<<<<< HEAD
        );
=======
        ];
>>>>>>> v2-test
    }
}
