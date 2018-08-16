<?php

namespace Royalcms\Component\Widget;

use Royalcms\Component\Routing\Controller as RoyalcmsController;

/**
 * 小挂件基础类
 *
 * @author royalwang
 *         @usage none
 */
abstract class WidgetController extends RoyalcmsController
{

    protected $options = null; // 显示选项
    protected $_name = null; // 挂件标识
    protected $id = null; // 在页面中的唯一标识
    protected $widget_root = ''; // HTTP根目录
    protected $widget_path = ''; // 物理路径
    protected $_ttl = 3600; // 缓存时间
    private $_view = null;

    public function __construct($id, $options = array())
    {
        parent::__construct();
           
        $this->id = $id; 
        $this->widget_path = SITE_WIDGET_PATH . $this->_name . DIRECTORY_SEPARATOR;
        $this->widget_root = SITE_WIDGET_URL . $this->_name . '/';
        
        /* 初始化视图配置 */
        $this->_view = & RC_Widget::_widget_view();
//         $this->_view->lib_base = SITE_URL . '/includes/libraries/javascript';

        $this->set_options($options);
        $this->assign('widget_root', $this->widget_root);
        $this->assign('id', $this->id);
        $this->assign('name', $this->_name);
    }

    /**
     * 设置选项
     *
     * @author Garbin
     * @param
     *            array
     * @return void
     */
    public function set_options($options)
    {
        $this->options = $options;
        $this->assign('options', $this->options);
    }

    /**
     * 显示
     *
     * @author Garbin
     * @param
     *            none
     * @return void
     */
    public function display()
    {
        echo $this->get_contents();
    }

    /**
     * 获取指定模板的数据
     *
     * @author Garbin
     * @param
     *            none
     * @return void
     */
    public function fetch($tpl)
    {
        return $this->_view->fetch('str:' . $this->_get_template($tpl));
    }

    /**
     * 给视图传送数据
     *
     * @author Garbin
     * @param mixed $k            
     * @param mixed $v            
     * @return void
     */
    public function assign($k, $v = null)
    {
        if (is_array($k)) {
            $args = func_get_args();
            // 遍历参数
            foreach ($args as $arg) {
                // 遍历数据并传给视图
                foreach ($arg as $key => $value) {
                    $this->_view->assign($key, $value);
                }
            }
        } else {
            $this->_view->assign($k, $v);
        }
    }

    /**
     * 取模板
     *
     * @author Garbin
     * @param string $tpl            
     * @return string
     */
    private function _get_template($tpl)
    {
        return file_get_contents($this->widget_path . "/{$tpl}.html");
    }

    /**
     * 取数据
     *
     * @author Garbin
     * @return array
     */
    abstract protected function _get_data();

    /**
     * 获取标准的挂件HTML
     *
     * @author Garbin
     * @param string $html            
     * @return string
     */
    private function _wrap_contents($html)
    {
        return "\r\n<div id=\"{$this->id}\" name=\"{$this->_name}\" widget_type=\"widget\" class=\"widget\">\r\n" . $html . "\r\n</div>\r\n";
    }

    /**
     * 将取得的数据按模板的样式输出
     *
     * @author Garbin
     * @return string
     */
    public function get_contents()
    {
        /* 获取挂件数据 */
        $this->assign('widget_data', $this->_get_data());
        
        /* 可能有问题 */
        $this->assign('options', $this->options);
        $this->assign('widget_root', $this->widget_root);
        
        return $this->_wrap_contents($this->fetch('widget'));
    }

    /**
     * 获取配置表单
     *
     * @author Garbin
     * @return string
     */
    public function get_config_form()
    {
        $this->get_config_datasrc();
        return $this->fetch('config');
    }

    /**
     * 传递配置页面需要的一些变量
     */
    abstract protected function get_config_datasrc();

    /**
     * 显示配置表单
     *
     * @author Garbin
     * @return void
     */
    public function display_config()
    {
        echo $this->get_config_form();
    }

    /**
     * 处理配置项
     *
     * @author Garbin
     * @param array $input            
     * @return array
     */
    abstract protected function parse_config($input);
    
    /* 取缓存id */
    private function _get_cache_id()
    {
        $config = array(
            'widget_name' => $this->_name
        );
        if ($this->options) {
            $config = array_merge($config, $this->options);
        }
        
        return md5('widget.' . var_export($config, true));
    }
}


// end