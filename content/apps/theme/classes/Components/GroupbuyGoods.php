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
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/7/23
 * Time: 11:56 AM
 */

namespace Ecjia\App\Theme\Components;


use Ecjia\App\Theme\ComponentAbstract;
use Ecjia\App\Goods\Models\GoodsActivityModel;
use RC_Time;
use RC_Upload;

class GroupbuyGoods extends ComponentAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'groupbuy_goods';

    /**
     * 名称
     * @var string
     */
    protected $name = '首页团购商品';

    /**
     * 描述
     * @var string
     */
    protected $description = '首页团购商品，最多支持10个。';

    /**
     * 缩略图
     * @var string
     */
    protected $thumb = '/statics/images/thumb/module_groupbuygoods.png'; //图片未添加


    /**
     * 预览显示使用的HTML
     */
    public function handlePriviewHtml()
    {
        $data = $this->queryData();

        return <<<HTML


HTML;
    }


    /**
     * API使用的数据格式
     */
    public function handleData()
    {
        $data = $this->queryData();

        return [
            'module' => $this->code,
            'title' => '',
            'data'  => $data,
        ];
    }


    protected function queryData()
    {
        $request 		= royalcms('request');
        $api_version	= $request->header('api-version');
        
        $location 	= $request->input('location', array());
        $city_id	= $request->input('city_id', 0);
        $city_id	= empty($city_id) ? 0 : $city_id;
        
        if (is_array($location) && isset($location['latitude']) && isset($location['longitude'])) {
        	$request                     = array('location' => $location);
        	$geohash                     = \RC_Loader::load_app_class('geohash', 'store');
        	$geohash_code                = $geohash->encode($location['latitude'] , $location['longitude']);
        	$store_id_group   			 = \RC_Api::api('store', 'neighbors_store_id', array('geohash' => $geohash_code, 'city_id' => $city_id));
        }
        
        if (empty($store_id_group)) {
        	$response['group_goods'] = array();
        	return $response;
        }
        
        if (version_compare($api_version, '1.18', '>=')) {
        	$store_id_arr = $store_id_group;
        	
        	$time = RC_Time::gmtime();
        	$query = GoodsActivityModel::with(['goods_model']);
        	$query->where('act_type', GAT_GROUP_BUY)->where('start_time', '<=', $time)->where('end_time', '>=', $time);
        	$query->whereHas('goods_model', function ($query) use ($store_id_arr) {
        		$query->where('is_delete', 0)->where('is_on_sale', 1)->where('is_alone_sale', 1);
        		if (is_array($store_id_arr) && !empty($store_id_arr)) {
        			$query->whereIn('store_id', $store_id_arr);
        		}
        		if (\ecjia::config('review_goods') == 1) {
        			$query->where('review_status', '>', 2);
        		}
        	});
        	
        	$res = $query->take(6)->orderBy('act_id', 'desc')->get();
        	$res = $res ? $res->toArray() : [];
        	
        	$group_goods_data = array();
        	if (!empty($res)) {
        		foreach ($res as $val) {
        			$val = $val['goods_model'] ? array_merge($val, $val['goods_model']) : $val;
         			$ext_info = unserialize($val['ext_info']);
        			$price_ladder = $ext_info['price_ladder'];
        			if (!is_array($price_ladder) || empty($price_ladder)) {
        				$price_ladder = array(array('amount' => 0, 'price' => 0));
        			} else {
        				foreach ($price_ladder AS $key => $amount_price) {
        					$price_ladder[$key]['formated_price'] = price_format($amount_price['price']);
        				}
        			}
        
        			$cur_price  = $price_ladder[0]['price'];    // 初始化
        			$group_goods_data[] = array(
        					'id'						=> $val['goods_id'],
        					'name'						=> $val['goods_name'],
        					'market_price'				=> $val['market_price'],
        					'formated_market_price'		=> price_format($val['market_price'], false),
        					'shop_price'				=> $val['market_price'],
        					'formated_shop_price'		=> price_format($val['market_price'], false),
        					'promote_price'				=> $cur_price,
        					'formated_promote_price'	=> price_format($cur_price, false),
        					'promote_start_date'		=> RC_Time::local_date('Y/m/d H:i:s', $val['start_time']),
        					'promote_end_date'			=> RC_Time::local_date('Y/m/d H:i:s', $val['end_time']),
        					'img'						=> array(
        							'small'	=> empty($val['goods_thumb']) ? '' : RC_Upload::upload_url($val['goods_thumb']),
        							'thumb'	=> empty($val['goods_img']) ? '' 	: RC_Upload::upload_url($val['goods_img']),
        							'url'	=> empty($val['original_img']) ? '' : RC_Upload::upload_url($val['original_img'])
        					),
        					'goods_activity_id'			=> $val['act_id'],
        					'activity_type'				=> 'GROUPBUY_GOODS'
        							);
        		}
        	}
        } else {
        	$group_goods_data = array();
        }
        
        return $group_goods_data;
    }


}