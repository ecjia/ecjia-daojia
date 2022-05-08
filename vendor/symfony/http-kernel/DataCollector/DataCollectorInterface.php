<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
<<<<<<< HEAD
=======
use Symfony\Contracts\Service\ResetInterface;
>>>>>>> v2-test

/**
 * DataCollectorInterface.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
<<<<<<< HEAD
interface DataCollectorInterface
{
    /**
     * Collects data for the given Request and Response.
     *
     * @param Request    $request   A Request instance
     * @param Response   $response  A Response instance
     * @param \Exception $exception An Exception instance
     */
    public function collect(Request $request, Response $response, \Exception $exception = null);
=======
interface DataCollectorInterface extends ResetInterface
{
    /**
     * Collects data for the given Request and Response.
     */
    public function collect(Request $request, Response $response, \Throwable $exception = null);
>>>>>>> v2-test

    /**
     * Returns the name of the collector.
     *
     * @return string The collector name
     */
    public function getName();
}
