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

class cron_run {
    private $cron_method;
    private $error;
    private $timestamp;
    private $db;
    
    public function __construct() {
        $this->cron_method = RC_Package::package('app::cron')->loadClass('cron_method');
        $this->error = new ecjia_error();
        $this->timestamp = RC_Time::gmtime();
        $this->db = RC_Package::package('app::cron')->loadModel('crons_model');
        RC_Package::package('app::cron')->loadClass('cron_nexttime', false);
        RC_Package::package('app::cron')->loadClass('cron_helper', false);
    }
    
    /**
     * 运行计划任务
     */
    public function run() {
        $this->check_method();
        
        $crondb = $this->cron_method->getCronInfo(); // 获得需要执行的计划任务数据
        
        foreach ($crondb AS $key => $cron_val) {
            if (!$this->check_allow_ip($cron_val)) {
                continue;
            }
             
            if (!$this->check_allow_files($cron_val)) {
                continue;
            }
            
            if (!$this->check_allow_hour($cron_val)) {
                continue;
            }
             
            if (!$this->check_allow_minute($cron_val)) {
                continue;
            }
            
            $handler = $this->cron_method->pluginInstance($cron_val['cron_code'], $cron_val['cron_config']);
            if (!$handler) {
                $this->error->add('code_not_found', $cron_val['cron_code'] . ' plugin not found!');
                continue;
            }
             
            $error = $handler->run();
            if (is_ecjia_error($error)) {
                $this->error->add($error->get_error_code(), $error->get_error_message());
            }
           
            $this->save_run_time($cron_val);
        }
        
        $this->write_error_log();
    }
    
    
    
    /**
     * 记录运行时间
     * @param array $param
     */
    protected function save_run_time($param) {
        $close = $param['run_once'] ? 0 : 1;
       
        $next_time = cron_nexttime::make($param['cron'])->getNextTime();
        
        $data = array(
        	'thistime' => $this->timestamp,
            'nextime' => $next_time,
            'enable' => $close,
        );
        
        $where = array(
        	'cron_id' => $param['cron_id'],
        );
        
        $this->db->where($where)->update($data);
    }
    
    /**
     * 保存错误日志
     */
    protected function write_error_log() {
        $error = $this->error->get_error_messages();
        if ( ! empty($error)) {
            RC_Logger::getLogger('cron')->error($error);
        }
    }
   
    /**
     * 检查设置了允许ip
     * @param unknown $param
     */
    protected function check_allow_ip($param) {
    	if (!$param['allow_ip']) {
    		return true;
    	}
    	
        $allow_ip = explode(',', $param['allow_ip']);
        $server_ip = RC_Ip::server_ip();
        if (!in_array($server_ip, $allow_ip)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * 检查设置允许调用文件
     * @param unknown $param
     */
    protected function check_allow_files($param) {
        $f_info = parse_url($_SERVER['HTTP_REFERER']);
        
        $f_get = array();
        parse_str($f_info['query'], $f_get);
        
        if (isset($f_get['m'])) {
            $f_m = $f_get['m'];
        } else {
            $f_m = RC_Config::get('route.default.m');
        }
        
        if ($f_m == RC_Config::get('system.admin_entrance')) {
            $f_m = 'system';
        }
        
        $f = explode(',', $param['alow_files']);
        if (!in_array($f_m, $f)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * 检查设置了允许小时段
     * @param unknown $param
     */
    protected function check_allow_hour($param) {
        $hour = $param['hour'];
        $hour_now = intval(RC_Time::local_date('G', $this->timestamp));
        if ($hour_now != $hour) {
            return false;
        }
    
        return true;
    }
    
    /**
     * 检查设置了允许分钟段
     * @param unknown $param
     */
    protected function check_allow_minute($param) {
        $m = explode(',', $param['minute']);
        $m_now = intval(RC_Time::local_date('i', $this->timestamp));
        if (!in_array($m_now, $m)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * 检查计划任务运行的模式，是Web请求，还是CLI命令模式
     */
    protected function check_method() {
        $if_cron = PHP_SAPI == 'cli' ? true : false;
        
        if (ecjia_config::has('cron_method')) {
            if (!$if_cron)
            {
                die('Hacking attempt');
            }
        } else {
            if ($if_cron) {
                die('Hacking attempt');
            } elseif (!isset($_GET['t']) || $this->timestamp - intval($_GET['t']) > 60 || empty($_SERVER['HTTP_REFERER'])) {
                exit('-1');
            }
        }
    }
}

// end