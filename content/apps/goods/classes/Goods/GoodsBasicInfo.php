<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
/**
 * 商品基本信息类
 */

namespace Ecjia\App\Goods\Goods;

use \Ecjia\App\Goods\Models\GoodsModel;

class GoodsBasicInfo
{

    protected $model;
    
    protected $goods_id;

    protected $store_id;

    public function __construct($goods_id, $store_id = 0)
    {
        $this->goods_id = $goods_id;

        $this->store_id = $store_id;
        
        $this->model = $this->goodsInfo();
    }
    
    /**
     * 获取商品信息
     */
    public function goodsInfo()
    {
    	if($this->store_id > 0) {
            $data = GoodsModel::where('goods_id', $this->goods_id)->where('store_id', $this->store_id)->orWhere('goods_sn', $this->goods_id)->first();
        } else {
            $data = GoodsModel::where('goods_id', $this->goods_id)->orWhere('goods_sn', $this->goods_id)->first();
        }
    	return $data;
    }

    /**
     * 商品相册
     * @return array
     */
    public function getGoodsGallery()
    {
    	$gallery = [];
    	if ($this->model->goods_gallery_collection) {
    		$disk = \RC_Filesystem::disk();
    		$gallery = $this->model->goods_gallery_collection->map(function ($item) use ($disk) {
    			if (!$disk->exists(\RC_Upload::upload_path($item['img_url'])) || empty($item['img_url'])) {
    				$item['format_img_url'] = \RC_Uri::admin_url('statics/images/nopic.png');
    			} else {
    				$item['format_img_url'] = \RC_Upload::upload_url($item['img_url']);
    			}
    	
    			if (!$disk->exists(\RC_Upload::upload_path($item['thumb_url'])) || empty($item['thumb_url'])) {
    				$item['format_thumb_url'] = \RC_Uri::admin_url('statics/images/nopic.png');
    			} else {
    				$item['format_thumb_url'] = \RC_Upload::upload_url($item['thumb_url']);
    			}
    			return $item;
    		});
    		$gallery = $gallery->toArray();
    	}
    	return $gallery;
    }
    
    /**
     * 商品的货品
     * @return array
     */
    public function goodsProducts()
    {
    	$product_list = [];
    	$disk = \RC_Filesystem::disk();
    	if ($this->model->products_collection) {
    		$goods = $this->model;
    		$time = \RC_Time::gmtime();
    		$product_list = $goods->products_collection->map(function ($item) use ($goods, $time, $disk) {
    			if (empty($item->product_name)) {
    				$item['product_name'] = $goods->goods_name;
    			}
    			//缩略图
    			$product_thumb = $item->product_thumb;
    			if (empty($product_thumb)) {
    				$product_thumb = $goods->goods_thumb;
    			} 
    			if (!$disk->exists(\RC_Upload::upload_path($item['product_thumb'])) || empty($product_thumb)) {
    				$item['format_product_thumb'] = \RC_Uri::admin_url('statics/images/nopic.png');
    			} else {
    				$item['format_product_thumb'] = \RC_Upload::upload_url($product_thumb);
    			}
    			//小图
    			$product_img = $item->product_img;
    			if (empty($product_img)) {
    				$product_img = $goods->goods_img;
    			}
    			if (!$disk->exists(\RC_Upload::upload_path($item['product_img'])) || empty($product_img)) {
    				$item['format_product_img'] = \RC_Uri::admin_url('statics/images/nopic.png');
    			} else {
    				$item['format_product_img'] = \RC_Upload::upload_url($product_img);
    			}
    			//原图
    			$product_original_img = $item->product_original_img;
    			if (empty($product_original_img)) {
    				$product_original_img = $goods->original_img;
    			}
    			if (!$disk->exists(\RC_Upload::upload_path($item['product_original_img'])) || empty($product_original_img)) {
    				$item['format_product_original_img'] = \RC_Uri::admin_url('statics/images/nopic.png');
    			} else {
    				$item['format_product_original_img'] = \RC_Upload::upload_url($product_original_img);
    			}
    			
    			$item['product_shop_price'] 			= $item->product_shop_price <= 0 ? $goods->shop_price : $item->product_shop_price;
    			$item['formatted_product_shop_price'] 	= $item->product_shop_price <= 0 ? ecjia_price_format($goods->shop_price, false) : ecjia_price_format($item->product_shop_price, false);
    			$item['product_attr_value'] = '';
    			$item['is_promote_now'] = 0 ;
    			if (($goods->promote_start_date <= $time && $goods->promote_end_date >= $time) && $item->is_promote == '1' && $item->promote_price > 0) {
    				$item['is_promote_now'] = 1;
    			}
    			if ($item->goods_attr) {
    				$goods_attr = explode('|', $item->goods_attr);
    				if ($goods->goods_attr_collection) {
    					$product_attr_value = $goods->goods_attr_collection->whereIn('goods_attr_id', $goods_attr)->sortBy('goods_attr_id')->lists('attr_value');
    					$product_attr_value = $product_attr_value->implode('/');
    					$item['product_attr_value'] = $product_attr_value;
    				}
    			}
    			return $item;
    		});
    		$product_list = $product_list->toArray();
    	}
    	return $product_list;
    }
    
