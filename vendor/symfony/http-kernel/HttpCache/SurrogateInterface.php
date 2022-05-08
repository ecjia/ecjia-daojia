<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\HttpCache;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface SurrogateInterface
{
    /**
     * Returns surrogate name.
     *
     * @return string
     */
    public function getName();

    /**
     * Returns a new cache strategy instance.
     *
     * @return ResponseCacheStrategyInterface A ResponseCacheStrategyInterface instance
     */
    public function createCacheStrategy();

    /**
     * Checks that at least one surrogate has Surrogate capability.
     *
<<<<<<< HEAD
     * @param Request $request A Request instance
     *
=======
>>>>>>> v2-test
     * @return bool true if one surrogate has Surrogate capability, false otherwise
     */
    public function hasSurrogateCapability(Request $request);

    /**
     * Adds Surrogate-capability to the given Request.
<<<<<<< HEAD
     *
     * @param Request $request A Request instance
=======
>>>>>>> v2-test
     */
    public function addSurrogateCapability(Request $request);

    /**
     * Adds HTTP headers to specify that the Response needs to be parsed for Surrogate.
     *
     * This method only adds an Surrogate HTTP header if the Response has some Surrogate tags.
<<<<<<< HEAD
     *
     * @param Response $response A Response instance
=======
>>>>>>> v2-test
     */
    public function addSurrogateControl(Response $response);

    /**
     * Checks that the Response needs to be parsed for Surrogate tags.
     *
<<<<<<< HEAD
     * @param Response $response A Response instance
     *
=======
>>>>>>> v2-test
     * @return bool true if the Response needs to be parsed, false otherwise
     */
    public function needsParsing(Response $response);

    /**
     * Renders a Surrogate tag.
     *
<<<<<<< HEAD
     * @param string $uri          A URI
     * @param string $alt          An alternate URI
     * @param bool   $ignoreErrors Whether to ignore errors or not
     * @param string $comment      A comment to add as an esi:include tag
     *
     * @return string
     */
    public function renderIncludeTag($uri, $alt = null, $ignoreErrors = true, $comment = '');
=======
     * @param string $alt     An alternate URI
     * @param string $comment A comment to add as an esi:include tag
     *
     * @return string
     */
    public function renderIncludeTag(string $uri, string $alt = null, bool $ignoreErrors = true, string $comment = '');
>>>>>>> v2-test

    /**
     * Replaces a Response Surrogate tags with the included resource content.
     *
<<<<<<< HEAD
     * @param Request  $request  A Request instance
     * @param Response $response A Response instance
     *
=======
>>>>>>> v2-test
     * @return Response
     */
    public function process(Request $request, Response $response);

    /**
     * Handles a Surrogate from the cache.
     *
<<<<<<< HEAD
     * @param HttpCache $cache        An HttpCache instance
     * @param string    $uri          The main URI
     * @param string    $alt          An alternative URI
     * @param bool      $ignoreErrors Whether to ignore errors or not
=======
     * @param string $alt An alternative URI
>>>>>>> v2-test
     *
     * @return string
     *
     * @throws \RuntimeException
     * @throws \Exception
     */
<<<<<<< HEAD
    public function handle(HttpCache $cache, $uri, $alt, $ignoreErrors);
=======
    public function handle(HttpCache $cache, string $uri, string $alt, bool $ignoreErrors);
>>>>>>> v2-test
}
