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
 * 代理商推荐的店铺
 * @author zrl
 */
use Ecjia\App\Affiliate\Models\AffiliateStoreRecordModel;
use Ecjia\App\Affiliate\Models\AffiliateStoreModel;

class invite_store_agent_invite_store_module extends api_front implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
        $this->authSession();
        if ($_SESSION['user_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
       	
        $size = $this->requestData('pagination.count', '20');
        $page = $this->requestData('pagination.page', '1');
        
        $type = $this->requestData('type', 'self_recommend');
        
        if (empty($type) || !in_array($type, ['self_recommend', 'sub_recommend'])) {
        	return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'affiliate'), __CLASS__));
        }
        
        $agent_info = AffiliateStoreModel::where('user_id', $_SESSION['user_id'])->first();
		if (empty($agent_info)) {
			return new ecjia_error('invalid_parameter', __('非代理角色不可查看此项', 'affiliate'));
		}
        
        $query = AffiliateStoreRecordModel::with([
        			'affiliate_store_model',
        			'store_franchisee_model',
        		]);
        
        if ($type == 'self_recommend') {
        	$query->where('affiliate_store_record.affiliate_store_id', $agent_info->id);
        } else {
        	$sub_agent_ids = RC_DB::table('affiliate_store')->where('agent_parent_id', $agent_info->id)->lists('id');
        	if (empty($sub_agent_ids)) {
        		return [
        			'data' 		=> array(),
        			'pager'		=> array('total' => 0, 'count' => 0, 'more' => 0)
        		 ];
        	}
        	$query->whereIn('affiliate_store_record.affiliate_store_id', $sub_agent_ids);
        }
        
        $count = $query->count();
        
        $ecjia_page = new ecjia_page($count, $size, 6, '', $page);
        
        $pager = array(
        		'total' => $ecjia_page->total_records,
        		'count' => $ecjia_page->total_records,
        		'more'  => $ecjia_page->total_pages <= $page ? 0 : 1,
        );
        
        $collection = $query->skip($ecjia_page->start_id - 1)->take($ecjia_page->page_size)->orderBy('affiliate_store_record.add_time', 'desc')->get();
        
        $list = $this->formatted_list($collection, $agent_info->id);
        
        return ['data' => $list, 'pager' => $pager];
    }
    
    private function formatted_list($collection, $agent_id)
    {
    	$list = [];
    	if ($collection) {
    		$list = $collection->map(function($val){
    			$referrer = null;
    			if ($val->affiliate_store_id != $agent_id) {
    				$referrer = $val->affiliate_store_model->agent_name;
    			}
    			$total_number = RC_DB::table('order_info')->where('store_id', $val->store_id)
    										->whereIn('order_info.order_status', array(OS_CONFIRMED, OS_SPLITED))
    										->whereIn('order_info.shipping_status', array(SS_RECEIVED))
    										->whereIn('order_info.pay_status', array(PS_PAYED, PS_PAYING))->count();
    			
    			$total_amount = RC_DB::table('order_info')->where('store_id', $val->store_id)
							    			->whereIn('order_info.order_status', array(OS_CONFIRMED, OS_SPLITED))
							    			->whereIn('order_info.shipping_status', array(SS_RECEIVED))
							    			->whereIn('order_info.pay_status', array(PS_PAYED, PS_PAYING))
    										->select(RC_DB::raw('sum(goods_amount + shipping_fee + insure_fee + pay_fee + pack_fee + card_fee + tax - bonus - integral_money -discount) as total_amount'))->first();
    			
    			$total_amount = $total_amount['total_amount'];
    			
    			$arr = [
    				'store_id' 				=> intval($val->store_id),
    				'store_name'			=> $val->store_franchisee_model->merchants_name,
    				'formatted_add_time'	=> RC_Time::local_date('Y-m-d H:i:s', $val->store_franchisee_model->apply_time),
    				'referrer'				=> $referrer,
    				'total_number'			=> $total_number,
    				'total_amount'  		=> $total_amount,
    				'formatted_total_amount'=> ecjia_price_format($total_amount, false)
    			];
    			return $arr;
    		});
    		$list = $list->toArray();
    	}
    	return $list;
    }
}

// end
