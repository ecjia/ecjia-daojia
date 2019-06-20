<?php


namespace Ecjia\App\Cart\Cart;


use ecjia_error;
use Royalcms\Component\Model\Model;

class AddCart
{
    /**
     * @var Model
     */
    protected $goods;

    public function __construct(Model $goods)
    {
        $this->goods = $goods;
    }


    public function add()
    {
        //检查商品
        $result = $this->checkBuyGoods();
        if (is_ecjia_error($result)) {
            return $result;
        }

        //计算商品促销价格


        //初始化插入购物车数据


        //插入配件商品






    }

    /**
     * 检查购买商品是否满足条件
     */
    public function checkBuyGoods()
    {
        //1.检查商品是否存在
        $this->checkGoodsExists();

        //2.检查商品是否已经下架
        $this->checkGoodsOnSale();

        //3.检查商品所属的店铺是否已经下线
        $this->checkGoodsForStoreOffline();

        //4.检查商品是否只能作为配件购买，不能单独销售
        $this->checkGoodsNotAloneSale();

        //5.检查商品是否有货品
        $this->checkGoodsHasProduct();

        //6.检查商品或货品的库存是否满足
        $this->checkLowStocks();


    }

    /**
     * 1.检查商品是否存在
     */
    protected function checkGoodsExists()
    {



    }


    protected function checkGoodsOnSale()
    {
        if ($this->goods['is_on_sale'] === 0) {
            return new ecjia_error('goods_out_of_stock', __('对不起，该商品已下架！', 'cart'));
        }

        return true;
    }


    protected function checkGoodsForStoreOffline()
    {

    }

    protected function checkGoodsNotAloneSale()
    {

    }

    protected function checkGoodsHasProduct()
    {

    }

    protected function checkLowStocks()
    {

    }

}