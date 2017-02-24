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

class goods_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'goods';
		parent::__construct();
	}

	/**
	 * 取得促销商品列表
	 * @param array $filter
	 * @return  array
	 */
	public function promotion_list($filter) {
		/* 过滤条件 */
		$filter['keywords'] = empty($filter['keywords']) ? '' : trim($filter['keywords']);
		$where = array();
		$where = array('is_promote' => 1);
		$where['is_delete'] = array('neq' => 1);
		/* 多商户处理*/
		if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0 ) {
			$where['store_id'] = $_SESSION['store_id'];
		}

		if (!empty($filter['keywords'])) {
			$where['goods_name'] = array('like' => '%'.$filter['keywords'].'%');
		}

		$time = RC_Time::gmtime();
		if ($filter['status'] == 'going') {
			$where['promote_start_date'] = array('elt' => $time);
			$where['promote_end_date'] = array('egt' => $time);
		}

		if ($filter['status'] == 'coming') {
			$where['promote_start_date'] = array('egt' => $time);
		}

		if ($filter['status'] == 'finished') {
			$where['promote_end_date'] = array('elt' => $time);
		}

		$filter['record_count'] = $this->where($where)->count();
		$field = 'goods_id, goods_name, shop_price, market_price, promote_price, promote_start_date, promote_end_date, goods_thumb, original_img, goods_img';
		//实例化分页
		$page_row = new ecjia_page($filter['record_count'], $filter['size'], 6, '', $filter['page']);

		$res = $this->field($field)->where($where)->order('sort_order asc')->limit($page_row->limit())->select();

		$list = array();
		if (!empty($res)) {
			foreach ($res as $row) {
				$row['promote_start_date']  = RC_Time::local_date('Y-m-d H:i:s', $row['promote_start_date']);
				$row['promote_end_date']    = RC_Time::local_date('Y-m-d H:i:s', $row['promote_end_date']);
				$row['goods_thumb']			= !empty($row['goods_thumb']) ? RC_Upload::upload_url($row['goods_thumb']) : RC_Uri::admin_url('statics/images/nopic.png');
				$row['original_img']		= !empty($row['original_img']) ? RC_Upload::upload_url($row['original_img']) : RC_Uri::admin_url('statics/images/nopic.png');
				$row['goods_img']			= !empty($row['goods_img']) ? RC_Upload::upload_url($row['goods_img']) : RC_Uri::admin_url('statics/images/nopic.png');
				$list[] = $row;
			}
		}
		return array('item' => $list, 'filter' => $filter, 'page' => $page_row);
	}

	/**
	 * 促销的商品信息
	 * @param int $goods_id
	 * @return array
	 */
	function promote_goods_info($goods_id) {
		$where = array();
		$where['goods_id'] = $goods_id;
		/*多商户处理*/
		if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0 ) {
			$where['store_id'] = $_SESSION['store_id'];
		}
		$field = 'goods_id, store_id, goods_name, shop_price, market_price, promote_price, promote_start_date, promote_end_date, goods_thumb, original_img, goods_img';
		$row = $this->field($field)->where($where)->find();

		if (! empty ( $row )) {
			$row['formatted_shop_price']		        = price_format($row['shop_price']);
			$row['formatted_market_price']		        = price_format($row['market_price']);
			$row['formatted_promote_price']		        = price_format($row['promote_price']);
			$row['promote_start_date']			        =  $row['promote_start_date'];
			$row['promote_end_date']  			        =  $row['promote_end_date'];
			$row['formatted_promote_start_date']  		= RC_Time::local_date('Y-m-d H:i:s', $row['promote_start_date']);
			$row['formatted_promote_end_date']    		= RC_Time::local_date('Y-m-d H:i:s', $row['promote_end_date']);
			$row['img']							        = array(
				'goods_thumb'  => !empty($row['goods_thumb']) ? RC_Upload::upload_url($row['goods_thumb']) : RC_Uri::admin_url('statics/images/nopic.png'),
				'original_img' => !empty($row['original_img']) ? RC_Upload::upload_url($row['original_img']) : RC_Uri::admin_url('statics/images/nopic.png'),
				'goods_img'    => !empty($row['goods_img']) ? RC_Upload::upload_url($row['goods_img']) : RC_Uri::admin_url('statics/images/nopic.png')
			);
		}
		unset($row['goods_thumb']);
		unset($row['original_img']);
		unset($row['goods_img']);
		return $row;
	}

	/**
	 * 取消商品的促销活动
	 * @param int $act_id
	 * @return boolean
	 */
	public function promotion_remove($goods_id) {
		$this->where(array('goods_id' => $goods_id))->update(array('is_promote' => 0, 'promote_price' => 0, 'promote_start_date' => 0, 'promote_end_date' => 0));
		return true;
	}


	/**
	 * 促销商品管理
	 * @param array $parameter
	 * @return int goods_id
	 */
	public function promotion_manage($parameter) {
		if (isset($parameter['goods_id']) && $parameter['goods_id'] > 0) {
			$act_id = $this->where(array('goods_id' => $parameter['goods_id']))->update($parameter);
		}
		return $act_id;
	}

	/* 查询字段信息 */
	public function goods_field($where, $field, $bool=false) {
	    return $this->where($where)->get_field($field, $bool);
	}

    public function is_only($where) {
    	return $this->where($where)->count();
    }

    /*搜索商品*/
    public function goods_select($where, $in=false, $field='*') {
        if ($in) {
            return $this->field($field)->in($where)->select();
        }
        return $this->field($field)->where($where)->select();
    }

    public function goods_find($where = array(), $field='*') {
        return $this->field($field)->where($where)->find();
    }

    public function goods_update($where, $data) {
    	return $this->where($where)->update($data);
    }

    public function goods_inc($field, $where, $num) {
    	return $this->inc($field, $where, $num);
    }
}

// end
