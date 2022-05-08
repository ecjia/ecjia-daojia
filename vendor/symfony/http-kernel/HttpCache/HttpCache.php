<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This code is partially based on the Rack-Cache library by Ryan Tomayko,
 * which is released under the MIT license.
 * (based on commit 02d2b48d75bcb63cf1c0c7149c077ad256542801)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\HttpCache;

<<<<<<< HEAD
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\TerminableInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
=======
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\TerminableInterface;
>>>>>>> v2-test

/**
 * Cache provides HTTP caching.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class HttpCache implements HttpKernelInterface, TerminableInterface
{
    private $kernel;
    private $store;
    private $request;
    private $surrogate;
    private $surrogateCacheStrategy;
<<<<<<< HEAD
    private $options = array();
    private $traces = array();
=======
    private $options = [];
    private $traces = [];
>>>>>>> v2-test

    /**
     * Constructor.
     *
     * The available options are:
     *
<<<<<<< HEAD
     *   * debug:                 If true, the traces are added as a HTTP header to ease debugging
=======
     *   * debug                  If true, exceptions are thrown when things go wrong. Otherwise, the cache
     *                            will try to carry on and deliver a meaningful response.
     *
     *   * trace_level            May be one of 'none', 'short' and 'full'. For 'short', a concise trace of the
     *                            master request will be added as an HTTP header. 'full' will add traces for all
     *                            requests (including ESI subrequests). (default: 'full' if in debug; 'none' otherwise)
     *
     *   * trace_header           Header name to use for traces. (default: X-Symfony-Cache)
>>>>>>> v2-test
     *
     *   * default_ttl            The number of seconds that a cache entry should be considered
     *                            fresh when no explicit freshness information is provided in
     *                            a response. Explicit Cache-Control or Expires headers
     *                            override this value. (default: 0)
     *
     *   * private_headers        Set of request headers that trigger "private" cache-control behavior
     *                            on responses that don't explicitly state whether the response is
     *                            public or private via a Cache-Control directive. (default: Authorization and Cookie)
     *
     *   * allow_reload           Specifies whether the client can force a cache reload by including a
     *                            Cache-Control "no-cache" directive in the request. Set it to ``true``
     *                            for compliance with RFC 2616. (default: false)
     *
     *   * allow_revalidate       Specifies whether the client can force a cache revalidate by including
     *                            a Cache-Control "max-age=0" directive in the request. Set it to ``true``
     *                            for compliance with RFC 2616. (default: false)
     *
     *   * stale_while_revalidate Specifies the default number of seconds (the granularity is the second as the
     *                            Response TTL precision is a second) during which the cache can immediately return
     *                            a stale response while it revalidates it in the background (default: 2).
     *                            This setting is overridden by the stale-while-revalidate HTTP Cache-Control
     *                            extension (see RFC 5861).
     *
     *   * stale_if_error         Specifies the default number of seconds (the granularity is the second) during which
     *                            the cache can serve a stale response when an error is encountered (default: 60).
     *                            This setting is overridden by the stale-if-error HTTP Cache-Control extension
     *                            (see RFC 5861).
<<<<<<< HEAD
     *
     * @param HttpKernelInterface $kernel    An HttpKernelInterface instance
     * @param StoreInterface      $store     A Store instance
     * @param SurrogateInterface  $surrogate A SurrogateInterface instance
     * @param array               $options   An array of options
     */
    public function __construct(HttpKernelInterface $kernel, StoreInterface $store, SurrogateInterface $surrogate = null, array $options = array())
=======
     */
    public function __construct(HttpKernelInterface $kernel, StoreInterface $store, SurrogateInterface $surrogate = null, array $options = [])
