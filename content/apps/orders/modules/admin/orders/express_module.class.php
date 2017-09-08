<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 获取订单物流信息
 * @author will
 *
 */
class express_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
		if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
    	$result = $this->admin_priv('order_view');
        if (is_ecjia_error($result)) {
			return $result;
		}
		
		$order_id = $this->requestData('order_id');
		if (empty($order_id)) {
			//EM_Api::outPut(101);
			return new ecjia_error( 'invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
		}
		
		if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
			$ru_id_group = RC_Model::model('orders/order_info_model')->where(array('order_id' => $order_id))->group('store_id')->get_field('store_id', true);
			if (count($ru_id_group) > 1 || $ru_id_group[0] != $_SESSION['store_id']) {
				return new ecjia_error('no_authority', '对不起，您没权限查看此订单相关信息！');
			}
		}
		
		$delivery_result = RC_Model::model('orders/delivery_order_model')->where(array('order_id' => $order_id))->select();
		RC_Logger::getlogger('info')->info($order_id);
		RC_Logger::getlogger('info')->info($delivery_result);
		
		$delivery_list = array();
		if (!empty($delivery_result)) {
			$delivery_goods_db = RC_Model::model('orders/delivery_viewmodel');
			$delivery_goods_db->view = array(
					'goods' => array(
							'type'  => Component_Model_View::TYPE_LEFT_JOIN,
							'alias' => 'g',
							'on'    => 'dg.goods_id = g.goods_id',
					),
			);
			foreach ($delivery_result as $val) {
				$shipping_info = RC_DB::table('shipping')
				->where('shipping_id', $val['shipping_id'])
				->first();
				if ($shipping_info['shipping_code'] == 'ship_o2o_express') {
					$delivery_list1 = array();
					if (!empty($val['invoice_no'])){
						$delivery_list1 = RC_DB::table('express_track_record as etr')
							->leftJoin('shipping as s', RC_DB::raw('s.shipping_code'), '=', RC_DB::raw('etr.express_code'))
							->where(RC_DB::raw('express_code'), $shipping_info['shipping_code'])
							->where(RC_DB::raw('track_number'), $val['invoice_no'])
							->selectRaw('etr.track_number, etr.time, etr.context, s.shipping_code, s.shipping_name')->get();
						/*商品*/
						$delivery_goods = $delivery_goods_db->where(array('delivery_id' => $val['delivery_id']))->select();
							
						$goods_lists = array();
						foreach ($delivery_goods as $v) {
							$goods_lists[] = array(
									'id'	=> $v['goods_id'],
									'name'	=> $v['goods_name'],
									'goods_sn'	 => $v['goods_sn'],
									'number'	 => $v['send_number'],
									'img'	=> array(
											'thumb'	=> (isset($v['goods_img']) && !empty($v['goods_img']))		 ? RC_Upload::upload_url($v['goods_img'])	  : RC_Uri::admin_url('statics/images/nopic.png'),
											'url'	=> (isset($v['original_img']) && !empty($v['original_img'])) ? RC_Upload::upload_url($v['original_img'])  : RC_Uri::admin_url('statics/images/nopic.png'),
											'small'	=> (isset($v['goods_thumb']) && !empty($v['goods_thumb']))   ? RC_Upload::upload_url($v['goods_thumb'])   : RC_Uri::admin_url('statics/images/nopic.png')
									),
							);
						}
						
						foreach ($delivery_list1 as $k1 => $v1) {
							$delivery_list[] = array(
									'shipping_name' 		=> $v1['shipping_name'],
									'shipping_code' 		=> $v1['shipping_code'],
									'shipping_number' 		=> $v1['track_number'],
									'shipping_status'		=> '',
									'label_shipping_status'	=> '',
									'sign_time_formated' 	=> $v1['time'],
									'content'				=> array('time' => $v1['time'], 'context' => $v1['context']),
									'goods_items'			=> $goods_lists
							);
						}
					}
				} else {
					$data = array();
					$typeCom = getComType($val['shipping_name']);//快递公司类型
					// 				$typeCom = getComType('天天');//快递公司类型
					if (!empty($typeCom) && !empty($val['invoice_no'])) {
						// 					$val['invoice_no'] = '667296821017';
					
						$cloud_express_key = ecjia::config('cloud_express_key');
						$cloud_express_secret = ecjia::config('cloud_express_secret');
						if (!empty($cloud_express_key) && !empty($cloud_express_secret)) {
							$params = array(
									'app_key' => $cloud_express_key,
									'app_secret' => $cloud_express_secret,
									'company' => $typeCom,
									'number' => $val['invoice_no'],
									'order' => 'desc',
							);
							$cloud = ecjia_cloud::instance()->api('express/track')->data($params)->run();
					
							if (is_ecjia_error($cloud->getError())) {
								$data = array('content' => array('time' => 'error', 'context' => $cloud->getError()->get_error_message()));
							} else {
								$data = $cloud->getReturnData();
							}
						} else {
							$data = array('content' => array('time' => 'error', 'context' => '物流跟踪未配置'));
						}
					}
					
					$delivery_goods = $delivery_goods_db->where(array('delivery_id' => $val['delivery_id']))->select();
					
					$goods_lists = array();
					foreach ($delivery_goods as $v) {
						$goods_lists[] = array(
								'id'	=> $v['goods_id'],
								'name'	=> $v['goods_name'],
								'goods_sn'	 => $v['goods_sn'],
								'number'	 => $v['send_number'],
								'img'	=> array(
										'thumb'	=> (isset($v['goods_img']) && !empty($v['goods_img']))		 ? RC_Upload::upload_url($v['goods_img'])	  : RC_Uri::admin_url('statics/images/nopic.png'),
										'url'	=> (isset($v['original_img']) && !empty($v['original_img'])) ? RC_Upload::upload_url($v['original_img'])  : RC_Uri::admin_url('statics/images/nopic.png'),
										'small'	=> (isset($v['goods_thumb']) && !empty($v['goods_thumb']))   ? RC_Upload::upload_url($v['goods_thumb'])   : RC_Uri::admin_url('statics/images/nopic.png')
								),
						);
					}
					
					$delivery_list[] = array(
							'shipping_name'		=> $val['shipping_name'],
							'shipping_code'     => $shipping_info['shipping_code'],
							'shipping_number'	=> $val['invoice_no'],
							'shipping_status' => !empty($data['shipping_status']) ? $data['shipping_status'] : '',
							'label_shipping_status' => $shipping_info['shipping_code'] == 'ship_no_express' ? '您当前选择的物流为【无需物流】，因此该订单暂无运单编号和物流状态' : (!empty($data['state_label']) ? $data['state_label'] : ''),
							'sign_time_formated' => !empty($data['sign_time_formated']) ? $data['sign_time_formated'] : '',
							'content'			=> !empty($data['content']) ? $data['content'] : array('time' => 'error', 'context' => '暂无物流信息'),
							'goods_items'		=> $goods_lists,
					);
				}
			
				
			}
		}
		return $delivery_list;
	}
	
	
}

