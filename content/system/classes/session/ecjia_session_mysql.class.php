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
 * ECJIA SESSION
 */
RC_Loader::load_sys_class('session.ecjia_session_base', false);

class ecjia_session_mysql extends ecjia_session_base {
    private $session_db;
    private $session_data_db;

    /**
     * Session打开方法
     * 打开session后，由session机制载入session数据，不需要手动载入  
     * @see session_mysql::handler_open()
     */
    protected function open_session($save_path, $session_name) {
        $this->session_db      			= RC_Loader::load_model('session_model');
        $this->session_data_db 			= RC_Loader::load_model('session_data_model');
        
    	return true;
    }
    
    /**
     * Session关闭方法
     * @see session_mysql::handler_close()
     */
    protected function close_session() {
        $this->update_session(null, null);
        $this->gc_session($this->lifetime);
        return true;
    }
    
    
    protected function insert_session() {
    	$data = array(
    			'sesskey'    => $this->session_key,
    			'expiry'     => $this->expiration,
    			'ip'         => $this->_ip,
    			'discount'   => 1,
    			'data'       => 'a:0:{}',
    	);
    	return $this->session_db->insert($data);
    }
    
    
    protected function has_session() {
        $data = array(
            'sesskey'    => $this->session_key
        );
        $count = $this->session_db->where($data)->count();
        return $count;
    }
    
    
    /**
     * 数据插入
     * @param string $session_id
     * @param serialize $data
     */
    protected function update_session($session_id, $data) {
        $data = $_SESSION;
    	$adminid 	= !empty($data['admin_id']) ? intval($data['admin_id']) : 0;
    	$userid  	= !empty($data['user_id'])  ? intval($data['user_id'])  : 0;
    	$user_name  = !empty($data['user_name'])  ? trim($data['user_name'])  : 0;
    	$user_rank  = !empty($data['user_rank'])  ? intval($data['user_rank'])  : 0;
    	$discount 	= !empty($data['discount'])  ? round($data['discount'], 2)  : 0;
    	$email  	= !empty($data['email'])  ? trim($data['email']) : 0;
    	 
    	unset($data['admin_id']);
    	unset($data['user_id']);
    	unset($data['user_name']);
    	unset($data['user_rank']);
    	unset($data['discount']);
    	unset($data['email']);
    	unset($data['ip']);
    	 
    	$data = serialize($data);
    	
    	if ($this->session_md5 == md5($data) && $this->_time < $this->session_expiry) {
    		return true;
    	}
    	
    	if (isset($data{255})) {
    		$field_values = array(
    			'sesskey' => $this->session_key, 
    			'expiry' => $this->expiration, 
    			'data' => $data,
    		);
    		
    		$update_values = array(
    			'expiry' => $this->expiration,
    			'data' => $data,
    		);
    		
    		$this->session_data_db->auto_replace($field_values, $update_values);
     	
			$data = '';
    	}
    	 
    	$up_data = array(
    			'expiry' 	=> $this->expiration,
    			'ip' 		=> $this->_ip,
    			'userid' 	=> $userid,
    			'adminid' 	=> $adminid,
    			'user_name' => $user_name,
    			'user_rank' => $user_rank,
    			'discount' 	=> $discount,
    			'email' 	=> $email,
    			'data' 		=> $data,
    	);
    	
    	return $this->session_db->where("sesskey = '" . $this->session_key . "'")->update($up_data);
    }
    
