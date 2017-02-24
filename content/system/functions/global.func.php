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
 * ECJIA 管理中心公用函数库
 */
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 过滤用户输入的基本数据，防止script攻击
 *
 * @access public
 * @return string
 */
function compile_str($str)
{
    $arr = array(
        '<' => '＜',
        '>' => '＞'
    );
    
    return strtr($str, $arr);
}


/**
 * 将一个字串中含有全角的数字字符、字母、空格或'%+-()'字符转换为相应半角字符
 *
 * @access public
 * @param string $str
 *            待转换字串
 *            
 * @return string $str 处理后字串
 */
function make_semiangle($str)
{
    $arr = array(
        '０' => '0',
        '１' => '1',
        '２' => '2',
        '３' => '3',
        '４' => '4',
        '５' => '5',
        '６' => '6',
        '７' => '7',
        '８' => '8',
        '９' => '9',
        'Ａ' => 'A',
        'Ｂ' => 'B',
        'Ｃ' => 'C',
        'Ｄ' => 'D',
        'Ｅ' => 'E',
        'Ｆ' => 'F',
        'Ｇ' => 'G',
        'Ｈ' => 'H',
        'Ｉ' => 'I',
        'Ｊ' => 'J',
        'Ｋ' => 'K',
        'Ｌ' => 'L',
        'Ｍ' => 'M',
        'Ｎ' => 'N',
        'Ｏ' => 'O',
        'Ｐ' => 'P',
        'Ｑ' => 'Q',
        'Ｒ' => 'R',
        'Ｓ' => 'S',
        'Ｔ' => 'T',
        'Ｕ' => 'U',
        'Ｖ' => 'V',
        'Ｗ' => 'W',
        'Ｘ' => 'X',
        'Ｙ' => 'Y',
        'Ｚ' => 'Z',
        'ａ' => 'a',
        'ｂ' => 'b',
        'ｃ' => 'c',
        'ｄ' => 'd',
        'ｅ' => 'e',
        'ｆ' => 'f',
        'ｇ' => 'g',
        'ｈ' => 'h',
        'ｉ' => 'i',
        'ｊ' => 'j',
        'ｋ' => 'k',
        'ｌ' => 'l',
        'ｍ' => 'm',
        'ｎ' => 'n',
        'ｏ' => 'o',
        'ｐ' => 'p',
        'ｑ' => 'q',
        'ｒ' => 'r',
        'ｓ' => 's',
        'ｔ' => 't',
        'ｕ' => 'u',
        'ｖ' => 'v',
        'ｗ' => 'w',
        'ｘ' => 'x',
        'ｙ' => 'y',
        'ｚ' => 'z',
        '（' => '(',
        '）' => ')',
        '〔' => '[',
        '〕' => ']',
        '【' => '[',
        '】' => ']',
        '〖' => '[',
        '〗' => ']',
        '“' => '[',
        '”' => ']',
        '‘' => '[',
        '’' => ']',
        '｛' => '{',
        '｝' => '}',
        '《' => '<',
        '》' => '>',
        '％' => '%',
        '＋' => '+',
        '—' => '-',
        '－' => '-',
        '～' => '-',
        '：' => ':',
        '。' => '.',
        '、' => ',',
        '，' => '.',
        '、' => '.',
        '；' => ',',
        '？' => '?',
        '！' => '!',
        '…' => '-',
        '‖' => '|',
        '”' => '"',
        '’' => '`',
        '‘' => '`',
        '｜' => '|',
        '〃' => '"',
        '　' => ' '
    );
    
    return strtr($str, $arr);
}

/**
 * 检查目标文件夹是否存在，如果不存在则自动创建该目录
 *
 * @access public
 * @param
 *            string folder 目录路径。不能使用相对于网站根目录的URL
 *            
 * @return bool
 */
