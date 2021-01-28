<?php
defined('IN_ECJIA') or exit('No permission resources.');

return array(
    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'DSCMALL CASHIER'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    'shop_type'                  => 'cashier',
    'shop_name'                  => '大商创收银台管理系统',
    'shop_product'               => 'dscmallx',
    'main_app'                   => 'main',

    /*
    |--------------------------------------------------------------------------
    | Custom Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */
    'custom_original_home_url'   => env('CUSTOM_ORIGINAL_HOME_URL'),
    'custom_original_site_url'   => env('CUSTOM_ORIGINAL_SITE_URL'),
    'custom_original_upload_url' => env('CUSTOM_ORIGINAL_UPLOAD_URL'),
    'custom_home_url'            => env('CUSTOM_HOME_URL'),
    'custom_home_content_url'    => env('CUSTOM_HOME_CONTENT_URL'),
    'custom_content_url'         => env('CUSTOM_CONTENT_URL'),
    'custom_admin_url'           => env('CUSTOM_ADMIN_URL'),
    'custom_asset_url'           => env('CUSTOM_ASSET_URL'),
    'custom_upload_url'          => env('CUSTOM_UPLOAD_URL'),

    
    //国际区号，国际短信使用
    //'international_area_code' => '60',

    //是否启用高级会员卡功能
    'membercard_enabled'         => true,

	//默认货币货币格式，兼容dsc新增功能货币格式切换（app还未同步此功能）
	'currency_format' => '￥%s',

    //是否启用店铺删除
    'store_delete_enabled'      => true,
);

// end
