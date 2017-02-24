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
defined('IN_ECJIA') or exit('No permission resources.');

class ecjia_form {
    
    /**
     * Echoes a submit button, with provided text and appropriate class(es).
     *
     * @since 1.0.0
     *
     * @see get_submit_button()
     *
     * @param string       $text             The text of the button (defaults to 'Save Changes')
     * @param string       $type             Optional. The type and CSS class(es) of the button. Core values
     *                                       include 'primary', 'secondary', 'delete'. Default 'primary'
     * @param string       $name             The HTML name of the submit button. Defaults to "submit". If no
     *                                       id attribute is given in $other_attributes below, $name will be
     *                                       used as the button's id.
     * @param bool         $wrap             True if the output button should be wrapped in a paragraph tag,
     *                                       false otherwise. Defaults to true
     * @param array|string $other_attributes Other attributes that should be output with the button, mapping
     *                                       attributes to their values, such as setting tabindex to 1, etc.
     *                                       These key/value attribute pairs will be output as attribute="value",
     *                                       where attribute is the key. Other attributes can also be provided
     *                                       as a string such as 'tabindex="1"', though the array format is
     *                                       preferred. Default null.
     */
    public static function submit_button( $text = null, $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = null ) {
        echo self::get_submit_button( $text, $type, $name, $wrap, $other_attributes );
    }
    
