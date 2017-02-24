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

/* 访问控制 */

return array(
	/* 应用配置 */
	'show_asynclist' => 1,
	'APP' => array(
		'DEFAULT_TIMEZONE' => 'PRC', // 时区设置
		/* 日志和错误调试配置 */
		'DEBUG'     => false, // 是否开启调试模式，true开启，false关闭
		'LOG_ON'    => false, // 是否开启出错信息保存到文件，true开启，false不开启
		'LOG_PATH'  => ROOT_PATH . 'data/cache/log/', // 出错信息存放的目录，出错信息以天为单位存放，一般不需要修改
		'ERROR_URL' => '', // 出错信息重定向页面，为空采用默认的出错页面，一般不需要修改
		/* 网址配置 */
		'URL_REWRITE_ON'  => false, // 是否开启重写，true开启重写,false关闭重写
		'URL_MODULE_DEPR' => '/', // 模块分隔符，一般不需要修改
		'URL_ACTION_DEPR' => '-', // 操作分隔符，一般不需要修改
		'URL_PARAM_DEPR'  => '-', // 参数分隔符，一般不需要修改
		'URL_HTML_SUFFIX' => 'html', // 伪静态后缀设置，例如 html ，一般不需要修改
		/* 模块配置 */
		'MULTI_MODULE'     => true, // 是否允许多模块 如果为false 则必须设置 DEFAULT_APP
		'CONTROLLER_LEVEL' =>  1,
		'MODULE_PATH'      => './module/', // 模块存放目录，一般不需要修改
		'MODULE_SUFFIX'    => 'Mod.class.php', // 模块后缀，一般不需要修改
		'MODULE_INIT'      => 'init.php', // 初始程序，一般不需要修改
		'MODULE_DEFAULT'   => 'index', // 默认模块，一般不需要修改
		'MODULE_EMPTY'     => 'empty', // 空模块 ，一般不需要修改
		/* 操作配置 */
		'ACTION_DEFAULT' => 'index', // 默认操作，一般不需要修改
		'ACTION_EMPTY'   => '_empty', // 空操作，一般不需要修改
		/* 模型配置 */
		'MODEL_PATH'     => './model/', // 模型存放目录，一般不需要修改
		'MODEL_SUFFIX'   => 'Model.class.php', // 模型后缀，一般不需要修改
		/* 静态页面缓存 */
		'HTML_CACHE_ON'   => false, // 是否开启静态页面缓存，true开启.false关闭
		'HTML_CACHE_PATH' => ROOT_PATH . 'data/cache/html_cache/', // 静态页面缓存目录，一般不需要修改
		/* 静态页面缓存规则 array('模块名'=>array('方法名'=>缓存时间,)) 缓存时间,单位：秒 */
		'HTML_CACHE_RULE' => array(
            'default' => array('index' => array('index' => 1000))
        ),
		/* URL配置 */
		'URL_CASE_INSENSITIVE' => true, // 默认true则表示不区分大小写
		'URL_MODEL'            => 0, // URL访问模式,可选参数0、1、2、3,代表以下四种模式：0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
		'URL_PATHINFO_DEPR'    => '/',	// PATHINFO模式下，各参数之间的分割符号
		'URL_REQUEST_URI'      =>  'REQUEST_URI', // 获取当前页面地址的系统变量 默认为REQUEST_URI
		/* 系统变量名称设置 */
		'VAR_MODULE'           => 'm', // 默认模块获取变量
		'VAR_CONTROLLER'       => 'c', // 默认控制器获取变量
		'VAR_ACTION'           => 'a', // 默认操作获取变量
		'VAR_PATHINFO'         =>  'r',    // 兼容模式PATHINFO获取变量例如 ?s=/module/action/id/1 后面的参数取决于URL_PATHINFO_DEPR
		'URL_PATHINFO_FETCH'   =>  'ORIG_PATH_INFO,REDIRECT_PATH_INFO,REDIRECT_URL', // 用于兼容判断PATH_INFO 参数的SERVER替代变量列表
		'URL_PARAMS_BIND'      =>  true, // URL变量绑定到Action方法参数
		'URL_PARAMS_BIND_TYPE' =>  0, // URL变量绑定的类型 0 按变量名绑定 1 按变量顺序绑定
		'AUTOLOAD_DIR'         => array(), // 自动加载扩展目录
	),
	/* 数据库配置 */
	'DB' => array(
		'DB_TYPE'       => 'mysql', // 数据库类型，一般不需要修改
		'DB_HOST'       => 'localhost', // 数据库主机，一般不需要修改
		'DB_USER'       => 'root', // 数据库用户名
		'DB_PWD'        => 'w123', // 数据库密码
		'DB_PORT'       => 3306, // 数据库端口，mysql默认是3306，一般不需要修改
		'DB_NAME'       => 'work', // 数据库名
		'DB_CHARSET'    => 'utf8', // 数据库编码，一般不需要修改
		'DB_PREFIX'     => 'ecs_', // 数据库前缀
		'DB_CACHE_ON'   => false, // 是否开启数据库缓存，true开启，false不开启
		'DB_CACHE_TYPE' => 'FileCache', // 缓存类型，FileCache或Memcache或SaeMemcache
		'DB_CACHE_TIME' => 600, // 缓存时间,0不缓存，-1永久缓存,单位：秒
		/* 文件缓存配置 */
		'DB_CACHE_PATH'   => ROOT_PATH . 'data/cache/db_cache/', // 数据库查询内容缓存目录，地址相对于入口文件，一般不需要修改
		'DB_CACHE_CHECK'  => false, // 是否对缓存进行校验，一般不需要修改
		'DB_CACHE_FILE'   => 'cachedata', // 缓存的数据文件名
		'DB_CACHE_SIZE'   => '15M', // 预设的缓存大小，最小为10M，最大为1G
		'DB_CACHE_FLOCK'  => true, // /是否存在文件锁，设置为false，将模拟文件锁,，一般不需要修改
		/* memcache配置，可配置多台memcache服务器 */
		'MEM_SERVER' => array(
			array('127.0.0.1', 11211),
			array('localhost', 11211)
		),
		'MEM_GROUP' => 'db',
		/* SaeMemcache配置 */
		'SAE_MEM_GROUP' => 'db',
		/* 数据库主从配置 */
		'DB_SLAVE' => array() // 数据库从机配置
	),
	/* 模板配置 */
	'TPL' => array(
		'TPL_TEMPLATE_PATH'   => RC_THEME_PATH . ecjia::config('template') . DIRECTORY_SEPARATOR, // 模板目录，一般不需要修改
		'TPL_TEMPLATE_SUFFIX' => '.php', // 模板后缀，一般不需要修改
		'TPL_CACHE_ON'        => false, // 是否开启模板缓存，true开启,false不开启
		'TPL_CACHE_TYPE'      => '', // 数据缓存类型，为空或Memcache或SaeMemcache，其中为空为普通文件缓存
		/* 普通文件缓存 */
		'TPL_CACHE_PATH'      => TEMPLATE_CACHE_PATH, // 模板缓存目录，一般不需要修改
		'TPL_CACHE_SUFFIX'    => '.php', // 模板缓存后缀,一般不需要修改
		/* memcache配置 */
		'MEM_SERVER' => array(
			array('127.0.0.1', 11211),
			array('localhost', 11211)
		),
		'MEM_GROUP'     => 'tpl',
		/* SaeMemcache配置 */
		'SAE_MEM_GROUP' => 'tpl'
	),
    /* SESSION设置 */
    'SESSION' => array(
        'SESSION_AUTO_START' => true, // 是否自动开启Session
        'SESSION_OPTIONS'    => array(), // session 配置数组 支持name id path expire domain 等参数
        'SESSION_PREFIX'     => '' // session 前缀
    ),
    /* Cookie设置 */
    'COOKIE' => array(
        'COOKIE_EXPIRE'   => 0, // Cookie有效期
        'COOKIE_DOMAIN'   => '', // Cookie有效域名
        'COOKIE_PATH'     => '/', // Cookie路径
        'COOKIE_PREFIX'   => '', // Cookie前缀 避免冲突
        'COOKIE_HTTPONLY' => '' // Cookie httponly设置
    )
);

// end
