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
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 订单快递查询
 * @author royalwang
 */
class express_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    		
    	$user_id = $_SESSION['user_id'];
    	if ($user_id < 1 ) {
    	    return new ecjia_error(100, 'Invalid session');
    	}
    	
		define('INIT_NO_USERS', true);
		RC_Loader::load_app_func('admin_order','orders');
		
		$AppKey = $this->requestData('app_key', '');
		$order_id = $this->requestData('order_id', 0);
		
		if (empty($order_id)) {
			return new ecjia_error(101, '参数错误');
		}
		
		$order_info = order_info($order_id);
		if (!$order_info || empty($order_info['shipping_name']) || empty($order_info['invoice_no'])) {
			return new ecjia_error(10009, '订单无发货信息');
		}
		$typeCom = getComType($order_info['shipping_name']);//快递公司类型
		
		if (empty($typeCom)) {
			return new ecjia_error(10009, '物流信息无法获取');
		}
		
		$url = 'http://api.kuaidi100.com/api?id='.$AppKey.'&com='.$typeCom.'&nu='.$order_info['invoice_no'].'&valicode=[]&show=0&muti=1&order=asc';
		$json =  file_get_contents($url);

		$data = json_decode($json, true);

		if (empty($data)) {
			return array(
    			'content' => array('context'=>'无物流记录', 'time'=>''),
    			'shipping_name' => $order_info['shipping_name']
			);
		} else {
			$data['data'] = array_reverse($data['data']);
		}
		$out = array();
		$out['content'] = $data['data'];
		$out['shipping_name'] = $order_info['shipping_name'];
		$out['shipping_number'] = $order_info['invoice_no'];  //快递单号
		$out['status'] = $data['state'] == 3 ? 1 : 0;   //是否签收
		
		return $out;		
	}
}

