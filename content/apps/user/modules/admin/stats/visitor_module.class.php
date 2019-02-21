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
 * ##访客数量
 * @author luchongchong
 */
class admin_stats_visitor_module extends api_admin implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {

        $this->authadminSession();
        $result = $this->admin_priv('flow_stats');

        if (is_ecjia_error($result)) {
            return $result;
        }
        //传入参数
        $start_date = $this->requestData('start_date');
        $end_date   = $this->requestData('end_date');
        if (empty($start_date) || empty($end_date)) {
            return new ecjia_error(101, __('参数错误', 'user'));
        }
        $cache_key = 'admin_stats_visitor_' . md5($start_date . $end_date);
        $data      = RC_Cache::app_cache_get($cache_key, 'api');

        if (empty($data)) {
            $response = $this->visitor($start_date, $end_date);
            RC_Cache::app_cache_set($cache_key, $response, 'api', 60);
            //流程逻辑结束
        } else {
            $response = $data;
        }
        return $response;
    }


    private function visitor($start_date, $end_date)
    {
        $type = $start_date == $end_date ? 'time' : 'day';

        $start_date = RC_Time::local_strtotime($start_date . ' 00:00:00');
        $end_date   = RC_Time::local_strtotime($end_date . ' 23:59:59');

        //$db_stats = RC_Model::model('stats/stats_model');

        /* 计算出有多少天*/
        $day = round(($end_date - $start_date) / (24 * 60 * 60));
        /* 计算时间刻度*/
        $group_scale = ($end_date + 1 - $start_date) / 6;
        $stats_scale = ($end_date + 1 - $start_date) / 30;

        //$where = array();

// 	/* 判断请求时间，一天按小时返回*/
// 	if ($type == 'day') {
// 		$field = "CONCAT(FROM_UNIXTIME(access_time, '%Y-%m-%d'), ' 00:00:00') as new_day,count(DISTINCT ip_address) as visitors";
// 	} else {
// 		$field = "CONCAT(FROM_UNIXTIME(access_time, '%Y-%m-%d %H'), ':00:00') as new_day,count(DISTINCT ip_address) as visitors";
// 	}
// 	$arr = $db_stats->field("count(visit_times) as visit_times,count(DISTINCT ip_address) as visitor_number")->where($where)->find();

// 	$total_visitors	= $arr['visitor_number'];
// 	$visit_times	= $arr['visit_times'];
// 	$web_visitors	= $arr['visitor_number'];

        $field = 'count(visit_times) as visit_times,count(DISTINCT ip_address) as visitor_number';

        $total_visitors  = $visit_times = $web_visitors = 0;
        $stats           = $group = array();
        $temp_start_time = $start_date;
        $now_time        = RC_Time::gmtime();
        $j               = 1;
        while ($j <= 30) {
            if ($temp_start_time > $now_time) {
                break;
            }
            $temp_end_time = $temp_start_time + $stats_scale;
            if ($j == 30) {
                $temp_end_time = $temp_end_time - 1;
            }
            $temp_total_visitors = 0;
            //$result = $db_stats->field($field)
            //    ->where(array_merge($where,array('access_time >="' .$temp_start_time. '" and access_time<="' .$temp_end_time. '"')))
            //    ->group('ip_address')
            //    ->order(array('access_time' => 'asc'))
            //    ->select();

            $result = RC_DB::table('stats')->where('access_time', '>=', $temp_start_time)->where('access_time', '<=', $temp_end_time)
                ->groupBy(RC_DB::raw('ip_address'))
                ->orderBy('access_time', 'asc')
                ->get();

            if (!empty($result)) {
                foreach ($result as $val) {
                    $temp_total_visitors += $val['visitor_number'];
                    $total_visitors      += $val['visitor_number'];
                    $visit_times         += $val['visit_times'];
                }
                $stats[] = array(
                    'time'           => $temp_start_time,
                    'formatted_time' => RC_Time::local_date('Y-m-d H:i:s', $temp_start_time),
                    'visitors'       => $temp_total_visitors,
                    'value'          => $temp_total_visitors,
                );
            } else {
                $stats[] = array(
                    'time'           => $temp_start_time,
                    'formatted_time' => RC_Time::local_date('Y-m-d H:i:s', $temp_start_time),
                    'visitors'       => 0,
                    'value'          => 0,
                );
            }
            $temp_start_time += $stats_scale;
            $j++;
        }

        $i          = 1;
        $temp_group = $start_date;
        while ($i <= 7) {
            if ($i == 7) {
                $group[] = array(
                    'time'           => $end_date,
                    'formatted_time' => RC_Time::local_date('Y-m-d H:i:s', $end_date),
                );
                break;
            }
            $group[]    = array(
                'time'           => $temp_group,
                'formatted_time' => RC_Time::local_date('Y-m-d H:i:s', $temp_group),
            );
            $temp_group += $group_scale;
            $i++;
        }


        $mobile_visitors = round($total_visitors * 0.2);//先做虚拟的
        $data            = array(
            'stats'           => $stats,
            'group'           => $group,
            'total_visitors'  => $total_visitors + $mobile_visitors,
            'visit_times'     => $visit_times,
            'mobile_visitors' => $mobile_visitors,
            'web_visitors'    => $total_visitors
        );
        return $data;
    }


}


// end