    /**
     * 分组参数
     * @return array
     */
    public function getGoodsGroupParameter()
    {
    	$result = [];
    	$res 	= [];
    	if ($this->model->goods_type_parameter_model) {
    		$parameter_id = $this->model->goods_type_parameter_model->cat_id;
    	} else {
    		$parameter_id = 0;
    	}
    	$attr_group = $this->attrGroup();
    	
    	if (!empty($parameter_id)) {
    		if ($this->model->goods_attr_collection) {
				//参数分组
				if (!empty($attr_group)) {
					$pra_attr_ids = $this->model->goods_type_parameter_model->attribute_collection->lists('attr_id');
					$goods_attr_collection = $this->model->goods_attr_collection->whereIn('attr_id', $pra_attr_ids);
					$res = $goods_attr_collection->map(function ($item) use ($attr_group) {
						if ($item->attribute_model) {
								$parameter = collect($attr_group)->map(function ($val, $key) use ($item, $attr_group){
									if ($item->attribute_model->attr_group == $val) {
											$arr = array(
													'attr_group_id' 	=> $key,
													'attr_group_name'	=> $val,
													'values'			=> array(
																				'attr_id'	=>  $item->attr_id,
																				'attr_name' => 	$item->attribute_model->attr_name,
																				'attr_value'=> 	$item->attr_value,
																				'attr_type'	=> 	$item->attribute_model->attr_type,
																			)
											); 
											
											return $arr;
										}
								});
							
						}
						return $parameter;
					});
				}
    		}
    	}
    	
    	if ($res) {
    		$result = $this->handleGroupParameter($res->toArray());
    	}
    	
    	return $result;
    }
    
    /**
     * 商品未分组参数
     * @return
     */
    public function getGoodsCommonParameter()
    {
    	$result = [];
    	 
    	if ($this->model->goods_type_parameter_model) {
    		$parameter_id = $this->model->goods_type_parameter_model->cat_id;
    	}
    	$arr = [];
    	
    	if ($this->model->goods_attr_collection) {
    		$res = $this->model->goods_attr_collection->map(function ($item) use ($parameter_id) {
    			if ($item->attribute_model) {
    				if ($item->attribute_model->cat_id == $parameter_id || intval($item->attribute_model->attr_type) === 0) {
    					if ($item->attribute_model->attr_name && $item->attr_value) {
    						return [
    							'attr_id'	=> $item->attr_id,
	    						'name'     	=> $item->attribute_model->attr_name,
	    						'value'		=> $item->attr_value,
    						];

    					}
    				}
    			}
    		})->filter()->all();
    		$result = $this->formatAdminCommonPra($res);
    	}
    	return $result;
    }
    
    /**
     * 参数分组信息
     * @return array
     */
    public function attrGroup()
    {
    	$grp = [];
    	if (!empty($this->model->goods_type_parameter_model->attr_group)) {
    		$data = $this->model->goods_type_parameter_model->attr_group;
    		$grp = str_replace("\r", '', $data);
    		if ($grp) {
    			$grp =  explode("\n", $grp);
    		} 
    	}
    	return $grp;
    }
    
    /**
     * 获取商品规格参数
     */
    public function getGoodsSpecPra()
    {
    	$parameter 		= $this->getGoodsParameter();
    	$specification 	= $this->getGoodsSpecification();
    	 
    	return [$parameter, $specification];
    }
    
    /**
     * 商品参数
     * @return array
     */
    protected function getGoodsParameter()
    {
    	$result = [];
    	 
    	if ($this->model->goods_type_parameter_model) {
    		$parameter_id = $this->model->goods_type_parameter_model->cat_id;
    	}
    	$arr = [];
    	
    	if ($this->model->goods_attr_collection) {
    		$res = $this->model->goods_attr_collection->map(function ($item) use ($parameter_id) {
    			if ($item->attribute_model) {
    				if ($item->attribute_model->cat_id == $parameter_id || intval($item->attribute_model->attr_type) === 0) {
    					if ($item->attribute_model->attr_name && $item->attr_value) {
    						return [
    							'attr_id'	=> $item->attr_id,
	    						'name'     	=> $item->attribute_model->attr_name,
	    						'value'		=> $item->attr_value,
    						];

    					}
    				}
    			}
    		})->filter()->all();
    		$result = $this->formatPra($res);
    	}
    	return $result;
    }
    