    /**
     * Returns a submit button, with provided text and appropriate class
     *
     * @since 3.1.0
     *
     * @param string $text The text of the button (defaults to 'Save Changes')
     * @param string $type The type of button. One of: primary, secondary, delete
     * @param string $name The HTML name of the submit button. Defaults to "submit". If no id attribute
     *               is given in $other_attributes below, $name will be used as the button's id.
     * @param bool $wrap True if the output button should be wrapped in a paragraph tag,
     * 			   false otherwise. Defaults to true
     * @param array|string $other_attributes Other attributes that should be output with the button,
     *                     mapping attributes to their values, such as array( 'tabindex' => '1' ).
     *                     These attributes will be output as attribute="value", such as tabindex="1".
     *                     Defaults to no other attributes. Other attributes can also be provided as a
     *                     string such as 'tabindex="1"', though the array format is typically cleaner.
     */
    public static function get_submit_button( $text = null, $type = 'primary large', $name = 'submit', $wrap = true, $other_attributes = null ) {
        if ( ! is_array( $type ) )
            $type = explode( ' ', $type );
    
        $button_shorthand = array( 'primary', 'small', 'large' );
        $classes = array( 'button' );
        foreach ( $type as $t ) {
            if ( 'secondary' === $t || 'button-secondary' === $t )
                continue;
            $classes[] = in_array( $t, $button_shorthand ) ? 'button-' . $t : $t;
        }
        $class = implode( ' ', array_unique( $classes ) );
    
        if ( 'delete' === $type )
            $class = 'button-secondary delete';
    
        $text = $text ? $text : __( 'Save Changes' );
    
        // Default the id attribute to $name unless an id was specifically provided in $other_attributes
        $id = $name;
        if ( is_array( $other_attributes ) && isset( $other_attributes['id'] ) ) {
            $id = $other_attributes['id'];
            unset( $other_attributes['id'] );
        }
    
        $attributes = '';
        if ( is_array( $other_attributes ) ) {
            foreach ( $other_attributes as $attribute => $value ) {
                $attributes .= $attribute . '="' . RC_Format::esc_attr( $value ) . '" '; // Trailing space is important
            }
        } else if ( !empty( $other_attributes ) ) { // Attributes provided as a string
            $attributes = $other_attributes;
        }
    
        $button = '<input type="submit" name="' . RC_Format::esc_attr( $name ) . '" id="' . RC_Format::esc_attr( $id ) . '" class="' . RC_Format::esc_attr( $class );
        $button	.= '" value="' . RC_Format::esc_attr( $text ) . '" ' . $attributes . ' />';
    
        if ( $wrap ) {
            $button = '<p class="submit">' . $button . '</p>';
        }
    
        return $button;
    }
    
    
	
// 	/**
// 	 * 
// 	 * @param string $name 表单名称
// 	 * @param int $id 表单id
// 	 * @param string $value 表单默认值
// 	 * @param string $moudle 模块名称
// 	 * @param int $catid 栏目id
// 	 * @param int $size 表单大小
// 	 * @param string $class 表单风格
// 	 * @param string $ext 表单扩展属性 如果 js事件等
// 	 * @param string $alowexts 允许图片格式
// 	 * @param array $thumb_setting 
// 	 * @param int $watermark_setting  0或1
// 	 */
// 	public static function images($name, $id = '', $value = '', $moudle='', $catid='', $size = 50, $class = '', $ext = '', $alowexts = '',$thumb_setting = array(),$watermark_setting = 0 ) {
// 		if(!$id) $id = $name;
// 		if(!$size) $size= 50;
// 		if(!empty($thumb_setting) && count($thumb_setting)) $thumb_ext = $thumb_setting[0].','.$thumb_setting[1];
// 		else $thumb_ext = ',';
// 		if(!$alowexts) $alowexts = 'jpg|jpeg|gif|bmp|png';
// 		if(!defined('IMAGES_INIT')) {
// 			$str = '<script type="text/javascript" src="'.JS_PATH.'swfupload/swf2ckeditor.js"></script>';
// 			define('IMAGES_INIT', 1);
// 		}
// 		$authkey = upload_key("1,$alowexts,1,$thumb_ext,$watermark_setting");
// 		return $str."<input type=\"text\" name=\"$name\" id=\"$id\" value=\"$value\" size=\"$size\" class=\"$class\" $ext/>  <input type=\"button\" class=\"button\" onclick=\"javascript:flashupload('{$id}_images', '".L('attachmentupload')."','{$id}',submit_images,'1,{$alowexts},1,{$thumb_ext},{$watermark_setting}','{$moudle}','{$catid}','{$authkey}')\"/ value=\"".L('imagesupload')."\">";
// 	}
	
// /**
// 	 * 日期时间控件
// 	 * 
// 	 * @param $name 控件name，id
// 	 * @param $value 选中值
// 	 * @param $isdatetime 是否显示时间
// 	 * @param $loadjs 是否重复加载js，防止页面程序加载不规则导致的控件无法显示
// 	 * @param $showweek 是否显示周，使用，true | false
// 	 */
// 	public static function date($name, $value = '', $isdatetime = 0, $loadjs = 0, $showweek = 'true') {
// 		if($value == '0000-00-00 00:00:00') $value = '';
// 		$id = preg_match("/\[(.*)\]/", $name, $m) ? $m[1] : $name;
// 		if($isdatetime) {
// 			$size = 21;
// 			$format = '%Y-%m-%d %H:%M:%S';
// 			$showsTime = 12;
// 		} else {
// 			$size = 10;
// 			$format = '%Y-%m-%d';
// 			$showsTime = 'false';
// 		}
// 		$str = '';
// 		if($loadjs || !defined('CALENDAR_INIT')) {
// 			define('CALENDAR_INIT', 1);
// //			$str .= '<link rel="stylesheet" type="text/css" href="'._FILE('script/calendar/jscal2.css').'"/>
// //			<link rel="stylesheet" type="text/css" href="'._FILE('script/calendar/border-radius.css').'"/>
// //			<link rel="stylesheet" type="text/css" href="'._FILE('script/calendar/win2k.css').'"/>
// //			<script type="text/javascript" src="'._FILE('script/calendar/calendar.js').'"></script>
// //			<script type="text/javascript" src="'._FILE('script/calendar/lang/en.js').'"></script>';
// 			$str .= '<link rel="stylesheet" type="text/css" href="'.RC_Uri::admin_url('script/calendar/jscal2.css').'"/>
// 			<link rel="stylesheet" type="text/css" href="'.RC_Uri::admin_url('script/calendar/border-radius.css').'"/>
// 			<link rel="stylesheet" type="text/css" href="'.RC_Uri::admin_url('script/calendar/win2k.css').'"/>
// 			<script type="text/javascript" src="'.RC_Uri::admin_url('script/calendar/calendar.js').'"></script>
// 			<script type="text/javascript" src="'.RC_Uri::admin_url('script/calendar/lang/en.js').'"></script>';
// 		}
// 		$str .= '<input type="text" name="'.$name.'" id="'.$id.'" value="'.$value.'" size="'.$size.'" class="date" readonly>&nbsp;';
// 		$str .= '<script type="text/javascript">
// 			Calendar.setup({
// 			weekNumbers: '.$showweek.',
// 		    inputField : "'.$id.'",
// 		    trigger    : "'.$id.'",
// 		    dateFormat: "'.$format.'",
// 		    showTime: '.$showsTime.',
// 		    minuteStep: 1,
// 		    onSelect   : function() {this.hide();}
// 			});
//         </script>';
// 		return $str;
// 	}

// 	/**
// 	 * 验证码
// 	 * @param string $id            生成的验证码ID
// 	 * @param integer $code_len     生成多少位验证码
// 	 * @param integer $font_size    验证码字体大小
// 	 * @param integer $width        验证图片的宽
// 	 * @param integer $height       验证码图片的高
// 	 * @param string $font          使用什么字体，设置字体的URL
// 	 * @param string $font_color    字体使用什么颜色
// 	 * @param string $background    背景使用什么颜色
// 	 */
// 	public static function checkcode($id = 'checkcode',$code_len = 4, $font_size = 20, $width = 130, $height = 50, $font = '', $font_color = '', $background = '') {
// 		return "<img id='$id' onclick='this.src=this.src+\"&\"+Math.random()' src='".SITE_URL."api.php?op=checkcode&code_len=$code_len&font_size=$font_size&width=$width&height=$height&font=".urlencode($font)."&font_color=".urlencode($font_color)."&background=".urlencode($background)."'>";
// 	}
	
// 	/**
// 	 * 栏目选择
// 	 * @param intval/array $catid 别选中的ID，多选是可以是数组
// 	 * @param string $str 属性
// 	 * @param string $default_option 默认选项
// 	 * @param intval $appid 按所属应用筛选
// 	 * @param string $file 栏目缓存文件名
// 	 */
// 	public static function select_category($str = '', $default_option = '', $catid = 0, $appid = 0) {
// 		$tree = RC_Loader::load_ext_class('tree');
// 		$siteid = get_siteid();
// 		$apps = getcache('apps', 'commons');
// 		$appident = array_search($appid, $apps);
// 		$result = getcache('category_'.$siteid, $appident);
// 		$result = !empty($result) ? $result : array();
// 		$string = '<select '.$str.'>';
// 		if($default_option) $string .= "<option value='0'>$default_option</option>";
// 		foreach($result as $r) {
// 			if(is_array($catid)) {
// 				$r['selected'] = in_array($r['catid'], $catid) ? 'selected' : '';
// 			} elseif(is_numeric($catid)) {
// 				$r['selected'] = $catid==$r['catid'] ? 'selected' : '';
// 			}
// 			$categorys[$r['catid']] = $r;
// 			//$string .= '<option >'.$r['catname'].'</option>';
// 			if($appid && $r['appid']!= $appid ) unset($categorys[$r['catid']]);
// 		}
// 		$str  = "<option value='\$catid' \$selected>\$spacer \$catname</option>";

// 		$tree->init($categorys);
// 		$string .= $tree->get_tree(0, $str);
			
// 		$string .= '</select>';
// 		return $string;
// 	}

// 	public static function select_linkage($keyid = 0, $parentid = 0, $name = 'parentid', $id ='', $alt = '', $linkageid = 0, $property = '') {
// 		$tree = RC_Loader::load_ext_class('tree');
// 		$result = getcache($keyid,'linkage');
// 		$id = $id ? $id : $name;
// 		$string = "<select name='$name' id='$id' $property>\n<option value='0'>$alt</option>\n";
// 		if($result['data']) {
// 			foreach($result['data'] as $area) {	
// 				$categorys[$area['linkageid']] = array('id'=>$area['linkageid'], 'parentid'=>$area['parentid'], 'name'=>$area['name']);	
// 			}
// 		}
// 		$str  = "<option value='\$id' \$selected>\$spacer \$name</option>";

// 		$tree->init($categorys);
// 		$string .= $tree->get_tree($parentid, $str, $linkageid);
			
// 		$string .= '</select>';
// 		return $string;
// 	}
	
