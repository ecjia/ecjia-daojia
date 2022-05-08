<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation;

/**
 * ResponseHeaderBag is a container for Response HTTP headers.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ResponseHeaderBag extends HeaderBag
{
<<<<<<< HEAD
    const COOKIES_FLAT = 'flat';
    const COOKIES_ARRAY = 'array';

    const DISPOSITION_ATTACHMENT = 'attachment';
    const DISPOSITION_INLINE = 'inline';

    /**
     * @var array
     */
    protected $computedCacheControl = array();

    /**
     * @var array
     */
    protected $cookies = array();

    /**
     * @var array
     */
    protected $headerNames = array();

    /**
     * Constructor.
     *
     * @param array $headers An array of HTTP headers
     */
    public function __construct(array $headers = array())
=======
    public const COOKIES_FLAT = 'flat';
    public const COOKIES_ARRAY = 'array';

    public const DISPOSITION_ATTACHMENT = 'attachment';
    public const DISPOSITION_INLINE = 'inline';

    protected $computedCacheControl = [];
    protected $cookies = [];
    protected $headerNames = [];

    public function __construct(array $headers = [])
>>>>>>> v2-test
    {
        parent::__construct($headers);

        if (!isset($this->headers['cache-control'])) {
            $this->set('Cache-Control', '');
        }
<<<<<<< HEAD
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $cookies = '';
        foreach ($this->getCookies() as $cookie) {
            $cookies .= 'Set-Cookie: '.$cookie."\r\n";
        }

        ksort($this->headerNames);

        return parent::__toString().$cookies;
=======

        /* RFC2616 - 14.18 says all Responses need to have a Date */
        if (!isset($this->headers['date'])) {
            $this->initDate();
        }
>>>>>>> v2-test
    }

    /**
     * Returns the headers, with original capitalizations.
     *
     * @return array An array of headers
     */
    public function allPreserveCase()
    {
<<<<<<< HEAD
        return array_combine($this->headerNames, $this->headers);
=======
        $headers = [];
        foreach ($this->all() as $name => $value) {
            $headers[$this->headerNames[$name] ?? $name] = $value;
        }

        return $headers;
    }

    public function allPreserveCaseWithoutCookies()
    {
        $headers = $this->allPreserveCase();
        if (isset($this->headerNames['set-cookie'])) {
            unset($headers[$this->headerNames['set-cookie']]);
        }

        return $headers;
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function replace(array $headers = array())
    {
        $this->headerNames = array();
=======
    public function replace(array $headers = [])
    {
        $this->headerNames = [];
>>>>>>> v2-test

        parent::replace($headers);

        if (!isset($this->headers['cache-control'])) {
            $this->set('Cache-Control', '');
        }
<<<<<<< HEAD
=======

        if (!isset($this->headers['date'])) {
            $this->initDate();
        }
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function set($key, $values, $replace = true)
    {
        parent::set($key, $values, $replace);

        $uniqueKey = str_replace('_', '-', strtolower($key));
        $this->headerNames[$uniqueKey] = $key;

        // ensure the cache-control header has sensible defaults
        if (in_array($uniqueKey, array('cache-control', 'etag', 'last-modified', 'expires'))) {
            $computed = $this->computeCacheControlValue();
            $this->headers['cache-control'] = array($computed);
=======
    public function all(string $key = null)
    {
        $headers = parent::all();

        if (null !== $key) {
            $key = strtr($key, self::UPPER, self::LOWER);

            return 'set-cookie' !== $key ? $headers[$key] ?? [] : array_map('strval', $this->getCookies());
        }

        foreach ($this->getCookies() as $cookie) {
            $headers['set-cookie'][] = (string) $cookie;
        }

        return $headers;
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $key, $values, bool $replace = true)
    {
        $uniqueKey = strtr($key, self::UPPER, self::LOWER);

        if ('set-cookie' === $uniqueKey) {
            if ($replace) {
                $this->cookies = [];
            }
            foreach ((array) $values as $cookie) {
                $this->setCookie(Cookie::fromString($cookie));
            }
            $this->headerNames[$uniqueKey] = $key;

            return;
        }

        $this->headerNames[$uniqueKey] = $key;

        parent::set($key, $values, $replace);

        // ensure the cache-control header has sensible defaults
        if (\in_array($uniqueKey, ['cache-control', 'etag', 'last-modified', 'expires'], true) && '' !== $computed = $this->computeCacheControlValue()) {
            $this->headers['cache-control'] = [$computed];
>>>>>>> v2-test
            $this->headerNames['cache-control'] = 'Cache-Control';
            $this->computedCacheControl = $this->parseCacheControl($computed);
        }
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function remove($key)
    {
        parent::remove($key);

        $uniqueKey = str_replace('_', '-', strtolower($key));
        unset($this->headerNames[$uniqueKey]);

        if ('cache-control' === $uniqueKey) {
            $this->computedCacheControl = array();
=======
    public function remove(string $key)
    {
        $uniqueKey = strtr($key, self::UPPER, self::LOWER);
        unset($this->headerNames[$uniqueKey]);

        if ('set-cookie' === $uniqueKey) {
            $this->cookies = [];

            return;
        }

        parent::remove($key);

        if ('cache-control' === $uniqueKey) {
            $this->computedCacheControl = [];
        }

        if ('date' === $uniqueKey) {
            $this->initDate();
>>>>>>> v2-test
        }
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function hasCacheControlDirective($key)
    {
        return array_key_exists($key, $this->computedCacheControl);
=======
    public function hasCacheControlDirective(string $key)
    {
        return \array_key_exists($key, $this->computedCacheControl);
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getCacheControlDirective($key)
    {
        return array_key_exists($key, $this->computedCacheControl) ? $this->computedCacheControl[$key] : null;
    }

    /**
     * Sets a cookie.
     *
     * @param Cookie $cookie
     */
    public function setCookie(Cookie $cookie)
    {
        $this->cookies[$cookie->getDomain()][$cookie->getPath()][$cookie->getName()] = $cookie;
=======
    public function getCacheControlDirective(string $key)
    {
        return \array_key_exists($key, $this->computedCacheControl) ? $this->computedCacheControl[$key] : null;
    }

    public function setCookie(Cookie $cookie)
    {
        $this->cookies[$cookie->getDomain()][$cookie->getPath()][$cookie->getName()] = $cookie;
        $this->headerNames['set-cookie'] = 'Set-Cookie';
>>>>>>> v2-test
    }

    /**
     * Removes a cookie from the array, but does not unset it in the browser.
<<<<<<< HEAD
     *
     * @param string $name
     * @param string $path
     * @param string $domain
     */
    public function removeCookie($name, $path = '/', $domain = null)
=======
     */
    public function removeCookie(string $name, ?string $path = '/', string $domain = null)
>>>>>>> v2-test
    {
        if (null === $path) {
            $path = '/';
        }

        unset($this->cookies[$domain][$path][$name]);

        if (empty($this->cookies[$domain][$path])) {
            unset($this->cookies[$domain][$path]);

            if (empty($this->cookies[$domain])) {
                unset($this->cookies[$domain]);
            }
        }
<<<<<<< HEAD
=======

        if (empty($this->cookies)) {
            unset($this->headerNames['set-cookie']);
        }
>>>>>>> v2-test
    }

    /**
     * Returns an array with all cookies.
     *
<<<<<<< HEAD
     * @param string $format
     *
     * @return array
     *
     * @throws \InvalidArgumentException When the $format is invalid
     */
    public function getCookies($format = self::COOKIES_FLAT)
    {
        if (!in_array($format, array(self::COOKIES_FLAT, self::COOKIES_ARRAY))) {
            throw new \InvalidArgumentException(sprintf('Format "%s" invalid (%s).', $format, implode(', ', array(self::COOKIES_FLAT, self::COOKIES_ARRAY))));
=======
     * @return Cookie[]
     *
     * @throws \InvalidArgumentException When the $format is invalid
     */
    public function getCookies(string $format = self::COOKIES_FLAT)
    {
        if (!\in_array($format, [self::COOKIES_FLAT, self::COOKIES_ARRAY])) {
            throw new \InvalidArgumentException(sprintf('Format "%s" invalid (%s).', $format, implode(', ', [self::COOKIES_FLAT, self::COOKIES_ARRAY])));
>>>>>>> v2-test
        }

        if (self::COOKIES_ARRAY === $format) {
            return $this->cookies;
        }

<<<<<<< HEAD
        $flattenedCookies = array();
=======
        $flattenedCookies = [];
>>>>>>> v2-test
        foreach ($this->cookies as $path) {
            foreach ($path as $cookies) {
                foreach ($cookies as $cookie) {
                    $flattenedCookies[] = $cookie;
                }
            }
        }

        return $flattenedCookies;
    }

    /**
     * Clears a cookie in the browser.
<<<<<<< HEAD
     *
     * @param string $name
     * @param string $path
     * @param string $domain
     * @param bool   $secure
     * @param bool   $httpOnly
     */
    public function clearCookie($name, $path = '/', $domain = null, $secure = false, $httpOnly = true)
    {
        $this->setCookie(new Cookie($name, null, 1, $path, $domain, $secure, $httpOnly));
    }

    /**
     * Generates a HTTP Content-Disposition field-value.
     *
     * @param string $disposition      One of "inline" or "attachment"
     * @param string $filename         A unicode string
     * @param string $filenameFallback A string containing only ASCII characters that
     *                                 is semantically equivalent to $filename. If the filename is already ASCII,
     *                                 it can be omitted, or just copied from $filename
     *
     * @return string A string suitable for use as a Content-Disposition field-value
     *
     * @throws \InvalidArgumentException
     *
     * @see RFC 6266
     */
    public function makeDisposition($disposition, $filename, $filenameFallback = '')
    {
        if (!in_array($disposition, array(self::DISPOSITION_ATTACHMENT, self::DISPOSITION_INLINE))) {
            throw new \InvalidArgumentException(sprintf('The disposition must be either "%s" or "%s".', self::DISPOSITION_ATTACHMENT, self::DISPOSITION_INLINE));
        }

        if ('' == $filenameFallback) {
            $filenameFallback = $filename;
        }

        // filenameFallback is not ASCII.
        if (!preg_match('/^[\x20-\x7e]*$/', $filenameFallback)) {
            throw new \InvalidArgumentException('The filename fallback must only contain ASCII characters.');
        }

        // percent characters aren't safe in fallback.
        if (false !== strpos($filenameFallback, '%')) {
            throw new \InvalidArgumentException('The filename fallback cannot contain the "%" character.');
        }

        // path separators aren't allowed in either.
        if (false !== strpos($filename, '/') || false !== strpos($filename, '\\') || false !== strpos($filenameFallback, '/') || false !== strpos($filenameFallback, '\\')) {
            throw new \InvalidArgumentException('The filename and the fallback cannot contain the "/" and "\\" characters.');
        }

        $output = sprintf('%s; filename="%s"', $disposition, str_replace('"', '\\"', $filenameFallback));

        if ($filename !== $filenameFallback) {
            $output .= sprintf("; filename*=utf-8''%s", rawurlencode($filename));
        }

        return $output;
=======
     */
    public function clearCookie(string $name, ?string $path = '/', string $domain = null, bool $secure = false, bool $httpOnly = true, string $sameSite = null)
    {
        $this->setCookie(new Cookie($name, null, 1, $path, $domain, $secure, $httpOnly, false, $sameSite));
    }

    /**
     * @see HeaderUtils::makeDisposition()
     */
    public function makeDisposition(string $disposition, string $filename, string $filenameFallback = '')
    {
        return HeaderUtils::makeDisposition($disposition, $filename, $filenameFallback);
>>>>>>> v2-test
    }

    /**
     * Returns the calculated value of the cache-control header.
     *
     * This considers several other headers and calculates or modifies the
     * cache-control header to a sensible, conservative value.
     *
     * @return string
     */
    protected function computeCacheControlValue()
    {
<<<<<<< HEAD
        if (!$this->cacheControl && !$this->has('ETag') && !$this->has('Last-Modified') && !$this->has('Expires')) {
            return 'no-cache';
        }

        if (!$this->cacheControl) {
            // conservative by default
            return 'private, must-revalidate';
=======
        if (!$this->cacheControl) {
            if ($this->has('Last-Modified') || $this->has('Expires')) {
                return 'private, must-revalidate'; // allows for heuristic expiration (RFC 7234 Section 4.2.2) in the case of "Last-Modified"
            }

            // conservative by default
            return 'no-cache, private';
>>>>>>> v2-test
        }

        $header = $this->getCacheControlHeader();
        if (isset($this->cacheControl['public']) || isset($this->cacheControl['private'])) {
            return $header;
        }

        // public if s-maxage is defined, private otherwise
        if (!isset($this->cacheControl['s-maxage'])) {
            return $header.', private';
        }

        return $header;
    }
<<<<<<< HEAD
=======

    private function initDate(): void
    {
        $this->set('Date', gmdate('D, d M Y H:i:s').' GMT');
    }
>>>>>>> v2-test
}
