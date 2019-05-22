<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-26
 * Time: 14:45
 */

namespace Ecjia\App\Goods\Collections;


use Ecjia\App\Goods\GoodsSearch\GoodsSearch;
use Closure;
use Royalcms\Component\Http\Request;

class GoodsCountable
{

    protected $input = [];

    protected $request;

    public function __construct(array $input)
    {
        if (isset($input['page'])) {
            unset($input['page']);
        }

        $this->input = $input;

        $this->request = Request::create('', 'GET', $input);
    }

    public function getData(Closure $callback = null)
    {
        $model = GoodsSearch::singleton()->applyFirst($this->request, $callback);

        return collect($model->toArray());
    }

    public static function test()
    {
        $input = [
            'is_delete'		=> 0,
        ];

        $collection = (new static($input))->getData();

        return $collection;
    }

}