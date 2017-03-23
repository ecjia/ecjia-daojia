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
/**
 * 载入Library Item项目
 * @param string $source
 * @param object $smarty
 * @return mixed
 */
function smarty_prefilter_library_item($source, $smarty) {
	$current_file = str_replace('.php', '', $smarty->_current_file);
	$file_type = strtolower(strrchr($current_file, '.'));
	
	$tmp_dir   = RC_Theme::get_template_directory_uri().'/'; // 前台模板所在路径
	if (defined('IN_ADMIN')) {
		$tmp_dir   = RC_Uri::admin_url('statics/'); // 后台模板所在路径
	}
	
	/**
	 * 处理模板文件
	 */
	if ($file_type == '.dwt') {
		/* 将模板中所有library替换为链接 */
		$pattern  = '/<!--\s#BeginLibraryItem\s\"\/(.*?)\"\s-->.*?<!--\s#EndLibraryItem\s-->/s';
		$source   = preg_replace_callback($pattern, function($matches) {
		    return '{include file="'.strtolower($matches[1]).'.php"}';
		}, $source);
		
		if (!defined('IN_ADMIN') || !defined('IN_MERCHANT')) {
			/* 检查有无动态库文件，如果有为其赋值 */
	        $dyna_libs = get_template_dynamic_libraries($smarty->_current_file);
	        
	        if ($dyna_libs) {
	            foreach ($dyna_libs AS $region => $libs) {
	                $pattern = '/<!--\\s*TemplateBeginEditable\\sname="'. $region .'"\\s*-->(.*?)<!--\\s*TemplateEndEditable\\s*-->/s';
	        
	                if (preg_match($pattern, $source, $reg_match)) {
	                    $reg_content = $reg_match[1];
	                    /* 生成匹配字串 */
	                    $keys = array_keys($libs);
	                    $lib_pattern = '';
	                    foreach ($keys AS $lib) {
	                        $lib_pattern .= '|' . str_replace('/', '\/', substr($lib, 1));
	                    }
	                    $lib_pattern = '/{include\sfile=\"(' . substr($lib_pattern, 1) . ').php\"}/';
	                    /* 修改$reg_content中的内容 */
	                    $GLOBALS['libs'] = $libs;
	                    $reg_content = preg_replace_callback($lib_pattern, 'dyna_libs_replace', $reg_content);
	        
	                    /* 用修改过的内容替换原来当前区域中内容 */
	                    $source = preg_replace($pattern, $reg_content, $source);
	                }
	            }
	        }

		}
		
		/* 在头部加入版本信息 */
		$source = preg_replace('/<head>/i', "<head>\r\n<meta name=\"Generator\" content=\"" . APPNAME .' ' . VERSION . "\" />",  $source);
	
		/* 修正css路径 */
		$source = preg_replace('/(<link\shref=["|\'])(?:\.\/|\.\.\/)?(css\/)?([a-z0-9A-Z_]+\.css["|\']\srel=["|\']stylesheet["|\']\stype=["|\']text\/css["|\'])/i', '\1' . $tmp_dir . '\2\3', $source);
	
		/* 修正js目录下js的路径 */
		$source = preg_replace('/(<script\s(?:type|language)=["|\']text\/javascript["|\']\ssrc=["|\'])(?:\.\/|\.\.\/)?(js\/[a-z0-9A-Z_\-\.]+\.(?:js|vbs)["|\']><\/script>)/', '\1' . $tmp_dir . '\2', $source);
	
		/* 更换编译模板的编码类型 */
		$source = preg_replace('/<meta\shttp-equiv=["|\']Content-Type["|\']\scontent=["|\']text\/html;\scharset=(?:.*?)["|\'][^>]*?>\r?\n?/i', '<meta http-equiv="Content-Type" content="text/html; charset=' . RC_CHARSET . '" />' . "\n", $source);
	}
	
	/**
	 * 处理库文件
	 */
	elseif ($file_type == '.lbi') {
		/* 去除meta */
		$source = preg_replace('/<meta\shttp-equiv=["|\']Content-Type["|\']\scontent=["|\']text\/html;\scharset=(?:.*?)["|\']>\r?\n?/i', '', $source);
	}
	
	/* 去除模板文件被直接访问时的常量定义判断 */
	$source = preg_replace('/<\?php\sdefined\(["|\']IN_ECJIA["|\']\)\sor\sexit\(["|\']\s?(?:.*?)\s?["|\']\);*?\?>\r?\n?/i', '', $source);
	$source = preg_replace('/<\?php(.|\n)*?\?>\r?\n?/is', '', $source);
	
	/* 替换文件编码头部 */
	if (strpos($source, "\xEF\xBB\xBF") !== false) {
		$source = str_replace("\xEF\xBB\xBF", '', $source);
	}
	
	$pattern = array(
			'/<!--[^>|\n]*?({.+?})[^<|{|\n]*?-->/', // 替换smarty注释
			'/<!--[^<|>|{|\n]*?-->/',               // 替换不换行的html注释
			'/(href=["|\'])\.\.\/(.*?)(["|\'])/i',  // 替换相对链接
			'/((?:background|src)\s*=\s*["|\'])(?:\.\/|\.\.\/)?(images\/.*?["|\'])/is', // 在images前加上 $tmp_dir
			'/((?:background|background-image):\s*?url\()(?:\.\/|\.\.\/)?(images\/)/is', // 在images前加上 $tmp_dir
			'/([\'|"])\.\.\//is', // 以../开头的路径全部修正为空
	);
	$replace = array(
			'\1',
		    '',
			'\1\2\3',
			'\1' . $tmp_dir . '\2',
			'\1' . $tmp_dir . '\2',
			'\1'
	);
	$source = preg_replace($pattern, $replace, $source);
	
	return $source;
}

