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
namespace Ecjia\System\Theme;

use RC_File;

class ThemeTemplate
{
    
    protected $file;
    
    protected $file_shortname;
    
    protected $filePath;
    
    protected $fileInfo;
    
    protected $libraries;
    
    protected $regions;
    
    /**
     * 动态库项目
     * @var array
     */
    protected $dynamic_libraries;
    
    /**
     * 主题对象
     * @var \Ecjia\System\Theme\Theme;
     */
    protected $theme;
    
    /**
     * Widget数据库更新
     * 
     * @var \Ecjia\System\Theme\WidgetMethod;
     */
    protected $mtehod;
    
    public function __construct(Theme $theme, $file)
    {
        if (substr($file, -4) != '.php')
        {
            $file .= '.php';
        }
        
        $this->theme = $theme;
        $this->file = $file;
        $this->file_shortname = basename(substr($this->file, 0, strpos($this->file, '.')));
        $this->filePath = $this->theme->getThemeDir() . $file;
        $this->fileInfo = $this->loadFileinfo();
        $this->libraries = $this->loadEditableLibraries();
        $this->regions = $this->loadEditableRegions();
        $this->mtehod = new WidgetMethod($this->theme, $this->file);
    }
    
    protected function loadFileinfo()
    {
        $default_headers = array(
            'Name' => 'Name',
            'Description' => 'Description',
            'Libraries' => 'Libraries',
        );
        
        $data = RC_File::get_file_data( $this->filePath, $default_headers, 'template' );
        
        if ($data['Libraries']) {
            $data['Libraries'] = explode(',', $data['Libraries']);
        }
        
        $data['File'] = $this->file;
        
        return $data;
    }
    
    public function getFileinfo()
    {
        return $this->fileInfo;
    }

    /**
     * 每个模板允许设置的库项目
     */
    public function getAllowSettingLibraries()
    {
        return $this->fileInfo['Libraries'];
    }
    
    /**
     * 获得模版文件中的所有编辑区域
     * 
     * @return array
     */
    protected function loadEditableRegions()
    {
        /* 将模版文件的内容读入内存 */
        $content = file_get_contents($this->filePath);
        
        /* 获得所有编辑区域 */
        static $regions = array();
        
        if (empty($regions)) {
            $matches = array();
            $result  = preg_match_all('/(<!--\\s*TemplateBeginEditable\\sname=")([^"]+)("\\sdesc=")([^"]+)("\\s*-->)/', $content, $matches, PREG_SET_ORDER);
        
            if ($result && $result > 0) {
                foreach ($matches AS $key => $val) {
                    if ($val[2] != 'doctitle' && $val[2] != 'head') {
                        $regions[$key]['name'] = $val[2];
                        $regions[$key]['desc'] = $val[4];
                    }
                }
            }
        
        }

        return $regions;
    }
    
    /**
     * 获得模版文件中的编辑区域中所有的库项目文件
     * 
     * @return array
     */
    protected function loadEditableLibraries()
    {
        $libs = array();
        
        $regions = $this->loadEditableRegions();

        /* 将模版文件的内容读入内存 */
        $content = file_get_contents($this->filePath);
        
        /* 遍历所有编辑区 */
        foreach ($regions AS $key => $val) {
            $matches = array();
            $pattern = '/(<!--\\s*TemplateBeginEditable\\sname="%s"\\sdesc="%s"\\s*-->)(.*?)(<!--\\s*TemplateEndEditable\\s*-->)/s';

            if (preg_match(sprintf($pattern, $val['name'], $val['desc']), $content, $matches)) {
                /* 找出该编辑区域内所有库项目 */
                $lib_matches = array();

                $result      = preg_match_all('/([\s|\S]{0,20})(<!--\\s#BeginLibraryItem\\s")([^"]+)("\\s-->)<!--\\s#EndLibraryItem\\s-->/', $matches[2], $lib_matches, PREG_SET_ORDER);
                
                if ($result && $result > 0) {
                    $i = 0;
                    foreach ($lib_matches AS $k => $v) {
                        $v[3]   = strtolower($v[3]);
                        $library = basename($v[3]);
                        $libs[] = with(new ThemeWidget($this->theme, $library))->setTemplate($this->file_shortname)->setRegion($val['name'])->setSortOrder($i);
                        $i++;
                    }
        
                }
            }
        }

        return $libs;
    }
    
    /**
     * 获得指定库项目在模板中的设置内容
     *
     * @access  public
     * @param   string  $lib    库项目
     * @return  void
     */
    public function getEditableSettedLibrary($lib)
    {
        //$libs 包含设定内容区域的library数组
        $libs = $this->getEditableLibraries();

        foreach ($libs as $key => $widget) {
            $val = $widget->process();
            if ($lib == $val['type']) {
                return $widget;
            }
        }
        
        $library = $lib . '.lbi.php';
        return with(new ThemeWidget($this->theme, $library));
    } 
    
    /**
     * 获取数据库中设置过的Libraray
     * 
     * @return array
     */
    public function getDBSettedLibraries()
    {
        $data = $this->mtehod->readRegionWidgets();
        return $data;
    }
    
    public function getEditableRegions()
    {
        return $this->regions;
    }
    
    public function getEditableLibraries()
    {
        return $this->libraries;
    }
    
    public function getDynamicLibraries()
    {
        $this->dynamic_libraries = array(
            'cat_goods',
            'brand_goods',
            'cat_articles',
            'ad_position',
        );
        
        return $this->dynamic_libraries;
    }
    
    public function getWidgetMethod()
    {
        return $this->mtehod;
    }
    
}
