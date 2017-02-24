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
 * ueditor完整配置项
 * 可以在这里配置整个编辑器的特性
 */
return array(
    
    'toolbars' => array(
    	
        /**
         * 基础的文字编辑和图片上传。使用场景：一般图文文章发布。
         */
        'base' => array(
        	array(
        	    'fullscreen', 'source', '|', 'fontfamily', 'fontsize', '|', 'bold', 'italic', 'underline', 'strikethrough', '|', 'forecolor', 'backcolor', '|',
        	    'insertorderedlist', 'insertunorderedlist', '|', 'selectall', 'cleardoc', 'removeformat',
        	    '|', 'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
        	    'link', 'unlink', '|', 'emotion', 'simpleupload', 'insertimage',
        	    '|', 'undo', 'redo',
        	    '|', 'horizontal', 'preview', 'drafts'
        	)
        ),
        
        /**
         * 简单的文字编辑和图片上传。使用场景：简单的回复评论框。
         */
        'simple' => array(
        	array(
        	    'bold', 'italic', 'underline', 'strikethrough', '|', 'forecolor', '|', 'blockquote', '|',
        	    'insertorderedlist', 'insertunorderedlist', '|',
        	    'link', 'unlink', '|', 'emotion'
        	)
        ),
        
        /**
         * 侧重于代码的编辑和展现。使用场景：关于代码的技术性文章回复和评论；技术性问答。
         */
        'code' => array(
        	array(
        	   'source', '|', 'insertcode', 'fontsize', '|', 'bold', 'italic', 'underline', 'strikethrough', '|', 'forecolor', 'backcolor', '|', 'removeformat', '|',
        	   'insertorderedlist', 'insertunorderedlist', '|', 'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
        	   'link', 'unlink', '|', 'emotion',  'simpleupload', 'insertimage', '|', 'undo', 'redo', '|', 'horizontal', 'preview', 'fullscreen', 'drafts'
        	)
        ),
        
        /**
         * 常用的的文字编辑，表格处理和图片、视频、附件上传。使用场景：包含表格，附件，图文文章发布，对文章格式要求较高。
         */
        'standard' => array(
        	array(
        	    'fullscreen','source', '|', 'paragraph', 'fontfamily', 'fontsize', '|',
        	    'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain',
        	    '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', '|',
        	    'rowspacingtop', 'rowspacingbottom', 'lineheight', 'indent', '|',
        	    'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
        	    'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
        	    'emotion', 'simpleupload', 'insertimage', 'insertvideo', 'attachment', 'pagebreak', '|',
        	    'horizontal', 'spechars', '|',
        	    'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'splittocells', 'charts', '|',
        	    'undo', 'redo', '|',
        	    'print', 'preview', 'searchreplace', 'drafts'
        	)
        ),
        
        /**
         * 高级完整版，高级复杂的文字和表格编辑，以及其他小功能。当“标准模式”不能满足时使用。
         */
        'advanced' => array(
        	array(
        	   'fullscreen', 'source', '|', 'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
                'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
                'rowspacingtop', 'rowspacingbottom', 'lineheight', 'indent', '|',
                'directionalityltr', 'directionalityrtl', '|',
                'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
                'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                'emotion', 'simpleupload', 'insertimage', 'insertvideo', 'attachment', 'insertcode', 'pagebreak', 'template', 'background', '|',
                'horizontal', 'date', 'time', 'spechars', '|',
                'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
                'undo', 'redo', '|',
                'print', 'preview', 'searchreplace', 'drafts'
        	)
        ),
    ),
    
    /**
     * 和原 UEditor /ueditor.config.js 配置完全相同
     */
    /**************************提示********************************
     * 所有被注释的配置项均为UEditor默认值。
     * 修改默认配置请首先确保已经完全明确该参数的真实用途。
     * 主要有两种修改方案，一种是取消此处注释，然后修改成对应参数；另一种是在实例化编辑器时传入对应参数。
     * 当升级编辑器时，可直接使用旧版配置文件替换新版配置文件,不用担心旧版配置文件中因缺少新功能所需的参数而导致脚本报错。
     **************************提示********************************/
    'editor' => array(
        /* 为编辑器实例添加一个路径，这个不能被注释 */
        /**
         * 编辑器资源文件根路径。它所表示的含义是：以编辑器实例化页面为当前路径，指向编辑器资源文件（即dialog等文件夹）的路径。
         * 鉴于很多同学在使用编辑器的时候出现的种种路径问题，此处强烈建议大家使用"相对于网站根目录的相对路径"进行配置。
         * "相对于网站根目录的相对路径"也就是以斜杠开头的形如"/myProject/ueditor/"这样的路径。
         * 如果站点中有多个不在同一层级的页面需要实例化编辑器，且引用了同一UEditor的时候，此处的URL可能不适用于每个页面的编辑器。
         * 因此，UEditor提供了针对不同页面的编辑器可单独配置的根路径，具体来说，在需要实例化编辑器的页面最顶部写上如下代码即可。当然，需要令此处的URL等于对应的配置。
         * window.UEDITOR_HOME_URL = "/xxxx/xxxx/";
         */
        'UEDITOR_HOME_URL' => '',
        
        /* 服务器统一请求接口路径 */
        'serverUrl' => '/index.php/_ueditor/server',
        
        /* 工具栏上的所有的功能按钮和下拉框，可以在new编辑器的实例时选择自己需要的从新定义 
        'toolbars' => array(
            array(
                'fullscreen', 'source', '|', 'undo', 'redo', '|',
                'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
                'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
                'directionalityltr', 'directionalityrtl', 'indent', '|',
                'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
                'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'gmap', 'insertframe', 'insertcode', 'webapp', 'pagebreak', 'template', 'background', '|',
                'horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage', '|',
                'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
                'print', 'preview', 'searchreplace', 'drafts', 'help'
            ),
        ),*/
        
        /* 语言配置项,默认是zh_CN。有需要的话也可以使用如下这样的方式来自动多语言切换，当然，前提条件是lang文件夹下存在对应的语言文件： */
        /* lang值也可以通过自动获取 (navigator.language||navigator.browserLanguage ||navigator.userLanguage).toLowerCase() */
        'lang' => 'zh_CN',
        
        /* 主题配置项,默认是default。有需要的话也可以使用如下这样的方式来自动多主题切换，当然，前提条件是themes文件夹下存在对应的主题文件： */
        /* 现有如下皮肤:default */
        'theme' => 'default',
        
        /* autoHeightEnabled 是否自动长高,默认true */
        'autoHeightEnabled' => false,

        /* autoFloatEnabled 是否保持toolbar的位置不动,默认true */
        'autoFloatEnabled' => false,
        /* 浮动时工具栏距离浏览器顶部的高度，用于某些具有固定头部的页面 */
        'topOffset' => 40,
        /* 编辑器底部距离工具栏高度(如果参数大于等于编辑器高度，则设置无效) */
        'toolbarTopOffset' => 0,
    ),
    
    /**
     * 和原 UEditor /php/config.json 配置完全相同
     *
     */
    /* 上传图片配置项 */
    'upload' => array(
        /* 执行上传图片的action名称 */
        "imageActionName" => "uploadimage", 
        
        /* 提交的图片表单名称 */
        "imageFieldName" => "upfile", 
        
        /* 上传大小限制，单位B */
        "imageMaxSize" => 2048000, 
        
        /* 上传图片格式显示 */
        "imageAllowFiles" => array(".png", ".jpg", ".jpeg", ".gif", ".bmp"), 
        
        /* 是否压缩图片,默认是true */
        "imageCompressEnable" => true, 
        
        /* 图片压缩最长边限制 */
        "imageCompressBorder" => 1600, 
        
        /* 插入的图片浮动方式 */
        "imageInsertAlign" => "none", 
        
        /* 图片访问路径前缀 */
        "imageUrlPrefix" => "", 
        
        /* 上传保存路径,可以自定义保存路径和文件名格式 */
        "imagePathFormat" => "data/descimg/{yyyy}{mm}{dd}/{time}{rand:6}",
         
        /* {filename} 会替换成原文件名,配置这项需要注意中文乱码问题 */
        /* {rand:6} 会替换成随机数,后面的数字是随机数的位数 */
        /* {time} 会替换成时间戳 */
        /* {yyyy} 会替换成四位年份 */
        /* {yy} 会替换成两位年份 */
        /* {mm} 会替换成两位月份 */
        /* {dd} 会替换成两位日期 */
        /* {hh} 会替换成两位小时 */
        /* {ii} 会替换成两位分钟 */
        /* {ss} 会替换成两位秒 */
        /* 非法字符 \ : * ? " < > | */
        /* 具请体看线上文档: fex.baidu.com/ueditor/#use-format_upload_filename */

        /* 涂鸦图片上传配置项 */
        /* 执行上传涂鸦的action名称 */
        "scrawlActionName" => "uploadscrawl", 
        
        /* 提交的图片表单名称 */
        "scrawlFieldName" => "upfile", 
        
        /* 上传保存路径,可以自定义保存路径和文件名格式 */
        "scrawlPathFormat" => "data/descimg/{yyyy}{mm}{dd}/{time}{rand:6}", 
        /* 上传大小限制，单位B */
        "scrawlMaxSize" => 2048000, 
        /* 图片访问路径前缀 */
        "scrawlUrlPrefix" => "", 
        "scrawlInsertAlign" => "none",

        /* 截图工具上传 */
        /* 执行上传截图的action名称 */
        "snapscreenActionName" => "uploadimage", 
        /* 上传保存路径,可以自定义保存路径和文件名格式 */
        "snapscreenPathFormat" => "data/descimg/{yyyy}{mm}{dd}/{time}{rand:6}",
        /* 图片访问路径前缀 */
        "snapscreenUrlPrefix" => "", 
        /* 插入的图片浮动方式 */
        "snapscreenInsertAlign" => "none", 

        /* 抓取远程图片配置 */
        "catcherLocalDomain" => array("127.0.0.1", "localhost", "img.baidu.com"),
        /* 执行抓取远程图片的action名称 */
        "catcherActionName" => "catchimage", 
        /* 提交的图片列表表单名称 */
        "catcherFieldName" => "source", 
        /* 上传保存路径,可以自定义保存路径和文件名格式 */
        "catcherPathFormat" => "data/descimg/{yyyy}{mm}{dd}/{time}{rand:6}", 
        /* 图片访问路径前缀 */
        "catcherUrlPrefix" => "", 
        /* 上传大小限制，单位B */
        "catcherMaxSize" => 2048000, 
        /* 抓取图片格式显示 */
        "catcherAllowFiles" => array(".png", ".jpg", ".jpeg", ".gif", ".bmp"), 

        /* 上传视频配置 */
        /* 执行上传视频的action名称 */
        "videoActionName" => "uploadvideo", 
        /* 提交的视频表单名称 */
        "videoFieldName" => "upfile", 
        /* 上传保存路径,可以自定义保存路径和文件名格式 */
        "videoPathFormat" => "data/descvideo/{yyyy}{mm}{dd}/{time}{rand:6}", 
        /* 视频访问路径前缀 */
        "videoUrlPrefix" => "", 
        /* 上传大小限制，单位B，默认100MB */
        "videoMaxSize" => 102400000, 
        /* 上传视频格式显示 */
        "videoAllowFiles" => array(
            ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
            ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid"), 

        /* 上传文件配置 */
        /* controller里,执行上传视频的action名称 */
        "fileActionName" => "uploadfile", 
        /* 提交的文件表单名称 */
        "fileFieldName" => "upfile", 
        /* 上传保存路径,可以自定义保存路径和文件名格式 */
        "filePathFormat" => "data/descfile/{yyyy}{mm}{dd}/{time}{rand:6}", 
        /* 文件访问路径前缀 */
        "fileUrlPrefix" => "", 
        /* 上传大小限制，单位B，默认50MB */
        "fileMaxSize" => 51200000, 
        /* 上传文件格式显示 */
        "fileAllowFiles" => array(
            ".png", ".jpg", ".jpeg", ".gif", ".bmp",
            ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
            ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid",
            ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2", ".cab", ".iso",
            ".doc", ".docx", ".xls", ".xlsx", ".ppt", ".pptx", ".pdf", ".txt", ".md", ".xml"
        ), 

        /* 列出指定目录下的图片 */
        /* 执行图片管理的action名称 */
        "imageManagerActionName" => "listimage", 
        /* 指定要列出图片的目录 */
        "imageManagerListPath" => "data/descimg/", 
        /* 每次列出文件数量 */
        "imageManagerListSize" => 20, 
        /* 图片访问路径前缀 */
        "imageManagerUrlPrefix" => "", 
        /* 插入的图片浮动方式 */
        "imageManagerInsertAlign" => "none", 
        /* 列出的文件类型 */
        "imageManagerAllowFiles" => array(".png", ".jpg", ".jpeg", ".gif", ".bmp"), 

        /* 列出指定目录下的文件 */
        /* 执行文件管理的action名称 */
        "fileManagerActionName" => "listfile", 
        /* 指定要列出文件的目录 */
        "fileManagerListPath" => "data/descfile/", 
        /* 文件访问路径前缀 */
        "fileManagerUrlPrefix" => "", 
        /* 每次列出文件数量 */
        "fileManagerListSize" => 20, 
        /* 列出的文件类型 */
        "fileManagerAllowFiles" => array(
            ".png", ".jpg", ".jpeg", ".gif", ".bmp",
            ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
            ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid",
            ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2", ".cab", ".iso",
            ".doc", ".docx", ".xls", ".xlsx", ".ppt", ".pptx", ".pdf", ".txt", ".md", ".xml"
        )
    )

);
