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
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Route;
=======
use Symfony\Component\Routing\Exception\ExceptionInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
>>>>>>> v2-test

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class RedirectableUrlMatcher extends UrlMatcher implements RedirectableUrlMatcherInterface
{
    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function match($pathinfo)
    {
        try {
            $parameters = parent::match($pathinfo);
        } catch (ResourceNotFoundException $e) {
            if ('/' === substr($pathinfo, -1) || !in_array($this->context->getMethod(), array('HEAD', 'GET'))) {
                throw $e;
            }

            try {
                parent::match($pathinfo.'/');

                return $this->redirect($pathinfo.'/', null);
            } catch (ResourceNotFoundException $e2) {
                throw $e;
            }
        }

        return $parameters;
    }

    /**
     * {@inheritdoc}
     */
    protected function handleRouteRequirements($pathinfo, $name, Route $route)
    {
        // expression condition
        if ($route->getCondition() && !$this->getExpressionLanguage()->evaluate($route->getCondition(), array('context' => $this->context, 'request' => $this->request))) {
            return array(self::REQUIREMENT_MISMATCH, null);
        }

        // check HTTP scheme requirement
        $scheme = $this->context->getScheme();
        $schemes = $route->getSchemes();
        if ($schemes && !$route->hasScheme($scheme)) {
            return array(self::ROUTE_MATCH, $this->redirect($pathinfo, $name, current($schemes)));
        }

        return array(self::REQUIREMENT_MATCH, null);
=======
    public function match(string $pathinfo)
    {
        try {
            return parent::match($pathinfo);
        } catch (ResourceNotFoundException $e) {
            if (!\in_array($this->context->getMethod(), ['HEAD', 'GET'], true)) {
                throw $e;
            }

            if ($this->allowSchemes) {
                redirect_scheme:
                $scheme = $this->context->getScheme();
                $this->context->setScheme(current($this->allowSchemes));
                try {
                    $ret = parent::match($pathinfo);

                    return $this->redirect($pathinfo, $ret['_route'] ?? null, $this->context->getScheme()) + $ret;
                } catch (ExceptionInterface $e2) {
                    throw $e;
                } finally {
                    $this->context->setScheme($scheme);
                }
            } elseif ('/' === $trimmedPathinfo = rtrim($pathinfo, '/') ?: '/') {
                throw $e;
            } else {
                try {
                    $pathinfo = $trimmedPathinfo === $pathinfo ? $pathinfo.'/' : $trimmedPathinfo;
                    $ret = parent::match($pathinfo);

                    return $this->redirect($pathinfo, $ret['_route'] ?? null) + $ret;
                } catch (ExceptionInterface $e2) {
                    if ($this->allowSchemes) {
                        goto redirect_scheme;
                    }
                    throw $e;
                }
            }
        }
>>>>>>> v2-test
    }
}
