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

namespace Ecjia\System\BaseController;

use ecjia;
use Ecjia\Component\ShowMessage\Options\JsonShowMessageOption;
use Ecjia\Component\ShowMessage\Options\PjaxShowMessageOption;
use Ecjia\Component\ShowMessage\ShowMessage;
use ecjia_utility;
use RC_Redirect;
use RC_Response;
use RC_Package;
use Royalcms\Component\Routing\Controller as RoyalcmsController;


/**
 * ECJIA 控制器基础类
 * 原类名 ecjia_base
 *
 * @method string display($resource_name, $cache_id = null, $show = true, $options = array()) 显示视图
 * @method string fetch($tpl_file = null, $cache_id = null, $options = array()) 获得视图显示内容 用于生成静态或生成缓存文件
 * @method string fetch_string($tpl_string = null, $cache_id = null, $options = array()) 使用字符串作为模板，获取解析后输出内容
 * @method bool is_cached($resource_name, $cache_id = null, $options = array()) 模板缓存是否过期
 * @method bool clear_cache($resource_name, $cache_id = null, $options = array()) 清除单个模板缓存
 * @method bool clear_all_cache($cache_time = null, $options = array()) 清除全部缓存
 * @method void assign($name, $value = null) 向模版注册变量
 * @method void assign_lang($lang = array()) 重新向模版注册语言包
 * @method bool clear_compiled_files() 清除模版编译文件
 * @method bool clear_cache_files() 清除缓存文件
 */
abstract class EcjiaController extends RoyalcmsController
{
    /**
     * 模板视图对象
     *
     * @var \ecjia_view
     */
    protected $view;

    protected $view_method = [
        'display',
        'fetch',
        'fetch_string',
        'is_cached',
        'clear_cache',
        'clear_all_cache',
        'assign',
        'assign_lang',
        'clear_compiled_files',
        'clear_cache_files'
    ];
    
    /**
     * HTTP请求对象
     * @var \Royalcms\Component\Http\Request
     */
    protected $request;

    /**
     * 模板视图对象静态属性
     *
     * @var \ecjia_view
     */
    public static $view_object;

    /**
     * 控制器对象静态属性
     * @var \Ecjia\System\BaseController\EcjiaController
     */
    public static $controller;

    /**
     * 公开路由控制器
     *
     * @var array
     */
    protected $public_route = [];


    /**
     * 构造函数
     *
     * @access  public
     * @param   string      $ver        版本号
     *
     * @return  void
     */
    public function __construct()
    {
        $this->request = royalcms('request');
        
        $this->session_start();

        $this->registerServiceProvider();
        $this->registerViewServiceProvider();
        
        static::$controller = & $this;
        static::$view_object = & $this->view;

        $this->load_hooks();
    }
    
    
    public function __call($method, $parameters) 
    {
        if (in_array($method, $this->view_method)) {
            return call_user_func_array(array($this->view, $method), $parameters);
        }
        
        return parent::__call($method, $parameters);
    }

