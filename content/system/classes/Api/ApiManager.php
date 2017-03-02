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
namespace Ecjia\System\Api;

use ecjia_error;
use Royalcms\Component\Foundation\Object;
use UnexpectedValueException;
use Royalcms\Component\Support\Facades\Error as RC_Error;
use Royalcms\Component\Support\Facades\Session as RC_Session;
use Royalcms\Component\Foundation\Cache as RC_Cache;


abstract class ApiManager extends Object
{    
    /**
     * 接口
     * @var $api
     */
    protected $api;
    
    /**
     * 错误信息
     * @var $error
     */
    protected $error;
    
    protected $cacheTime;
    
    protected $hasPage = false;
    
    protected $response;
    
    protected $request;
    
    /**
     * constructor
     */
    public function __construct()
    {
        $this->error = new ecjia_error();
        $this->request = ApiRequest::create();
        $this->request->setMethod('POST');
    }
    
    /**
     * 服务器地址
     * @return serverHost
     */
    abstract public function serverHost();
    
    /**
     * 设置需要发送的数据
     * @param array $data
     * @return \Ecjia\System\Api\ApiManager
     */
    public function data($data) {
        $this->request->setParameters($data);
        
        return $this;
    }
    
    /**
     * 设置需要发送的Header
     * @param array $data
     * @return \Ecjia\System\Api\ApiManager
     */
    public function header($header) {
        $this->request->setHeader($header);
        
        return $this;
    }
    
    
    public function cookie($cookie) {
        $this->request->setCookie($cookie);
        
        return $this;
    }
    
    /**
     * 设置API接口
     * @param string $api 例如 xx/xxx
     * @return \Ecjia\System\Api\ApiManager
     */
    public function api($api) {
        $this->api = $api;
        return $this;
    }
    
    /**
     * 设置缓存的时间
     * @param integer $time
     * @return \Ecjia\System\Api\ApiManager
     */
    public function cacheTime($time) {
        $this->cacheTime = $time;
        return $this;
    }
    
    /**
     * 设置有Page返回
     * @return \Ecjia\System\Api\ApiManager
     */
    public function hasPage() {
        $this->hasPage = true;
        return $this;
    }
    
    
    /**
     * 获取错误对象
     * @return ecjia_error
     */
    public function getError() {
        return $this->error;
    }
    
    /**
     * 获取Api Response结果
     * 
     * @return \Ecjia\System\Api\ApiResponse
     */
    public function getResponse() {
        return $this->response;
    }
    
    /**
     * 获取Api Request结果
     *
     * @return \Ecjia\System\Api\ApiRequest
     */
    public function getRequest() {
        return $this->request;
    }
    
    /**
     * 请求
     * @return ecjia_error | array
     */
    public function run() {
        $cache_key = 'api_request_'.md5($this->api);
        $data = RC_Cache::app_cache_get($cache_key, 'system');
    
        if (!$this->cacheTime || 'error' == $data['status'] || SYS_TIME - $this->cacheTime > $data['timestamp']) {
            $response = $this->send();
            if (is_ecjia_error($response)) {
                return $this->error;
            }
            
            $body = $this->response->getResolve()->getData();
            $paginated = $this->response->getResolve()->getPaginated();

            RC_Cache::app_cache_set($cache_key, array('body' => $body, 'paginated' => $paginated, 'status' => $this->response->getResolve()->getStatus(), 'timestamp' => SYS_TIME), 'system');

            return $this->hasPage ? array($body, $paginated) : $body;
        } else {
            return $this->hasPage ? array($data['body'], $data['paginated']) : $data['body'];
        }
    }
    
    /**
     * 
     * @return ecjia_error|\Ecjia\System\Api\ApiResponse
     */
    public function send() {
        if ( ! $this->serverHost()) {
            $this->error->add('server_host_not_found', __('Const [serverHost] url not defined.'));
            return $this->error;
        }
        
        $serverHost = $this->serverHost();

        $this->request->setCookie($this->getCacheCookie());

        $response = $this->request->request($serverHost . $this->api);
        
        if (RC_Error::is_error($response)) {
            $this->error->add($response->get_error_code(), $response->get_error_message(), $response->get_error_data());
            return $this->error;
        }
        
        $this->response = ApiResponse::create($response);
        $this->response->setResolve(new ResolveBody());

        if ($this->response->getResolve()->getStatus() == 'error') {
            $this->error->add($this->response->getResolve()->getErrorCode(), $this->response->getResolve()->getErrorMessage());
            return $this->error;
        }
        
        $this->cacheCookie($this->response->getCookies());

        return $this->response;
    }
    
    
    protected function cacheCookie($cookie) {
        $cache_key = 'api_request_cookie::'. RC_Session::session_id();
        
        RC_Cache::app_cache_set($cache_key, $cookie, 'system'); 
    }
    
    protected function getCacheCookie() {
        $cache_key = 'api_request_cookie::'. RC_Session::session_id();
        
        $data = RC_Cache::app_cache_get($cache_key, 'system');

        return $data ?: array();
    }
        
}

// end