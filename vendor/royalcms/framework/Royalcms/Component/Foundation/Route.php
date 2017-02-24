<?php namespace Royalcms\Component\Foundation;

use Royalcms\Component\Support\Facades\Config;
use Royalcms\Component\Rewrite\Facades\Rewrite;

/**
 * URL处理类
 *
 * @package Royalcms
 */
class Route extends Object
{

    /**
     * 路由APP只读属性
     */
    public $app = '';

    /**
     * 路由CONTROL只读属性
     */
    public $control = '';

    /**
     * 路由METHOD只读属性
     */
    public $method = '';

    /**
     * 路由DATA只读属性
     */
    public $data = array();

    /**
     * 从配置文件获取的路由配置信息
     */
    private $config = array();

    /**
     * 路由路径
     */
    private $path = '';

    /**
     * 解析完后的路由数组
     */
    private $route = array();

    /**
     * URL路径参数数组
     */
    private $params = array();

    /**
     * HTTP请求方法
     */
    private $requestMethod = '';

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->config = \RC_Config::load_config('route', SITE_HOST) ? \RC_Config::load_config('route', SITE_HOST) : \RC_Config::load_config('route', 'default');
        $this->requestMethod = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        
        $this->loadPath();
        $this->matchPath();
        $this->matchRoute();
        
        $this->buildGetParams();
        if ($this->requestMethod == 'POST') {
            $this->buildPostParams();
        }
        
        $var_m = Config::get('system.url_var_app');
        $this->app = & $this->route[$var_m];
        
        $var_c = Config::get('system.url_var_control');
        $this->control = & $this->route[$var_c];
        
        $var_a = Config::get('system.url_var_method');
        $this->method = & $this->route[$var_a];
        
