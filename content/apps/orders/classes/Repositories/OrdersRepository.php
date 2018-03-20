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

namespace Ecjia\App\Orders\Repositories;

use Royalcms\Component\Repository\Repositories\AbstractRepository;
use ecjia_page;
use RC_DB;
use Ecjia\App\Orders\OrderStatus;

class OrdersRepository extends AbstractRepository
{
    protected $model = 'Ecjia\App\Orders\Models\OrdersModel';
    
    protected $orderBy = ['order_info.order_id' => 'desc'];
    
   
    public function findWhereLimit(array $where, $columns = ['*'], $page = 1, $perPage = 15, callable $callback = null)
    {
        $this->newQuery();
        
        $this->query->select($columns);
        
        if (is_callable($callback)) {
            $callback($this->query);
        }
        
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->query->where($field, $condition, $val);
            }
            else {
                $this->query->where($field, '=', $value);
            }
        }
        
        if ($page && $perPage) {
            $this->query->forPage($page, $perPage);
        }
        
        return $this->query->get();
    }
    
    
    public function findWhereCount(array $where, $columns = ['*'], callable $callback = null)
    {
        $this->newQuery();
        
        if (is_callable($callback)) {
            $callback($this->query);
        }
        
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->query->where($field, $condition, $val);
            }
            else {
                $this->query->where($field, '=', $value);
            }
        }
        
        return $this->query->count($columns);
    }
    
    
    /**
     *  获取用户指定范围的订单列表
     *
     * @param   int         $user_id        用户ID, 为0，获取所有用户的订单
     * @param   string      $type           订单类型，订单状态类型
     * @param   int         $page           列表当前页数
     * @param   int         $size           列表每页多少条
     * @param   string      $keywords       搜索关键词，可为订单号、商品名称
     * @param   string      $store_id       店铺ID，为null，获取所有店铺的订单
     * @param   string|array $with          关联表查询
     * @param   callable    $callback       查询结果回调处理
     * @return  array       $order_list     订单列表
     */
    public function getUserOrdersList($user_id, $type = null, $page = 1, $size = 15, $keywords = null, $store_id = null, $with = null, callable $callback = null)
    {
        $where = [
        	'order_info.is_delete' => 0,
        ];
        
        if ($user_id > 0) {
            $where['order_info.user_id'] = $user_id;
        }
        
        if ($store_id > 0) {
            $where['order_info.store_id'] = $store_id;
        }

        $field = [
        	'order_info.order_id',
        	'order_info.order_sn',
        	'order_info.order_status',
        	'order_info.shipping_status',
        	'order_info.pay_status',
        	'order_info.add_time',
        	'order_info.goods_amount',
        	'order_info.shipping_fee',
        	'order_info.insure_fee',
        	'order_info.pay_fee',
        	'order_info.pack_fee',
        	'order_info.card_fee',
        	'order_info.tax',
        	'order_info.integral_money',
        	'order_info.bonus',
        	'order_info.discount',
        	'order_info.pay_id',
        	'order_info.order_amount',
        	'order_info.store_id',
            'order_info.extension_code',
        ];
        
        if (!empty($keywords)) {
            $field[] = 'order_goods.goods_id';
            $field[] = 'order_goods.goods_name';
        }
        
        $whereQuery = null;
        if (!empty($type)) {
            $whereQuery = OrderStatus::getQueryOrder($type);
        }
        
        
        
        $table = RC_DB::getTableFullName('order_info');
        $count = $this->findWhereCount($where, RC_DB::raw("DISTINCT {$table}.order_id"), function($query) use ($keywords, $whereQuery) {
            if (!empty($keywords)) {
                $query->leftJoin('order_goods', function ($join) {
                    $join->on('order_info.order_id', '=', 'order_goods.order_id');
                });
                
                $query->where(function ($query) use ($keywords) {
                    return $query->where('order_goods.goods_name', 'like', '%' . $keywords .'%')
                          ->orWhere('order_info.order_sn', 'like', '%' . $keywords .'%');
                });
            }
            
            if (is_callable($whereQuery)) {
                $whereQuery($query);
            }
        });
        
        $orders = $this->findWhereLimit($where, $field, $page, $size, function($query) use ($keywords, $whereQuery, $with) {
            if (!empty($with)) {
                $query->with($with);
            }
            
            if (!empty($keywords)) {
                $query->leftJoin('order_goods', function ($join) {
                    $join->on('order_info.order_id', '=', 'order_goods.order_id');
                });
                    
                $query->where(function ($query) use ($keywords) {
                    $query->where('order_goods.goods_name', 'like', '%' . $keywords .'%')
                          ->orWhere('order_info.order_sn', 'like', '%' . $keywords .'%');
                });
            }
            
            if (is_callable($whereQuery)) {
                $whereQuery($query);
            }
        });
        
        if (is_callable($callback)) {
            return $callback($orders, $count);
        }
        
        return $orders;
    }
    
    
    /**
     * 获取订单列表
     */
    public function getOrderList(array $filter, $page, $size, $with = null, callable $callback = null)
    {
        /* 过滤信息 */
        $filter['order_sn']             = trim(array_get($filter, 'order_sn'));
        $filter['consignee']            = trim(array_get($filter, 'consignee'));
        $filter['keywords']             = trim(array_get($filter, 'keywords'));
        $filter['email']                = trim(array_get($filter, 'email'));
        $filter['address']              = trim(array_get($filter, 'address'));
        $filter['zipcode']              = trim(array_get($filter, 'zipcode'));
        $filter['tel']                  = trim(array_get($filter, 'tel'));
        $filter['mobile']               = trim(array_get($filter, 'mobile'));
        $filter['merchants_name']       = trim(array_get($filter, 'merchants_name'));
        $filter['merchant_keywords']    = trim(array_get($filter, 'merchant_keywords'));
        
        $filter['country']              = trim(array_get($filter, 'country'));
        $filter['province']             = trim(array_get($filter, 'province'));
        $filter['district']             = trim(array_get($filter, 'district'));
        
        $filter['shipping_id']          = intval(array_get($filter, 'shipping_id'));
        $filter['pay_id']               = intval(array_get($filter, 'pay_id'));
        $filter['status']               = intval(array_get($filter, 'status', -1));
        $filter['order_status']         = intval(array_get($filter, 'order_status', -1));
        $filter['shipping_status']      = intval(array_get($filter, 'shipping_status', -1));
        $filter['pay_status']           = intval(array_get($filter, 'pay_status', -1));
        
        $filter['user_id']              = intval(array_get($filter, 'user_id'));
        $filter['user_name']            = trim(array_get($filter, 'user_name'));
        $filter['composite_status']     = intval(array_get($filter, 'composite_status', -1));
        $filter['group_buy_id']         = intval(array_get($filter, 'group_buy_id'));
        $filter['sort_by']              = trim(array_get($filter, 'sort_by', 'add_time'));
        $filter['sort_order']           = trim(array_get($filter, 'sort_order', 'DESC'));
        
        $filter['start_time']           = trim(array_get($filter, 'start_time'));
        $filter['end_time']             = trim(array_get($filter, 'end_time'));
        $filter['type']                 = trim(array_get($filter, 'type'));
        
        
        $field = [
            'order_info.order_id',
            'order_info.store_id',
            'order_info.order_sn',
            'order_info.add_time',
            'order_info.order_status',
            'order_info.shipping_status',
            'order_info.order_amount',
            'order_info.money_paid',
            'order_info.pay_status',
            'order_info.consignee',
            'order_info.address',
            'order_info.email',
            'order_info.tel',
            'order_info.mobile',
            'order_info.extension_code',
            'order_info.extension_id',
        ];
        
        $where = [];
        
        $orders = $this->findWhereLimit($where, $field, $page, $size, function($query) use ($keywords, $whereQuery, $with) {
            if (!empty($with)) {
                $query->with($with);
            }
            
            if (!empty($keywords)) {
                $query->leftJoin('order_goods', function ($join) {
                    $join->on('order_info.order_id', '=', 'order_goods.order_id');
                });
            
                $query->where(function ($query) use ($keywords) {
                    $query->where('order_goods.goods_name', 'like', '%' . $keywords .'%')
                    ->orWhere('order_info.order_sn', 'like', '%' . $keywords .'%');
                });
            
                $query->groupby('order_info.order_id');
            }
            
            if (is_callable($whereQuery)) {
                $whereQuery($query);
            }
            
        });
        
        if (is_callable($callback)) {
            return $callback($orders, $count);
        }
        
        return $orders;
    }
    
    
    public function orderQuery(array $filter)
    {
        return function ($query) use ($filter) {
            if (array_get($filter, 'keywords')) {
                $query->where(function ($query) {
                    $query->where('order_info.order_sn', 'like', '%'.ecjia_mysql_like_quote(array_get($filter, 'keywords')).'%')
                    ->orWhere('order_info.consignee', 'like', '"%'.ecjia_mysql_like_quote(array_get($filter, 'keywords')).'%"');
                });
            } else {
                if (array_get($filter, 'order_sn')) {
                    $query->where('order_info.order_sn', 'like', '%'.ecjia_mysql_like_quote(array_get($filter, 'order_sn')).'%');
                }
                if (array_get($filter, 'consignee')) {
                    $query->where('order_info.consignee', 'like', '"%'.ecjia_mysql_like_quote(array_get($filter, 'consignee')).'%"');
                }
            }
            
            if (array_get($filter, 'email')) {
                $query->where('order_info.email', 'like', '%'.ecjia_mysql_like_quote(array_get($filter, 'email')).'%');
            }
            if (array_get($filter, 'address')) {
                $query->where('order_info.address', 'like', '%'.ecjia_mysql_like_quote(array_get($filter, 'address')).'%');
            }
            if (array_get($filter, 'zipcode')) {
                $query->where('order_info.zipcode', 'like', '%'.ecjia_mysql_like_quote(array_get($filter, 'zipcode')).'%');
            }
            if (array_get($filter, 'tel')) {
                $query->where('order_info.tel', 'like', '%'.ecjia_mysql_like_quote(array_get($filter, 'tel')).'%');
            }
            if (array_get($filter, 'mobile')) {
                $query->where('order_info.mobile', 'like', '%'.ecjia_mysql_like_quote(array_get($filter, 'mobile')).'%');
            }
            if (array_get($filter, 'country')) {
                $query->where('order_info.country', array_get($filter, 'country'));
            }
            if (array_get($filter, 'province')) {
                $query->where('order_info.province', array_get($filter, 'province'));
            }
            if (array_get($filter, 'city')) {
                $query->where('order_info.city', array_get($filter, 'city'));
            }
            if (array_get($filter, 'district')) {
                $query->where('order_info.district', array_get($filter, 'district'));
            }
            if (array_get($filter, 'shipping_id')) {
                $query->where('order_info.shipping_id', array_get($filter, 'shipping_id'));
            }
            if (array_get($filter, 'pay_id')) {
                $query->where('order_info.pay_id', array_get($filter, 'pay_id'));
            }
            if (array_get($filter, 'status') != -1) {
                $query->where(function ($query) {
                	$query->where('order_info.order_status', array_get($filter, 'status'))
                	       ->orWhere('order_info.shipping_status', array_get($filter, 'status'))
                	       ->orWhere('order_info.pay_status', array_get($filter, 'status'));
                });
            }
            if (array_get($filter, 'order_status') != -1) {
                $query->where('order_info.order_status', array_get($filter, 'order_status'));
            }
            if (array_get($filter, 'shipping_status') != -1) {
                $query->where('order_info.shipping_status', array_get($filter, 'shipping_status'));
            }
            if (array_get($filter, 'pay_status') != -1) {
                $query->where('order_info.pay_status', array_get($filter, 'pay_status'));
            }
            if (array_get($filter, 'start_time')) {
                $query->where('order_info.start_time', array_get($filter, '>=', 'start_time'));
            }
            if (array_get($filter, 'end_time')) {
                $query->where('order_info.start_time', array_get($filter, '<=', 'start_time'));
            }
            if (array_get($filter, 'group_buy_id')) {
                $query->where('order_info.extension_code', 'group_buy');
                $query->where('order_info.extension_id', array_get($filter, 'group_buy_id'));
            }
            
            
            if (array_get($filter, 'composite_status')) {
                //综合状态
                switch(array_get($filter, 'composite_status')) {
                	case CS_AWAIT_PAY :
                	    $whereQuery = OrderStatus::getQueryOrder('await_pay');
                	    $whereQuery($query);
                	    break;
                
                	case CS_AWAIT_SHIP :
                	    $whereQuery = OrderStatus::getQueryOrder('await_ship');
                	    $whereQuery($query);
                	    break;
                
                	case CS_FINISHED :
                	    $whereQuery = OrderStatus::getQueryOrder('finished');
                	    $whereQuery($query);
                	    break;
                
                	case CS_RECEIVED :
                	    $whereQuery = OrderStatus::getQueryOrder('received');
                	    $whereQuery($query);
                	    break;
                
                	case CS_SHIPPED :
                	    $whereQuery = OrderStatus::getQueryOrder('shipped');
                	    $whereQuery($query);
                	    break;
                	default:
                	    
                };
                
            }
        	
        };
    }
    
}

// end