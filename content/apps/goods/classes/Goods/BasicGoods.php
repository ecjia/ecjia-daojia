<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/30
 * Time: 15:06
 */

namespace Ecjia\App\Goods\Goods;

use Ecjia\App\Goods\Models\GoodsModel;

/**
 * Class BasicGoods
 * 基本商品类
 *
 * @package Ecjia\App\Goods\Goods
 */
class BasicGoods
{

    protected $model;

    public function __construct(GoodsModel $model)
    {
        $this->model = $model;
    }


}