<?php

namespace Royalcms\Component\Routing;

use Closure;
use BadMethodCallException;
use Royalcms\Component\Support\Str;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class Controller extends \Illuminate\Routing\Controller
{

    /**
     * The "before" filters registered on the controller.
     *
     * @var array
     */
    protected $beforeFilters = [];

    /**
     * The "after" filters registered on the controller.
     *
     * @var array
     */
    protected $afterFilters = [];

    /**
     * The router instance.
     *
     * @var \Royalcms\Component\Routing\Router
     */
    protected static $router;


    /**
     * Register a "before" filter on the controller.
     *
     * @param  \Closure|string  $filter
     * @param  array  $options
     * @return void
     *
     * @deprecated since version 5.1.
     */
    public function beforeFilter($filter, array $options = [])
    {
        $this->beforeFilters[] = $this->parseFilter($filter, $options);
    }

    /**
     * Register an "after" filter on the controller.
     *
     * @param  \Closure|string  $filter
     * @param  array  $options
     * @return void
     *
     * @deprecated since version 5.1.
     */
    public function afterFilter($filter, array $options = [])
    {
        $this->afterFilters[] = $this->parseFilter($filter, $options);
    }

    /**
     * Parse the given filter and options.
     *
     * @param  \Closure|string  $filter
     * @param  array  $options
     * @return array
     */
    protected function parseFilter($filter, array $options)
    {
        $parameters = [];

        $original = $filter;

        if ($filter instanceof Closure) {
            $filter = $this->registerClosureFilter($filter);
        } elseif ($this->isInstanceFilter($filter)) {
            $filter = $this->registerInstanceFilter($filter);
        } else {
            list($filter, $parameters) = Route::parseFilter($filter);
        }

        return compact('original', 'filter', 'parameters', 'options');
    }

    /**
     * Register an anonymous controller filter Closure.
     *
     * @param  \Closure  $filter
     * @return string
     */
    protected function registerClosureFilter(Closure $filter)
    {
        $this->getRouter()->filter($name = spl_object_hash($filter), $filter);

        return $name;
    }

    /**
     * Register a controller instance method as a filter.
     *
     * @param  string  $filter
     * @return string
     */
    protected function registerInstanceFilter($filter)
    {
        $this->getRouter()->filter($filter, [$this, substr($filter, 1)]);

        return $filter;
    }

    /**
     * Determine if a filter is a local method on the controller.
     *
     * @param  mixed  $filter
     * @return bool
     *
     * @throws \InvalidArgumentException
     */
    protected function isInstanceFilter($filter)
    {
        if (is_string($filter) && Str::startsWith($filter, '@')) {
            if (method_exists($this, substr($filter, 1))) {
                return true;
            }

            throw new InvalidArgumentException("Filter method [$filter] does not exist.");
        }

        return false;
    }

    /**
     * Remove the given before filter.
     *
     * @param  string  $filter
     * @return void
     *
     * @deprecated since version 5.1.
     */
    public function forgetBeforeFilter($filter)
    {
        $this->beforeFilters = $this->removeFilter($filter, $this->getBeforeFilters());
    }

    /**
     * Remove the given after filter.
     *
     * @param  string  $filter
     * @return void
     *
     * @deprecated since version 5.1.
     */
    public function forgetAfterFilter($filter)
    {
        $this->afterFilters = $this->removeFilter($filter, $this->getAfterFilters());
    }

    /**
     * Remove the given controller filter from the provided filter array.
     *
     * @param  string  $removing
     * @param  array   $current
     * @return array
     */
    protected function removeFilter($removing, $current)
    {
        return array_filter($current, function ($filter) use ($removing) {
            return $filter['original'] != $removing;
        });
    }

    /**
     * Get the registered "before" filters.
     *
     * @return array
     *
     * @deprecated since version 5.1.
     */
    public function getBeforeFilters()
    {
        return $this->beforeFilters;
    }

    /**
     * Get the registered "after" filters.
     *
     * @return array
     *
     * @deprecated since version 5.1.
     */
    public function getAfterFilters()
    {
        return $this->afterFilters;
    }

    /**
     * Get the router instance.
     *
     * @return \Royalcms\Component\Routing\Router
     */
    public static function getRouter()
    {
        return static::$router;
    }

    /**
     * Set the router instance.
     *
     * @param  \Royalcms\Component\Routing\Router  $router
     * @return void
     */
    public static function setRouter(Router $router)
    {
        static::$router = $router;
    }

    /**
     * Handle calls to missing methods on the controller.
     *
     * @param  array   $parameters
     * @return mixed
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function missingMethod($parameters = [])
    {
        throw new NotFoundHttpException('Controller method not found.');
    }

}