function make_dir($folder)
{
    $reval = false;
    
    if (! file_exists($folder)) {
        /* 如果目录不存在则尝试创建该目录 */
        @umask(0);
        
        /* 将目录路径拆分成数组 */
        preg_match_all('/([^\/]*)\/?/i', $folder, $atmp);
        
        /* 如果第一个字符为/则当作物理路径处理 */
        $base = ($atmp[0][0] == '/') ? '/' : '';
        
        /* 遍历包含路径信息的数组 */
        foreach ($atmp[1] as $val) {
            if ('' != $val) {
                $base .= $val;
                
                if ('..' == $val || '.' == $val) {
                    /* 如果目录为.或者..则直接补/继续下一个循环 */
                    $base .= '/';
                    
                    continue;
                }
            } else {
                continue;
            }
            
            $base .= '/';
            
            if (! file_exists($base)) {
                /* 尝试创建目录，如果创建失败则继续循环 */
                if (@mkdir(rtrim($base, '/'), 0777)) {
                    @chmod($base, 0777);
                    $reval = true;
                }
            }
        }
    } else {
        /* 路径已经存在。返回该路径是不是一个目录 */
        $reval = is_dir($folder);
    }
    
    clearstatcache();
    
    return $reval;
}

/**
 * 去除字符串右侧可能出现的乱码
 *
 * @param string $str
 *            字符串
 *            
 * @return string
 */
function trim_right($str)
{
    $len = strlen($str);
    /* 为空或单个字符直接返回 */
    if ($len == 0 || ord($str{$len - 1}) < 127) {
        return $str;
    }
    /* 有前导字符的直接把前导字符去掉 */
    if (ord($str{$len - 1}) >= 192) {
        return substr($str, 0, $len - 1);
    }
    /* 有非独立的字符，先把非独立字符去掉，再验证非独立的字符是不是一个完整的字，不是连原来前导字符也截取掉 */
    $r_len = strlen(rtrim($str, "\x80..\xBF"));
    if ($r_len == 0 || ord($str{$r_len - 1}) < 127) {
        return RC_String::sub_str($str, 0, $r_len);
    }
    
    $as_num = ord(~ $str{$r_len - 1});
    if ($as_num > (1 << (6 + $r_len - $len))) {
        return $str;
    } else {
        return RC_String::sub_str($str, 0, $r_len - 1);
    }
}


/**
 * 对 MYSQL LIKE 的内容进行转义
 *
 * @access public
 * @param
 *            string string 内容
 * @return string
 */
function mysql_like_quote($str)
{
    return strtr($str, array(
        "\\\\" => "\\\\\\\\",
        '_' => '\_',
        '%' => '\%',
        "\'" => "\\\\\'"
    ));
}

/**
 * 生成文件MD5值缓存
 */
function generate_md5_files($currentdir, $ext = '', $sub = 1, $skip = '')
{
    $md5data = RC_File::get_md5_files($currentdir, $ext, $sub, $skip);
    $md5data = array_flip($md5data);
    RC_Cache::app_cache_set('md5files', $md5data, 'system');
    return $md5data;
}

/**
 * Check whether variable is a WordPress Error.
 *
 * Returns true if $thing is an object of the WP_Error class.
 *
 * @since 1.0.0
 *       
 * @param mixed $thing
 *            Check if unknown variable is a WP_Error object.
 * @return bool True, if WP_Error. False, if not WP_Error.
 */
function is_ecjia_error($thing)
{
    if (is_object($thing) && is_a($thing, 'ecjia_error'))
        return true;
    return false;
}


/**
 * 去除HTML标签
 *
 * @param string $content
 */
