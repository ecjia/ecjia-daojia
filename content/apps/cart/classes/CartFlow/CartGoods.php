<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-19
 * Time: 18:30
 */

namespace Ecjia\App\Cart\CartFlow;


use Ecjia\App\Cart\Models\CartModel;
use ecjia_error;
use ecjia;
use RC_Upload;

class CartGoods
{

    /**
     * @var CartModel
     */
    protected $model;

    protected $output = [];

    public function __construct(CartModel $model)
    {
        $this->model = $model;

        /**
         * $this->model->goods 这是购物车商品的数据模型
         */
        
        /**
         * $this->model->store_franchisee 这是购物车店铺的数据模型
         */
    }


    public function formattedHandleData()
    {
        //初始状态
        $this->output['is_disabled'] = 0;
        $this->output['disabled_label'] = '';

        //判断库存
        $result = $this->checkGoodsStockNumber();
        if (is_ecjia_error($result)) {
            $this->output['is_disabled'] = 1;
            $this->output['disabled_label'] = $result->get_error_message();
        }

        //判断上架状态
        $result = $this->checkOnSaleStatus();
        if (is_ecjia_error($result)) {
            $this->output['is_disabled'] = 1;
            $this->output['disabled_label'] = $result->get_error_message();
        }
		
		//判断购物车商品所属店铺是否关闭
		$result = $this->checkStoreIsClose();
		if (is_ecjia_error($result)) {
			$this->output['is_disabled'] = 1;
			$this->output['disabled_label'] = $result->get_error_message();
		}
        
        //不可用状态，取消选中
        $this->checkSeletedStatus();

        //增加购物车选中状态判断,选中购物车商品总价

        /* 返回未格式化价格*/
        $this->output['rec_id']					= intval($this->model->rec_id);
        $this->output['goods_id']				= intval($this->model->goods_id);
        $this->output['goods_sn']				= trim($this->model->goods_sn);
        $this->output['goods_name'] 			= rc_stripslashes($this->model->goods_name);
        $this->output['goods_price'] 			= $this->model->goods_price;
        $this->output['market_price'] 			= $this->model->market_price;
        $this->output['formatted_goods_price'] 	= ecjia_price_format($this->model->goods_price, false);
        $this->output['formatted_market_price'] = ecjia_price_format($this->model->market_price, false);
        $this->output['goods_number']			= $this->model->goods_number;
        $this->output['subtotal'] 				= ($this->model->goods_price) * ($this->model->goods_number);
        $this->output['formatted_subtotal'] 	= ecjia_price_format($this->output['subtotal'], false);
        $this->output['is_checked'] 			= $this->model->is_checked;
        $this->output['is_shipping'] 			= $this->model->is_shipping;
        $this->output['img']					= array(
        											 'thumb' => empty($this->model->goods->goods_img) ? '' : RC_Upload::upload_url($this->model->goods->goods_img),
        											 'url'	 => empty($this->model->goods->original_img) ? '' : RC_Upload::upload_url($this->model->goods->original_img),
        											 'small' => empty($this->model->goods->goods_thumb) ? '' : RC_Upload::upload_url($this->model->goods->goods_thumb),
        										  );
        $this->output['attr'] 					= !empty($this->model->goods_attr) ? addslashes(str_replace('\n', '', $this->model->goods_attr)) : '';
        /* 统计实体商品和虚拟商品的个数 */


        /* 查询规格 */
        $this->getGoodsAttrs();
        $this->output['goods_attr'] 			=  $this->getGoodsAttrs();
        $this->output['goods_attr_id'] 			=  $this->model->goods_attr_id;
        /*货品属性库存判断*/
        $this->output['attr_number']			= $this->checkProductStock();
        

        return $this->output;
    }

    /**
     * 检查商品库存数量
     */
    protected function checkGoodsStockNumber()
    {
    	if ($this->model->goods->goods_number < $this->model->goods_number || $this->model->goods->goods_number < 1) {
    		return new ecjia_error('inventory_shortage', __('库存不足', 'cart'));
    	}
    }

    /**
     * 检测上架状态
     */
    protected function checkOnSaleStatus()
    {
    	if ($this->model->goods->is_on_sale == 0 || $this->model->goods->is_delete == '1') {
    		return new ecjia_error('goods_onsale_error', __('商品已下架', 'cart'));
    	}
    }
    
    /**
     * 检查店铺是否关闭
     */
    protected function checkStoreIsClose()
    {
    	if ($this->model->store_franchisee->shop_close != 0) {
    		return new ecjia_error('store_error', __('商品所属店铺已关闭', 'cart'));
    	}
    }

    /**
     * 检查商品选中状态;不可用状态，取消选中
     */
    protected function checkSeletedStatus()
    {
        if ($this->model->is_disabled === 1) {
            $this->output['is_checked'] = 0;
            //TODO，更新购物车已选中状态
			CartModel::where('rec_id', $this->model->rec_id)->update(array('is_checked' => 0));
        }
    }
    
    /**
     * 查询规格
     */
    protected function getGoodsAttrs()
    {
    	$goods_attrs = [];
    	/* 查询规格 */
    	if (!empty($this->model->goods_attr)) {
    		$goods_attr = explode("\n", $this->model->goods_attr);
    		$goods_attr = array_filter($goods_attr);
    		foreach ($goods_attr as $v) {
    			$a = explode(':', $v);
    			if (!empty($a[0]) && !empty($a[1])) {
    				$goods_attrs[] = array('name' => $a[0], 'value' => $a[1]);
    			}
    		}
    	}
    	
    	return $goods_attrs;
    }
    
    protected function checkProductStock()
    {
    	$attr_number = 1;
    	if (ecjia::config('use_storage') == 1) {
    		if($this->model->product_id) {
    			$product_info = $this->model->products->toArray();
    			if ($product_info &&  $this->model->goods_number > $product_info['product_number']) {
    				$attr_number = 0;
    			}
    		} else {
    			if($this->model->goods_number > $this->model->goods->goods_number) {
    				$attr_number = 0;
    			}
    		}
    	}
    	
    	return $attr_number;
    }

}