>>>>>>> v2-test
    {
        $this->store = $store;
        $this->kernel = $kernel;
        $this->surrogate = $surrogate;

        // needed in case there is a fatal error because the backend is too slow to respond
<<<<<<< HEAD
        register_shutdown_function(array($this->store, 'cleanup'));

        $this->options = array_merge(array(
            'debug' => false,
            'default_ttl' => 0,
            'private_headers' => array('Authorization', 'Cookie'),
=======
        register_shutdown_function([$this->store, 'cleanup']);

        $this->options = array_merge([
            'debug' => false,
            'default_ttl' => 0,
            'private_headers' => ['Authorization', 'Cookie'],
>>>>>>> v2-test
            'allow_reload' => false,
            'allow_revalidate' => false,
            'stale_while_revalidate' => 2,
            'stale_if_error' => 60,
<<<<<<< HEAD
        ), $options);
=======
            'trace_level' => 'none',
            'trace_header' => 'X-Symfony-Cache',
        ], $options);

        if (!isset($options['trace_level'])) {
            $this->options['trace_level'] = $this->options['debug'] ? 'full' : 'none';
        }
>>>>>>> v2-test
    }

    /**
     * Gets the current store.
     *
<<<<<<< HEAD
     * @return StoreInterface $store A StoreInterface instance
=======
     * @return StoreInterface A StoreInterface instance
>>>>>>> v2-test
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * Returns an array of events that took place during processing of the last request.
     *
     * @return array An array of events
     */
    public function getTraces()
    {
        return $this->traces;
    }

<<<<<<< HEAD
=======
    private function addTraces(Response $response)
    {
        $traceString = null;

        if ('full' === $this->options['trace_level']) {
            $traceString = $this->getLog();
        }

        if ('short' === $this->options['trace_level'] && $masterId = array_key_first($this->traces)) {
            $traceString = implode('/', $this->traces[$masterId]);
        }

        if (null !== $traceString) {
            $response->headers->add([$this->options['trace_header'] => $traceString]);
        }
    }