function noHTML($content)
{
    $content = preg_replace("/<a[^>]*>/i", '', $content);
    $content = preg_replace("/<\/a>/i", '', $content);
    $content = preg_replace("/<div[^>]*>/i", '', $content);
    $content = preg_replace("/<\/div>/i", '', $content);
    $content = preg_replace("/<font[^>]*>/i", '', $content);
    $content = preg_replace("/<\/font>/i", '', $content);
    $content = preg_replace("/<p[^>]*>/i", '', $content);
    $content = preg_replace("/<\/p>/i", '', $content);
    $content = preg_replace("/<span[^>]*>/i", '', $content);
    $content = preg_replace("/<\/span>/i", '', $content);
    $content = preg_replace("/<\\?xml[^>]*>/i", '', $content);
    $content = preg_replace("/<\\/\\?xml>/i", '', $content);
    $content = preg_replace("/<o:p[^>]*>/i", '', $content);
    $content = preg_replace("/<\/o:p>/i", '', $content);
    $content = preg_replace("/<u[^>]*>/i", '', $content);
    $content = preg_replace("/<\/u>/i", '', $content);
    $content = preg_replace("/<b[^>]*>/i", '', $content);
    $content = preg_replace("/<\/b>/i", '', $content);
    $content = preg_replace("/<meta[^>]*>/i", '', $content);
    $content = preg_replace("/<\/meta>/i", '', $content);
    $content = preg_replace("/<!--[^>]*-->/i", '', $content); // 注释内容
    $content = preg_replace("/<p[^>]*-->/i", '', $content); // 注释内容
    $content = preg_replace("/style=.+?['|\"]/i", '', $content); // 去除样式
    $content = preg_replace("/class=.+?['|\"]/i", '', $content); // 去除样式
    $content = preg_replace("/id=.+?['|\"]/i", '', $content); // 去除样式
    $content = preg_replace("/lang=.+?['|\"]/i", '', $content); // 去除样式
    $content = preg_replace("/width=.+?['|\"]/i", '', $content); // 去除样式
    $content = preg_replace("/height=.+?['|\"]/i", '', $content); // 去除样式
    $content = preg_replace("/border=.+?['|\"]/i", '', $content); // 去除样式
    $content = preg_replace("/face=.+?['|\"]/i", '', $content); // 去除样式
    $content = preg_replace("/face=.+?['|\"]/", '', $content);
    $content = preg_replace("/face=.+?['|\"]/", '', $content);
    $content = str_replace("&nbsp;", "", $content);
    return $content;
}


/**
 * 清除HTML标签
 *
 * @param string $str
 */
function deleteHTML($str)
{
    $st = - 1; // 开始
    $et = - 1; // 结束
    $stmp = array();
    $stmp[] = "&nbsp;";
    $len = strlen($str);

    for ($i = 0; $i < $len; $i ++) {
        $ss = substr($str, $i, 1);
        // ord("<")==60
        if (ord($ss) == 60) {
            $st = $i;
        }

        // ord(">")==62
        if (ord($ss) == 62) {
            $et = $i;
            if ($st != - 1) {
                $stmp[] = substr($str, $st, $et - $st + 1);
            }
        }
    }

    $str = str_replace($stmp, "", $str);
    return $str;
}


/**
 * 格式化商品价格
 *
 * @access public
 * @param float $price
 *        	商品价格
 * @return string
 */
function price_format($price, $change_price = true)
{
    if ($price === '') {
        $price = 0;
    }
    
    $price = floatval($price);
    
    if ($change_price && defined('IN_ADMIN') === false) {
        switch (ecjia::config('price_format')) {
        	case 0:
        	    $price = number_format($price, 2, '.', '');
        	    break;
        	case 1: // 保留不为 0 的尾数
        	    $price = preg_replace('/(.*)(\\.)([0-9]*?)0+$/', '\1\2\3', number_format($price, 2, '.', ''));

        	    if (substr($price, - 1) == '.') {
        	        $price = substr($price, 0, - 1);
        	    }
        	    break;
        	case 2: // 不四舍五入，保留1位
        	    $price = substr(number_format($price, 2, '.', ''), 0, - 1);
        	    break;
        	case 3: // 直接取整
        	    $price = intval($price);
        	    break;
        	case 4: // 四舍五入，保留 1 位
        	    $price = number_format($price, 1, '.', '');
        	    break;
        	case 5: // 先四舍五入，不保留小数
        	    $price = round($price);
        	    break;
        }
    } else {
        $price = number_format($price, 2, '.', '');
    }

    return sprintf(ecjia::config('currency_format'), $price);
}


/**
 * 重写 URL 地址
 *
 * @access public
 * @param string $app
 *        	执行程序
 * @param array $params
 *        	参数数组
 * @param string $append
 *        	附加字串
 * @param integer $page
 *        	页数
 * @param string $keywords
 *        	搜索关键词字符串
 * @return void
 */