/**
 * 创建模板实例
 * 
 * @param string $template_file
 * @return \Ecjia\System\Theme\ThemeTemplate
 */
function get_template_dynamic_libraries($template_file) {
    $theme = Ecjia_ThemeManager::driver();
    if (is_a($theme, 'Ecjia\System\Theme\Theme')) {
        $template = new \Ecjia\System\Theme\ThemeTemplate($theme, $template_file.'.dwt.php');
        
        $dyna_libs = $template->getDynamicLibraries();
        
        return $dyna_libs;
    }
    
    return false;
}

/**
 * 替换动态模块
 *
 * @access  public
 * @param   string       $matches    匹配内容
 *
 * @return string        结果
 */
function dyna_libs_replace($matches) {
    $key = '/' . $matches[1];
    $row = array_shift($GLOBALS['libs'][$key]);
    if ($row) {
        $str = '';
        switch($row['type']) {
        	case 1:
        	    // 分类的商品
        	    $str = '{assign var="cat_goods" value=$cat_goods_' .$row['id']. '}
        	           {assign var="goods_cat" value=$goods_cat_' .$row['id']. '}';
        	    break;
        	case 2:
        	    // 品牌的商品
        	    $str = '{assign var="brand_goods" value=$brand_goods_' .$row['id']. '}
        	           {assign var="goods_brand" value=$goods_brand_' .$row['id']. '}';
        	    break;
        	case 3:
        	    // 文章列表
        	    $str = '{assign var="articles" value=$articles_' .$row['id']. '}
        	           {assign var="articles_cat" value=$articles_cat_' .$row['id']. '}';
        	    break;
        	case 4:
        	    //广告位
        	    $str = '{assign var="ads_id" value=' . $row['id'] . '}
        	           {assign var="ads_num" value=' . $row['number'] . '}';
        	    break;
    	    case 5:
    	    	//问卷调查
        	    $str = '{assign var="vote_form" value=$vote_form_' .$row['id']. '}';
    	    	break;
        }
        return $str . $matches[0];
    } else {
        return $matches[0];
    }
}


// end
