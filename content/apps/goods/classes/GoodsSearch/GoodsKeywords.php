<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-02
 * Time: 15:38
 */

namespace Ecjia\App\Goods\GoodsSearch;


class GoodsKeywords
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
    protected $keyword_input;

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
            $this->keyword_input = implode(' ', $keyword);
        }
        else {
            $this->keyword = $this->participle($keyword);
            $this->keyword_input = $keyword;
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
		//搜索关键词记录
    	$this->saveSearchLog();
    	
        if ($this->operator == self::WHERE_OR) {

            $query = function ($query) {

                collect($this->keyword)->each(function($item, $key) use ($query) {

                    $item = trim($item);

                    $subQuery =  function ($query) use ($item) {
                        $query->where('goods_name', 'like', "%{$item}%")
                            ->orWhere('goods_sn', 'like', "%{$item}%")
                            ->orWhere('keywords', 'like', "%{$item}%")
                            ->orWhereHas('products_collection', function($query) use ($item) {
                            	$query->where('product_name', 'like', '%' . ecjia_mysql_like_quote($item) . '%');
                            });
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
                        $query->where('goods_name', 'like', "%{$item}%")
                            ->orWhere('goods_sn', 'like', "%{$item}%")
                            ->orWhere('keywords', 'like', "%{$item}%")
                            ->orWhereHas('products_collection', function($query) use ($item) {
                            	$query->where('product_name', 'like', '%' . ecjia_mysql_like_quote($item) . '%');
                            });
                    };

                    $query->where($subQuery);
                });

                return $query;
            };
        }

        return $query;
    }

    /**
     * 保存搜索日志
     */
    public function saveSearchLog()
    {
    	$count = \RC_DB::table('keywords')->where('date', \RC_Time::local_date('Y-m-d'))->where('searchengine', 'ecjia')->where('keyword', addslashes(str_replace('%', '', $this->keyword_input)))->pluck('count');
    		
    	if (!empty($count) && $count > 0) {
    		\RC_DB::table('keywords')->where('date', \RC_Time::local_date('Y-m-d'))->where('searchengine', 'ecjia')->where('keyword', addslashes(str_replace('%', '', $this->keyword_input)))->update(array('count' => $count + 1));
    	} else {
    		$data = array(
    				'date' => \RC_Time::local_date('Y-m-d'),
    				'searchengine' => 'ecjia',
    				'count'=> '1',
    				'keyword' => addslashes(str_replace('%', '', $this->keyword_input)));
    		\RC_DB::table('keywords')->insert($data);
    	}
    }

}