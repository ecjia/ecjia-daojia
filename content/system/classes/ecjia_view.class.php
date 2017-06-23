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
 * ecjia 模板视图类
 * @author royalwang
 *
 */
class ecjia_view {
    
    /**
     * 模板视图对象
     *
     * @var view
     * @access private
     */
    protected $smarty;
    
    protected $isAdminView = true;
    
    protected $fileloader;
    
    public function __construct(ecjia_template_fileloader $fileloader) {
        $this->fileloader = $fileloader;
        
        $this->smarty = royalcms('view')->getSmarty();
        
        $filters = array('ecjia_tag');
        
        if (ROUTE_M != 'installer') {
            $filters[] = 'library_item';
        }
        // 模板配置
        $this->smarty->autoload_filters = array('pre' => $filters);
        
        // 默认标签处理
        RC_Loader::load_sys_func('smarty_handler');
        if (function_exists('smarty_plugin_handler')) {
            $this->smarty->registerDefaultPluginHandler('smarty_plugin_handler');
        }
    }
    
    /**
     * 获取视图对象
     * @return view
     */
    public function getSmarty() {
        return $this->smarty;
    }
    
    public function getFileloader() {
        return $this->fileloader;
    }
 
    /**
     * 显示视图
     *
     * @access protected
     * @param string   $tpl_file       模板文件
     * @param null     $cache_id       缓存id
     * @param string   $cache_path     缓存目录
     * @param bool     $stat           是否返回解析结果
     * @param string   $content_type   文件类型
     * @param string   $charset        字符集
     * @param bool     $show           是否显示
     * @return mixed $stat = false, $content_type = 'text/html', $charset = ''
     */
    public function display($resource_name, $cache_id = null, $show = true, $options = array())
    {
        if (strpos($resource_name, 'string:') !== 0) {
            $this->fileloader->get_template_file($resource_name);
        }
        
        $content_type = isset($options['content_type']) ? $options['content_type'] : 'text/html';
        $charset = isset($options['charset']) ? $options['charset'] : '';
        $compile_id = isset($options['compile_id']) ? $options['compile_id'] : null;
        $parent = isset($options['parent']) ? $options['parent'] : null;
        $display = isset($options['display']) ? $options['display'] : false;
        $merge_tpl_vars = isset($options['merge_tpl_vars']) ? $options['merge_tpl_vars'] : true;
        $no_output_filter = isset($options['no_output_filter']) ? $options['no_output_filter'] : false;

        $content = $this->smarty->fetch($resource_name, $cache_id, $compile_id, $parent, $display, $merge_tpl_vars, $no_output_filter);
    
        if ($show) {
            $charset = strtoupper(RC_CHARSET) == 'UTF8' ? "UTF-8" : strtoupper(RC_CHARSET);
            if (! headers_sent()) {
                header("Content-type:" . $content_type . ';charset=' . $charset);
            }
            echo $content;
        } else {
            return $content;
        }
    }
    
    
    /**
     * 获得视图显示内容 用于生成静态或生成缓存文件
     *
     * @param string   $tplFile        模板文件
     * @param null     $cache_id       缓存id
     * @param string   $cachePath      缓存目录
     * @param string   $contentType    文件类型
     * @param string   $charset        字符集
     * @param bool     $show           是否显示
     * @return mixed
     */
    public function fetch($tpl_file = null, $cache_id = null, $options = array())
    {
        return $this->display($tpl_file, $cache_id, false, $options);
    }
    
    
    /**
     * 使用字符串作为模板，获取解析后输出内容
     * @param string   $tpl_string
     * @param string   $cache_time
     * @param array    $options
     * @return mixed
     */
    public function fetch_string($tpl_string = null, $cache_id = null, $options = array()) {
        $tpl_file = null;
    
        if ($tpl_string) {
            $tpl_file = 'string:' . $tpl_string;
        }
        return $this->fetch($tpl_file, $cache_id, $options);
    }
    
    
    /**
     * 模板缓存是否过期
     *
     * @param string $cachePath 缓存目录
     * @access protected
     * @return mixed
     */
    public function is_cached($resource_name, $cache_id = null, $options = array())
    {
        if (strpos($resource_name, 'string:') !== 0) {
            $this->fileloader->get_template_file($resource_name);
        }
    
        $compile_id = isset($options['compile_id']) ? $options['compile_id'] : null;
        $parent = isset($options['parent']) ? $options['parent'] : null;
    
        return $this->smarty->isCached($resource_name, $cache_id, $compile_id, $parent);
    }
    
    
    /**
     * 清除单个模板缓存
     */
    public function clear_cache($resource_name, $cache_id = null, $options = array())
    {
        if (strpos($resource_name, 'string:') !== 0) {
            $this->fileloader->get_template_file($resource_name);
        }
    
        $cache_time = isset($options['cache_time']) ? $options['cache_time'] : null;
        $compile_id = isset($options['compile_id']) ? $options['compile_id'] : null;
        $type       = isset($options['type']) ? $options['type'] : null;
    
        return $this->smarty->clearCache($resource_name, $cache_id, $compile_id, $cache_time, $type);
    }
    
    
    /**
     * 清除全部缓存
     */
    public function clear_all_cache($cache_time = null, $options = array())
    {
        $type = isset($options['type']) ? $options['type'] : null;
        return $this->smarty->clearAllCache($cache_time, $type);
    }
    
    
    /**
     * 向模版注册变量
     * @see Component_Control_Control::assign()
     */
    public function assign($name, $value = null)
    {
        return $this->smarty->assign($name, $value);
    }
    
    
    /**
     * 重新向模版注册语言包
     */
    public function assign_lang($lang = array()) {
        if (!empty($lang)) {
            // 载入语言包
            $this->smarty->assign('lang', $lang);
        } else {
            // 载入语言包
            $this->smarty->assign('lang', RC_Lang::lang());
        }
    }
    
    
    /**
     * 清除模版编译文件
     *
     * @access  public
     * @return  void
     */
    public function clear_compiled_files() {
        if (royalcms('files')->isDirectory(TEMPLATE_COMPILE_PATH)) {
            // 清除整个编译目录的文件
            $this->smarty->clearCompiledTemplate();
        }
    }
    
    
    /**
     * 清除缓存文件
     *
     * @access  public
     * @return  void
     */
    public function clear_cache_files() {
        if (royalcms('files')->isDirectory(TEMPLATE_CACHE_PATH)) {
            // 清除全部缓存
            $this->smarty->clearAllCache();
        }
    }
    
    public function __call($method, $parameters)
    {
        return call_user_func_array(array($this->smarty, $method), $parameters);
    }
    
    public function __set($name, $value) 
    {
        return $this->smarty->$name = $value;
    }
    
    public function __get($name) 
    {
        return $this->smarty->$name;
    }
    
    public function __isset($name)
    {
        return isset($this->smarty->$name);
    }
    
    public function __unset($name)
    {
        unset($this->smarty->$name);
    }
    
    
}

// end