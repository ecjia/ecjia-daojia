<?php

namespace Royalcms\Component\Url;

use Royalcms\Component\Support\Traits\Macroable;
use Psr\Http\Message\UriInterface;
use Royalcms\Component\Url\Exceptions\InvalidArgument;

class Url implements UriInterface
{
    use Macroable;

    /** @var string */
    protected $scheme = '';

    /** @var string */
    protected $host = '';

    /** @var int|null */
    protected $port = null;

    /** @var string */
    protected $user = '';

    /** @var string|null */
    protected $password = null;

    /** @var string */
    protected $path = '';

    /** @var \Royalcms\Component\Url\QueryParameterBag */
    protected $query;

    /** @var string */
    protected $fragment = '';

    public static $VALID_SCHEMES = ['http', 'https', 'mailto'];

    public function __construct()
    {
        $this->query = new QueryParameterBag();
    }

    public static function create()
    {
        return new static();
    }

    public static function fromString($url)
    {
        $parts = array_merge(parse_url($url));

        $url = new static();
        $url->scheme = isset($parts['scheme']) ? $url->sanitizeScheme($parts['scheme']) : '';
        $url->host = isset($parts['host']) ? $parts['host'] : '';
        $url->port = isset($parts['port']) ? $parts['port'] : null;
        $url->user = isset($parts['user']) ? $parts['user'] : '';
        $url->password = isset($parts['pass']) ? $parts['pass'] : null;
        $url->path = isset($parts['path']) ? $parts['path'] : '/';
        $url->query = QueryParameterBag::fromString(isset($parts['query']) ? $parts['query'] : '');
        $url->fragment = isset($parts['fragment']) ? $parts['fragment'] : '';

        return $url;
    }

    public function getScheme()
    {
        return $this->scheme;
    }

    public function getAuthority()
    {
        $authority = $this->host;

        if ($this->getUserInfo()) {
            $authority = $this->getUserInfo().'@'.$authority;
        }

        if ($this->port !== null) {
            $authority .= ':'.$this->port;
        }

        return $authority;
    }

    public function getUserInfo()
    {
        $userInfo = $this->user;

        if ($this->password !== null) {
            $userInfo .= ':'.$this->password;
        }

        return $userInfo;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getBasename()
    {
        return $this->getSegment(-1);
    }

    public function getDirname()
    {
        $segments = $this->getSegments();

        array_pop($segments);

        return '/'.implode('/', $segments);
    }

    public function getQuery()
    {
        return (string) $this->query;
    }

    public function getQueryParameter($key, $default = null)
    {
        return $this->query->get($key, $default);
    }

    public function hasQueryParameter($key)
    {
        return $this->query->has($key);
    }

    /**
     * @return array
     */
    public function getAllQueryParameters()
    {
        return $this->query->all();
    }

    /**
     * @param string $key
     * @param string $value
     * @return Url
     */
    public function withQueryParameter($key, $value)
    {
        $url = clone $this;
        $url->query->remove($key);

        $url->query->set($key, $value);

        return $url;
    }

    /**
     * @param string $key
     * @return Url
     */
    public function withoutQueryParameter($key)
    {
        $url = clone $this;
        $url->query->remove($key);

        return $url;
    }

    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * @return array
     */
    public function getSegments()
    {
        return explode('/', trim($this->path, '/'));
    }

    /**
     * @param int $index
     * @param null $default
     * @return mixed|null
     */
    public function getSegment($index, $default = null)
    {
        $segments = $this->getSegments();

        if ($index === 0) {
            throw InvalidArgument::segmentZeroDoesNotExist();
        }

        if ($index < 0) {
            $segments = array_reverse($segments);
            $index = abs($index);
        }

        return isset($segments[$index - 1]) ? $segments[$index - 1] : $default;
    }

    public function getFirstSegment()
    {
        $segments = $this->getSegments();

        return isset($segments[0]) ? $segments[0] : null;
    }

    public function getLastSegment()
    {
        $segments = $this->getSegments();

        $end = end($segments);
        return isset($end) ? $end : null;
    }

    public function withScheme($scheme)
    {
        $url = clone $this;

        $url->scheme = $this->sanitizeScheme($scheme);

        return $url;
    }

    /**
     * @param string $scheme
     * @return string
     */
    protected function sanitizeScheme($scheme)
    {
        $scheme = strtolower($scheme);

        if (! in_array($scheme, static::$VALID_SCHEMES)) {
            throw InvalidArgument::invalidScheme($scheme);
        }

        return $scheme;
    }

    public function withUserInfo($user, $password = null)
    {
        $url = clone $this;

        $url->user = $user;
        $url->password = $password;

        return $url;
    }

    public function withHost($host)
    {
        $url = clone $this;

        $url->host = $host;

        return $url;
    }

    public function withPort($port)
    {
        $url = clone $this;

        $url->port = $port;

        return $url;
    }

    public function withPath($path)
    {
        $url = clone $this;

        if (strpos($path, '/') !== 0) {
            $path = '/'.$path;
        }

        $url->path = $path;

        return $url;
    }

    /**
     * @param string $dirname
     * @return UriInterface|Url
     */
    public function withDirname($dirname)
    {
        $dirname = trim($dirname, '/');

        if (! $this->getBasename()) {
            return $this->withPath($dirname);
        }

        return $this->withPath($dirname.'/'.$this->getBasename());
    }

    /**
     * @param string $basename
     * @return UriInterface|Url
     */
    public function withBasename($basename)
    {
        $basename = trim($basename, '/');

        if ($this->getDirname() === '/') {
            return $this->withPath('/'.$basename);
        }

        return $this->withPath($this->getDirname().'/'.$basename);
    }

    public function withQuery($query)
    {
        $url = clone $this;

        $url->query = QueryParameterBag::fromString($query);

        return $url;
    }

    public function withFragment($fragment)
    {
        $url = clone $this;

        $url->fragment = $fragment;

        return $url;
    }

    /**
     * @param self $url
     * @return bool
     */
    public function matches(self $url)
    {
        return (string) $this === (string) $url;
    }

    public function __toString()
    {
        $url = '';

        if ($this->getScheme() !== '' && $this->getScheme() != 'mailto') {
            $url .= $this->getScheme().'://';
        }

        if ($this->getScheme() === 'mailto' && $this->getPath() !== '') {
            $url .= $this->getScheme().':';
        }

        if ($this->getScheme() === '' && $this->getAuthority() !== '') {
            $url .= '//';
        }

        if ($this->getAuthority() !== '') {
            $url .= $this->getAuthority();
        }

        $url .= rtrim($this->getPath(), '/');

        if ($this->getQuery() !== '') {
            $url .= '?'.$this->getQuery();
        }

        if ($this->getFragment() !== '') {
            $url .= '#'.$this->getFragment();
        }

        return $url;
    }

    public function __clone()
    {
        $this->query = clone $this->query;
    }
}
