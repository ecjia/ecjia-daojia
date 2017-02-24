<?php
namespace Royalcms\Component\App;
use Royalcms\Component\Support\Facades\Config;

/**
 * ROYALCMS应用包管理类
 */
class Bundle
{
    /**
     * 应用唯一标识符
     * @var string
     */
    private $identifier;
    
    /**
     * 应用所在文件夹名
     * @var string
     */
    private $directory;
    
    /**
     * 应用路由访问别名
     * @var string
     */
    private $alias;
    
    
    /**
     * 应用控制器根路径
     * @var string
     */
    private $controller_path;
    
    /**
     * 构造函数
     */
    public function __construct($app_id, $app_floder, $app_alias = null) {
        if (is_null($app_alias)) {
            $this->alias = $app_floder;
        } else {
            $this->alias = $app_alias;
        }
        
        if (Config::get('system.admin_enable') === true && $app_alias == Config::get('system.admin_entrance')) {
            $this->identifier = $app_id ? $app_id : 'system';
            $this->directory = $app_floder ? $app_floder : 'system';
            $this->controller_path = \RC_Uri::admin_path();
        } else {
            $this->identifier = $app_id;
            $this->directory = $app_floder;
            if (\RC_Loader::exists_site_app($this->alias)) {
                $this->controller_path = SITE_APP_PATH . $this->alias . DIRECTORY_SEPARATOR;
            } else {
                $this->controller_path = RC_APP_PATH . $this->alias . DIRECTORY_SEPARATOR;
            } 
        }
    }
    
    
    /**
     * 加载控制器
     *
     * @param string $filename
     * @param string $m
     * @return obj
     */
    public function load_controller($filename)
    {
        $alias_map = \RC_App::get_alias();
        if (!empty($alias_map) && !isset($alias_map[$this->alias])) {
            return new \RC_Error('not_register_route_app', '没有注册此路由名称');
        }
        
        $identifier_map = \RC_App::get_identifier();
        if (!empty($identifier_map) && !isset($identifier_map[$this->identifier])) {
            return new \RC_Error('not_register_app_identifier', '没有注册此应用ID');
        } 
        
        $app_controller = $this->controller_path . $filename . '.php';
        
        if (file_exists($app_controller)) {
            $classname = $filename;
            include_once $app_controller;
            $mypath = \RC_Loader::my_path($app_controller);
            if ($mypath) {
                $classname = 'MY_' . $filename;
                include_once $mypath;
            }
            return new $classname();
        } else {
            return new \RC_Error('controller_does_not_exist', 'Controller does not exist.');
        }
    }
    
    
    public function get_identifier() {
        return $this->identifier;
    }
    
    
    public function get_directory() {
        return $this->directory;
    }
    
    
    public function get_alias() {
        return $this->alias;
    }
    
}

// end