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
 * ecjia api控制器父类
 */
namespace Ecjia\App\Api\BaseControllers;

use Ecjia\App\Api\Transformers\Transformer;
use Ecjia\System\BaseController\EcjiaController;
use ecjia_template_fileloader;
use RC_Config;
use RC_Hook;
use RC_Session;
use ecjia_view;
use ecjia_app;
use RC_Loader;
use RC_Api;

abstract class EcjiaApi extends EcjiaController implements ecjia_template_fileloader
{
    /**
     * @var array
     */
    protected $requestData = array();

    /**
     * @var null
     */
    protected $token = null;

    /**
     * @var array
     */
    protected $device = array();

    /**
     * @var null
     */
    protected $api_version = null;

    protected $api_driver = null;

	public function __construct()
    {
		parent::__construct();
		
		self::$controller = static::$controller;
		self::$view_object = static::$view_object;
		
		if (defined('DEBUG_MODE') == false) {
		    define('DEBUG_MODE', 0);
		}
		
		if (isset($_SERVER['PHP_SELF'])) {
		    $_SERVER['PHP_SELF'] = htmlspecialchars($_SERVER['PHP_SELF']);
		}
		
		if (RC_Config::get('system.debug')) {
		    error_reporting(E_ALL);
		} else {
		    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		}

		$this->visitorSession();

		$this->apiRequestProcess();
		
		RC_Hook::do_action('ecjia_api_finish_launching');
	}

    /**
     * 游客状态也需要设置一下session值
     */
	protected function visitorSession()
    {
        if (empty($_SESSION['user_id'])) {
            $_SESSION['user_id']     = 0;
            $_SESSION['user_name']   = '';
            $_SESSION['email']       = '';
            $_SESSION['user_rank']   = 0;
            $_SESSION['discount']    = 1.00;
            if (!isset($_SESSION['login_fail'])) {
                $_SESSION['login_fail'] = 0;
            }
        }
    }

    /**
     * @return ecjia_view
     */
	public function create_view()
	{
	    if ($this->api_driver == 'local') {
            return null;
        }

        return new ecjia_view($this);
	}

    /**
     * 加载hook文件
     */
	protected function load_hooks() 
	{
	    $apps = ecjia_app::installed_app_floders();
	    if (is_array($apps)) {
	        foreach ($apps as $app) {
	            RC_Loader::load_app_class('hooks.api_' . $app, $app, false);
	        }
	    }
	}
	
	/**
	 * 获得模板目录
	 * @return string
	 */
	public function get_template_dir()
    {
	    //不需要实现
	}
	
	/**
	 * 获得模板文件
	*/
	public function get_template_file($file)
    {
        //不需要实现
	}

    /**
     * ==================================================
     */

    protected function apiRequestProcess()
    {
        $request = royalcms('request');

        $json = $request->input('json');
        $jsonData = json_decode($json, true);
        if (empty($jsonData)) {
            $jsonData = [];
        }

        $this->requestData = array_merge($request->input(), $jsonData);

        $this->token = $this->requestData('token') ? $this->requestData('token') : $this->requestData('session.sid');

        $this->device['client'] = $request->header('device-client');
        $this->device['code']	= $request->header('device-code');
        $this->device['udid']	= $request->header('device-udid');
        $this->device['sn']	    = $request->header('device-sn');
        $this->api_version		= $request->header('api-version');
        $this->api_driver		= $request->header('api-driver');

        if ($this->api_driver != 'local') {
            RC_Api::api('stats', 'statsapi', array('api_name' => $request->input('url'), 'device' => $this->device));
            RC_Api::api('mobile', 'device_record', array('device' => $this->device));
        }

    }

    /**
     * 获取请求的设备信息
     *
     * @param $name
     * @return mixed
     */
	public function requestDevice($name, $default = null)
    {
        return array_get($this->device, $name, $default);
    }

    /**
     * 获取请求的token信息
     *
     * @return null
     */
    public function requestToken()
    {
        return $this->token;
    }

    /**
     * 获取请求的api版本
     *
     * @return null
     */
    public function requestApiVersion()
    {
        return $this->api_version;
    }

    /**
     * 获取请求的body中数组
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function requestData($key, $default = null)
    {
        $value = array_get($this->requestData, $key, $default);
        return $value;
    }

    /**
     * 获取请求中的上传文件
     *
     * @param null $key
     * @param null $default
     * @return mixed
     */
    public function requestFile($key = null, $default = null)
    {
        return $this->request->file($key, $default);
    }

    /**
     * 判断请求中是否含有上传文件
     *
     * @param $key
     * @return bool
     */
    public function hasRequestFile($key)
    {
        return $this->request->hasFile($key);
    }


    public function getValueByDefault($value, $default) {
        if (!is_array($value)) {
            $whiteList = array();
            if (is_array($default)) {
                $whiteList = $default;
                $default = isset($default[0]) ? $default[0] : $default;
            } elseif ($value == '') {
                return $default;
            }

            if (is_string($default)) {
                $value = trim($value);
            } elseif (is_int($default)) {
                $value = intval($value);
            } elseif (is_array($default)) {
                if ($value == '') {
                    return $default;
                }
                $value = (array)$value;
            } else {
                $value = floatval($value);
            }

            if ($whiteList && !in_array($value, $whiteList)) {
                $value = $default;
            }

        } else {
            foreach ($value as $key => $val) {
                $t = isset($default[$key]) ? $default[$key] : '';
                $value[$key] = $this->getValueByDefault($value[$key], $t);
            }
            if (is_array($default)) {
                $value += $default;
            }
        }

        return $value;
    }


    public static function transformerData($type, $data)
    {
        return Transformer::transformerData($type, $data);
    }



	
}

// end