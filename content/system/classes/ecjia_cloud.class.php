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
/**
 * ecjia cloud 业务处理类
 * @author royalwang
 *
 */
class ecjia_cloud extends RC_Object
{
    
    /**
     * 服务器地址
     * @var serverHost
     */
    const serverHost = 'https://cloud.ecjia.com/sites/api/?url=';
    
    const STATUS_ERROR = 'error';
    const STATUS_SUCCESS = 'success';
    
    /**
     * 需要发送的数据
     * @var $data
     */
    private $data   = array();
    /**
     * 接口
     * @var $api
     */
    private $api;
    
    private $cache_time;
    
    // 返回信息
    protected $status = self::STATUS_ERROR;
    
    protected $paginated;
    
    protected $return_data = array();
    
    protected $response;
    
    protected $is_cached = false;
    
    /**
     * 错误信息
     * @var $error
     */
    private $error;
    
    
    /**
     * 返回当前终级类对象的实例
     *
     * @param $cache_config 缓存配置
     * @return ecjia_cloud
     */
    public static function instance() {
        return static::make();
    }
    
    public function addError($code = '', $message = '', $data = '')
    {
        if (!is_ecjia_error($this->error)) {
            $this->error = new ecjia_error($code, $message, $data);
        } else {
            return $this->error->add($code, $message, $data);
        }
        
        return $this;
    }
    
    
    /**
     * 设置需要发送的数据
     * @param array $data
     * @return ecjia_cloud
     */
    public function data($data) {
        $this->data = $data;
        
        return $this;
    }
    
    
    /**
     * 设置API接口
     * @param string $api 例如 xx/xxx
     * @return ecjia_cloud
     */
    public function api($api) {
        $this->api = $api;
        
        return $this;
    }
    
    /**
     * 设置缓存的时间
     * @param integer $time
     * @return ecjia_cloud
     */
    public function cacheTime($time) {
        $this->cache_time = $time;
        
        return $this;
    }
    
    
    /**
     * 请求
     * @return ecjia_cloud
     */
    public function run() {        
        $cache_key = 'api_request_'.md5($this->api);
        $data = RC_Cache::app_cache_get($cache_key, 'system');

        if (!$this->cache_time || 'error' == $data['status'] || SYS_TIME - $this->cache_time > $data['timestamp']) {
            $fields['body'] = array(
                'json' => json_encode($this->data),
            );
            
            $response = RC_Http::remote_post(self::serverHost . $this->api, $fields);
            if (RC_Error::is_error($response)) {
                $this->addError($response->get_error_code(), $response->get_error_message(), $response->get_error_data());
                $this->status = self::STATUS_ERROR;
                return $this;
            }
            $this->response = $response;
            RC_Cache::app_cache_set($cache_key, array('body' => $this->response, 'status' => $this->status, 'timestamp' => SYS_TIME), 'system');
            $this->returnResolve($this->response['body']);
        } else {
            $this->is_cached = true;
            $this->returnResolve($data['body']);
        }

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
     * 获取请求状态
     * @return string | ecjia_cloud::STATUS_ERROR | ecjia_cloud::STATUS_SUCCESS
     */
    public function getStatus() {
        return $this->status;
    }
    
    /**
     * 获取分页数据
     * @return array
     */
    public function getPaginated() {
        return $this->paginated;
    }
    
    /**
     * 获取正常数据Data
     * @return array
     */
    public function getReturnData() {
        return $this->return_data;
    }
    
    /**
     * 获取整个请求返回内容
     */
    public function getResponse() {
        return $this->response;
    }
    
    /**
     * 获取内容是否缓存
     * @return boolean
     */
    public function isCached()
    {
        return $this->is_cached;
    }

    /**
     * 解析服务器返回的数据
     * @param string $data
     * @return ecjia_cloud
     */
    protected function returnResolve($data) {        
        $data = json_decode($data, true);
        if (!is_array($data) || !array_has($data, 'status') ) {
            $this->status = self::STATUS_ERROR;
            $this->addError('unknown_error', __('服务器返回信息错误！'));
            return $this;
        }
        
        if (!array_get($data, 'status.succeed')) {
            $this->status = self::STATUS_ERROR;
            $this->addError(array_get($data, 'status.error_code'), array_get($data, 'status.error_desc'));
            return $this;
        }
        
        $this->paginated = array_get($data, 'paginated', null);
        $this->status = self::STATUS_SUCCESS;
        $this->return_data = $data['data'];
        
        return $this;
    }
    
}

// end