<?php

// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK OPTIONS
// $options
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
return array(

    // ----------------------------------------
    // a option section for options overview  -
    // ----------------------------------------
    array(
        'name'        => 'overview',
        'title'       => '常规',
        'icon'        => 'fa fa-star',
        'fields'      => array(
            array(
                'type'  => 'notice',
                'class' => 'info',
                'content'   => '头部设置',
            ),
            array(
                'id'      => 'i_logo_url',
                'type'    => 'upload',
                'title'   => '网站标志',
                'default' => RC_Theme::get_template_directory_uri()."/assets/images/logo.png",
                'help'    => '上传网站标志',
                'desc'     => '比例：高度100px，长度354px(高清图片可等比倍数大图皆可)',
            ),
            array(
                'id'      => 'i_mobile_logo_url',
                'type'    => 'upload',
                'title'   => '移动端网站标志',
                'default' => RC_Theme::get_template_directory_uri()."/assets/images/logo_mobile.png",
                'help'    => '上传移动端网站标志',
                'desc'     => '上传移动端网站标志，建议大小为80px * 80px',
            ),
            array(
                'id'      => 'i_favicon_url',
                'type'    => 'upload',
                'title'   => 'Favicon网标',
                'default' => RC_Theme::get_template_directory_uri()."/assets/images/favicon.ico",
                'help'    => '上传Favicon网标',
            ),
            array(
                'id'      => 'i_site_title_switcher',
                'type'    => 'switcher',
                'title'   => '是否显示网站标志处标题',
                'default' => false,
            ),
            array(
                'id'      => 'i_site_language_switcher',
                'type'    => 'switcher',
                'title'   => '切换为繁体',
                'default' => false,
            ),
            array(
                'id'      => 'i_admin_login_switcher',
                'type'    => 'switcher',
                'title'   => '显示后台登录按钮',
                'default' => false,
            ),
            // theme color
            array(
                'id'         => 'i_theme_color',
                'type'       => 'color_picker',
                'title'      => '主题配色',
                'default'    => '#38B7EA',
                'info'       => '选择你喜欢的主题颜色',
            ),
            // post setting
            array(
                'type' => 'notice',
                'class' => 'info',
                'content' => '文章列表设置',
            ),
            array(
                'id'      => 'i_thumbnail_default',
                'type'    => 'upload',
                'title'   => '默认缩略图',
                'default' => RC_Theme::get_template_directory_uri()."/assets/images/thumbnail_default.png",
            ),
            array(
                'id' => 'i_posts_per_page',
                'type' => 'number',
                'title' => '首页每页文章数',
                'default' => 6,
            ),
            array(
                'id' => 'i_posts_excerpt_length',
                'type' => 'number',
                'title' => '摘要数量',
                'default' => 100,
            ),
            array(
                'id'           => 'i_category_not_in',
                'class'        => 'horizontal',
                'type'         => 'checkbox',
                'title'        => '该分类下文章不显示在文章列表中',
                'options'      => '',//getCategoryArray()
            ),
            array(
                'id'           => 'i_posts_meta',
                'class'        => 'horizontal',
                'type'         => 'checkbox',
                'title'        => '文章参数不显示',
                'options'      => array(
                    1   =>  "点赞数",
                    2   =>  "评论数",
                    3   =>  "阅读数",
                )
            ),

        ),
    ),



    /*
    ==================================================
    footer
    ==================================================
    */
    array(
        'name'        => 'footer',
        'title'       => '底部设置',
        'icon'        => 'fa fa-bars',
        'fields'      => array(
            array(
                'type' => 'notice',
                'class' => 'info',
                'content' => 'footer设置',
            ),
            array(
                'id'      => 'i_footer_theme_switcher',
                'type'    => 'switcher',
                'title'   => '底部网站介绍开关',
                'default' => true,
            ),
            array(
                'id'      => 'i_footer_feature_switcher',
                'type'    => 'switcher',
                'title'   => '底部功能开关',
                'default' => true,
            ),
            array(
                'type' => 'notice',
                'class' => 'info',
                'content' => '底部友情链接',
            ),
            array(
                'id'      => 'i_footer_friends_switcher',
                'type'    => 'switcher',
                'title'   => '底部友情链接开关',
                'default' => true,
            ),
            array(
                'id'           => 'i_footer_friends_location',
                'class'        => 'horizontal',
                'type'         => 'checkbox',
                'title'        => '底部友情链接显示位置',
                'options'      => array(
                    'index'     => '首页',
                    'page'      => '独立页面',
                    'article'   => '文章页',
                    'archive'   => '分类、标签、搜索页'
                ),
                'dependency'   => array('i_footer_friends_switcher', '==', 'true'),
            ),
            array(
                'id'        => 'i_friends_nums',
                'type'      => 'number',
                'title'     => '底部友情链接数量',
                'default'   => 3,
                'dependency' => array("i_footer_friends_switcher", "==", "true"),
            ),
            array(
                'type' => 'notice',
                'class' => 'info',
                'content' => '底部网站信息',
            ),
            array(
                'id' => 'i_site_date',
                'type' => 'text',
                'title' => '建站时间',
                'default' => 2018,
            ),
            array(
                'id' => 'i_site_version',
                'type' => 'text',
                'title' => '版本号',
                'default' => '3.0',
            ),
            array(
                'id' => 'i_site_description',
                'type' => 'text',
                'title' => '网站简介',
                'default' => "为极客、创意工作者而设计",
            ),
            array(
                'id'      => 'i_site_record',
                'type'    => 'text',
                'title'   => '网站备案号',
                'default' => "京ICP备1000000号-01",
            ),
            array(
                'id'      => 'i_site_record_href',
                'type'    => 'text',
                'title'   => '网站备案链接',
                'default' => "http://www.miitbeian.gov.cn",
            )
        ),
    ),


    /*
    ==================================================
    图片轮播功能
    ==================================================
    */
    array(
        'name'     => 'carousel',
        'title'    => '轮播设置',
        'icon'     => 'fa fa-picture-o',
        'fields'   => array(
            // 专题轮播
            array(
                'type' => 'notice',
                'class' => 'success',
                'content' => '专题轮播'
            ),
            array(
                'id'        => 'i_category_switcher',
                'type'      => 'switcher',
                'title'     => '专题开关',
                'default'   => false
            ),
            array(
                'id'           => 'i_category_carousel',
                'type'         => 'checkbox',
                'title'        => '专题选择',
                'options'      => '',//getCategoryArray(),
                'dependency' => array("i_category_switcher", "==", "true"),
            ),
            // 主图轮播
            array(
                'type' => 'notice',
                'class' => 'success',
                'content' => '图片轮播'
            ),
            array(
                'id' => 'i_carousel_switcher',
                'type' => 'switcher',
                'title' => '图片轮播功能开关',
                'default' => true,
            ),
            array(
                'id' => 'i_carousel_mousewheel_switcher',
                'type' => 'switcher',
                'title' => '鼠标控制轮播开关',
            ),
            array(
                'id'        => 'i_carousel_opacity',
                'type'      => 'number',
                'title'     => '轮播图遮挡层透明度',
                'default'   => 10,
                'after'     => '<p>轮播图遮挡层透明度，范围是0到100</p>'
            ),
            array(
                'id'        => 'i_carousel_default_speed',
                'type'      => 'number',
                'title'     => '默认轮播图速度',
                'default'   => 3000,
                'after'     => '<p>轮播速度，单位为毫秒</p>'
            ),
            array(
                'id'        => 'i_carousel_default_animate_speed',
                'type'      => 'number',
                'title'     => '默认动画速度',
                'default'   => 600,
                'after'     => '<p>动画速度，单位为毫秒</p>'
            ),
            array(
                'id'           => 'i_carousel_type',
                'type'         => 'radio',
                'title'        => '选择图片轮播样式',
                'options'      => array(
                    'slide'     => '卡片滑动式',
                    'image'     => '大图片式',
                    'one'		=> '单图式'
                ),
                'default'      => 'slide'
            ),
            array(
                'id'            => 'i_carousel_animation',
                'type'          => 'radio',
                'title'         => '选择动画形式（仅限于单图式）',
                'options'       => array(
                    'fade'      => '淡入淡出',
                    'slide'     => '滑动',
                ),
                'default'      => 'slide',
//            'dependency' => array("i_carousel_type", "any", "one, image"),
            ),
            array(
                'id' => 'i_carousel_info_switcher',
                'type' => 'switcher',
                'title' => '关闭轮播图信息',
                'default'   => false,
            ),
            array(
                'id'        => 'i_carousel_default_numbers',
                'type'      => 'number',
                'title'     => '默认轮播图数量',
                'default'   => 3,
                'after'     => '<p>没有置顶文章和自定义轮播内容时默认显示轮播数量（按照时间顺序显示）</p>'
            ),
            array(
                'type' => 'notice',
                'class' => 'warning',
                'content' => '自定义(广告、标签、分类)'
            ),
            // custom carousel
            array(
                'id'              => 'i_carousel_customize',
                'type'            => 'group',
                'title'           => '添加自定义链接',
                'button_title'    => '添加',
                'accordion_title' => '新添加自定义类型',
                'fields'          => array(
                    array(
                        'id'          => 'i_carousel_customize_title',
                        'type'        => 'text',
                        'title'       => '标题',
                    ),
                    array(
                        'id'          => 'i_carousel_customize_switcher',
                        'type'        => 'switcher',
                        'title'       => '显示开关',
                        'default'     => true,
                    ),
                    array(
                        'id'          => 'i_carousel_customize_url',
                        'type'        => 'text',
                        'title'       => '链接地址',
                        'after'     => '<p><b>填写完整的url地址(http://....)</b></p>',
                    ),
                    array(
                        'id'      => 'i_carousel_customize_img',
                        'type'    => 'upload',
                        'title'   => '图片',
                        'default' => RC_Theme::get_template_directory_uri()."/assets/images/carousel_bg.png",
                        'help'    => '上传背景',
                    ),
                )
            ),
        )
    ),


    /*
    ==================================================
    公告栏设置
    ==================================================
    */
    array(
        'name'     => 'notice',
        'title'    => '公告栏设置',
        'icon'     => 'fa fa-bullhorn',
        'fields'   => array(
            array(
                'type' => 'notice',
                'class' => 'info',
                'content' => '公告栏设置',
            ),
            array(
                'id'    => 'i_notice_switcher',
                'type'  => 'switcher',
                'title' => '公告栏开关',
                'default' => true,
            ),
//        array(
//            'id' => 'i_notice_content',
//            'type' => 'text',
//            'title' => '公告栏内容',
//            'default' => '公告栏内容',
//        ),
            // custom carousel
            array(
                'id'              => 'i_notice_groups',
                'type'            => 'group',
                'title'           => '添加自定义公告栏',
                'button_title'    => '添加',
                'accordion_title' => '新添加公告栏',
                'fields'          => array(
                    array(
                        'id'          => 'i_notice_group_switcher',
                        'type'        => 'switcher',
                        'title'       => '公告栏内容',
                        'default'     => true,
                    ),
                    array(
                        'id'          => 'i_notice_group_content',
                        'type'        => 'textarea',
                        'title'       => '公告栏内容',
                    ),
                    array(
                        'id'          => 'i_notice_group_url',
                        'type'        => 'text',
                        'title'       => '链接地址',
                    ),
                )
            ),
        )
    ),


    /*
    ==================================================
    小功能
    ==================================================
    */
    array(
        'name'     => 'function',
        'title'    => '小功能',
        'icon'     => 'fa fa-github',
        'fields'   => array(
            array(
                'type' => 'notice',
                'class' => 'info',
                'content' => '去除head冗余代码',
            ),
            array(
                'id' => 'i_function_version_switcher',
                'type' => 'switcher',
                'title' => '移除wordpress版本号',
                'default' => true,
            ),
            array(
                'id' => 'i_function_emoji_switcher',
                'type' => 'switcher',
                'title' => '移除emoji',
                'default' => true,
            ),
            array(
                'id' => 'i_function_embed_switcher',
                'type' => 'switcher',
                'title' => '移除embed',
                'default' => true,
            ),
            array(
                'id' => 'i_function_element_switcher',
                'type' => 'switcher',
                'title' => '移除head头部多余元素',
                'default' => true,
            ),
            array(
                'type' => 'notice',
                'class' => 'info',
                'content' => 'HTTPS设置',
            ),
            array(
                'id' => 'i_function_https_switcher',
                'type' => 'switcher',
                'title' => '开启https',
                'default' => false,
            ),
            // avatar
            array(
                'type' => 'notice',
                'class' => 'info',
                'content' => '头像设置',
            ),
            array(
                'id' => 'i_function_avatar_ssl_switcher',
                'type' => 'switcher',
                'title' => 'gravater被墙，调用ssl头像链接',
                'default' => true,
            ),
//        array(
//            'id'    =>  'i_function_avatar_location',
//            'type'    => 'upload',
//            'title'   => '上传本地头像',
//            'default' => get_template_directory_uri()."/assets/images/avatar.png",
//            'help'    => '上传本地头像',
//        ),
            array(
                'type' => 'notice',
                'class' => 'info',
                'content' => '分页设置',
            ),
            array(
                'id'            => 'i_pagination_type',
                'class'        => 'horizontal',
                'type'          => 'radio',
                'title'         => '选择分页形式',
                'options'       => array(
                    'next'      => '下一页/上一页',
                    'number'    => '页码',
                    'more'		=> 'ajax加载更多',
                    'infinite'  => 'ajax无限加载'
                ),
                'default'      => 'more'
            ),
            array(
                'type' => 'notice',
                'class' => 'info',
                'content' => '个性功能',
            ),
            array(
                'id'    =>  'i_function_fancybox_switcher',
                'type'  =>  'switcher',
                'title' =>  'fancybox功能开关',
                'default'   =>  false,
            )
        )
    ),



    /*
    ==================================================
    布局
    ==================================================
    */
    array(
        'name'     => 'layout',
        'title'    => '布局',
        'icon'     => 'fa fa-cubes',
        'fields'   => array(
            array(
                'type'  => 'notice',
                'class' => 'info',
                'content'   => '首页、分类和标签布局',
            ),
            array(
                'id'           => 'i_layout_index_type',
                'class'        => 'horizontal',
                'type'         => 'radio',
                'title'        => '选择首页布局',
                'options'      => array(
                    'dcolumn'     => '双栏式',
                    'cascade'     => '瀑布流',
                ),
                'default'      => 'dcolumn'
            ),
            array(
                'id'           => 'i_layout_archive_type',
                'class'        => 'horizontal',
                'type'         => 'radio',
                'title'        => '选择分类、标签和搜索结果布局',
                'options'      => array(
                    'column'     => '竖排列表',
                    'cascade'     => '瀑布流',
                ),
                'default'      => 'cascade'
            ),
        )
    ),


    /*
    ==================================================
    文章页设置
    ==================================================
    */
    array(
        'name'     => 'article',
        'title'    => '文章页',
        'icon'     => 'fa fa-book',
        'fields'   => array(
            array(
                'id'    =>  'i_article_full_switcher',
                'type'  =>  'switcher',
                'title' =>  '文章内容全屏显示(去掉侧边栏)',
                'default'   =>  false,
            ),
            array(
                'id'    =>  'i_article_thumbnail_switcher',
                'type'  =>  'switcher',
                'title' =>  '文章是否显示特色图',
                'default'   =>  false,
            ),
            array(
                'type'  => 'notice',
                'class' => 'info',
                'content'   => '文章页样式设置',
            ),
            array(
                'id'    =>  'i_article_indent_switcher',
                'type'  =>  'switcher',
                'title' =>  '段落首行缩进',
                'default'   =>  false,
            ),
            array(
                'id'    =>  'i_article_support_switcher',
                'type'  =>  'switcher',
                'title' =>  '显示打赏功能',
                'default'   =>  true,
            ),
            array(
                'id'    =>  'i_article_support_description',
                'type'  =>  'text',
                'title' =>  '打赏说明',
                'default'   => '「如果你觉得对你有用，欢迎点击下方按钮对我打赏」',
                'dependency' => array("i_article_support_switcher", "==", "true"),
            ),
            array(
                'id'      => 'i_article_support_zhifubao',
                'type'    => 'upload',
                'title'   => '支付宝收款二维码',
                'default' => RC_Theme::get_template_directory_uri()."/assets/images/zhifubao_qrcode.png",
                'desc'     => '上传支付宝收款二维码图片',
                'dependency' => array("i_article_support_switcher", "==", "true"),
            ),
            array(
                'id'      => 'i_article_support_wechat',
                'type'    => 'upload',
                'title'   => '微信收款二维码',
                'default' => RC_Theme::get_template_directory_uri()."/assets/images/wechat_qrcode.png",
                'desc'     => '上传微信收款二维码图片',
                'dependency' => array("i_article_support_switcher", "==", "true"),
            ),
            array(
                'id'    =>  'i_article_share_switcher',
                'type'  =>  'switcher',
                'title' =>  '显示分享功能',
                'default'   => true,
            ),
            array(
                'id'    =>  'i_article_copyright_switcher',
                'type'  =>  'switcher',
                'title' =>  '显示版权信息',
                'default'   => true,
            ),
            array(
                'id'    =>  'i_article_like_switcher',
                'type'  =>  'switcher',
                'title' =>  '显示点赞信息',
                'default'   => true,
            ),
        )
    ),


    /*
    ==================================================
    关注我们
    ==================================================
    */
    array(
        'name'     => 'follow',
        'title'    => '关注我们',
        'icon'     => 'fa fa-wechat',
        'fields'   => array(
            // follow us
            array(
                'type' => 'notice',
                'class' => 'warning',
                'content' => '关注我们'
            ),
            array(
                'id' => 'i_follow_switcher',
                'type' => 'switcher',
                'title' => '开启底部关注我们功能',
                'default' => true,
            ),
            array(
                'id'    => 'i_follow_weibo',
                'type'  => 'text',
                'title' => '微博地址',
                'dependency' => array('i_follow_switcher', '==', 'true'),
            ),
            array(
                'id'    => 'i_follow_qq',
                'type'  => 'text',
                'default' => '164903112',
                'title' => 'qq号',
                'dependency' => array('i_follow_switcher', '==', 'true'),
            ),
            array(
                'id'      => 'i_follow_rss',
                'type'    => 'switcher',
                'default' => true,
                'title'   => 'RSS订阅',
                'dependency' => array('i_follow_switcher', '==', 'true'),
            ),
            array(
                'type' => 'notice',
                'class' => 'success',
                'content' => '微信公众号设置',
            ),
            array(
                'id'      => 'i_follow_wechat',
                'type'    => 'upload',
                'title'   => '微信公众号二维码',
                'default' => RC_Theme::get_template_directory_uri()."/assets/images/wechat_official_account.png",
                'help'    => '上传微信公众号二维码',
            ),
            array(
                'id' => 'i_follow_wechat_name',
                'type' => 'text',
                'title' => '微信公众号名',
                'default' => '创造狮',
            ),
            array(
                'id' => 'i_follow_wechat_id',
                'type' => 'text',
                'title' => '微信公众号ID',
                'default' => 'chuangzaoshi',
            ),
            array(
                'id' => 'i_follow_wechat_description',
                'type' => 'text',
                'title' => '微信公众号说明',
                'default' => '扫描关注我们',
            ),
        )
    ),



    /*
    ==================================================
    广告设置
    ==================================================
    */
    array(
        'name'     => 'advertisement',
        'title'    => '广告设置',
        'icon'     => 'fa fa-money',
        'fields'   => array(
            // advertisement
            array(
                'id' => 'i_advertisement_switcher',
                'type' => 'switcher',
                'title' => '一键开关闭广告功能',
                'default' => true,
            ),
            array(
                'type' => 'notice',
                'class' => 'warning',
                'content' => '文章列表广告设置'
            ),
            array(
                'id'   => 'i_advertisement_article_list',
                'type' => 'textarea',
                'title' => '文章列表广告代码'
            ),
            array(
                'id'    => 'i_advertisement_article_list_script',
                'type'  => 'switcher',
                'title' => '是否为script代码',
            ),
            array(
                'id'   => 'i_advertisement_article_list_after',
                'type' => 'number',
                'default' => 3,
                'title' => '广告位于文章列表第几篇之后（最新的文章算第一篇）'
            ),
            array(
                'type' => 'notice',
                'class' => 'success',
                'content' => '文章底部广告设置'
            ),
            array(
                'id'   => 'i_advertisement_article_tail',
                'type' => 'textarea',
                'title' => '文章尾部广告代码'
            ),
            array(
                'id'    => 'i_advertisement_article_tail_script',
                'type'  => 'switcher',
                'title' => '是否为script代码',
            ),
            array(
                'type' => 'notice',
                'class' => 'success',
                'content' => '文章侧边栏广告设置'
            ),
            array(
                'id'   => 'i_advertisement_sidebar',
                'type' => 'textarea',
                'title' => '侧边栏广告代码'
            ),
            array(
                'id'    => 'i_advertisement_sidebar_script',
                'type'  => 'switcher',
                'title' => '是否为script代码',
            ),
        )
    ),


    /*
    ==================================================
    SEO设置
    ==================================================
    */
    array(
        'name'     => 'seo',
        'title'    => 'SEO设置',
        'icon'     => 'fa fa-bug',
        'fields'   => array(
            array(
                'type'    => 'notice',
                'class'   => 'info',
                'content' => '百度主动推送',
            ),
            array(
                'id'    	  => 'i_push_baidu_switcher',
                'type'      => 'switcher',
                'title'     => '百度主动推送',
            ),
            // 接口调用地址
            array(
                'id'            => 'i_push_baidu_api',
                'type'          => 'text',
                'title'         => '接口调用地址',
                'after'  		  => '<p class="cs-text-muted">在站长平台申请的接口调用地址,点击<a href="http://zhanzhang.baidu.com/linksubmit/" target="_blank">这里</a>获取</p>',
                'dependency' => array( 'i_push_baidu_switcher', '==', 'true' ),
            ),
            array(
                'id' => 'i_seo_category_switcher',
                'type' => 'switcher',
                'title' => '去除url中的category',
            ),
            array(
                'id' => 'i_seo_link_rule',
                'type' => 'switcher',
                'title' => '外链跳转',
                'after'  => '需要创建一个go新页面，链接形式是"/go"',
            ),
            array(
                'id'   => 'i_seo_keywords',
                'type' => 'text',
                'title' => '网站关键字keywords',
                'default' => '黑糖主题',
            ),
            array(
                'id'   => 'i_seo_description',
                'type' => 'textarea',
                'title' => '网站描述description',
                'default' => '黑糖主题BlackCandy，漂亮的产品自媒体网站，为极客、创意工作者而设计！',
            ),
            array(
                'id'   => 'i_seo_statistics',
                'type' => 'textarea',
                'title' => '统计代码',
                'desc' => '支持百度统计',
            ),

        )
    ),


    /*
    ==================================================
    自定义代码
    ==================================================
    */
    array(
        'name'     => 'code',
        'title'    => '自定义',
        'icon'     => 'fa fa-code',
        'fields'   => array(

            array(
                'class' => 'info',
                'type'  => 'notice',
                'content' => '自定义样式',
            ),
            array(
                'id'            => 'i_category_color_switcher',
                'type'          => 'switcher',
                'title'         => '显示分类信息',
                'default'       => true
            ),
            array(
                'id'         => 'i_category_color',
                'type'       => 'color_picker',
                'title'      => '分类配色',
                'default'    => '#666',
                'info'       => '选择你喜欢的分类颜色',
                'dependency' => array( 'i_category_color_switcher', '==', 'true' ),
            ),
            array(
                'id'         => 'i_category_opacity',
                'type'       => 'number',
                'title'      => '分类配色透明度',
                'default'    => '1',
                'info'       => '选择你喜欢的分类颜色透明度',
                'dependency' => array( 'i_category_color_switcher', '==', 'true' ),
            ),
            array(
                'class' => 'info',
                'type'  => 'notice',
                'content' => '自定义代码',
            ),
            array(
                'id'   => 'i_code_footer',
                'type' => 'textarea',
                'title' => 'footer自定义代码',
                'desc'  => '显示在网站版权之前'
            ),
            array(
                'id'   => 'i_code_css',
                'type' => 'textarea',
                'title' => '自定义样式css代码',
                'desc' => '不要添加style标签',
            ),
        )
    ),



    /*
    ==================================================
    Backup
    ==================================================
    */
    array(
        'name'     => 'backup_section',
        'title'    => '配置备份',
        'icon'     => 'fa fa-shield',
        'fields'   => array(

            array(
                'type'    => 'notice',
                'class'   => 'warning',
                'content' => 'You can save your current options. Download a Backup and Import.',
            ),
            array(
                'type'    => 'backup',
            ),

        )
    ),


    // ------------------------------
    // license                      -
    // ------------------------------
    array(
        'name'     => 'license_section',
        'title'    => '关于',
        'icon'     => 'fa fa-info-circle',
        'fields'   => array(

            array(
                'type'    => 'heading',
                'content' => 'ECJIA TEAM'
            ),
            array(
                'type'    => 'content',
                'content' => 'ECJia到家官网，详情请访问： <a href="https://daojia.ecjia.com/" target="_blank">ECJia到家</a>',
            ),

        )
    ),

);
