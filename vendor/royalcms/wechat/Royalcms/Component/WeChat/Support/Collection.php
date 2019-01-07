<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/3
 * Time: 15:48
 */

namespace Royalcms\Component\WeChat\Support;

use Royalcms\Component\Support\Collection as BaseCollection;

class Collection extends BaseCollection
{

    /**
     * Get a data by key.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

}