    /**
     * 数据查找
     * @param string $session_id
     */
    protected function load_session($session_id) {
    	$session = $this->session_db->where("sesskey = '" . $this->session_key . "'")->field('userid, adminid, ip, user_name, user_rank, discount, email, data, expiry')->find();
    	
    	$data = array();
    	 
    	if (empty($session)) {
    		$this->insert_session();
    		$this->session_expiry 		= 0;
    		$this->session_md5    		= md5('a:0:{}');
    	} else {
    		if (!empty($session['data']) && $this->_time <= $session['expiry']) {
    			$this->session_expiry 	= $session['expiry'];
    			$this->session_md5    	= md5($session['data']);
    	
    			$data  					= unserialize($session['data']);
    			$data['user_id'] 		= $session['userid'];
    			$data['admin_id'] 		= $session['adminid'];
    			$data['user_name'] 		= $session['user_name'];
    			$data['user_rank'] 		= $session['user_rank'];
    			$data['discount'] 		= $session['discount'];
    			$data['email'] 			= $session['email'];
    			$data['ip'] 			= $session['ip'];
    		} else {
    			$session_data = $this->session_data_db->where("sesskey = '" . $this->session_key . "'")->field('data, expiry')->find();
    	
    			if (!empty($session_data['data']) && $this->_time <= $session_data['expiry']) {
    				$this->session_expiry 	= $session_data['expiry'];
    				$this->session_md5    	= md5($session_data['data']);
    				
    				$data 					= unserialize($session_data['data']);
    				$data['user_id'] 		= $session['userid'];
    				$data['admin_id'] 		= $session['adminid'];
    				$data['user_name'] 		= $session['user_name'];
    				$data['user_rank'] 		= $session['user_rank'];
    				$data['discount'] 		= $session['discount'];
    				$data['email'] 			= $session['email'];
    				$data['ip'] 			= $session['ip'];
    			} else {
    				$this->session_expiry 	= 0;
    				$this->session_md5    	= md5('a:0:{}');
    			}
    		}
    	}
    	
    	$_SESSION = $data;
    	
    	return session_id() ? session_encode() : null;
    }
    
    /**
     * 数据清除
     * @param string $session_id
     */
    protected function destroy_session($session_id) {
        $this->session_data_db->where(array('sesskey' => $this->session_key))->delete();        
        $result = $this->session_db->where(array('sesskey' => $this->session_key))->delete();
        return $result;
    }
    
    /**
     * 回收过期数据
     * @param string $expire_time
     */
    protected function gc_session($expire_time) {
    	// 垃圾回收执行
    	/* 由于垃圾回收机制有问题，暂时先注释观察 */
    	if (mt_rand(0, 2) == 2) {
    		$this->session_data_db->where("expiry < $this->_time")->delete();
    	}
    	if ((time() % 2) == 0) {
    		return $this->session_db->where("expiry < $this->_time")->delete();
    	}
    	return true;
    }
    
	/**
	 * 删除指定管理员的session
	 * @param int $adminid
	 * @return boolean
	 */
    public function delete_spec_admin_session($adminid) {
        if (!empty($_SESSION['admin_id']) && $adminid) {
            return $this->session_db->where("adminid = '$adminid'")->delete();
        } else {
            return false;
        }
    }

    /**
     * 获取当前在线用户总数
     * @return number
     */
    public function get_users_count() {
        return $this->session_db->count();
    }
    
    /**
     * 获取指定session_id的数据
     * @param string $session_id
     */
    public function get_session_data($session_id) {
        $session_key = substr($session_id, 0, 32);
        $session = $this->session_db->where("sesskey = '" . $session_key . "'")->field('userid, adminid, ip, user_name, user_rank, discount, email, data, expiry')->find();
         
        $data = array();
        
        if (!empty($session)) {
            if (!empty($session['data']) && $this->_time <= $session['expiry']) {
                $data  					= unserialize($session['data']);
                $data['user_id'] 		= $session['userid'];
                $data['admin_id'] 		= $session['adminid'];
                $data['user_name'] 		= $session['user_name'];
                $data['user_rank'] 		= $session['user_rank'];
                $data['discount'] 		= $session['discount'];
                $data['email'] 			= $session['email'];
                $data['ip'] 			= $session['ip'];
            } else {
                $session_data = $this->session_data_db->where("sesskey = '" . $session_key . "'")->field('data, expiry')->find();
                 
                if (!empty($session_data['data']) && $this->_time <= $session_data['expiry']) {
                    $data 					= unserialize($session_data['data']);
                    $data['user_id'] 		= $session['userid'];
                    $data['admin_id'] 		= $session['adminid'];
                    $data['user_name'] 		= $session['user_name'];
                    $data['user_rank'] 		= $session['user_rank'];
                    $data['discount'] 		= $session['discount'];
                    $data['email'] 			= $session['email'];
                    $data['ip'] 			= $session['ip'];
                }
            }
        }
        
        return $data;
    }
}

// end