    /**
     * 商品规格
     * @return array
     */
    protected function getGoodsSpecification()
    {
    	$result = [];
    	$specification_id = 0;
    	if ($this->model->goods_type_specification_model) {
    		$specification_id = $this->model->goods_type_specification_model->cat_id;
    	}
    	//商品未绑定规格模板，兼容老数据；看goods表的goods_type字段有没值
    	if (empty($specification_id)) {
    		if ($this->model->goods_type) {
    			$specification_id = $this->model->goods_type;
    		}
    	}
    	if (!empty($specification_id)) {
    		if ($this->model->goods_attr_collection) {
    			$result = $this->model->goods_attr_collection->map(function ($item) use ($specification_id) {
    				if ($item->attribute_model) {
    					if ($item->attribute_model->cat_id == $specification_id) {
    						return [
    						'goods_attr_id' => $item->goods_attr_id,
    						'attr_value'	=> $item->attr_value,
    						'attr_price'	=> $item->attr_price,
    						'attr_id'		=> $item->attribute_model->attr_id,
    						'attr_name'		=> $item->attribute_model->attr_name,
    						'attr_group'	=> $item->attribute_model->attr_group,
    						'is_linked'		=> $item->attribute_model->is_linked,
    						'attr_type'		=> $item->attribute_model->attr_type
    						];
    					}
    				}
    			});
    		}
    	}
    	if ($result) {
    		$result = $result->toArray();
    		$result = $this->formatSpec($result);
    	}
    	return $result;
    }
    
    /**
     * 商品规格处理
     * @param array $specification
     * @return array
     */
    protected function formatSpec($specification)
    {
    	$arr = [];
    	$spec = [];
    	
    	foreach ($specification as $row ) {
    		if ($row ['attr_type'] != 0) {
    			$arr [$row ['attr_id']] ['attr_type'] = $row ['attr_type'];
    			$arr [$row ['attr_id']] ['name'] = $row ['attr_name'];
    			$arr [$row ['attr_id']] ['value'] [] = array (
    					'label' => $row ['attr_value'],
    					'price' => $row ['attr_price'],
    					'format_price' => price_format ( abs ( $row ['attr_price'] ), false ),
    					'id' => $row ['goods_attr_id']
    			);
    		}
    
    	}
    	if (!empty($arr)) {
    		foreach ($arr as $key => $value) {
    			if (!empty($value['values'])) {
    				$value['value'] = $value['values'];
    				unset($value['values']);
    			}
    			$spec[] = $value;
    		}
    	}
    	return $spec;
    }
    
    /**
     * 参数分组处理
     * @param array $res
     * @return array
     */
    protected function handleGroupParameter ($res = [])
    {
    	$attr = [];
    	if (!empty($res)) {
    		$res = array_merge($res);
    		foreach ($res as $key => $val) {
    			if ($val) {
    				foreach ($val as $k => $v) {
    					$arr[] = $v;
    				}
    			}
    		}
    		$res  = collect($arr)->filter()->all();
    		$arr = [];
    		if ($res) {
    			foreach ($res as $row) {
    				if (!isset($arr[$row['attr_group_id']])) {
    					$arr[$row['attr_group_id']] = [
    						'attr_group_id' 	=> $row['attr_group_id'],
    						'attr_group_name'	=> $row['attr_group_name'],
    					];
    				}
    				$arr[$row['attr_group_id']]['values'][] = $row['values'];
    			}
    			if ($arr) {
    				foreach ($arr as $k => $attr) {
    					if ($attr['values']) {
    						$attr['values'] = $this->formatAttrValue($attr['values']);
    					}
    					$list[] = $attr;
    				}
    			}
    		}
    	}
    	return $list;
    }
    
    protected function formatPra($parameter)
    {
    	$arr = [];
    	$result = [];
    	if ($parameter) {
    		foreach ($parameter as $row) {
    			$arr[$row['attr_id']]['name'] = $row['name'];
    			$arr[$row['attr_id']]['value'] .= $row['value'].'/';
    		}
    		$arr = array_merge($arr);
    		foreach ($arr as $row) {
    			$result[] = [
    				'name' 		=>  $row['name'],
    				'value'		=> rtrim($row['value'], '/')
    			];
    		}
    	}
    	return $result;
    }
    
    protected function formatAdminCommonPra($parameter)
    {
    	$arr = [];
    	$result = [];
    	if ($parameter) {
    		foreach ($parameter as $row) {
    			$arr[$row['attr_id']]['name'] = $row['name'];
    			$arr[$row['attr_id']]['value'] .= $row['value'].'/';
    		}
    		$arr = array_merge($arr);
    		foreach ($arr as $row) {
    			$result[] = [
    				'attr_name' 		=>  $row['name'],
    				'attr_value'		=> rtrim($row['value'], '/')
    			];
    		}
    	}
    	return $result;
    }
    
    protected function formatAttrValue($attr)
    {
    	$arr = [];
    	$result = [];
    	
    	if ($attr) {
    		foreach ($attr as $row) {
    			if ($row['attr_value']) {
    				$arr[$row['attr_id']]['attr_name'] = $row['attr_name'];
    				if ($row['attr_type'] == '2') {
    					$arr[$row['attr_id']]['attr_value'] .= $row['attr_value'].'/';
    				} else {
    					$arr[$row['attr_id']]['attr_value'] = $row['attr_value'];
    				}
    			}
    		}
    		$arr = array_merge($arr);
    		if (!empty($arr)) {
    			foreach ($arr as $rows) {
    				$result[] = [
	    				'attr_name' 		=>  $rows['attr_name'],
	    				'attr_value'		=> rtrim($rows['attr_value'], '/')
    				];
    			}
    		}
    	}
    	return $result;
    }
}