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
 * 商品列表筛选数据获取
 * @author will.chen
 */
class goods_goods_filter_api extends Component_Event_Api {
	private $children = '';
	private $cat = array();
    /**
     * @param  $options['cat_id'] 分类id
     * @return array
     */
	public function call(&$options) {
	    if (!is_array($options)
	        && !isset($options['cat_id'])) {
	        return new ecjia_error('invalid_parameter', '参数无效');
	    }

	    $options = array(
	    	'cat_id'	=> intval($options['cat_id']),
	    	'brand_id'	=> isset($options['brand']) && intval($options['brand']) > 0 ? intval($options['brand']) : 0,
	    	'price_max'	=> isset($options['price_max']) && intval($options['price_max']) > 0 ? intval($options['price_max']) : 0,
	    	'price_min'	=> isset($options['price_min']) && intval($options['price_min']) > 0 ? intval($options['price_min']) : 0,
	    	'filter_attr_str' => isset($options['filter_attr']) ? htmlspecialchars(trim($options['filter_attr'])) : '0',
	    );

	    RC_Loader::load_app_class('goods_category', 'goods', false);
	    // 获得指定分类下所有底层分类的ID
	    $this->children = goods_category::get_children($options['cat_id']);
	    // 获得分类的相关信息
	    $this->cat = goods_category::get_cat_info($options['cat_id']);

	    $category_filter	= goods_category::cat_list($options['cat_id'], 0, false );
	    $brands_filter		= $this->brands_filter($options);
	    $price_filter		= $this->price_filter($options);
	    $attr_filter		= $this->attr_filter($options);

	    $filter =  array(
    		'category_filter' => $category_filter,
    		'brands_filter' => $brands_filter,
    		'price_filter'	=> $price_filter,
    		'attr_filter'	=> $attr_filter,
	    );
	    return $filter;
	}
	/**
	 * 属性筛选
	 * @param   object  $filters    过滤条件
	 */
	private function attr_filter($options) {
		$db_attribute_view = RC_Model::model('goods/attribute_viewmodel');
		$db_goods_view = RC_Model::model ('goods/goods_viewmodel');
		$db_attribute_view->view =array(
			'goods_attr' => array(
				'type'  => Component_Model_View::TYPE_INNER_JOIN,
				'alias' => 'ga',
				'on'    => 'ga.attr_id = a.attr_id'
			),
			'goods' => array (
				'type' 	=> Component_Model_View::TYPE_INNER_JOIN,
				'alias' => 'g',
				'on' 	=> 'ga.goods_id = g.goods_id'
			)
		);

		$cat = $this->cat;
		/* 属性筛选 */
		$ext = ''; //商品查询条件扩展
		$all_attr_list = array();
		if ($cat['filter_attr'] > 0) {
			$cat_filter_attr = explode(',', $cat['filter_attr']);       //提取出此分类的筛选属性

			$where['g.is_delete'] = 0;
			$where['g.is_on_sale'] = 1;
			$where['g.is_alone_sale'] = 1;
            if (ecjia::config('review_goods')) {
        		$where['g.review_status'] = array('gt' => 2);
        	}
			$where[] = '('.$this->children.' OR '.goods_category::get_extension_goods($this->children).')';
			foreach ($cat_filter_attr AS $key => $value) {
				$where['a.attr_id'] = $value;
				$temp_name = $db_attribute_view->join(array('goods_attr', 'goods'))->where($where)->get_field('attr_name');
				if (!empty($temp_name)) {
					$all_attr_list[$key]['filter_attr_name'] = $temp_name;

					$field = 'a.attr_id, MIN(a.goods_attr_id ) AS goods_id, a.attr_value AS attr_value';
					$attr_list = $db_goods_view->join('goods_attr')->field($field)->where($where)->group('a.attr_value')->select();
					$temp_arrt_url_arr = array();

					//获取当前url中已选择属性的值，并保留在数组中
					for ($i = 0; $i < count($cat_filter_attr); $i++) {
						$temp_arrt_url_arr[$i] = !empty($filter_attr[$i]) ? $filter_attr[$i] : 0;
					}
					foreach ($attr_list as $k => $v) {
// 						$temp_key = $k + 1;
						$temp_arrt_url_arr[$key] = $v['goods_id'];       //为url中代表当前筛选属性的位置变量赋值,并生成以‘.’分隔的筛选属性字符串
						$temp_arrt_url = implode('.', $temp_arrt_url_arr);

						$all_attr_list[$key]['attr_list'][$k]['goods_attr_id'] = $v['goods_id'];
						$all_attr_list[$key]['attr_list'][$k]['attr_value'] = $v['attr_value'];
						$all_attr_list[$key]['attr_list'][$k]['url'] = build_uri('category', array('cid' => $options['cat_id'], 'bid' => $options['brand_id'], 'price_min'=> $options['price_min'], 'price_max' => $options['price_max'], 'filter_attr' => $temp_arrt_url), $this->cat['cat_name']);

						/* 判断属性是否被选中 */
						if (!empty($filter_attr[$key]) AND $filter_attr[$key] == $v['goods_id']) {
							$all_attr_list[$key]['attr_list'][$k]['selected'] = 1;
						} else {
							$all_attr_list[$key]['attr_list'][$k]['selected'] = 0;
						}
					}

					//“全部”的信息生成
					$temp_arrt_url_arr[$key] = 0;
					$temp_arrt_url = implode('.', $temp_arrt_url_arr);
					array_unshift($all_attr_list[$key]['attr_list'], array(
						'goods_attr_id' => 0,
						'attr_value' => __('全部'),
						'url'		 => build_uri('category', array('cid' => $options['cat_id'], 'bid' => $options['brand_id'], 'price_min'=> $options['price_min'], 'price_max' => $options['price_max'], 'filter_attr' => $temp_arrt_url), $this->cat['cat_name']),
						'selected'	 => empty($filter_attr[$key]) ? 1 : 0,
					));
				}

			}
		}
		return $all_attr_list;
	}

