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
RC_Loader::load_sys_class('session.ecjia_session_interface', false);
abstract class ecjia_session_base implements \SessionHandlerInterface, ecjia_session_interface {

    protected $session_key;
    
    protected $session_expiry 		= 0;
    protected $session_md5    		= null;
    
    protected $_ip  		 			= null;
    protected $_time 					= 0;
    /**
     * 生存周期时间，分钟数，多少分钟后过期
     * @var int
     */
    protected $lifetime;
    /**
     * 到期时间，时间戳，具体时间秒数
     * @var int
     */
    protected $expiration;
    
    public function __construct() {
        $this->_ip = RC_Ip::client_ip();
        $this->_time = SYS_TIME;
        // 秒数不能超过60×60×24×30（30天时间的秒数）
        // 如果失效的值大于这个值， 服务端会将其作为一个真实的Unix时间戳来处理而不是 自当前时间的偏移。
        $this->lifetime = $this->lifetime ?: RC_Config::get('session.lifetime', 60) * 60;
        $this->expiration = $this->_time + $this->lifetime;

        RC_Hook::add_filter('rc_session_generate_id', array($this, 'hook_session_generate_id'));
    }
    
    public function hook_session_generate_id($session_id) {
        return $this->generateSessionId();
    }
    
    /**
     * 验证session id
     * @param string $session_id
     */
    protected function verifySessionId($session_id) {
        $tmp_session_id = substr($session_id, 0, 32);
        $this->session_key = $tmp_session_id;
        return true;
        
        //session id暂不校验，直接返回
        if ($this->generateChecksum($tmp_session_id) == substr($session_id, 32)) {
            $this->session_key = $tmp_session_id;
            return true;
        } else {
            $this->clearCookie();
            return false;
        }
    }
    
    /**
     * 生成session 校验码
     * @param string $session_id
     * @return string
     */
    protected function generateChecksum($session_id) {
        //加密因子 SITE_ROOT . $this->_ip . $session_id
        return sprintf('%08x', crc32(SITE_ROOT . $session_id));
    }
    
    /**
     * 生成session key
     * @param string $session_id
     * @return string
     */
    protected function generateSessionKey() {
        return md5(uniqid(mt_rand(), true));
    }
    
    /**
     * 生成新的session id
     */
    public function generateSessionId() {
        // 设置session_key
        $session_key = $this->generateSessionKey();
        // 设置session_id
        $session_id = $session_key . $this->generateChecksum($session_key);
        
        return $session_id;
    }
    
    public function getSessionKey() {
        return $this->session_key;
    }
    
    public function getLifeTime() {
        return $this->lifetime;
    }
    
    /**
     * 清除本地的Cookie
     */
    public function clearCookie() {
        // 如果要清理的更彻底，那么同时删除会话 cookie
        // 注意：这样不但销毁了会话中的数据，还同时销毁了会话本身
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
            session_name(),
            '',
            $this->_time - 43200,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
            );
        }
    }
    
    
    /**
     * 获取真正的session id
     * @return string
     */
    public function get_session_id() {
        return $this->getSessionKey();
    }
    
    /**
     * session_set_save_handler open方法
     *
     * @param $save_path
     * @param $session_name
     * @return true
     */
    public function open($save_path, $name)
    {        
    	$this->verifySessionId(session_id());
        return $this->open_session($save_path, $name);
    }
    
    /**
     * session_set_save_handler close方法
     *
     * @return bool
     */
    public function close()
    {
        return $this->close_session();
    }
    
    /**
     * 读取session_id
     * session_set_save_handler read方法
     *
     * @return string 读取session_id
     */
    public function read($session_id)
    {
        if ($this->verifySessionId($session_id)) 
        {
            return $this->load_session($session_id);
        }
        
        return null;
    }
    
    /**
     * 写入session_id 的值
     *
     * @param $id session
     * @param $data 值
     * @return mixed query 执行结果
     */
    public function write($session_id, $session_data)
    {
        if ($this->verifySessionId($session_id))
        {
            return $this->update_session($session_id, $session_data);
        }
        return false;
    }
    
    /**
     * 删除指定的session_id
     *
     * @param $id session
     * @return bool $this->db->delete(array('sessionid'=>$id));
     */
    public function destroy($session_id)
    {
        if ($this->verifySessionId($session_id))
        {
            // 如果要清理的更彻底，那么同时删除会话 cookie
            // 注意：这样不但销毁了会话中的数据，还同时销毁了会话本身
            $this->clearCookie();
            return $this->destroy_session($session_id);
        }
        
        return false;
    }
    
    /**
     * 删除过期的 session
     *
     * @param $maxlifetime 存活期时间
     * @return bool $this->db->delete("`lastvisit`<$expiretime");
     */
    public function gc($maxlifetime)
    {
        return $this->gc_session($maxlifetime);
    }
}