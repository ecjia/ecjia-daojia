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
use Ecjia\System\Version\Version;
use Ecjia\System\Database\Migrate;
use Ecjia\System\Database\Seeder;
use Ecjia\App\Adsense\Repositories\CycleImageRepository;
use Ecjia\App\Adsense\Repositories\ShortcutMenuRepository;
use Ecjia\App\Adsense\Repositories\AdGroupRepository;
use Ecjia\App\Adsense\Repositories\AdPositionRepository;
use Ecjia\App\Adsense\Repositories\AdRepository;

class Version_10500 extends Version
{


    /**
     * 升级触发
     */
    public function fire()
    {
        $migrate = new Migrate();
            
        // 更新1.5中新增的迁移项
        $migrate->fire();
        
        //修复hidden小组的type类型为group
        $this->fixHiddenGroupType();
        
        // 更新shop_config数据表主键ID顺序
        $seeder = new Seeder('FixShopConfigTableSeeder');
        $seeder->fire();
        
        // 更新shop_config数据填充
        $seeder = new Seeder('InitShopConfigTableSeeder');
        $seeder->fire();
        
        // 迁移旧数据到新表中
        $this->migrateCycleimageData();
        $this->migratePCMerchantCycleimageData();
        $this->migrateDiscoverData();
        $this->migrateHomeAdsenseGroupData();
        $this->migrateShortcutMenuData();
        $this->migrateStartAdsenseData();
        
        // 清除缓存
        ecjia_update_cache::make()->clean('system_userdata_cache');
        ecjia_update_cache::make()->clean('system_app_cache');
        ecjia_update_cache::make()->clean('front_template_cache');
        
        return true;
    }
    
    /**
     * 修复hidden小组的type类型为group
     */
    public function fixHiddenGroupType()
    {
        RC_DB::table('shop_config')->where('code', 'hidden')->update(['type' => 'group']);
    }
    
    /**
     * 迁移原轮播图数据
     */
    public function migrateCycleimageData()
    {
        
        $cycleimageData = ecjia_config::get('cycleimage_data');
        $cycleimageData and $cycleimageData = unserialize($cycleimageData);
        
        if (! $cycleimageData) {
            return false;
        }
        
        $cycleImageRepository = new CycleImageRepository();
        $attributes = [
        	'position_name' => '首页轮播图',
            'position_code' => 'home_cycleimage',
            'ad_width'      => '1000',
            'ad_height'     => '400',
            'max_number'    => '5',
            'city_id'       => '0',
            'city_name'     => '默认',
            'type'          => 'cycleimage',
        ];
        $model = $cycleImageRepository->create($attributes);
        
        $position_id = $model->position_id;
        
        $adRepository = new AdRepository('cycleimage');
        
        collect($cycleimageData)->each(function($item) use ($position_id, $adRepository) {
            $attributes = [
            	'position_id'  => $position_id,
            	'media_type'   => '0',
            	'ad_link'      => $item['url'],
            	'ad_name'      => $item['text'],
            	'ad_code'      => $item['src'],
            	'sort_order'   => $item['sort'],
            	'show_client'  => '273',
            ];
            $adRepository->create($attributes);   
        });
        
        $home_url = RC_Uri::home_url();
            
        $pcCycleimageData = [
        	[
        	    'url'  => $home_url . '/index.php?m=merchant&c=store&a=category&cat_id=4',
        	    'text' => '',
        	    'src'  => 'data/cycleimage/1492650806593974463.png',
        	    'sort' => '1'
    	    ],
            [
                'url'  => $home_url . '/index.php?m=merchant&c=goods&a=init&store_id=111',
                'text' => '',
                'src'  => 'data/cycleimage/1492651290525993731.png',
                'sort' => '2'
            ],
            [
                'url'  => $home_url . '/index.php?m=merchant&c=goods&a=init&store_id=60',
                'text' => '',
                'src'  => 'data/cycleimage/1492651307128656813.png',
                'sort' => '3'
            ],
            [
                'url'  => $home_url . '/index.php?m=merchant&c=goods&a=init&store_id=109',
                'text' => '',
                'src'  => 'data/cycleimage/1492651334051472978.png',
                'sort' => '4'
            ],
            [
                'url'  => $home_url . '/index.php?m=goods&c=index&a=init&cat_id=1033',
                'text' => '',
                'src'  => 'data/cycleimage/1492651353919196607.png',
                'sort' => '5'
            ],
        ];
        
        collect($pcCycleimageData)->each(function($item) use ($position_id, $adRepository) {
            $attributes = [
                'position_id'  => $position_id,
                'media_type'   => '0',
                'ad_link'      => $item['url'],
                'ad_name'      => $item['text'],
                'ad_code'      => $item['src'],
                'sort_order'   => $item['sort'],
                'show_client'  => '4096',
                ];
            $adRepository->create($attributes);
        });
        
        
    }
    
