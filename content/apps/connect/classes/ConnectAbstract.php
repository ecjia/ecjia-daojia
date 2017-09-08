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
namespace Ecjia\App\Connect;

use Ecjia\System\Plugin\AbstractPlugin;

/**
 * 短信插件抽象类
 * @author royalwang
 */
abstract class ConnectAbstract extends AbstractPlugin {
    
    protected $profile = [];
    
    protected $open_id;
    protected $access_token;
    protected $refresh_token;
    protected $expires_in;
	
    /**
     * 生成默认用户名
     * @return string
     */
    public function default_generate_username() {
        /* 不是用户注册，则创建随机用户名*/
        return 'a' . rc_random(10, 'abcdefghijklmnopqrstuvwxyz0123456789');;
    }
    
    /**
     * 生成默认邮箱
     * @return string
     */
    public function default_generate_email() {
        /* 不是用户注册，则创建随机用户名*/
        $string = 'a' . rc_random(10, 'abcdefghijklmnopqrstuvwxyz0123456789');
        $email = $string.'@163.com';
        return $email;
    }
    
    /**
     * 生成默认密码
     * @return string
     */
    public function default_generate_password() {
        $password = md5(rc_random(9, 'abcdefghijklmnopqrstuvwxyz0123456789'));
        return $password;
    }
    
    /**
     * 设置用户信息
     * @param array $profile
     * @return \Ecjia\App\Connect\ConnectAbstract
     */
    public function setProfile(array $profile)
    {
        $this->profile = $profile;
        
        return $this;
    }
    
    /**
     * 获取用户信息
     * @return array
     */
    public function getProfile()
    {
        return $this->profile;
    }
    
    /**
     * 获取access token
     */
    public function access_token($callback_url, $code) {
    
    }
    
    /**
     * 使用refresh token 获取新的access token
     * @param unknown $refresh_token
     */
    public function access_token_refresh($refresh_token) {
    
    }
    
    /**
     * 获取登录用户信息
     */
    public function me() {
    
    }
    
    /**
     * 调用接口
     * 示例：获取登录用户信息
     * $result = $obj->api('users/me', array(), 'GET');
     */
    public function api($url, $params = array(), $method = 'GET') {
    
    }
    
    /**
     * 生成授权网址
     */
    abstract function authorize_url();
    
    /**
     * 登录成功后回调处理
     * @param $user_type 用户类型
     *          ConnectUser::USER,
     *          ConnectUser::MERCHANT,
     *          ConnectUser::ADMIN
     * @see \Ecjia\App\Connect\ConnectAbstract::callback()
     * @return \Ecjia\App\Connect\ConnectUser
     */
    abstract public function callback($user_type = 'user');
    
    /**
     * 获取用户名
     */
    public function get_username() {
        return $this->default_generate_username();
    }
    
    /**
     * 获取用户头像
     */
    public function get_headerimg() {
        
    }
    
    /**
     * 获取email
     */
    public function get_email() {
        return $this->default_generate_email();
    }
    
    /**
     * 获取password
     */
    public function get_password() {
        return $this->default_generate_password();
    }
   
}

// end