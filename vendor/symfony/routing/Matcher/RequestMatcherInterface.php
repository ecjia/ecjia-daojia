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
<<<<<<< HEAD
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
=======
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\NoConfigurationException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
>>>>>>> v2-test

/**
 * RequestMatcherInterface is the interface that all request matcher classes must implement.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface RequestMatcherInterface
{
    /**
     * Tries to match a request with a set of routes.
     *
     * If the matcher can not find information, it must throw one of the exceptions documented
     * below.
     *
<<<<<<< HEAD
     * @param Request $request The request to match
     *
     * @return array An array of parameters
     *
=======
     * @return array An array of parameters
     *
     * @throws NoConfigurationException  If no routing configuration could be found
>>>>>>> v2-test
     * @throws ResourceNotFoundException If no matching resource could be found
     * @throws MethodNotAllowedException If a matching resource was found but the request method is not allowed
     */
    public function matchRequest(Request $request);
}
