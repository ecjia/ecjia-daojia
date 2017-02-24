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

class ParseThemeStyle
{
    private $template_name;
    
    private $template_uri;
    
    private $template_desc;
    
    private $template_version;
    
    private $template_author;
    
    private $author_uri;
    
    private $logo_filename;
    
    private $template_type;
    
    private $template_color;
    
    private $stylename;
    
    /**
     * 模板缩略图
     * @var string
     */
    private $screenshot;
    
    private $style;
    private $style_path;
    
    /**
     * 主题对象
     * @var \Ecjia\System\Theme\Theme;
     */
    private $theme;
    
    public function __construct(Theme $theme, $stylename = null)
    {
        $this->theme = $theme;
        $this->stylename = $stylename;
        
        $this->parseScreenshot();
        $this->parseStyle();
    }
    
    
    /**
     * 解析模板的缩略图Screenshot
     */
    protected function parseScreenshot()
    {
        $ext  = array('png', 'gif', 'jpg', 'jpeg');
        
        if ($this->stylename) 
        {
            foreach ($ext as $val) {
                if (file_exists($this->theme->getThemeDir() . 'images/screenshot_' . $this->stylename . '.' . $val)) {
                    $this->screenshot = $this->theme->getThemeUrl() . 'images/screenshot_' . $this->stylename . '.' . $val;
                    break;
                }
            }
        }
        else {
            $this->screenshot = null;
        }
        
        if (! $this->screenshot)
        {
            foreach ($ext as $val) {
                if (file_exists($this->theme->getThemeDir() . 'images/screenshot.' . $val)) {
                    $this->screenshot = $this->theme->getThemeUrl() . 'images/screenshot.' . $val;
                    break;
                }
            }
        }
 
    }
    
    protected function parseStyle()
    {
        $this->style = $this->theme->getThemeUrl() . 'style.css';
        $this->style_path = $this->theme->getThemeDir() . 'style.css';
        
        if ($this->stylename) {
            $css_stylename_path = $this->theme->getThemeDir() . 'style_' . $this->stylename . '.css';
            $css_stylename_url = $this->theme->getThemeUrl() . 'style_' . $this->stylename . '.css';
        } else {
            $css_stylename_path = null;
        }
        
        if (file_exists($css_stylename_path)) {
            $this->style = $css_stylename_url;
            $this->style_path = $css_stylename_path;
        }
        
        if (file_exists($this->style_path))
        {
            $arr = array_slice(file($this->style_path), 0, 10);
            $template_name      = explode(': ', $arr[1]);
            $template_uri       = explode(': ', $arr[2]);
            $template_desc      = explode(': ', $arr[3]);
            $template_version   = explode(': ', $arr[4]);
            $template_author    = explode(': ', $arr[5]);
            $author_uri         = explode(': ', $arr[6]);
            $logo_filename      = explode(': ', $arr[7]);
            $template_type      = explode(': ', $arr[8]);
            $template_color     = explode(': ', $arr[9]);
            
            $this->template_name = isset($template_name[1]) ? trim($template_name[1]) : '';
            $this->template_uri = isset($template_uri[1]) ? trim($template_uri[1]) : '';
            $this->template_desc = isset($template_desc[1]) ? trim($template_desc[1]) : '';
            $this->template_version = isset($template_version[1]) ? trim($template_version[1]) : '';
            $this->template_author = isset($template_author[1]) ? trim($template_author[1]) : '';
            $this->author_uri = isset($author_uri[1]) ? trim($author_uri[1]) : '';
            $this->logo_filename = isset($logo_filename[1]) ? trim($logo_filename[1]) : '';
            $this->template_type = isset($template_type[1]) ? trim($template_type[1]) : '';
            $this->template_color = isset($template_color[1]) ? trim($template_color[1]) : ''; 
        }
    }
    
    /**
     * 拼装结果
     *
     * @api
     */
    public function process() {
        return array(
            'name'      => $this->template_name,
            'uri'       => $this->template_uri,
            'desc'      => $this->template_desc,
            'version'   => $this->template_version,
            'author'        => $this->template_author,
            'author_uri'    => $this->author_uri,
            'logo'      => $this->logo_filename,
            'type'      => $this->template_type,
            'color'     => $this->template_color,
            'screenshot'    => $this->screenshot,
            'style'         => $this->style,
            'stylename' => $this->stylename,
            'code'      => $this->theme->getThemeCode(),
        );
    }
    
    /**
     * 魔术方法
     *
     * @api
     */
    public function __toString() {
        return var_export($this->process(), true);
    }
    
    public function getName()
    {
        return $this->template_name;
    }
    
    public function getUri()
    {
        return $this->template_uri;
    }
    
    public function getDesc()
    {
        return $this->template_desc;
    }
    
    public function getVersion()
    {
        return $this->template_version;
    }
    
    public function getAuthor()
    {
        return $this->template_author;
    }
    
    public function getAuthorUri()
    {
        return $this->author_uri;
    }
    
    public function getLogo()
    {
        return $this->logo_filename;
    }
    
    public function getType()
    {
        return $this->template_type;
    }
    
    public function getColor()
    {
        return $this->template_color;
    }
    
    public function getScreenshot()
    {
        return $this->screenshot;
    }
    
    public function getStyle()
    {
        return $this->style;
    }
    
}