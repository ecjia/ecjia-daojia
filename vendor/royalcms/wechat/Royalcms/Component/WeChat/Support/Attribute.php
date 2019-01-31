<?php namespace Royalcms\Component\WeChat\Support;

use Royalcms\Component\WeChat\Core\Exceptions\InvalidArgumentException;
use Royalcms\Component\Support\Collection as BaseCollection;
use Royalcms\Component\Support\Str;

/**
 * Class Attributes.
 */
abstract class Attribute extends BaseCollection
{
    /**
     * Attributes alias.
     *
     * @var array
     */
    protected $aliases = [];

    /**
     * Auto snake attribute name.
     *
     * @var bool
     */
    protected $snakeable = true;

    /**
     * Required attributes.
     *
     * @var array
     */
    protected $requirements = [];

    /**
     * Constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * Set attribute.
     *
     * @param string $attribute
     * @param string $value
     *
     * @return Attribute
     */
    public function setAttribute($attribute, $value)
    {
        $this->set($attribute, $value);

        return $this;
    }

    /**
     * Get attribute.
     *
     * @param string $attribute
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getAttribute($attribute, $default)
    {
        return $this->get($attribute, $default);
    }

    /**
     * Set attribute.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return Attribute
     *
     * @throws \Royalcms\Component\WeChat\Core\Exceptions\InvalidArgumentException
     */
    public function with($attribute, $value)
    {
        $this->snakeable && $attribute = Str::snake($attribute);

        if (!$this->validate($attribute, $value)) {
            throw new InvalidArgumentException("Invalid attribute '{$attribute}'.");
        }

        $this->set($attribute, $value);

        return $this;
    }

    /**
     * Attribute validation.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    protected function validate($attribute, $value)
    {
        return true;
    }

    /**
     * Override parent set() method.
     *
     * @param string $attribute
     * @param mixed  $value
     */
    public function set($attribute, $value = null)
    {
        parent::set($this->getRealKey($attribute), $value);
    }

    /**
     * Override parent get() method.
     *
     * @param string $attribute
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($attribute, $default = null)
    {
        return parent::get($this->getRealKey($attribute), $default);
    }

    /**
     * Magic call.
     *
     * @param string $method
     * @param array  $args
     *
     * @return Attribute
     */
    public function __call($method, $args)
    {
        if (stripos($method, 'with') === 0) {
            $method = substr($method, 4);
        }

        return $this->with($method, array_shift($args));
    }

    /**
     * Magic set.
     *
     * @param string $property
     * @param mixed  $value
     *
     * @return Attribute
     */
    public function __set($property, $value)
    {
        return $this->with($property, $value);
    }

    /**
     * Whether or not an data exists by key.
     *
     * @param string $key
     *
     * @return bool
     */
    public function __isset($key)
    {
        return parent::__isset($this->getRealKey($key));
    }

    /**
     * Return the raw name of attribute.
     *
     * @param string $key
     *
     * @return string
     */
    protected function getRealKey($key)
    {
        if (($alias = array_search($key, $this->aliases, true)) != false) {
            $key = $alias;
        }

        return $key;
    }

    /**
     * Check required attributes.
     *
     * @throws InvalidArgumentException
     */
    protected function checkRequiredAttributes()
    {
        foreach ($this->requirements as $attribute) {
            if (!isset($this->$attribute)) {
                throw new InvalidArgumentException(" '{$attribute}' cannot be empty.");
            }
        }
    }

    /**
     * Return all items.
     *
     * @return array
     *
     * @throws InvalidArgumentException
     */
    public function all()
    {
        $this->checkRequiredAttributes();

        return parent::all();
    }
}