        $this->data = & $this->route['data'];
    }

    /**
     * 获取请求路径
     *
     * @return string。
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * 获取请求路由
     *
     * @return array null
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * 获取请求路径中的参数
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->params;
    }

    /**
     * 获取请求方法
     * 'GET', 'POST', 'PUT', 'DELETE', 'HEAD', 'NONE', 'OPTIONS', 'TRACE', 'CONNECT'
     *
     * @return string 一般为'GET'或'POST'
     */
    public function getMethod()
    {
        return $this->requestMethod;
    }

    /**
     * 获取路由规则
     *
     * @return array
     */
    public function getRule()
    {
        return $rules = isset($this->config['rule']) ? $this->config['rule'] : array();
    }

    /**
     * 载入路径
     */
    private function loadPath()
    {
        if (Config::get('system.url_mode') === 'cli') {
            $this->path = $_SERVER["argv"][1];
        } elseif (Config::get('system.url_mode') === 'pathinfo') {
            if (isset($_SERVER['PATH_INFO'])) {
                $this->path = $_SERVER['PATH_INFO'];
            } else {
                if (isset($_GET[Config::get('system.url_pathinfo_var')])) {
                    $this->path = $_GET[Config::get('system.url_pathinfo_var')];
                } else {
                    $this->path = $_SERVER['QUERY_STRING'];
                }
            }
        } elseif (Config::get('system.url_mode') === 'normal') {
            $this->path = $_SERVER['QUERY_STRING'] ? $_SERVER['QUERY_STRING'] : '';
        } else {
            $this->path = $_SERVER['REQUEST_URI'];
        }
    }

    /**
     * 匹配路径
     */
    private function matchPath()
    {
        // 清除伪静态后缀
        $this->path = str_ireplace(Config::get('system.url_pathinfo_suf'), '', trim($this->path, '/'));
        
        $this->path = $this->matchRule();
        
        // 拆分后的GET变量
        $gets = array();
        if (! empty($_SERVER['PATH_INFO']) || (Config::get('system.url_mode') === 'pathinfo' && isset($_GET[Config::get('system.url_pathinfo_var')]))) {
            $url = str_replace(array(
                '&',
                '='
            ), Config::get('system.url_pathinfo_dli'), $this->path);
        } else {
            // 解析URL
            parse_str($this->path, $gets);
        }

        if (! empty($gets)) {
            $this->params = $gets;
        } else if (! empty($url)) {
            $this->params = explode(Config::get('system.url_pathinfo_dli'), $url);
        } else {
            
        }
        
        Rewrite::instance()->set_permalink_structure(true);
        $rewrite = royalcms('rewrite');
        $rewrite->add_query_vars(array_keys($_GET));
        $rewrite->parse_request();
        $this->params = array_merge($this->params, $rewrite->get_query_var());
        
        $querys = array();
        if (! empty($_SERVER['PATH_INFO']) && ! empty($_SERVER['QUERY_STRING'])) {
            // 解析URL
            parse_str($_SERVER['QUERY_STRING'], $querys);
        }
        
        $this->params = array_merge($this->params, $querys);
    }

    /**
     * 匹配路由规则
     */
    private function matchRule()
    {
        $rules = isset($this->config['rule']) ? $this->config['rule'] : array();
        if (! $rules or ! is_array($rules)) {
            return $this->path;
        }
        
        // 解析路由规则
        foreach ($rules as $k => $v) {
            // 正则路由
            if (preg_match("@^/.*/[isUx]*$@i", $k)) {
                // 如果匹配URL地址
                if (preg_match($k, $this->path)) {
                    // 元子组替换
                    $v = str_replace('#', '\\', $v);
                    // 匹配当前正则路由,url按正则替换
                    return preg_replace($k, $v, $this->path);
                }
                // 下一个路由规则
                continue;
            }
            
            // 非正则路由
            $search = array(
                '@(:year)@i',
                '@(:month)@i',
                '@(:day)@i',
                '@(:num)@i',
                '@(:any)@i',
                '@(:[a-z0-9]+\\\d)@i',
                '@(:[a-z0-9]+\\\w)@i',
                '@(:[a-z0-9]+)@i'
            );
            $replace = array(
                '\d{4}',
                '\d{1,2}',
                '\d{1,2}',
                '\d+',
                '.+',
                '\d+',
                '\w+',
                '([a-z0-9]+)'
            );
            
            // 将:year等替换
            $base_preg = "@^" . preg_replace($search, $replace, $k) . "$@i";
            
            // 不满足路由规则
            if (! preg_match($base_preg, $this->path)) {
                continue;
            }
            // 满足路由，但不存在参数如:uid等
            if (! strstr($k, ":")) {
                return $v;
            }
            /**
             * user/:id=>user/1
             */
            $vars = "";
            preg_match('/[^:\sa-z0-9]/i', $k, $vars);
            // :id=>"index/index"
            if (isset($vars[0])) {
                // 拆分路由获得:id
                $roles_ex = explode($vars[0], $k);
                // 上例中拆分请求参数获得1
                $url_args = explode($vars[0], $this->path);
            } else {
                $roles_ex = array(
                    $k
                );
                $url_args = array(
                    $this->path
                );
            }
            
            // 匹配路由规则
            $query = $v;
            foreach ($roles_ex as $m => $n) {
                if (! strstr($n, ":")) {
                    continue;
                }
                $_GET[str_replace(":", "", $n)] = $url_args[$m];
            }
            return $query;
        }
        
        return $query;
    }

    /**
     * 分析路由
     */
    private function matchRoute()
    {
        $args = $this->params;

        // 应用
        $app = Config::get('system.url_var_app');
        if (isset($args[$app])) {
            $this->route[$app] = $args[$app];
            unset($_GET[$app]);
            unset($args[$app]);
        } elseif (isset($args[0]) && ! empty($args[0])) {
            if ($args[0] == $app) {
                $this->route[$app] = $args[1];
                array_shift($args);
                array_shift($args);
            } else {
                $this->route[$app] = $args[0];
                array_shift($args);
            }
        } else {
            $this->route[$app] = $this->config[$app];
        }
        
        // 控制器
        $control = Config::get('system.url_var_control');
        if (isset($args[$control])) {
            $this->route[$control] = $args[$control];
            unset($_GET[$control]);
            unset($args[$control]);
        } elseif (isset($args[0]) && ! empty($args[0])) {
            if ($args[0] == $control) {
                $this->route[$control] = $args[1];
                array_shift($args);
                array_shift($args);
            } else {
                $this->route[$control] = $args[0];
                array_shift($args);
            }
        } else {
            $this->route[$control] = $this->config[$control];
        }
        
        // 方法
        $method = Config::get('system.url_var_method');
        if (isset($args[$method])) {
            $this->route[$method] = $args[$method];
            unset($_GET[$method]);
            unset($args[$method]);
        } elseif (isset($args[0]) && ! empty($args[0])) {
            if ($args[0] == $method) {
                $this->route[$method] = $args[1];
                array_shift($args);
                array_shift($args);
            } else {
                $this->route[$method] = $args[0];
                array_shift($args);
            }
        } else {
            $this->route[$method] = $this->config[$method];
        }
        
        $this->route['data']['GET'] = $this->route['data']['POST'] = array();
        // 获取路由配置中的GET数组
        if ($this->requestMethod == 'GET' && isset($this->config['data']['GET']) && is_array($this->config['data']['GET'])) {
            $this->route['data']['GET'] = array_merge($this->route['data']['GET'], $this->config['data']['GET']);
        }
        
        // 获取路由配置中的POST数组
        if ($this->requestMethod == 'POST' && isset($this->config['data']['POST']) && is_array($this->config['data']['POST'])) {
            $this->route['data']['POST'] = array_merge($this->route['data']['POST'], $this->config['data']['POST']);
        }
        
        if (! empty($args)) {
            $count = count($args);
            for ($i = 0; $i < $count;) {
                if (isset($args[$i])) {
                    $this->route['data']['GET'][$args[$i]] = isset($args[$i + 1]) ? $args[$i + 1] : '';
                    unset($args[$i]);
                    unset($args[$i + 1]);
                }
                $i += 2;
            }
        }
        
        // 获得$_GET数据
        if (! empty($_GET)) {
            $this->route['data']['GET'] = array_merge($this->route['data']['GET'], $_GET);
        }
        
        // 获得$_POST数据
        if ($this->requestMethod == 'POST' && ! empty($_POST)) {
            $this->route['data']['POST'] = array_merge($this->route['data']['POST'], $_POST);
        }
    }

    /**
     * 构建$_GET数据
     */
    private function buildGetParams()
    {
        $_GET = array();
        if (isset($this->route['data']['GET']) && is_array($this->route['data']['GET'])) {
            $_GET = & $this->route['data']['GET'];
        }
        $_REQUEST = array_merge($_REQUEST, $_GET);
    }

    /**
     * 构建$_POST数据
     */
    private function buildPostParams()
    {
        $_POST = array();
        if (isset($this->route['data']['POST']) && is_array($this->route['data']['POST'])) {
            $_POST = & $this->route['data']['POST'];
        }
        $_REQUEST = array_merge($_REQUEST, $_POST);
    }
}

// end