    /**
     * 迁移PC商家列表下的轮播图
     */
    public function migratePCMerchantCycleimageData()
    {
        $cycleImageRepository = new CycleImageRepository();
        $attributes = [
            'position_name' => '商家轮播图',
            'position_code' => 'merchant_cycleimage',
            'ad_width'      => '1920',
            'ad_height'     => '420',
            'max_number'    => '1',
            'city_id'       => '0',
            'city_name'     => '默认',
            'type'          => 'cycleimage',
            ];
        $model = $cycleImageRepository->create($attributes);
        
        $position_id = $model->position_id;
        
        $adRepository = new AdRepository('cycleimage');
        
        $home_url = RC_Uri::home_url();
        
        $attributes = [
            'position_id'  => $position_id,
            'media_type'   => '0',
            'ad_link'      => $home_url . '/index.php?m=merchant&c=store&a=category&cat_id=9',
            'ad_name'      => '',
            'ad_code'      => 'data/cycleimage/1492650692097234468.png',
            'sort_order'   => '50',
            'show_client'  => '4096',
            ];
        $adRepository->create($attributes);
    }
    
    /**
     * 迁移原快捷菜单数据
     */
    public function migrateShortcutMenuData()
    {
        
        $shortcutData = ecjia_config::get('mobile_shortcut_data');
        $shortcutData and $shortcutData = unserialize($shortcutData);
        
        if (! $shortcutData) {
            return false;
        }
        
        $shortcutMenuRepository = new ShortcutMenuRepository();
        $attributes = [
            'position_name' => '首页快捷菜单',
            'position_code' => 'home_shortcut',
            'ad_width'      => '200',
            'ad_height'     => '200',
            'max_number'    => '10',
            'city_id'       => '0',
            'city_name'     => '默认',
            'type'          => 'shortcut',
            ];
        $model = $shortcutMenuRepository->create($attributes);
        
        $position_id = $model->position_id;
        
        $adRepository = new AdRepository('shortcut');
        
        collect($shortcutData)->each(function($item) use ($position_id, $adRepository) {
            $attributes = [
                'position_id'  => $position_id,
                'media_type'   => '0',
                'ad_link'      => $item['url'],
                'ad_name'      => $item['text'],
                'ad_code'      => $item['src'],
                'sort_order'   => $item['sort'],
                'show_client'  => '273',
                ];
            $adRepository->create($attributes);
        });
        
    }
    
