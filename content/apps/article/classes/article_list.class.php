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
 * 文章列表类
 */
class article_list {
	/**
	 * 取得文章信息
	 * @param   array $options	条件参数
	 * @return  array   文章列表
	 */
	
	public static function article_lists($options) {
	
		$dbview = RC_DB::table('article as a')
		->leftJoin('article_cat as ac', RC_DB::raw('ac.cat_id'), '=', RC_DB::raw('a.cat_id'));
	
		$filter = array();
		$filter['cat_id']     = empty($options['cat_id']) 		? 0 : intval($options['cat_id']);
		$filter['sort_by']    = empty($options['sort_by']) 		? 'a.add_time' : trim($options['sort_by']);
		$filter['sort_order'] = empty($options['sort_order']) 	? 'DESC' : trim($options['sort_order']);
		$filter['size']  	  = empty($options['size']) 		? 15 : intval($options['size']);
		$filter['page'] 	  = empty($options['page']) 		? 1 : intval($options['page']);
		
		if (!empty($options['suggest_type'])) {
			$dbview->where(RC_DB::raw('a.suggest_type'), $options['suggest_type']);
		}
		
		if ($filter['cat_id'] && ($filter['cat_id'] > 0)) {
			//含分类自己			
			RC_Loader::load_app_class('article_cat', 'article', false);
			$datas = article_cat::article_cat_list($filter['cat_id'], 0, false, 0, 'article');
			$datas = array_merge($datas);
			$datas = $datas ? collect($datas)->pluck('cat_id')->toArray() : [];
			if (!empty($datas) && is_array($datas)) {
				$dbview->whereIn(RC_DB::raw('a.cat_id'), $datas);
			}
		}
		/*显示审核通过的*/
		if ($options['article_approved'] && $options['article_approved'] == 1) {
			$dbview->where(RC_DB::raw('a.article_approved'), '=', 1);
		}
		
		/* 文章总数 */
		$filter['record_count'] = '';
		$count = $dbview->select('article_id')->count();
		$page_row = new ecjia_page($count, $filter['size'], 6, '', $filter['page']);
	
		$result = $dbview->select(RC_DB::raw('a.*, ac.cat_name, ac.cat_type, ac.sort_order'))
		->orderby(RC_DB::raw($filter['sort_by']), $filter['sort_order'])->take($filter['size'])->skip($page_row->start_id - 1)->get();
		$pager = array(
				'total' => $page_row->total_records,
				'count' => $page_row->total_records,
				'more'	=> $page_row->total_pages <= $filter['page'] ? 0 : 1,
		);
		return array('list' => $result, 'page' => $pager);
	}
	
	
	/**
	 * 子分类ids
	 * @return string
	 */
	public static function GetIds($parent_id){
		if ($parent_id) {
			if (is_array($parent_id)) {
				$parent_id = join(',', $parent_id);
				$data = RC_DB::table('article_cat')->whereIn('parent_id', $parent_id)->lists('cat_id');
			} else {
				$data = RC_DB::table('article_cat')->where('parent_id', $parent_id)->lists('cat_id');
			}
			if (!empty($data)) {
				$datas = self::GetIds($data) ? array_merge($data,self::GetIds($data)) : $data;
			} else {
				$datas = array('0' =>$parent_id);
			}
		}
		return $datas;
	}
	
	/**
	 * 更新文章评论数
	 * @return bool
	 */
	public static function update_comment_count($article_id){
		$count = RC_DB::table('discuss_comments')
				->where('id_value', $article_id)
				->whereIn('comment_approved', array(1))
				->where('comment_type', 'article')->count('id');
		$res = RC_DB::table('article')->where('article_id', $article_id)->update(array('comment_count' => $count));
		return true;
	}
}	


// end