	/**
	 * 品牌筛选
	 * @param   object  $filters    过滤条件
	 */
	private function brands_filter($options) {
		$dbview = RC_Model::model('goods/brand_goods_goods_cat_viewmodel');

		$where['is_on_sale'] = 1;
		$where['is_alone_sale'] = 1;
		$where['g.is_delete'] = 0;
		$where[] = '('.$this->children.' OR '.goods_category::get_children($options['cat_id'], 'gc.cat_id').')';
		$where['g.brand_id'] = array('gt' => 0);
		$brands_filter = $dbview->join(array('brand', 'goods_cat'))
				->where($where)
				->having('goods_num > 0')
				->order(array('b.sort_order' => 'ASC', 'b.brand_id' => 'ASC'))
				->group('b.brand_id')
				->select();
		if (!empty($brands_filter)) {
			foreach ($brands_filter AS $key => $val) {
				$brands_filter[$key]['url'] = build_uri('category', array('cid' => $options['cat_id'], 'bid' => $val['brand_id'], 'price_min'=> $options['price_min'], 'price_max'=> $options['price_max'], 'filter_attr' => $options['filter_attr_str']), $this->cat['cat_name']);

				/* 判断品牌是否被选中 */
				if ($options['brand_id'] == $brands_filter[$key]['brand_id']) {
					$brands_filter[$key]['selected'] = 1;
				} else {
					$brands_filter[$key]['selected'] = 0;
				}
			}
			//“全部”的信息生成
			array_unshift($brands_filter, array(
				'brand_id'	 => 0,
				'brand_name' => __('全部'),
				'url'		 => build_uri('category', array('cid' => $options['cat_id'], 'bid' => 0, 'price_min'=> $options['price_min'], 'price_max'=> $options['price_max'], 'filter_attr'=> $options['filter_attr_str']), $this->cat['cat_name']),
				'selected'	 => empty($options['brand']) ? 1 : 0,
			));
		}
		return $brands_filter;
	}

