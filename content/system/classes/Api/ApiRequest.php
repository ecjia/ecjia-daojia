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

use Royalcms\Component\HttpRequest\HttpRequest as RC_Http;

/**
 * @file
 *
 * ApiRequest
 */

class ApiRequest {
    
    protected $url;
    
    protected $method = 'GET';
    
    protected $timeout = 5;
    
    protected $httpVersion = '1.1';
    
    protected $blocking = true;
    
    protected $headers = array();
    
    protected $body;
    
    protected $cookies = array();

    /**
     * 构造函数
     *
     * @param mixed   $content
     * @param integer $status
     * @param array   $params
     *
     * @api
     */
    public function __construct(array $params = array()) {
        $this->body = $params;
    }
    
    /**
     * 设置Cookies数组
     * @param array $cookies
     * @return \Ecjia\System\Api\ApiRequest
     */
    public function setCookie(array $cookies) {
        $this->cookies = $cookies;
        
        return $this;
    }
    
    /**
     * 获取Cookies数组
     * @return multitype:
     */
    public function getCookie() {
        return $this->cookies;
    }
    
    /**
     * 设置Http Header信息，数组格式
     * 
     * @param array $header
     * @return \Ecjia\System\Api\ApiRequest
     */
    public function setHeader(array $header) {
        $this->headers = $header;
        
        return $this;
    }
    
    public function getHeader($key, $default = null) {
        return array_get($this->headers, $key, $default);
    }
    
    public function getHeaders() {
        return $this->headers;
    }
    
    public function setMethod($method) {
        $this->method = $method;
        
        return $this;
    }
    
    public function getMethod() {
        return $this->method;
    }
    
    /**
     * 是否有指定名称的元素
     *
     * @return bool
     *
     * @api
     */
    public function hasParameter($name) {
        return isset($this->body[$name]);
    }
    
    /**
     * 获取指定名称的元素
     *
     * @return mixed|null
     *
     * @api
     */
    public function getParameter($name, $default = null) {
        return isset($this->body[$name]) ? $this->body[$name] : $default;
    }
    public function get($name, $default = null) {
        return $this->getParameter($name, $default);
    }
    
    /**
     * 获取指定名称的多个元素
     *
     * @return mixed|null
     *
     * @api
     */
    public function getParameters($names = null) {
        if (is_array($names)) {
            foreach ($names as $name) {
                $return[$name] = $this->getParameter($name);
            }
            return $return;
        } elseif (!isset($names)) {
            return $this->body;
        }
    }
    
    /**
     * 设置指定名称的元素
     *
     * @api
     */
    public function setParameter($name, $value = null) {
        if (is_null($value)) {
            unset($this->body[$name]);
        } else {
            $this->body[$name] = $value;
        }
        
        return $this;
    }
    
    /**
     * 设置指定名称的一批元素
     *
     * @api
     */
    public function setParameters(array $values) {
        $this->body = $values + $this->body;
        
        return $this;
    }

    /**
     * 重置parameters
     *
     * @api
     */
    public function replace(array $params = array()) {
        $this->body = $params;
    }

    /**
     * 清空parameters
     *
     * @api
     */
    public function flush() {
        $this->body = array();
    }
    
    /**
     * 读取所有的keys
     *
     * @api
     */
    public function keys() {
        return array_keys($this->body);
    }
    
    /**
     * 发送API请求
     */
    public function request($url) {
        $this->url = $url;
        
        return RC_Http::remote_request($this->url, $this->process());
    }
    
    /**
     * 拼装结果
     *
     * @api
     */
    public function process() {
        return array(
            'method'    => $this->method,
            'timeout'   => $this->timeout,
            'httpversion' => $this->httpVersion,
            'blocking'  => $this->blocking,
            'body'      => $this->body,
            'headers'   => $this->headers,
            'cookies'   => $this->cookies,
        );
    }
    
    /**
     * 魔术方法
     *
     * @api
     */
    public function __toString() {
        return var_export($this->process(), true);
    }
    
    //自身迭代
    public static function create(array $params = array()) {
        return new static($params);
    }
    
}
