<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-01
 * Time: 18:20
 */

namespace Ecjia\System\Frameworks\SuperSearch;

use Royalcms\Component\Database\Eloquent\Builder;
use Royalcms\Component\Http\Request;
use Closure;

abstract class SuperSearch
{

    /**
     * @var \Royalcms\Component\Database\Eloquent\Model
     */
    protected $model;

    /**
     * @var static
     */
    protected static $instance;

    abstract public function __construct();

    public function apply(Request $filters, Closure $callback = null)
    {

        $query = $this->model->newQuery();
        $query = static::applyDecoratorsFromRequest($filters, $query);

        if ($callback instanceof Closure) {
            $callback($query);
        }

        // 返回搜索结果
        return $this->getResults($query);
    }

    public function applyCount(Request $filters, Closure $callback = null)
    {

        $filters->replace($filters->except('page'));

        $query = $this->model->newQuery();

        $query = static::applyDecoratorsFromRequest($filters, $query);

        if ($callback instanceof Closure) {
            $callback($query);
        }

        // 返回搜索结果
        return $this->getCount($query);
    }

    public function applyFirst(Request $filters, Closure $callback = null)
    {

        $filters->replace($filters->except('page'));

        $query = $this->model->newQuery();

        $query = static::applyDecoratorsFromRequest($filters, $query);

        if ($callback instanceof Closure) {
            $callback($query);
        }

        // 返回搜索结果
        return $this->getFirst($query);
    }

    /**
     * 获取条数
     * @param Builder | \Royalcms\Component\Database\Query\Builder $query
     * @return mixed
     */
    protected function getCount(Builder $query)
    {
        $key = $this->model->getTable() . '.' . $this->model->getKeyName();
        return $query->count($key);
    }

    /**
     * 获取条数
     * @param Builder $query
     * @return mixed
     */
    protected function getFirst(Builder $query)
    {
        return $query->first();
    }

    /**
     * 获取结果集
     * @param Builder $query
     * @return Builder[]|\Royalcms\Component\Database\Eloquent\Collection
     */
    protected function getResults(Builder $query)
    {
        return $query->get();
    }

    protected static function applyDecoratorsFromRequest(Request $request, Builder $query)
    {
        /**
         * @var $decorator FilterInterface
         */
        foreach ($request->all() as $filterName => $value) {
            $decorator = static::createFilterDecorator($filterName);

            if (static::isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }

        }

        return $query;
    }

    protected static function filterNamespace()
    {
        return __NAMESPACE__;
    }

    protected static function createFilterDecorator($name)
    {
        return static::filterNamespace() . '\\Filters\\' .
        str_replace(' ', '',
            ucwords(str_replace('_', ' ', $name)));
    }

    protected static function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }

    /**
     * 获取单例类
     * @return SuperSearch
     */
    public static function singleton()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

}