	/**
	 * 价格筛选
	 * @param   object  $filters    过滤条件
	 */
	private function price_filter($options) {
		$db_goods = RC_Model::model('goods/goods_viewmodel');
		$cat = $this->cat;
		/* 获取价格分级 */
		if ($cat['grade'] == 0  && $cat['parent_id'] != 0) {
			$cat['grade'] = goods_category::get_parent_grade($options['cat_id']); //如果当前分类级别为空，取最近的上级分类
		}

		if ($cat['grade'] > 1) {
			/* 需要价格分级 */

			/*
			 算法思路：
			1、当分级大于1时，进行价格分级
			2、取出该类下商品价格的最大值、最小值
			3、根据商品价格的最大值来计算商品价格的分级数量级：
			价格范围(不含最大值)    分级数量级
			0-0.1                   0.001
			0.1-1                   0.01
			1-10                    0.1
			10-100                  1
			100-1000                10
			1000-10000              100
			4、计算价格跨度：
			取整((最大值-最小值) / (价格分级数) / 数量级) * 数量级
			5、根据价格跨度计算价格范围区间
			6、查询数据库

			可能存在问题：
			1、
			由于价格跨度是由最大值、最小值计算出来的
			然后再通过价格跨度来确定显示时的价格范围区间
			所以可能会存在价格分级数量不正确的问题
			该问题没有证明
			2、
			当价格=最大值时，分级会多出来，已被证明存在
			*/

			//获得当前分类下商品价格的最大值、最小值
			$where['is_delete'] = 0;
			$where['is_on_sale'] = 1;
			$where['is_alone_sale'] = 1;
			$where[] = '('.$this->children.' OR '.goods_category::get_extension_goods($this->children).')';

			$row = $db_goods->join(null)->field('min(g.shop_price) AS min, max(g.shop_price) as max')->find($where);

			// 取得价格分级最小单位级数，比如，千元商品最小以100为级数
			$price_grade = 0.0001;
			for($i = -2; $i <= log10($row['max']); $i++){
				$price_grade *= 10;
			}

			//跨度
			$dx = ceil(($row['max'] - $row['min']) / ($cat['grade']) / $price_grade) * $price_grade;
			if ($dx == 0) {
				$dx = $price_grade;
			}

			for($i = 1; $row['min'] > $dx * $i; $i ++);

        	for($j = 1; $row['min'] > $dx * ($i-1) + $price_grade * $j; $j++);
        	$row['min'] = $dx * ($i-1) + $price_grade * ($j - 1);

        	for(; $row['max'] >= $dx * $i; $i ++);
        	$row['max'] = $dx * ($i) + $price_grade * ($j - 1);


        	$price_grade = $db_goods->join(null)
				->field('(FLOOR((g.shop_price - '.$row['min'].') / '.$dx.')) AS sn, COUNT(*) AS goods_num')
				->where($where)
				->group('sn')
				->select();

        	foreach ($price_grade as $key => $val) {
        		$price_grade[$key]['goods_num'] = $val['goods_num'];
        		$price_grade[$key]['start'] = $row['min'] + round($dx * $val['sn']);
        		$price_grade[$key]['end'] = $row['min'] + round($dx * ($val['sn'] + 1));
        		$price_grade[$key]['price_range'] = $price_grade[$key]['start'] . '   -   ' . $price_grade[$key]['end'];
        		$price_grade[$key]['formated_start'] = price_format($price_grade[$key]['start']);
        		$price_grade[$key]['formated_end'] = price_format($price_grade[$key]['end']);

        		$price_grade[$key]['url'] = build_uri('category', array('cid' => $options['cat_id'], 'bid'=> $options['brand_id'], 'price_min'=> $price_grade[$key]['start'], 'price_max'=> $price_grade[$key]['end'], 'filter_attr' => $options['filter_attr_str']), $this->cat['cat_name']);

        		/* 判断价格区间是否被选中 */
        		if (isset($_REQUEST['price_min']) && $price_grade[$key]['start'] == $price_min && $price_grade[$key]['end'] == $price_max) {
        			$price_grade[$key]['selected'] = 1;
        		} else {
        			$price_grade[$key]['selected'] = 0;
        		}
        	}

        	//“全部”的信息生成
        	array_unshift($price_grade, array(
	        	'start'	 => 0,
	        	'end'	 => 0,
	        	'price_range' => __('全部'),
	        	'url'		 => build_uri('category', array('cid'=>$options['cat_id'], 'bid'=> $options['brand_id'], 'price_min'=>0, 'price_max'=> 0, 'filter_attr' => $options['filter_attr_str']), $this->cat['cat_name']),
	        	'selected'	 => empty($price_max) ? 1 : 0,
        	));
			return $price_grade;
		}
	}
}

// end