function build_uri($app, $params, $append = '', $page = 0, $keywords = '', $size = 0) {
    static $rewrite = NULL;

    if ($rewrite === NULL) {
        $rewrite = intval (ecjia::config('rewrite'));
    }

    $args = array (
        'cid' => 0,
        'gid' => 0,
        'bid' => 0,
        'acid' => 0,
        'aid' => 0,
        'sid' => 0,
        'gbid' => 0,
        'auid' => 0,
        'sort' => '',
        'order' => ''
    );

    extract ( array_merge ( $args, $params ) );

    $uri = '';
    switch ($app) {
    	case 'category' :
    	    if (empty ( $cid )) {
    	        return false;
    	    } else {
    	        if ($rewrite) {
    	            $uri = 'category-' . $cid;
    	            if (isset ( $bid )) {
    	                $uri .= '-b' . $bid;
    	            }
    	            if (isset ( $price_min )) {
    	                $uri .= '-min' . $price_min;
    	            }
    	            if (isset ( $price_max )) {
    	                $uri .= '-max' . $price_max;
    	            }
    	            if (isset ( $filter_attr )) {
    	                $uri .= '-attr' . $filter_attr;
    	            }
    	            if (! empty ( $page )) {
    	                $uri .= '-' . $page;
    	            }
    	            if (! empty ( $sort )) {
    	                $uri .= '-' . $sort;
    	            }
    	            if (! empty ( $order )) {
    	                $uri .= '-' . $order;
    	            }
    	        } else {
    	            $uri = 'index.php?m=goods&c=category&a=init&id=' . $cid;
    	            if (! empty ( $bid )) {
    	                $uri .= '&amp;brand=' . $bid;
    	            }
    	            if (isset ( $price_min )) {
    	                $uri .= '&amp;price_min=' . $price_min;
    	            }
    	            if (isset ( $price_max )) {
    	                $uri .= '&amp;price_max=' . $price_max;
    	            }
    	            if (! empty ( $filter_attr )) {
    	                $uri .= '&amp;filter_attr=' . $filter_attr;
    	            }
    	            	
    	            if (! empty ( $page )) {
    	                $uri .= '&amp;page=' . $page;
    	            }
    	            if (! empty ( $sort )) {
    	                $uri .= '&amp;sort=' . $sort;
    	            }
    	            if (! empty ( $order )) {
    	                $uri .= '&amp;order=' . $order;
    	            }
    	        }
    	    }
    	    	
    	    break;
    	case 'goods' :
    	    if (empty ( $gid )) {
    	        return false;
    	    } else {
    	        $uri = $rewrite ? 'goods-' . $gid : 'index.php?m=goods&c=index&a=lists&id=' . $gid;
    	    }
    	    	
    	    break;
    	case 'brand' :
    	    if (empty ( $bid )) {
    	        return false;
    	    } else {
    	        if ($rewrite) {
    	            $uri = 'brand-' . $bid;
    	            if (isset ( $cid )) {
    	                $uri .= '-c' . $cid;
    	            }
    	            if (! empty ( $page )) {
    	                $uri .= '-' . $page;
    	            }
    	            if (! empty ( $sort )) {
    	                $uri .= '-' . $sort;
    	            }
    	            if (! empty ( $order )) {
    	                $uri .= '-' . $order;
    	            }
    	        } else {
    	            $uri = 'index.php?m=goods&c=brand&a=init&id=' . $bid;
    	            if (! empty ( $cid )) {
    	                $uri .= '&amp;cat=' . $cid;
    	            }
    	            if (! empty ( $page )) {
    	                $uri .= '&amp;page=' . $page;
    	            }
    	            if (! empty ( $sort )) {
    	                $uri .= '&amp;sort=' . $sort;
    	            }
    	            if (! empty ( $order )) {
    	                $uri .= '&amp;order=' . $order;
    	            }
    	        }
    	    }
    	    	
    	    break;
    	case 'article_cat' :
    	    if (empty ( $acid )) {
    	        return false;
    	    } else {
    	        if ($rewrite) {
    	            $uri = 'article_cat-' . $acid;
    	            if (! empty ( $page )) {
    	                $uri .= '-' . $page;
    	            }
    	            if (! empty ( $sort )) {
    	                $uri .= '-' . $sort;
    	            }
    	            if (! empty ( $order )) {
    	                $uri .= '-' . $order;
    	            }
    	            if (! empty ( $keywords )) {
    	                $uri .= '-' . $keywords;
    	            }
    	        } else {
    	            $uri = 'index.php?m=article&c=category&a=init&id=' . $acid;
    	            if (! empty ( $page )) {
    	                $uri .= '&amp;page=' . $page;
    	            }
    	            if (! empty ( $sort )) {
    	                $uri .= '&amp;sort=' . $sort;
    	            }
    	            if (! empty ( $order )) {
    	                $uri .= '&amp;order=' . $order;
    	            }
    	            if (! empty ( $keywords )) {
    	                $uri .= '&amp;keywords=' . $keywords;
    	            }
    	        }
    	    }
    	    	
    	    break;
    	case 'article' :
    	    if (empty ( $aid )) {
    	        return false;
    	    } else {
    	        $uri = $rewrite ? 'article-' . $aid : 'index.php?m=article&c=index&a=init&id=' . $aid;
    	    }
    	    	
    	    break;
    	case 'group_buy' :
    	    if (empty ( $gbid )) {
    	        return false;
    	    } else {
    	        $uri = $rewrite ? 'group_buy-' . $gbid : 'index.php?m=groupbuy&c=index&a=view&amp;id=' . $gbid;
    	    }
    	    	
    	    break;
    	case 'auction' :
    	    if (empty ( $auid )) {
    	        return false;
    	    } else {
    	        $uri = $rewrite ? 'auction-' . $auid : 'index.php?m=auction&c=index&a=view&amp;id=' . $auid;
    	    }
    	    	
    	    break;
    	case 'snatch' :
    	    if (empty ( $sid )) {
    	        return false;
    	    } else {
    	        $uri = $rewrite ? 'snatch-' . $sid : 'index.php?m=snatch&c=index&a=init&id=' . $sid;
    	    }
    	    	
    	    break;
    	case 'search' :
    	    break;
    	case 'exchange' :
    	    if ($rewrite) {
    	        $uri = 'exchange-' . $cid;
    	        if (isset ( $price_min )) {
    	            $uri .= '-min' . $price_min;
    	        }
    	        if (isset ( $price_max )) {
    	            $uri .= '-max' . $price_max;
    	        }
    	        if (! empty ( $page )) {
    	            $uri .= '-' . $page;
    	        }
    	        if (! empty ( $sort )) {
    	            $uri .= '-' . $sort;
    	        }
    	        if (! empty ( $order )) {
    	            $uri .= '-' . $order;
    	        }
    	    } else {
    	        $uri = 'index.php?m=exchange&c=index&a=lists&cat_id=' . $cid;
    	        if (isset ( $price_min )) {
    	            $uri .= '&amp;integral_min=' . $price_min;
    	        }
    	        if (isset ( $price_max )) {
    	            $uri .= '&amp;integral_max=' . $price_max;
    	        }

    	        if (! empty ( $page )) {
    	            $uri .= '&amp;page=' . $page;
    	        }
    	        if (! empty ( $sort )) {
    	            $uri .= '&amp;sort=' . $sort;
    	        }
    	        if (! empty ( $order )) {
    	            $uri .= '&amp;order=' . $order;
    	        }
    	    }
    	    	
    	    break;
    	case 'exchange_goods' :
    	    if (empty ( $gid )) {
    	        return false;
    	    } else {
    	        $uri = $rewrite ? 'exchange-id' . $gid : 'index.php?m=exchange&c=index&a=lists&id=' . $gid . '&amp;act=view';
    	    }
    	    	
    	    break;
    	default :
    	    return false;
    	    break;
    }

    if ($rewrite) {
        if ($rewrite == 2 && ! empty ( $append )) {
            $uri .= '-' . urlencode ( preg_replace ( '/[\.|\/|\?|&|\+|\\\|\'|"|,]+/', '', $append ) );
        }

        $uri .= '.html';
    }
    if (($rewrite == 2) && (strpos ( strtolower ( EC_CHARSET ), 'utf' ) !== 0)) {
        $uri = urlencode ( $uri );
    }
    return $uri;
}





// end