    /**
     * @return \Royalcms\Component\Http\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    public function setResponse($response)
    {
        royalcms()->instance('response', $response);

        return $response;
    }

    protected function registerServiceProvider()
    {
        //sub class to do...
    }

    protected function registerViewServiceProvider()
    {
        royalcms()->forgeRegister('Royalcms\Component\SmartyView\SmartyServiceProvider');

        $this->view = $this->create_view();
    }

    /**
     * 验证公开路由是否通过
     *
     * @return bool
     */
    public function isVerificationPublicRoute()
    {
        $route_controller = $this->getRouteController();
        if (in_array($route_controller, $this->public_route)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */
    public function getRouteController()
    {
        $route_m = (royalcms('default-router')->getModule() == config('system.admin_entrance')) ? 'system' : royalcms('default-router')->getModule();
        $route_controller = $route_m . '/' . royalcms('default-router')->getController() . '/' . royalcms('default-router')->getAction();
        return $route_controller;
    }


    /**
     * Ajax输出
     *
     * @param $data 数据
     * @param string $type 数据类型 text html xml json
     */
    protected function ajax($data, $type = ecjia::DATATYPE_JSON)
    {
        $type = strtoupper($type);
        switch ($type) {
        	case ecjia::DATATYPE_HTML:
        	case ecjia::DATATYPE_TEXT:
                return royalcms('response')->setContent($data); //直接返回response对象，不再send
        	    break;

        	// XML处理
        	case ecjia::DATATYPE_XML:
        	    return $this->xml($data);
        	    break;

        	// JSON处理
        	case ecjia::DATATYPE_JSON:
        	default:
        	    return $this->json($data);
        }
    }
    
    /**
     * 以XML格式输出内容
     * 
     * @param string|array $data
     */
    protected function xml($data)
    {
        $cookies = royalcms('response')->headers->getCookies();
        $response = RC_Response::xml($data);
        foreach ($cookies as $cookie)
        {
            $response->withCookie($cookie);
        }

        royalcms()->instance('response', $response);

        return $response; //直接返回response对象，不再send
    }
    
    /**
     * 以JSON格式输出内容
     *
     * @param string|array $data
     */
    protected function json($data)
    {
        $cookies = royalcms('response')->headers->getCookies();
        $response = RC_Response::json($data);
        foreach ($cookies as $cookie)
        {
            $response->withCookie($cookie);
        }

        royalcms()->instance('response', $response);

        return $response; //直接返回response对象，不再send
    }

    /**
     * 直接跳转，返回Response对象
     *
     * @param string $url
     * @param int $code
     */
    public function redirect($url, $code = 302)
    {
        $cookies = royalcms('response')->headers->getCookies();
        $response = RC_Redirect::away($url, $code);
        foreach ($cookies as $cookie)
        {
            $response->withCookie($cookie);
        }

        royalcms()->instance('response', $response);

        return $response;  //直接返回response对象，不再send
    }

    /**
     * 程序中断退出
     */
    public function exited()
    {
        royalcms('response')->send();
        exit(0);
    }

    /**
     * 直接跳转，并中断程序输出
     *
     * @param string $url
     * @param int $code
     */
    public function redirectWithExited($url, $code = 302)
    {
        $this->redirect($url, $code);
        $this->exited();
    }

    /**
     * 自定义header内容
     *
     * @param string $string 内容
     * @return void
     *
     */
    protected function header($key, $value, $replace = true)
    {
        RC_Response::header($key, $value, $replace);
    }

    /**
     * 弹出信息
     *
     * @param string $msg
     * @param string $url
     * @param string $parent
     */
    protected function alert($msg, $url = null, $parent = false)
    {
        header("Content-type: text/html; charset=utf-8");
        $alert_msg = "alert('$msg');";
        if (empty($url)) {
            $gourl = 'history.go(-1);';
        } else {
            $gourl = ($parent ? 'parent' : 'window') . ".location.href = '{$url}'";
        }
        
        $script = "<script>" . PHP_EOL;
        $script .= $alert_msg . PHP_EOL;
        $script .= $gourl . PHP_EOL;
        $script .= "</script>" . PHP_EOL;

        $cookies = royalcms('response')->headers->getCookies();
        $response = RC_Response::make($script);
        foreach ($cookies as $cookie)
        {
            $response->withCookie($cookie);
        }

        royalcms()->instance('response', $response);

        return $response; //直接返回response对象，不再send
    }

    /**
    * 信息提示
    *
    * @param string $msg 提示内容
    * @param string $url 跳转URL
    * @param int $time 跳转时间
    * @param null $tpl 模板文件
    */
    protected function message($msg = '操作成功', $url = null, $time = 2, $tpl = null)
    {
        $url = $url ? "window.location.href='" . $url . "'" : "window.history.back(-1);";
	    $content = ecjia_utility::message_template($msg, $url);
	    
	    $cookies = royalcms('response')->headers->getCookies();
	    $response = RC_Response::make($content);
	    foreach ($cookies as $cookie)
	    {
	        $response->withCookie($cookie);
	    }

        royalcms()->instance('response', $response);

        return $response; //直接返回response对象，不再send
    }

    /**
     * 输出内容
     *
     * @param string $msg 显示内容
     */
    public function displayContent($content, $content_type = null)
    {
        $response = royalcms('response');
        if ($content_type) {
            $response->header('Content-Type', $content_type);
        }

        $response->setContent($content);

        royalcms()->instance('response', $response);

        return $response;
    }

    /**
     * 显示视图
     *
     * @param string   $app            应用目录
     * @param string   $tpl_file       模板文件
     * @param null     $cache_id       缓存id
     * @param string   $cache_path     缓存目录
     * @param bool     $stat           是否返回解析结果
     * @param string   $content_type   文件类型
     * @param string   $charset        字符集
     * @param bool     $show           是否显示
     * @return mixed $stat = false, $content_type = 'text/html', $charset = ''
     */
    public function displayAppTemplate($app, $resource_name, $cache_id = null, $show = true, $options = array())
    {
        $resource_name = RC_Package::package('app::'.$app)->loadTemplate($resource_name, true);
        return $this->display($resource_name, $cache_id, $show, $options);
    }

    /**
     * 显示视图
     *
     * @param string   $app            应用目录
     * @param string   $tpl_file       模板文件
     * @param null     $cache_id       缓存id
     * @param string   $cache_path     缓存目录
     * @param bool     $stat           是否返回解析结果
     * @param string   $content_type   文件类型
     * @param string   $charset        字符集
     * @param bool     $show           是否显示
     * @return mixed $stat = false, $content_type = 'text/html', $charset = ''
     */
    public function fetchAppTemplate($app, $resource_name, $cache_id = null, $options = array())
    {
        $resource_name = RC_Package::package('app::'.$app)->loadTemplate($resource_name, true);
        return $this->fetch($resource_name, $cache_id, $options);
    }
    
    /**
     * 载入项目常量
     */
    public function load_constants()
    {
        //default not used
    }


    /**
     * 系统提示信息
     * @access      public
     * @param       string      $message      	消息内容
     * @param       int         $type        	消息类型， (0:html, 1:alert, 2:json, 3:xml)(0:错误，1:成功，2:消息, 3:询问)
     * @param		array		$options		消息可选参数
     * @return      string | \Royalcms\Component\Http\Response
     */
    public function showmessage($message, $msgtype = ecjia::MSGTYPE_HTML, $options = array()) {
        $state = $msgtype & 0x0F;
        $type = $msgtype & 0xF0;
         
        if ($type === ecjia::MSGTYPE_JSON && !is_ajax()) {
            $type = ecjia::MSGTYPE_ALERT;
        }
         
        // HTML消息提醒
        if ($type === ecjia::MSGTYPE_HTML) {
            switch ($state) {
                case 1:
                    $this->assign('page_state', array('icon' => 'fontello-icon-ok-circled', 'msg' => __('操作成功'), 'class' => 'alert-success'));
                    break;
                case 2:
                    $this->assign('page_state', array('icon' => 'fontello-icon-info-circled', 'msg' => __('操作提示'), 'class' => 'alert-info'));
		              break;
		          case 3:
			         $this->assign('page_state', array('icon' => 'fontello-icon-attention-circled', 'msg' => __('操作警告'), 'class' => ''));
			         break;
			     default:
			         $this->assign('page_state', array('icon' => 'fontello-icon-cancel-circled', 'msg' => __('操作错误'), 'class' => 'alert-danger'));
            }

        	$this->assign('ur_here',     __('系统信息'));
        	$this->assign('msg_detail',  $message);
        	$this->assign('msg_type',    $state);

            if (!empty($options)) {
	           foreach ($options AS $key => $val) {
	               $this->assign($key,     $val);
		       }
            }

            return $this->message($message, null, 3);
        }
    		     
		// ALERT消息提醒
		elseif ($type === ecjia::MSGTYPE_ALERT) {
            //alert支持PJAXurl的跳转
            if ($options instanceof PjaxShowMessageOption) {
                $options->setMessage($message);
                $options->setState($state);
                return (new ShowMessage($message, $msgtype, $options))->getResponse();
            }
            else {
                $url = '';
                if (!empty($options) && !empty($options['pjaxurl'])) {
                    $url = $options['pjaxurl'];
                }
                return $this->alert($message, $url);
            }
        }
 
        // JSON消息提醒
        elseif ($type === ecjia::MSGTYPE_JSON) {

            if ($options instanceof PjaxShowMessageOption) {
                $options->setMessage($message);
                $options->setState($state);
                return (new ShowMessage($message, $msgtype, $options))->getResponse();
            }

//            $res = array('message' => $message);
//            if ($state === 0) {
//                $res['state'] = 'error';
//            } elseif ($state === 1) {
//                $res['state'] = 'success';
//            }
//
//            if (!empty($options)) {
//                foreach ($options AS $key => $val) {
//                    $res[$key] = $val;
//                }
//            }
//
//            return $this->ajax($res);

            $jsonOption = (new JsonShowMessageOption())->setMessage($message)->setState($state)->setOptions($options);
            return (new ShowMessage($message, $msgtype, $jsonOption))->getResponse();
        }
 
        // XML消息提醒
        elseif ($type === ecjia::MSGTYPE_XML) {
            return $this->ajax($message, 'xml');
        }

        return royalcms('response');
    }

    /**
     * 创建视图对象
     */
    abstract public function create_view();
    
    /**
     * hooks载入抽象方法
     */
    abstract protected function load_hooks();
    
    /**
     * Session start
     */
    abstract protected function session_start();

}

// end