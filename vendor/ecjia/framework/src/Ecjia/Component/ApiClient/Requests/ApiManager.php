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
namespace Ecjia\Component\ApiClient\Requests;

use ecjia_error;
use RC_Object;
use Ecjia\Component\ApiClient\Requests\Actions\ActionFactory;

abstract class ApiManager extends RC_Object
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

    /**
     * @var \Ecjia\App\Api\Requests\ApiResponse
     */
    protected $response;

    /**
     * @var \Ecjia\App\Api\Requests\Actions\BaseAction
     */
    protected $request;

    protected $driver = 'remote';

    protected $method = 'GET';
    
    /**
     * constructor
     */
    public function __construct()
    {
        $this->error = new ecjia_error();
        $this->method = 'POST';

        $this->request = ActionFactory::instance($this->driver);
        $this->request->setApiManager($this);
    }

    /**
     * 设置API接口
     * @param string $api 例如 xx/xxx
     * @return $this
     */
    public function api($api)
    {
        $this->api = $api;

        return $this;
    }

    /**
     * @return string
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @return mixed
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * @param $method
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }
    
    /**
     * 服务器地址
     * @return string serverHost
     */
    abstract public function serverHost();
    
    /**
     * 设置需要发送的数据
     * @param array $data
     * @return $this
     */
    public function data($data)
    {
        $this->request->setParameters($data);
        
        return $this;
    }
    
    /**
     * 设置需要发送的Header
     * @param array $data
     * @return $this
     */
    public function header(array $header)
    {
        $this->request->setHeaders($header);
        
        return $this;
    }
    
    /**
     * 设置POST FILE上传信息，数组格式
     * @param array $data
     * @return $this
     */
    public function file(array $file)
    {
        $this->request->setFiles($file);
        
        return $this;
    }
    
    public function cookie(array $cookie)
    {
        $this->request->setCookies($cookie);
        
        return $this;
    }
    

    
    /**
     * 设置缓存的时间，单位分钟
     * @param integer $time
     * @return $this
     */
    public function cacheTime($time)
    {
        $this->cacheTime = $time;

        return $this;
    }
    
    /**
     * 设置有Page返回
     * @return $this
     */
    public function hasPage()
    {
        $this->hasPage = true;

        return $this;
    }

    public function get($name, $default = null)
    {
        return $this->request->getParameter($name, $default);
    }
    
    
    /**
     * 获取错误对象
     * @return ecjia_error
     */
    public function getError()
    {
        return $this->error;
    }
    
    /**
     * 获取Api Response结果
     * 
     * @return \Ecjia\App\Api\Requests\ApiResponse
     */
    public function getResponse()
    {
        return $this->response;
    }
    
    /**
     * 获取Api Request结果
     *
     * @return \Ecjia\App\Api\Requests\Actions\BaseAction
     */
    public function getRequest()
    {
        return $this->request;
    }
    
    /**
     * 请求
     * @return ecjia_error | array
     */
    public function run()
    {
        if ($this->cacheTime > 0) {
            $cache_key = $this->cacheResponseKey();
            $data = ecjia_cache('api')->get($cache_key);
        } else {
            $data = null;
        }

        /**
         * 缓存判断第一条件：缓存时间设置
         * 如果设置缓存时间，缓存才生效
         *
         * 第二条件：缓存数据必须取到，如果取不数据，缓存无效
         * 此条件判断，已经包含了缓存有效期了
         *
         * 第三条件：缓存数据的状态必须成功，如果是error，缓存无效
         *
         */
        if (!$this->cacheTime || empty($data) || 'error' == $data['status']) {
            $response = $this->send();
            if (is_ecjia_error($response)) {
                return $this->error;
            }

            $body = $this->response->getResolveBody()->getData();
            $paginated = $this->response->getResolveBody()->getPaginated();

            if ($this->cacheTime > 0) {
                $this->cacheResponse($body, $paginated);
            }

            return $this->hasPage ? array($body, $paginated) : $body;
        } else {
            return $this->hasPage ? array($data['body'], $data['paginated']) : $data['body'];
        }
    }
    
    /**
     * 
     * @return ecjia_error|\Ecjia\App\Api\Requests\ApiResponse
     */
    public function send()
    {
        try {
            $response = $this->request->send();

            $this->response = ApiResponse::create($response);
            $this->response->setResolveBody(new ResolveEcjiaBody());

            if ($this->response->getResolveBody()->getStatus() == 'error') {
                $this->error->add($this->response->getResolveBody()->getErrorCode(), $this->response->getResolveBody()->getErrorMessage());
                return $this->error;
            }

            return $this->response;
        }
        catch (\Exception $e) {
            $this->error->add(get_class($e), $e->getMessage());
            return $this->error;
        }
    }

    protected function cacheResponseKey()
    {
        $cache_key = 'api_request_'.md5($this->api);
        return $cache_key;
    }

    protected function cacheResponse($body, $paginated)
    {
        
        if ($this->cacheTime > 0) {

            $cache_key = $this->cacheResponseKey();

            ecjia_cache('api')->put($cache_key,
                array(
                    'body' => $body,
                    'paginated' => $paginated,
                    'status' => $this->response->getResolveBody()->getStatus(),
                ), $this->cacheTime);
        }
    }


    /**
     * 自身迭代
     *
     * @param array $params
     * @return static
     */
    public static function create()
    {
        return new static();
    }
        
}

// end