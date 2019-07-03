<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-02
 * Time: 15:38
 */

namespace Ecjia\App\Store\StoreSearch;


class StoreKeywords
{

    const WHERE_AND = 'AND';

    const WHERE_OR = 'OR';

    /**
     * @var array
     */
    protected $keyword = [];

    /**
     * @var string
     */

    protected $operator = self::WHERE_AND;

    /**
     * GoodsKeywords constructor.
     * @param $keyword
     */
    public function __construct($keyword)
    {
        if (is_array($keyword)) {
            $this->keyword = $keyword;
            $this->operator = self::WHERE_OR;
        }
        else {
            $this->keyword = $this->participle($keyword);
        }

    }

    /**
     * 搜索关键词简单分词技术
     * @param $keyword
     * @return array
     */
    protected function participle($keyword)
    {
        if (stristr($keyword, ' AND ') !== false) {
            /* 检查关键字中是否有AND，如果存在就是并 */
            $keywords = explode('AND', $keyword);
            $this->operator = self::WHERE_AND;
        }
        elseif (stristr($keyword, ' OR ') !== false) {
            /* 检查关键字中是否有OR，如果存在就是或 */
            $keywords = explode('OR', $keyword);
            $this->operator = self::WHERE_OR;
        }
        elseif (stristr($keyword, ' + ') !== false) {
            /* 检查关键字中是否有加号，如果存在就是并 */
            $keywords = explode('+', $keyword);
            $this->operator = self::WHERE_AND;
        }
        elseif (stristr($keyword, ' ') !== false) {
            /* 检查关键字中是否有空格，如果存在就是或 */
            $keywords = explode(' ', $keyword);
            $this->operator = self::WHERE_OR;
        }
        else {
            /* 检查关键字中是否有空格，如果存在就是并 */
            $keywords = (array) $keyword;
            $this->operator = self::WHERE_AND;
        }

        return $keywords;
    }

    public function buildQuery()
    {
        if ($this->operator == self::WHERE_OR) {

            $query = function ($query) {

                collect($this->keyword)->each(function($item, $key) use ($query) {

                    $item = trim($item);

                    $subQuery =  function ($query) use ($item) {
                        $query->where('merchants_name', 'like', "%{$item}%")
                            ->orWhere('goods_name', 'like', "%{$item}%");
                    };

                    if ($key === 0) {
                        $query->where($subQuery);
                    } else {
                        $query->orWhere($subQuery);
                    }

                });

                return $query;
            };

        }
        else {

            $query = function ($query) {

                collect($this->keyword)->each(function($item, $key) use ($query) {

                    $item = trim($item);

                    $subQuery =  function ($query) use ($item) {
                        $query->where('merchants_name', 'like', "%{$item}%")
                            ->orWhere('goods_name', 'like', "%{$item}%");
                    };

                    $query->where($subQuery);
                });

                return $query;
            };
        }

        return $query;
    }
}