// 				0：在途，即货物处于运输过程中；
// 				1：揽件，货物已由快递公司揽收并且产生了第一条跟踪信息；
// 				2：疑难，货物寄送过程出了问题；
// 				3：签收，收件人已签收；
// 				4：退签，即货物由于用户拒签、超区等原因退回，而且发件人已经签收；
// 				5：派件，即快递正在进行同城派件；
// 				6：退回，货物正处于退回发件人的途中；
	
/* if (isset($data['state'])) {
 switch ($data['state']) {
 case 0 :
 $label_shipping_status = '即货物处于运输过程中';
 break;
 case 1 :
 $label_shipping_status = '货物已由快递公司揽收并且产生了第一条跟踪信息';
 break;
 case 2 :
 $label_shipping_status = '货物寄送过程出了问题';
 break;
 case 3 :
 $label_shipping_status = '收件人已签收';
 break;
 case 4 :
 $label_shipping_status = '即货物由于用户拒签、超区等原因退回，而且发件人已经签收';
 break;
 case 5 :
 $label_shipping_status = '即快递正在进行同城派件';
 break;
 case 6 :
 $label_shipping_status = '货物正处于退回发件人的途中';
 break;
 default:
 $label_shipping_status = '暂无配送信息';
 break;
 }
 } else {
 $label_shipping_status = '暂无配送信息';
 } */