>>>>>>> v2-test
    /**
     * Returns a log message for the events of the last request processing.
     *
     * @return string A log message
     */
    public function getLog()
    {
<<<<<<< HEAD
        $log = array();
=======
        $log = [];
>>>>>>> v2-test
        foreach ($this->traces as $request => $traces) {
            $log[] = sprintf('%s: %s', $request, implode(', ', $traces));
        }

        return implode('; ', $log);
    }

    /**
     * Gets the Request instance associated with the master request.
     *
     * @return Request A Request instance
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Gets the Kernel instance.
     *
     * @return HttpKernelInterface An HttpKernelInterface instance
     */
    public function getKernel()
    {
        return $this->kernel;
    }

    /**
     * Gets the Surrogate instance.
     *
     * @return SurrogateInterface A Surrogate instance
     *
     * @throws \LogicException
     */
    public function getSurrogate()
    {
<<<<<<< HEAD
        if (!$this->surrogate instanceof Esi) {
            throw new \LogicException('This instance of HttpCache was not set up to use ESI as surrogate handler. You must overwrite and use createSurrogate');
        }

=======
>>>>>>> v2-test
        return $this->surrogate;
    }

    /**
<<<<<<< HEAD
     * Gets the Esi instance.
     *
     * @return Esi An Esi instance
     *
     * @throws \LogicException
     *
     * @deprecated since version 2.6, to be removed in 3.0. Use getSurrogate() instead
     */
    public function getEsi()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 2.6 and will be removed in 3.0. Use the getSurrogate() method instead.', E_USER_DEPRECATED);

        return $this->getSurrogate();
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        // FIXME: catch exceptions and implement a 500 error page here? -> in Varnish, there is a built-in error page mechanism
        if (HttpKernelInterface::MASTER_REQUEST === $type) {
            $this->traces = array();
            $this->request = $request;
=======
     * {@inheritdoc}
     */
    public function handle(Request $request, int $type = HttpKernelInterface::MASTER_REQUEST, bool $catch = true)
    {
        // FIXME: catch exceptions and implement a 500 error page here? -> in Varnish, there is a built-in error page mechanism
        if (HttpKernelInterface::MASTER_REQUEST === $type) {
            $this->traces = [];
            // Keep a clone of the original request for surrogates so they can access it.
            // We must clone here to get a separate instance because the application will modify the request during
            // the application flow (we know it always does because we do ourselves by setting REMOTE_ADDR to 127.0.0.1
            // and adding the X-Forwarded-For header, see HttpCache::forward()).
            $this->request = clone $request;
>>>>>>> v2-test
            if (null !== $this->surrogate) {
                $this->surrogateCacheStrategy = $this->surrogate->createCacheStrategy();
            }
        }

<<<<<<< HEAD
        $path = $request->getPathInfo();
        if ($qs = $request->getQueryString()) {
            $path .= '?'.$qs;
        }
        $this->traces[$request->getMethod().' '.$path] = array();

        if (!$request->isMethodSafe()) {
            $response = $this->invalidate($request, $catch);
        } elseif ($request->headers->has('expect')) {
            $response = $this->pass($request, $catch);
=======
        $this->traces[$this->getTraceKey($request)] = [];

        if (!$request->isMethodSafe()) {
            $response = $this->invalidate($request, $catch);
        } elseif ($request->headers->has('expect') || !$request->isMethodCacheable()) {
            $response = $this->pass($request, $catch);
        } elseif ($this->options['allow_reload'] && $request->isNoCache()) {
            /*
                If allow_reload is configured and the client requests "Cache-Control: no-cache",
                reload the cache by fetching a fresh response and caching it (if possible).
            */
            $this->record($request, 'reload');
            $response = $this->fetch($request, $catch);
>>>>>>> v2-test
        } else {
            $response = $this->lookup($request, $catch);
        }

        $this->restoreResponseBody($request, $response);

<<<<<<< HEAD
        $response->setDate(\DateTime::createFromFormat('U', time(), new \DateTimeZone('UTC')));

        if (HttpKernelInterface::MASTER_REQUEST === $type && $this->options['debug']) {
            $response->headers->set('X-Symfony-Cache', $this->getLog());
=======
        if (HttpKernelInterface::MASTER_REQUEST === $type) {
            $this->addTraces($response);
>>>>>>> v2-test
        }

        if (null !== $this->surrogate) {
            if (HttpKernelInterface::MASTER_REQUEST === $type) {
                $this->surrogateCacheStrategy->update($response);
            } else {
                $this->surrogateCacheStrategy->add($response);
            }
        }

        $response->prepare($request);

        $response->isNotModified($request);

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function terminate(Request $request, Response $response)
    {
        if ($this->getKernel() instanceof TerminableInterface) {
            $this->getKernel()->terminate($request, $response);
        }
    }

    /**
     * Forwards the Request to the backend without storing the Response in the cache.
     *
<<<<<<< HEAD
     * @param Request $request A Request instance
     * @param bool    $catch   Whether to process exceptions
     *
     * @return Response A Response instance
     */
    protected function pass(Request $request, $catch = false)
=======
     * @param bool $catch Whether to process exceptions
     *
     * @return Response A Response instance
     */
    protected function pass(Request $request, bool $catch = false)
>>>>>>> v2-test
    {
        $this->record($request, 'pass');

        return $this->forward($request, $catch);
    }

    /**
     * Invalidates non-safe methods (like POST, PUT, and DELETE).
     *
<<<<<<< HEAD
     * @param Request $request A Request instance
     * @param bool    $catch   Whether to process exceptions
=======
     * @param bool $catch Whether to process exceptions
>>>>>>> v2-test
     *
     * @return Response A Response instance
     *
     * @throws \Exception
     *
     * @see RFC2616 13.10
     */
<<<<<<< HEAD
    protected function invalidate(Request $request, $catch = false)
=======
    protected function invalidate(Request $request, bool $catch = false)
>>>>>>> v2-test
    {
        $response = $this->pass($request, $catch);

        // invalidate only when the response is successful
        if ($response->isSuccessful() || $response->isRedirect()) {
            try {
                $this->store->invalidate($request);

                // As per the RFC, invalidate Location and Content-Location URLs if present
<<<<<<< HEAD
                foreach (array('Location', 'Content-Location') as $header) {
                    if ($uri = $response->headers->get($header)) {
                        $subRequest = Request::create($uri, 'get', array(), array(), array(), $request->server->all());
=======
                foreach (['Location', 'Content-Location'] as $header) {
                    if ($uri = $response->headers->get($header)) {
                        $subRequest = Request::create($uri, 'get', [], [], [], $request->server->all());
>>>>>>> v2-test

                        $this->store->invalidate($subRequest);
                    }
                }

                $this->record($request, 'invalidate');
            } catch (\Exception $e) {
                $this->record($request, 'invalidate-failed');

                if ($this->options['debug']) {
                    throw $e;
                }
            }
        }

        return $response;
    }

    /**
     * Lookups a Response from the cache for the given Request.
     *
     * When a matching cache entry is found and is fresh, it uses it as the
     * response without forwarding any request to the backend. When a matching
     * cache entry is found but is stale, it attempts to "validate" the entry with
     * the backend using conditional GET. When no matching cache entry is found,
     * it triggers "miss" processing.
     *
<<<<<<< HEAD
     * @param Request $request A Request instance
     * @param bool    $catch   whether to process exceptions
=======
     * @param bool $catch Whether to process exceptions
>>>>>>> v2-test
     *
     * @return Response A Response instance
     *
     * @throws \Exception
     */
<<<<<<< HEAD
    protected function lookup(Request $request, $catch = false)
    {
        // if allow_reload and no-cache Cache-Control, allow a cache reload
        if ($this->options['allow_reload'] && $request->isNoCache()) {
            $this->record($request, 'reload');

            return $this->fetch($request, $catch);
        }

=======
    protected function lookup(Request $request, bool $catch = false)
    {
>>>>>>> v2-test
        try {
            $entry = $this->store->lookup($request);
        } catch (\Exception $e) {
            $this->record($request, 'lookup-failed');

            if ($this->options['debug']) {
                throw $e;
            }

            return $this->pass($request, $catch);
        }

        if (null === $entry) {
            $this->record($request, 'miss');

            return $this->fetch($request, $catch);
        }

        if (!$this->isFreshEnough($request, $entry)) {
            $this->record($request, 'stale');

            return $this->validate($request, $entry, $catch);
        }

<<<<<<< HEAD
=======
        if ($entry->headers->hasCacheControlDirective('no-cache')) {
            return $this->validate($request, $entry, $catch);
        }

>>>>>>> v2-test
        $this->record($request, 'fresh');

        $entry->headers->set('Age', $entry->getAge());

        return $entry;
    }

    /**
     * Validates that a cache entry is fresh.
     *
     * The original request is used as a template for a conditional
     * GET request with the backend.
     *
<<<<<<< HEAD
     * @param Request  $request A Request instance
     * @param Response $entry   A Response instance to validate
     * @param bool     $catch   Whether to process exceptions
     *
     * @return Response A Response instance
     */
    protected function validate(Request $request, Response $entry, $catch = false)
=======
     * @param bool $catch Whether to process exceptions
     *
     * @return Response A Response instance
     */
    protected function validate(Request $request, Response $entry, bool $catch = false)
>>>>>>> v2-test
    {
        $subRequest = clone $request;

        // send no head requests because we want content
        if ('HEAD' === $request->getMethod()) {
            $subRequest->setMethod('GET');
        }

        // add our cached last-modified validator
<<<<<<< HEAD
        $subRequest->headers->set('if_modified_since', $entry->headers->get('Last-Modified'));
=======
        if ($entry->headers->has('Last-Modified')) {
            $subRequest->headers->set('if_modified_since', $entry->headers->get('Last-Modified'));
        }
>>>>>>> v2-test

        // Add our cached etag validator to the environment.
        // We keep the etags from the client to handle the case when the client
        // has a different private valid entry which is not cached here.
<<<<<<< HEAD
        $cachedEtags = $entry->getEtag() ? array($entry->getEtag()) : array();
=======
        $cachedEtags = $entry->getEtag() ? [$entry->getEtag()] : [];
>>>>>>> v2-test
        $requestEtags = $request->getETags();
        if ($etags = array_unique(array_merge($cachedEtags, $requestEtags))) {
            $subRequest->headers->set('if_none_match', implode(', ', $etags));
        }

        $response = $this->forward($subRequest, $catch, $entry);

        if (304 == $response->getStatusCode()) {
            $this->record($request, 'valid');

            // return the response and not the cache entry if the response is valid but not cached
            $etag = $response->getEtag();
<<<<<<< HEAD
            if ($etag && in_array($etag, $requestEtags) && !in_array($etag, $cachedEtags)) {
=======
            if ($etag && \in_array($etag, $requestEtags) && !\in_array($etag, $cachedEtags)) {
>>>>>>> v2-test
                return $response;
            }

            $entry = clone $entry;
            $entry->headers->remove('Date');

<<<<<<< HEAD
            foreach (array('Date', 'Expires', 'Cache-Control', 'ETag', 'Last-Modified') as $name) {
=======
            foreach (['Date', 'Expires', 'Cache-Control', 'ETag', 'Last-Modified'] as $name) {
>>>>>>> v2-test
                if ($response->headers->has($name)) {
                    $entry->headers->set($name, $response->headers->get($name));
                }
            }

            $response = $entry;
        } else {
            $this->record($request, 'invalid');
        }

        if ($response->isCacheable()) {
            $this->store($request, $response);
        }

        return $response;
    }

    /**
<<<<<<< HEAD
     * Forwards the Request to the backend and determines whether the response should be stored.
     *
     * This methods is triggered when the cache missed or a reload is required.
     *
     * @param Request $request A Request instance
     * @param bool    $catch   whether to process exceptions
     *
     * @return Response A Response instance
     */
    protected function fetch(Request $request, $catch = false)
=======
     * Unconditionally fetches a fresh response from the backend and
     * stores it in the cache if is cacheable.
     *
     * @param bool $catch Whether to process exceptions
     *
     * @return Response A Response instance
     */
    protected function fetch(Request $request, bool $catch = false)
>>>>>>> v2-test
    {
        $subRequest = clone $request;

        // send no head requests because we want content
        if ('HEAD' === $request->getMethod()) {
            $subRequest->setMethod('GET');
        }

        // avoid that the backend sends no content
        $subRequest->headers->remove('if_modified_since');
        $subRequest->headers->remove('if_none_match');

        $response = $this->forward($subRequest, $catch);

        if ($response->isCacheable()) {
            $this->store($request, $response);
        }

        return $response;
    }

    /**
     * Forwards the Request to the backend and returns the Response.
     *
<<<<<<< HEAD
     * @param Request  $request A Request instance
     * @param bool     $catch   Whether to catch exceptions or not
     * @param Response $entry   A Response instance (the stale entry if present, null otherwise)
     *
     * @return Response A Response instance
     */
    protected function forward(Request $request, $catch = false, Response $entry = null)
=======
     * All backend requests (cache passes, fetches, cache validations)
     * run through this method.
     *
     * @param bool          $catch Whether to catch exceptions or not
     * @param Response|null $entry A Response instance (the stale entry if present, null otherwise)
     *
     * @return Response A Response instance
     */
    protected function forward(Request $request, bool $catch = false, Response $entry = null)
>>>>>>> v2-test
    {
        if ($this->surrogate) {
            $this->surrogate->addSurrogateCapability($request);
        }

<<<<<<< HEAD
        // modify the X-Forwarded-For header if needed
        $forwardedFor = $request->headers->get('X-Forwarded-For');
        if ($forwardedFor) {
            $request->headers->set('X-Forwarded-For', $forwardedFor.', '.$request->server->get('REMOTE_ADDR'));
        } else {
            $request->headers->set('X-Forwarded-For', $request->server->get('REMOTE_ADDR'));
        }

        // fix the client IP address by setting it to 127.0.0.1 as HttpCache
        // is always called from the same process as the backend.
        $request->server->set('REMOTE_ADDR', '127.0.0.1');

        // make sure HttpCache is a trusted proxy
        if (!in_array('127.0.0.1', $trustedProxies = Request::getTrustedProxies())) {
            $trustedProxies[] = '127.0.0.1';
            Request::setTrustedProxies($trustedProxies);
        }

        // always a "master" request (as the real master request can be in cache)
        $response = $this->kernel->handle($request, HttpKernelInterface::MASTER_REQUEST, $catch);
        // FIXME: we probably need to also catch exceptions if raw === true

        // we don't implement the stale-if-error on Requests, which is nonetheless part of the RFC
        if (null !== $entry && in_array($response->getStatusCode(), array(500, 502, 503, 504))) {
=======
        // always a "master" request (as the real master request can be in cache)
        $response = SubRequestHandler::handle($this->kernel, $request, HttpKernelInterface::MASTER_REQUEST, $catch);

        /*
         * Support stale-if-error given on Responses or as a config option.
         * RFC 7234 summarizes in Section 4.2.4 (but also mentions with the individual
         * Cache-Control directives) that
         *
         *      A cache MUST NOT generate a stale response if it is prohibited by an
         *      explicit in-protocol directive (e.g., by a "no-store" or "no-cache"
         *      cache directive, a "must-revalidate" cache-response-directive, or an
         *      applicable "s-maxage" or "proxy-revalidate" cache-response-directive;
         *      see Section 5.2.2).
         *
         * https://tools.ietf.org/html/rfc7234#section-4.2.4
         *
         * We deviate from this in one detail, namely that we *do* serve entries in the
         * stale-if-error case even if they have a `s-maxage` Cache-Control directive.
         */
        if (null !== $entry
            && \in_array($response->getStatusCode(), [500, 502, 503, 504])
            && !$entry->headers->hasCacheControlDirective('no-cache')
            && !$entry->mustRevalidate()
        ) {
>>>>>>> v2-test
            if (null === $age = $entry->headers->getCacheControlDirective('stale-if-error')) {
                $age = $this->options['stale_if_error'];
            }

<<<<<<< HEAD
            if (abs($entry->getTtl()) < $age) {
=======
            /*
             * stale-if-error gives the (extra) time that the Response may be used *after* it has become stale.
             * So we compare the time the $entry has been sitting in the cache already with the
             * time it was fresh plus the allowed grace period.
             */
            if ($entry->getAge() <= $entry->getMaxAge() + $age) {
>>>>>>> v2-test
                $this->record($request, 'stale-if-error');

                return $entry;
            }
        }

<<<<<<< HEAD
=======
        /*
            RFC 7231 Sect. 7.1.1.2 says that a server that does not have a reasonably accurate
            clock MUST NOT send a "Date" header, although it MUST send one in most other cases
            except for 1xx or 5xx responses where it MAY do so.

            Anyway, a client that received a message without a "Date" header MUST add it.
        */
        if (!$response->headers->has('Date')) {
            $response->setDate(\DateTime::createFromFormat('U', time()));
        }

>>>>>>> v2-test
        $this->processResponseBody($request, $response);

        if ($this->isPrivateRequest($request) && !$response->headers->hasCacheControlDirective('public')) {
            $response->setPrivate();
        } elseif ($this->options['default_ttl'] > 0 && null === $response->getTtl() && !$response->headers->getCacheControlDirective('must-revalidate')) {
            $response->setTtl($this->options['default_ttl']);
        }

        return $response;
    }

    /**
     * Checks whether the cache entry is "fresh enough" to satisfy the Request.
     *
<<<<<<< HEAD
     * @param Request  $request A Request instance
     * @param Response $entry   A Response instance
     *
=======
>>>>>>> v2-test
     * @return bool true if the cache entry if fresh enough, false otherwise
     */
    protected function isFreshEnough(Request $request, Response $entry)
    {
        if (!$entry->isFresh()) {
            return $this->lock($request, $entry);
        }

        if ($this->options['allow_revalidate'] && null !== $maxAge = $request->headers->getCacheControlDirective('max-age')) {
            return $maxAge > 0 && $maxAge >= $entry->getAge();
        }

        return true;
    }

    /**
     * Locks a Request during the call to the backend.
     *
<<<<<<< HEAD
     * @param Request  $request A Request instance
     * @param Response $entry   A Response instance
     *
=======
>>>>>>> v2-test
     * @return bool true if the cache entry can be returned even if it is staled, false otherwise
     */
    protected function lock(Request $request, Response $entry)
    {
        // try to acquire a lock to call the backend
        $lock = $this->store->lock($request);

<<<<<<< HEAD
        // there is already another process calling the backend
        if (true !== $lock) {
            // check if we can serve the stale entry
            if (null === $age = $entry->headers->getCacheControlDirective('stale-while-revalidate')) {
                $age = $this->options['stale_while_revalidate'];
            }

            if (abs($entry->getTtl()) < $age) {
                $this->record($request, 'stale-while-revalidate');

                // server the stale response while there is a revalidation
                return true;
            }

            // wait for the lock to be released
            $wait = 0;
            while ($this->store->isLocked($request) && $wait < 5000000) {
                usleep(50000);
                $wait += 50000;
            }

            if ($wait < 5000000) {
                // replace the current entry with the fresh one
                $new = $this->lookup($request);
                $entry->headers = $new->headers;
                $entry->setContent($new->getContent());
                $entry->setStatusCode($new->getStatusCode());
                $entry->setProtocolVersion($new->getProtocolVersion());
                foreach ($new->headers->getCookies() as $cookie) {
                    $entry->headers->setCookie($cookie);
                }
            } else {
                // backend is slow as hell, send a 503 response (to avoid the dog pile effect)
                $entry->setStatusCode(503);
                $entry->setContent('503 Service Unavailable');
                $entry->headers->set('Retry-After', 10);
            }

            return true;
        }

        // we have the lock, call the backend
        return false;
=======
        if (true === $lock) {
            // we have the lock, call the backend
            return false;
        }

        // there is already another process calling the backend

        // May we serve a stale response?
        if ($this->mayServeStaleWhileRevalidate($entry)) {
            $this->record($request, 'stale-while-revalidate');

            return true;
        }

        // wait for the lock to be released
        if ($this->waitForLock($request)) {
            // replace the current entry with the fresh one
            $new = $this->lookup($request);
            $entry->headers = $new->headers;
            $entry->setContent($new->getContent());
            $entry->setStatusCode($new->getStatusCode());
            $entry->setProtocolVersion($new->getProtocolVersion());
            foreach ($new->headers->getCookies() as $cookie) {
                $entry->headers->setCookie($cookie);
            }
        } else {
            // backend is slow as hell, send a 503 response (to avoid the dog pile effect)
            $entry->setStatusCode(503);
            $entry->setContent('503 Service Unavailable');
            $entry->headers->set('Retry-After', 10);
        }

        return true;
>>>>>>> v2-test
    }

    /**
     * Writes the Response to the cache.
     *
<<<<<<< HEAD
     * @param Request  $request  A Request instance
     * @param Response $response A Response instance
     *
=======
>>>>>>> v2-test
     * @throws \Exception
     */
    protected function store(Request $request, Response $response)
    {
<<<<<<< HEAD
        if (!$response->headers->has('Date')) {
            $response->setDate(\DateTime::createFromFormat('U', time()));
        }
=======
>>>>>>> v2-test
        try {
            $this->store->write($request, $response);

            $this->record($request, 'store');

            $response->headers->set('Age', $response->getAge());
        } catch (\Exception $e) {
            $this->record($request, 'store-failed');

            if ($this->options['debug']) {
                throw $e;
            }
        }

        // now that the response is cached, release the lock
        $this->store->unlock($request);
    }

    /**
     * Restores the Response body.
<<<<<<< HEAD
     *
     * @param Request  $request  A Request instance
     * @param Response $response A Response instance
     */
    private function restoreResponseBody(Request $request, Response $response)
    {
        if ($request->isMethod('HEAD') || 304 === $response->getStatusCode()) {
            $response->setContent(null);
            $response->headers->remove('X-Body-Eval');
            $response->headers->remove('X-Body-File');

            return;
        }

=======
     */
    private function restoreResponseBody(Request $request, Response $response)
    {
>>>>>>> v2-test
        if ($response->headers->has('X-Body-Eval')) {
            ob_start();

            if ($response->headers->has('X-Body-File')) {
                include $response->headers->get('X-Body-File');
            } else {
                eval('; ?>'.$response->getContent().'<?php ;');
            }

            $response->setContent(ob_get_clean());
            $response->headers->remove('X-Body-Eval');
            if (!$response->headers->has('Transfer-Encoding')) {
<<<<<<< HEAD
                $response->headers->set('Content-Length', strlen($response->getContent()));
            }
        } elseif ($response->headers->has('X-Body-File')) {
            $response->setContent(file_get_contents($response->headers->get('X-Body-File')));
=======
                $response->headers->set('Content-Length', \strlen($response->getContent()));
            }
        } elseif ($response->headers->has('X-Body-File')) {
            // Response does not include possibly dynamic content (ESI, SSI), so we need
            // not handle the content for HEAD requests
            if (!$request->isMethod('HEAD')) {
                $response->setContent(file_get_contents($response->headers->get('X-Body-File')));
            }
>>>>>>> v2-test
        } else {
            return;
        }

        $response->headers->remove('X-Body-File');
    }

    protected function processResponseBody(Request $request, Response $response)
    {
        if (null !== $this->surrogate && $this->surrogate->needsParsing($response)) {
            $this->surrogate->process($request, $response);
        }
    }

    /**
     * Checks if the Request includes authorization or other sensitive information
     * that should cause the Response to be considered private by default.
<<<<<<< HEAD
     *
     * @param Request $request A Request instance
     *
     * @return bool true if the Request is private, false otherwise
     */
    private function isPrivateRequest(Request $request)
=======
     */
    private function isPrivateRequest(Request $request): bool
>>>>>>> v2-test
    {
        foreach ($this->options['private_headers'] as $key) {
            $key = strtolower(str_replace('HTTP_', '', $key));

            if ('cookie' === $key) {
<<<<<<< HEAD
                if (count($request->cookies->all())) {
=======
                if (\count($request->cookies->all())) {
>>>>>>> v2-test
                    return true;
                }
            } elseif ($request->headers->has($key)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Records that an event took place.
<<<<<<< HEAD
     *
     * @param Request $request A Request instance
     * @param string  $event   The event name
     */
    private function record(Request $request, $event)
=======
     */
    private function record(Request $request, string $event)
    {
        $this->traces[$this->getTraceKey($request)][] = $event;
    }

    /**
     * Calculates the key we use in the "trace" array for a given request.
     */
    private function getTraceKey(Request $request): string
>>>>>>> v2-test
    {
        $path = $request->getPathInfo();
        if ($qs = $request->getQueryString()) {
            $path .= '?'.$qs;
        }
<<<<<<< HEAD
        $this->traces[$request->getMethod().' '.$path][] = $event;
=======

        return $request->getMethod().' '.$path;
    }

    /**
     * Checks whether the given (cached) response may be served as "stale" when a revalidation
     * is currently in progress.
     */
    private function mayServeStaleWhileRevalidate(Response $entry): bool
    {
        $timeout = $entry->headers->getCacheControlDirective('stale-while-revalidate');

        if (null === $timeout) {
            $timeout = $this->options['stale_while_revalidate'];
        }

        return abs($entry->getTtl()) < $timeout;
    }

    /**
     * Waits for the store to release a locked entry.
     */
    private function waitForLock(Request $request): bool
    {
        $wait = 0;
        while ($this->store->isLocked($request) && $wait < 100) {
            usleep(50000);
            ++$wait;
        }

        return $wait < 100;
>>>>>>> v2-test
    }
}