function getComType($typeCom) {
	if ($typeCom == 'AAE全球专递'){
		$typeCom = 'aae';
	}elseif ($typeCom == '安捷快递'){
		$typeCom = 'anjiekuaidi';
	}elseif ($typeCom == '安信达快递'){
		$typeCom = 'anxindakuaixi';
	}elseif ($typeCom == '百福东方'){
		$typeCom = 'baifudongfang';
	}elseif ($typeCom == '彪记快递'){
		$typeCom = 'biaojikuaidi';
	}elseif ($typeCom == 'BHT'){
		$typeCom = 'bht';
	}elseif ($typeCom == '希伊艾斯快递'){
		$typeCom = 'cces';
	}elseif ($typeCom == '中国东方'){
		$typeCom = 'coe';
	}elseif ($typeCom == '长宇物流'){
		$typeCom = 'changyuwuliu';
	}elseif ($typeCom == '大田物流'){
		$typeCom = 'datianwuliu';
	}elseif ($typeCom == '德邦物流'){
		$typeCom = 'debangwuliu';
	}elseif ($typeCom == 'DPEX'){
		$typeCom = 'dpex';
	}elseif ($typeCom == 'DHL'){
		$typeCom = 'dhl';
	}elseif ($typeCom == 'D速快递'){
		$typeCom = 'dsukuaidi';
	}elseif ($typeCom == 'fedex'){
		$typeCom = 'fedex';
	}elseif ($typeCom == '飞康达物流'){
		$typeCom = 'feikangda';
	}elseif ($typeCom == '凤凰快递'){
		$typeCom = 'fenghuangkuaidi';
	}elseif ($typeCom == '港中能达物流'){
		$typeCom = 'ganzhongnengda';
	}elseif ($typeCom == '广东邮政物流'){
		$typeCom = 'guangdongyouzhengwuliu';
	}elseif ($typeCom == '汇通快运'){
		$typeCom = 'huitongkuaidi';
	}elseif ($typeCom == '恒路物流'){
		$typeCom = 'hengluwuliu';
	}elseif ($typeCom == '华夏龙物流'){
		$typeCom = 'huaxialongwuliu';
	}elseif ($typeCom == '佳怡物流'){
		$typeCom = 'jiayiwuliu';
	}elseif ($typeCom == '京广速递'){
		$typeCom = 'jinguangsudikuaijian';
	}elseif ($typeCom == '急先达'){
		$typeCom = 'jixianda';
	}elseif ($typeCom == '佳吉物流'){
		$typeCom = 'jiajiwuliu';
	}elseif ($typeCom == '加运美'){
		$typeCom = 'jiayunmeiwuliu';
	}elseif ($typeCom == '快捷速递'){
		$typeCom = 'kuaijiesudi';
	}elseif ($typeCom == '联昊通物流'){
		$typeCom = 'lianhaowuliu';
	}elseif ($typeCom == '龙邦物流'){
		$typeCom = 'longbanwuliu';
	}elseif ($typeCom == '民航快递'){
		$typeCom = 'minghangkuaidi';
	}elseif ($typeCom == '配思货运'){
		$typeCom = 'peisihuoyunkuaidi';
	}elseif ($typeCom == '全晨快递'){
		$typeCom = 'quanchenkuaidi';
	}elseif ($typeCom == '全际通物流'){
		$typeCom = 'quanjitong';
	}elseif ($typeCom == '全日通快递'){
		$typeCom = 'quanritongkuaidi';
	}elseif ($typeCom == '全一快递'){
		$typeCom = 'quanyikuaidi';
	}elseif ($typeCom == '盛辉物流'){
		$typeCom = 'shenghuiwuliu';
	}elseif ($typeCom == '速尔物流'){
		$typeCom = 'suer';
	}elseif ($typeCom == '盛丰物流'){
		$typeCom = 'shengfengwuliu';
	}elseif ($typeCom == '天地华宇'){
		$typeCom = 'tiandihuayu';
	}elseif ($typeCom == '天天'){
		$typeCom = 'tiantian';
	}elseif ($typeCom == 'TNT'){
		$typeCom = 'tnt';
	}elseif ($typeCom == 'UPS'){
		$typeCom = 'ups';
	}elseif ($typeCom == '万家物流'){
		$typeCom = 'wanjiawuliu';
	}elseif ($typeCom == '文捷航空速递'){
		$typeCom = 'wenjiesudi';
	}elseif ($typeCom == '伍圆速递'){
		$typeCom = 'wuyuansudi';
	}elseif ($typeCom == '万象物流'){
		$typeCom = 'wanxiangwuliu';
	}elseif ($typeCom == '新邦物流'){
		$typeCom = 'xinbangwuliu';
	}elseif ($typeCom == '信丰物流'){
		$typeCom = 'xinfengwuliu';
	}elseif ($typeCom == '星晨急便'){
		$typeCom = 'xingchengjibian';
	}elseif ($typeCom == '鑫飞鸿物流快递'){
		$typeCom = 'xinhongyukuaidi';
	}elseif ($typeCom == '亚风速递'){
		$typeCom = 'yafengsudi';
	}elseif ($typeCom == '一邦速递'){
		$typeCom = 'yibangwuliu';
	}elseif ($typeCom == '优速物流'){
		$typeCom = 'youshuwuliu';
	}elseif ($typeCom == '远成物流'){
		$typeCom = 'yuanchengwuliu';
	}elseif ($typeCom == '圆通速递'){
		$typeCom = 'yuantong';
	}elseif ($typeCom == '源伟丰快递'){
		$typeCom = 'yuanweifeng';
	}elseif ($typeCom == '元智捷诚快递'){
		$typeCom = 'yuanzhijiecheng';
	}elseif ($typeCom == '越丰物流'){
		$typeCom = 'yuefengwuliu';
	}elseif ($typeCom == '韵达快运'){
		$typeCom = 'yunda';
	}elseif ($typeCom == '源安达'){
		$typeCom = 'yuananda';
	}elseif ($typeCom == '运通快递'){
		$typeCom = 'yuntongkuaidi';
	}elseif ($typeCom == '宅急送'){
		$typeCom = 'zhaijisong';
	}elseif ($typeCom == '中铁快运'){
		$typeCom = 'zhongtiewuliu';
	}elseif ($typeCom == 'EMS快递'){
		$typeCom = 'ems';
	}elseif ($typeCom == '申通快递'){
		$typeCom = 'shentong';
	}elseif ($typeCom == '顺丰速运'){
		$typeCom = 'shunfeng';
	}elseif ($typeCom == '中通速递'){
		$typeCom = 'zhongtong';
	}elseif ($typeCom == '中邮物流'){
		$typeCom = 'zhongyouwuliu';
	} else {
		$typeCom = '';
	}
	return $typeCom;
}

// end