function getComType($typeCom)
{
	if ($typeCom == 'AAE全球专递') {
		$typeCom = 'aae';
	} elseif ($typeCom == '安捷快递') {
		$typeCom = 'anjiekuaidi';
	} elseif ($typeCom == '安信达快递') {
		$typeCom = 'anxindakuaixi';
	} elseif ($typeCom == '百福东方') {
		$typeCom = 'baifudongfang';
	} elseif ($typeCom == '彪记快递') {
		$typeCom = 'biaojikuaidi';
	} elseif ($typeCom == 'BHT') {
		$typeCom = 'bht';
	} elseif ($typeCom == '希伊艾斯快递') {
		$typeCom = 'cces';
	} elseif ($typeCom == '中国东方') {
		$typeCom = 'coe';
	} elseif ($typeCom == '长宇物流') {
		$typeCom = 'changyuwuliu';
	} elseif ($typeCom == '大田物流') {
		$typeCom = 'datianwuliu';
	} elseif ($typeCom == '德邦物流') {
		$typeCom = 'debangwuliu';
	} elseif ($typeCom == 'DPEX') {
		$typeCom = 'dpex';
	} elseif ($typeCom == 'DHL') {
		$typeCom = 'dhl';
	} elseif ($typeCom == 'D速快递') {
		$typeCom = 'dsukuaidi';
	} elseif ($typeCom == 'fedex') {
		$typeCom = 'fedex';
	} elseif ($typeCom == '飞康达物流') {
		$typeCom = 'feikangda';
	} elseif ($typeCom == '凤凰快递') {
		$typeCom = 'fenghuangkuaidi';
	} elseif ($typeCom == '港中能达物流') {
		$typeCom = 'ganzhongnengda';
	} elseif ($typeCom == '广东邮政物流') {
		$typeCom = 'guangdongyouzhengwuliu';
	} elseif ($typeCom == '汇通快运') {
		$typeCom = 'huitongkuaidi';
	} elseif ($typeCom == '恒路物流') {
		$typeCom = 'hengluwuliu';
	} elseif ($typeCom == '华夏龙物流') {
		$typeCom = 'huaxialongwuliu';
	} elseif ($typeCom == '佳怡物流') {
		$typeCom = 'jiayiwuliu';
	} elseif ($typeCom == '京广速递') {
		$typeCom = 'jinguangsudikuaijian';
	} elseif ($typeCom == '急先达') {
		$typeCom = 'jixianda';
	} elseif ($typeCom == '佳吉物流') {
		$typeCom = 'jiajiwuliu';
	} elseif ($typeCom == '加运美') {
		$typeCom = 'jiayunmeiwuliu';
	} elseif ($typeCom == '快捷速递') {
		$typeCom = 'kuaijiesudi';
	} elseif ($typeCom == '联昊通物流') {
		$typeCom = 'lianhaowuliu';
	} elseif ($typeCom == '龙邦物流') {
		$typeCom = 'longbanwuliu';
	} elseif ($typeCom == '民航快递') {
		$typeCom = 'minghangkuaidi';
	} elseif ($typeCom == '配思货运') {
		$typeCom = 'peisihuoyunkuaidi';
	} elseif ($typeCom == '全晨快递') {
		$typeCom = 'quanchenkuaidi';
	} elseif ($typeCom == '全际通物流') {
		$typeCom = 'quanjitong';
	} elseif ($typeCom == '全日通快递') {
		$typeCom = 'quanritongkuaidi';
	} elseif ($typeCom == '全一快递') {
		$typeCom = 'quanyikuaidi';
	} elseif ($typeCom == '盛辉物流') {
		$typeCom = 'shenghuiwuliu';
	} elseif ($typeCom == '速尔物流') {
		$typeCom = 'suer';
	} elseif ($typeCom == '盛丰物流') {
		$typeCom = 'shengfengwuliu';
	} elseif ($typeCom == '天地华宇') {
		$typeCom = 'tiandihuayu';
	} elseif ($typeCom == '天天') {
		$typeCom = 'tiantian';
	} elseif ($typeCom == 'TNT') {
		$typeCom = 'tnt';
	} elseif ($typeCom == 'UPS') {
		$typeCom = 'ups';
	} elseif ($typeCom == '万家物流') {
		$typeCom = 'wanjiawuliu';
	} elseif ($typeCom == '文捷航空速递') {
		$typeCom = 'wenjiesudi';
	} elseif ($typeCom == '伍圆速递') {
		$typeCom = 'wuyuansudi';
	} elseif ($typeCom == '万象物流') {
		$typeCom = 'wanxiangwuliu';
	} elseif ($typeCom == '新邦物流') {
		$typeCom = 'xinbangwuliu';
	} elseif ($typeCom == '信丰物流') {
		$typeCom = 'xinfengwuliu';
	} elseif ($typeCom == '星晨急便') {
		$typeCom = 'xingchengjibian';
	} elseif ($typeCom == '鑫飞鸿物流快递') {
		$typeCom = 'xinhongyukuaidi';
	} elseif ($typeCom == '亚风速递') {
		$typeCom = 'yafengsudi';
	} elseif ($typeCom == '一邦速递') {
		$typeCom = 'yibangwuliu';
	} elseif ($typeCom == '优速物流') {
		$typeCom = 'youshuwuliu';
	} elseif ($typeCom == '远成物流') {
		$typeCom = 'yuanchengwuliu';
	} elseif ($typeCom == '圆通速递') {
		$typeCom = 'yuantong';
	} elseif ($typeCom == '源伟丰快递') {
		$typeCom = 'yuanweifeng';
	} elseif ($typeCom == '元智捷诚快递') {
		$typeCom = 'yuanzhijiecheng';
	} elseif ($typeCom == '越丰物流') {
		$typeCom = 'yuefengwuliu';
	} elseif ($typeCom == '韵达快运') {
		$typeCom = 'yunda';
	} elseif ($typeCom == '源安达') {
		$typeCom = 'yuananda';
	} elseif ($typeCom == '运通快递') {
		$typeCom = 'yuntongkuaidi';
	} elseif ($typeCom == '宅急送') {
		$typeCom = 'zhaijisong';
	} elseif ($typeCom == '中铁快运') {
		$typeCom = 'zhongtiewuliu';
	} elseif ($typeCom == 'EMS快递') {
		$typeCom = 'ems';
	} elseif ($typeCom == '申通快递') {
		$typeCom = 'shentong';
	} elseif ($typeCom == '顺丰速运') {
		$typeCom = 'shunfeng';
	} elseif ($typeCom == '中通速递') {
		$typeCom = 'zhongtong';
	} elseif ($typeCom == '中邮物流') {
		$typeCom = 'zhongyouwuliu';
	} else {
		$typeCom = '';
	}
	return $typeCom;
}

function getExpressComCode($shipping_code)
{
    $express_code = array(
        'ship_yto' => 'yuantong',
        'ship_sto_express' => 'shentong',
        'ship_zto' => 'zhongtong',
        'ship_ems' => 'ems',
        'ship_sf_express' => 'shunfeng',
    );
    
    if (isset($express_code[$shipping_code])) {
        return $express_code[$shipping_code];
    } else {
        return false;
    }
}


// end