    /**
     * 迁移原快捷菜单数据
     */
    public function migrateDiscoverData()
    {
        $shortcutData = ecjia_config::get('mobile_discover_data');
        $shortcutData and $shortcutData = unserialize($shortcutData);
        
        if (! $shortcutData) {
            return false;
        }
        
        $shortcutMenuRepository = new ShortcutMenuRepository();
        $attributes = [
            'position_name' => '百宝箱',
            'position_code' => 'discover',
            'ad_width'      => '200',
            'ad_height'     => '200',
            'max_number'    => '10',
            'city_id'       => '0',
            'city_name'     => '默认',
            'type'          => 'shortcut',
            ];
        $model = $shortcutMenuRepository->create($attributes);
        
        $position_id = $model->position_id;
        
        $adRepository = new AdRepository('shortcut');
        
        collect($shortcutData)->each(function($item) use ($position_id, $adRepository) {
            $attributes = [
                'position_id'  => $position_id,
                'media_type'   => '0',
                'ad_link'      => $item['url'],
                'ad_name'      => $item['text'],
                'ad_code'      => $item['src'],
                'sort_order'   => $item['sort'],
                'show_client'  => '273',
                ];
            $adRepository->create($attributes);
        });
    }
    
    
    /**
     * 迁移原首页广告组数据
     */
    public function migrateHomeAdsenseGroupData()
    {
        $adsenseGroupData = ecjia_config::get('mobile_home_adsense_group');
        $adsenseGroupData and $adsenseGroupData = explode(',', $adsenseGroupData);
        
        if (! $adsenseGroupData) {
            return false;
        }
        
        $adGroupRepository = new AdGroupRepository();
        $attributes = [
            'position_name' => '首页多组广告位',
            'position_code' => 'home_complex_adsense',
            'position_desc' => 'App、H5首页上使用的多广告位合成效果。',
            'city_id'       => '0',
            'city_name'     => '默认',
            'type'          => 'group',
            ];
        $model = $adGroupRepository->create($attributes);
        
        $position_id = $model->position_id;
        
        $adPositionRepository = new AdPositionRepository();
        
        collect($adsenseGroupData)->each(function($item, $key) use ($position_id, $adPositionRepository) {
            $model = $adPositionRepository->find($item);
            
            if ($model) {
                $attributes = [
                    'position_code' => 'position_'.$item,
                    'group_id'      => $position_id,
                    'sort_order'    => $key,
                    'city_id'       => '0',
                    'city_name'     => '默认',
                    ];
                $adPositionRepository->update($model, $attributes);
                
                $adsModel = $model->ads();
                $adsModel->get()->each(function($item) {
                    $item->update(['show_client' => '273']);
                });
            }
        });
    }
    
    /**
     * 迁移启动广告数组
     */
    public function migrateStartAdsenseData()
    {
        $startAdsenseData = ecjia_config::get('mobile_launch_adsense');
        if (! $startAdsenseData) {
            return false;
        }
        
        $adPositionRepository = new AdPositionRepository();
        $model = $adPositionRepository->find($startAdsenseData);
        
        if ($model) {
            $attributes = [
                'position_name' => '应用启动广告位',
                'position_code' => 'app_start_adsense',
                'ad_width'      => '750',
                'ad_height'     => '1334',
                'max_number'    => '1',
                'city_id'       => '0',
                'city_name'     => '默认',
                'type'          => 'adsense',
                ];
            $adPositionRepository->update($model, $attributes);
        }

    }
    
    
    /**
     * shop_config 表中废弃的code值记录
     * 
     * mobile_topic_adsense         主题街广告数据
     * mobile_cycleimage_phone_data 手机轮播图数据
     * mobile_home_adsense_group    首页广告组数据
     * mobile_cycleimage_data       手机轮播图数据
     * mobile_home_adsense1         首页广告一数据
     * mobile_home_adsense2         首页广告二数据
     * mobile_launch_adsense        启动广告数据
     * mobile_shortcut_data         快捷菜单数据
     * mobile_discover_data         百宝箱数据
     * cycleimage_data              轮播图数据
     * cycleimage_style             轮播图风格样式
     */
    public function shop_config_remarks() {}


    /**
     * 获取更新日志文件路径
     */
    public function upgradeLogPath()
    {
        return __DIR__ . '/ecjia-daojia-patch-v1.5.0.log';
    }

    /**
     * 获取更新说明文件路径
     */
    public function upgradeReadmePath()
    {
        return __DIR__ . '/readme.txt';
    }
}

// end
