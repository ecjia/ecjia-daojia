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

class Theme
{
    /**
     * 当前主题代号
     * @var string
     */
    protected $theme_code;
    
    protected $theme_styles = array();
    
    protected $theme_dir;
    
    protected $library_dir;
    
    protected $library_bak_dir;
    
    protected $default_style;
    
    /**
     * 当前主题访问Url
     * @var string
     */
    protected $theme_url;
    
    public function __construct($themeCode) 
    {
        $this->theme_code = $themeCode;
        $this->theme_dir = SITE_THEME_PATH . $this->theme_code . DIRECTORY_SEPARATOR;
        $this->library_dir = $this->theme_dir . 'library' . DIRECTORY_SEPARATOR;
        $this->theme_url = \RC_Theme::get_theme_root_uri()  .'/'. $this->theme_code . '/';
        $this->theme_styles = $this->loadThemeStyles();
        $this->library_bak_dir = SITE_CACHE_PATH . 'backup' . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR;
        
        $this->createLibraryBakDir();
    }
    
    protected function createLibraryBakDir()
    {
        if (! is_dir($this->library_bak_dir)) {
            royalcms('files')->makeDirectory($this->library_bak_dir);
        }
    }
    
    /**
     * 获取可用的主题风格列表
     */
    protected function loadThemeStyles()
    {
        $available_styles = $this->findAvailableStyles();
        
        $themes = array();
        $themes[] = $this->loadDefaultStyle()->process();
        
        foreach ($available_styles as $key => $value) 
        {
            $themes[] = $this->loadSpecifyStyle($value)->process();
        }
        
        return $themes;
    }
    
    public function getThemeStyles()
    {
        return $this->theme_styles;
    }
    
    
    /**
     * 寻找激活的主题风格样式
     */
    public function findAvailableStyles()
    {
        
        $available_styles = array();
        
        if (file_exists($this->theme_dir)) 
        {
            $tpl_style_dir = opendir($this->theme_dir);
            while (false != ($file = readdir($tpl_style_dir)))
            {
                if ($file != '.' &&
                    $file != '..' &&
                    $file != '.svn' &&
                    $file != 'git' &&
                    $file != 'index.htm' &&
                    $file != 'index.html' &&
                    is_file($this->theme_dir . $file))
                {
                    if ($this->matchStyleFile($file)) {
                        $this->findStyleName($file, $available_styles);
                    }
                }
            }
            closedir($tpl_style_dir);
        }
        
        return $available_styles;
    }
    
    
    private function matchStyleFile($file)
    {
        if (preg_match("/^(style|style_)(.*)*/i", $file)) {
            return true;
        } else {
            return false;
        }
    }
    
    private function findStyleName($file, array & $styles)
    {
        $start = strpos($file, '.');
        $temp = substr($file, 0, $start);
        $temp = explode('_', $temp);
        if (count($temp) == 2) {
            $styles[] = $temp[1];
        }
    }
    
    protected function loadTemplateFiles()
    {
        $files = array();
        
        if (file_exists($this->theme_dir))
        {
            $template_handle = opendir($this->theme_dir);
            while (false != ($file = readdir($template_handle)))
            {
                if (substr($file, -7) == 'dwt.php')
                {
                    $filename = substr($file, 0, -8);
                    $files[$filename] = with(new ThemeTemplate($this, $file))->getFileinfo();
                }
            }
            closedir($template_handle);
        }
        
        return $files;
    }
    
    /**
     * 可以设置内容的模板
     * @return array
     */
    public function getAllowSettingTemplates()
    {
        $files = $this->loadTemplateFiles();
        
        foreach ($files as $key => & $file) 
        {
            if (!$file['Libraries']) {
                unset($files[$key]);
            }
        }
        
        return $files;
    }
    
    public function getLibraryFiles()
    {
        $files = $this->loadLibraryFiles();
        
        foreach ($files as $key => $file)
        {
            if (!$file['Name'] || !$file['Description']) {
                unset($files[$key]);
            }
        }
        
        return $files;
    }
    
    public function getAllLibraryFiles()
    {
        return $this->loadLibraryFiles();
    }
    
    protected function loadLibraryFiles()
    {
        $files = array();
        
        if (is_dir($this->library_dir)) {
            $library_handle = opendir($this->library_dir);
            while (false != ($file = readdir($library_handle))) 
            {
                if (substr($file, -7) == 'lbi.php')
                {
                    $filename         = substr($file, 0, -8);
                    $files[$filename] = with(new ThemeLibrary($this, $file))->getFileinfo();
                }
            }
            closedir($library_handle);
        }
        
        return $files;
    }
    
    public function getDefaultStyle()
    {
        return $this->default_style;
    }
    
    protected function loadDefaultStyle()
    {
        $this->default_style = new ParseThemeStyle($this);
        return $this->default_style;
    }
    
    public function loadSpecifyStyle($stylename)
    {
        return new ParseThemeStyle($this, $stylename);
    }
    
    public function getThemeDir()
    {
        return $this->theme_dir;
    }

    public function getThemeUrl()
    {
        return $this->theme_url;
    }
    
    public function getThemeCode()
    {
        return $this->theme_code;
    }
    
    public function getLibraryDir()
    {
        return $this->library_dir;
    }
    
    public function getLibraryBakDir()
    {
        return $this->library_bak_dir;
    }
}