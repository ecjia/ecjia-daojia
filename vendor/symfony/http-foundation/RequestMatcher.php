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
 * RequestMatcher compares a pre-defined set of checks against a Request instance.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class RequestMatcher implements RequestMatcherInterface
{
    /**
<<<<<<< HEAD
     * @var string
=======
     * @var string|null
>>>>>>> v2-test
     */
    private $path;

    /**
<<<<<<< HEAD
     * @var string
=======
     * @var string|null
>>>>>>> v2-test
     */
    private $host;

    /**
<<<<<<< HEAD
     * @var array
     */
    private $methods = array();

    /**
     * @var string
     */
    private $ips = array();
=======
     * @var int|null
     */
    private $port;

    /**
     * @var string[]
     */
    private $methods = [];

    /**
     * @var string[]
     */
    private $ips = [];
>>>>>>> v2-test

    /**
     * @var array
     */
<<<<<<< HEAD
    private $attributes = array();
=======
    private $attributes = [];
>>>>>>> v2-test

    /**
     * @var string[]
     */
<<<<<<< HEAD
    private $schemes = array();

    /**
     * @param string|null          $path
     * @param string|null          $host
     * @param string|string[]|null $methods
     * @param string|string[]|null $ips
     * @param array                $attributes
     * @param string|string[]|null $schemes
     */
    public function __construct($path = null, $host = null, $methods = null, $ips = null, array $attributes = array(), $schemes = null)
=======
    private $schemes = [];

    /**
     * @param string|string[]|null $methods
     * @param string|string[]|null $ips
     * @param string|string[]|null $schemes
     */
    public function __construct(string $path = null, string $host = null, $methods = null, $ips = null, array $attributes = [], $schemes = null, int $port = null)
>>>>>>> v2-test
    {
        $this->matchPath($path);
        $this->matchHost($host);
        $this->matchMethod($methods);
        $this->matchIps($ips);
        $this->matchScheme($schemes);
<<<<<<< HEAD
=======
        $this->matchPort($port);
>>>>>>> v2-test

        foreach ($attributes as $k => $v) {
            $this->matchAttribute($k, $v);
        }
    }

    /**
     * Adds a check for the HTTP scheme.
     *
     * @param string|string[]|null $scheme An HTTP scheme or an array of HTTP schemes
     */
    public function matchScheme($scheme)
    {
<<<<<<< HEAD
        $this->schemes = array_map('strtolower', (array) $scheme);
=======
        $this->schemes = null !== $scheme ? array_map('strtolower', (array) $scheme) : [];
>>>>>>> v2-test
    }

    /**
     * Adds a check for the URL host name.
<<<<<<< HEAD
     *
     * @param string $regexp A Regexp
     */
    public function matchHost($regexp)
=======
     */
    public function matchHost(?string $regexp)
>>>>>>> v2-test
    {
        $this->host = $regexp;
    }

    /**
<<<<<<< HEAD
     * Adds a check for the URL path info.
     *
     * @param string $regexp A Regexp
     */
    public function matchPath($regexp)
=======
     * Adds a check for the the URL port.
     *
     * @param int|null $port The port number to connect to
     */
    public function matchPort(?int $port)
    {
        $this->port = $port;
    }

    /**
     * Adds a check for the URL path info.
     */
    public function matchPath(?string $regexp)
>>>>>>> v2-test
    {
        $this->path = $regexp;
    }

    /**
     * Adds a check for the client IP.
     *
     * @param string $ip A specific IP address or a range specified using IP/netmask like 192.168.1.0/24
     */
<<<<<<< HEAD
    public function matchIp($ip)
=======
    public function matchIp(string $ip)
>>>>>>> v2-test
    {
        $this->matchIps($ip);
    }

    /**
     * Adds a check for the client IP.
     *
<<<<<<< HEAD
     * @param string|string[] $ips A specific IP address or a range specified using IP/netmask like 192.168.1.0/24
     */
    public function matchIps($ips)
    {
        $this->ips = (array) $ips;
=======
     * @param string|string[]|null $ips A specific IP address or a range specified using IP/netmask like 192.168.1.0/24
     */
    public function matchIps($ips)
    {
        $ips = null !== $ips ? (array) $ips : [];

        $this->ips = array_reduce($ips, static function (array $ips, string $ip) {
            return array_merge($ips, preg_split('/\s*,\s*/', $ip));
        }, []);
>>>>>>> v2-test
    }

    /**
     * Adds a check for the HTTP method.
     *
<<<<<<< HEAD
     * @param string|string[] $method An HTTP method or an array of HTTP methods
     */
    public function matchMethod($method)
    {
        $this->methods = array_map('strtoupper', (array) $method);
=======
     * @param string|string[]|null $method An HTTP method or an array of HTTP methods
     */
    public function matchMethod($method)
    {
        $this->methods = null !== $method ? array_map('strtoupper', (array) $method) : [];
>>>>>>> v2-test
    }

    /**
     * Adds a check for request attribute.
<<<<<<< HEAD
     *
     * @param string $key    The request attribute name
     * @param string $regexp A Regexp
     */
    public function matchAttribute($key, $regexp)
=======
     */
    public function matchAttribute(string $key, string $regexp)
>>>>>>> v2-test
    {
        $this->attributes[$key] = $regexp;
    }

    /**
     * {@inheritdoc}
     */
    public function matches(Request $request)
    {
<<<<<<< HEAD
        if ($this->schemes && !in_array($request->getScheme(), $this->schemes)) {
            return false;
        }

        if ($this->methods && !in_array($request->getMethod(), $this->methods)) {
=======
        if ($this->schemes && !\in_array($request->getScheme(), $this->schemes, true)) {
            return false;
        }

        if ($this->methods && !\in_array($request->getMethod(), $this->methods, true)) {
>>>>>>> v2-test
            return false;
        }

        foreach ($this->attributes as $key => $pattern) {
            if (!preg_match('{'.$pattern.'}', $request->attributes->get($key))) {
                return false;
            }
        }

        if (null !== $this->path && !preg_match('{'.$this->path.'}', rawurldecode($request->getPathInfo()))) {
            return false;
        }

        if (null !== $this->host && !preg_match('{'.$this->host.'}i', $request->getHost())) {
            return false;
        }

<<<<<<< HEAD
=======
        if (null !== $this->port && 0 < $this->port && $request->getPort() !== $this->port) {
            return false;
        }

>>>>>>> v2-test
        if (IpUtils::checkIp($request->getClientIp(), $this->ips)) {
            return true;
        }

        // Note to future implementors: add additional checks above the
        // foreach above or else your check might not be run!
<<<<<<< HEAD
        return count($this->ips) === 0;
=======
        return 0 === \count($this->ips);
>>>>>>> v2-test
    }
}
