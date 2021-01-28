<?php

namespace Royalcms\Component\Url;

use Royalcms\Component\Url\Helpers\Arr;

class QueryParameterBag
{
    /** @var array */
    protected $parameters;

    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    public static function fromString($query = '')
    {
        if ($query === '') {
            return new static();
        }

        return new static(Arr::mapToAssoc(explode('&', $query), function ($keyValue) {
            $parts = explode('=', $keyValue, 2);

            return count($parts) === 2 ? $parts : [$parts[0], null];
        }));
    }

    public function get($key, $default = null)
    {
        return isset($this->parameters[$key]) ? $this->parameters[$key] : $default;
    }

    public function has($key)
    {
        return array_key_exists($key, $this->parameters);
    }

    public function set($key, $value)
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    public function remove($key)
    {
        unset($this->parameters[$key]);

        return $this;
    }

    public function all()
    {
        return $this->parameters;
    }

    public function __toString()
    {
        $keyValuePairs = Arr::map($this->parameters, function ($value, $key) {
            return "{$key}={$value}";
        });

        return implode('&', $keyValuePairs);
    }
}