	/**
	 * 下拉选择框
	 */
	public static function select($array = array(), $id = 0, $str = '', $default_option = '') {
		$string = '<select '.$str.'>';
		$default_selected = (empty($id) && $default_option) ? 'selected' : '';
		if($default_option) $string .= "<option value='' $default_selected>$default_option</option>";
		if(!is_array($array) || count($array)== 0) return false;
		$ids = array();
		if($id) $ids = explode(',', $id);
		foreach($array as $key=>$value) {
			$selected = in_array($key, $ids) ? 'selected' : '';
			$string .= '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
		}
		$string .= '</select>';
		return $string;
	}
	
	/**
	 * 复选框
	 * 
	 * @param $array 选项 二维数组
	 * @param $id 默认选中值，多个用 '逗号'分割
	 * @param $str 属性
	 * @param $defaultvalue 是否增加默认值 默认值为 -99
	 * @param $width 宽度
	 */
	public static function checkbox($array = array(), $id = '', $str = '', $defaultvalue = '', $width = 0, $field = '') {
		$string = '';
		$id = trim($id);
		if($id != '') $id = strpos($id, ',') ? explode(',', $id) : array($id);
		if($defaultvalue) $string .= '<input type="hidden" '.$str.' value="-99">';
		$i = 1;
		foreach($array as $key=>$value) {
			$key = trim($key);
			$checked = ($id && in_array($key, $id)) ? 'checked' : '';
			if($width) $string .= '<label class="ib" style="width:'.$width.'px">';
			$string .= '<input type="checkbox" '.$str.' id="'.$field.'_'.$i.'" '.$checked.' value="'.htmlspecialchars($key).'"> '.htmlspecialchars($value);
			if($width) $string .= '</label>';
			$i++;
		}
		return $string;
	}

	/**
	 * 单选框
	 * 
	 * @param $array 选项 二维数组
	 * @param $id 默认选中值
	 * @param $str 属性
	 */
	public static function radio($array = array(), $id = 0, $str = '', $width = 0, $field = '') {
		$string = '';
		foreach($array as $key=>$value) {
			$checked = trim($id)==trim($key) ? 'checked' : '';
			if($width) $string .= '<label class="ib" style="width:'.$width.'px">';
			$string .= '<input type="radio" '.$str.' id="'.$field.'_'.htmlspecialchars($key).'" '.$checked.' value="'.$key.'"> '.$value;
			if($width) $string .= '</label>';
		}
		return $string;
	}

}

// end