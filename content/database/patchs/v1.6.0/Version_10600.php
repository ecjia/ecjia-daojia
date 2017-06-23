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
use Ecjia\App\Adsense\Repositories\AdRepository;

class Version_10600 extends Version
{


    /**
     * 升级触发
     */
    public function fire()
    {
        $migrate = new Migrate();
        
        // 更新1.6中新增的迁移项
        $migrate->fire();
        
        // 修复原来的短信记录为互亿无线
        $this->fixSmsSendListChannelType();
        
        // 填充新的文章表数据
        $seeder = new Seeder('DemoArticleCatTableSeeder');
        $seeder->fire();
        $seeder = new Seeder('DemoArticleTableSeeder');
        $seeder->fire();
        $seeder = new Seeder('DemoGoodsArticleTableSeeder');
        $seeder->fire();
        
        // 导入发现轮播图数据
        $this->migrateDiscoverCycleimageData();
        
        // 清除缓存
        ecjia_update_cache::make()->clean('system_userdata_cache');
        ecjia_update_cache::make()->clean('system_app_cache');
        ecjia_update_cache::make()->clean('front_template_cache');
        
        // 移除废弃的短信模板配置
        $this->removeDiscardSmsTemplate();
        
        // 移除废弃的短信发送时机开关
        $this->removeDiscardSmsConfigCode();
        
        // 更新shop_config数据表主键ID顺序
        $seeder = new Seeder('FixShopConfigTableSeeder');
        $seeder->fire();
        
        return true;
    }
    
    /**
     * 修复原来的短信记录为互亿无线
     */
    public function fixSmsSendListChannelType()
    {
        RC_DB::table('sms_sendlist')->where('channel_code', '')->update(['channel_code' => 'sms_ihuyi']);
    }
    
    /**
     * 导入发现轮播图数据
     */
    public function migrateDiscoverCycleimageData()
    {
        $cycleImageRepository = new CycleImageRepository();
        $attributes = [
            'position_name' => '发现轮播图',
            'position_code' => 'article_cycleimage',
            'position_desc' => '发现页面的轮播图',
            'ad_width'      => '1000',
            'ad_height'     => '200',
            'max_number'    => '5',
            'city_id'       => '0',
            'city_name'     => '默认',
            'type'          => 'cycleimage',
            ];
        $model = $cycleImageRepository->create($attributes);
    
        $position_id = $model->position_id;
    
        $adRepository = new AdRepository('cycleimage');

        $attributes = [
            [
                'position_id'  => $position_id,
                'media_type'   => '0',
                'ad_link'      => 'https://ecjia.com/download.html',
                'ad_name'      => '',
                'ad_code'      => 'data/cycleimage/1496342092378279633.png',
                'sort_order'   => '50',
                'show_client'  => '273',
            ],
            [
                'position_id'  => $position_id,
                'media_type'   => '0',
                'ad_link'      => 'https://mp.weixin.qq.com/s?__biz=MzA5MjcwMzU0MQ==&idx=2&mid=2247483774&sn=6a467a8912156ec70b648f4bd167b44d',
                'ad_name'      => '',
                'ad_code'      => 'data/cycleimage/1496342134992478693.png',
                'sort_order'   => '50',
                'show_client'  => '273',
            ],
            [
                'position_id'  => $position_id,
                'media_type'   => '0',
                'ad_link'      => 'https://mp.weixin.qq.com/s?__biz=MzA5MjcwMzU0MQ==&mid=2247483769&idx=2&sn=115250bee8f874e095dcea7f71a50889',
                'ad_name'      => '',
                'ad_code'      => 'data/cycleimage/1496342191006151668.png',
                'sort_order'   => '50',
                'show_client'  => '273',
            ],
            [
                'position_id'  => $position_id,
                'media_type'   => '0',
                'ad_link'      => 'https://mp.weixin.qq.com/s?__biz=MzA5MjcwMzU0MQ==&mid=2247483769&idx=3&sn=9bbf280fcdad31eff45fb7bf6b05f37a',
                'ad_name'      => '',
                'ad_code'      => 'data/cycleimage/1496342278158792453.png',
                'sort_order'   => '50',
                'show_client'  => '273',
            ],
            [
                'position_id'  => $position_id,
                'media_type'   => '0',
                'ad_link'      => 'http://www.ecmoban.com/goods-795.html',
                'ad_name'      => '',
                'ad_code'      => 'data/cycleimage/1496342328783842332.png',
                'sort_order'   => '50',
                'show_client'  => '273',
            ],
        ];
        collect($attributes)->map(function ($attribute) use ($adRepository) {
            $adRepository->create($attribute);
        }); 
    }
    
    /**
     * 移除废弃的短信模板配置
     */
    public function removeDiscardSmsTemplate()
    {
        RC_DB::table('mail_templates')->where('type', 'sms')->delete();
    }
    
    /**
     * 移除废弃的短信发送时机开关
     */
    public function removeDiscardSmsConfigCode()
    {
        ecjia_config::delete('sms_order_placed'); //客户下单
        ecjia_config::delete('sms_order_payed'); //客户付款
        ecjia_config::delete('sms_order_shipped'); //商家发货
        ecjia_config::delete('sms_user_signin'); //用户注册
        ecjia_config::delete('sms_receipt_verification'); //收货验证码
        ecjia_config::delete('sms_user_name'); //短信平台帐号
        ecjia_config::delete('sms_password'); //短信平台密码
        
        // 前1.5.0升级时废弃的配置项
        ecjia_config::delete('cycleimage_data');
        ecjia_config::delete('cycleimage_style');
        ecjia_config::delete('mobile_discover_data');
        ecjia_config::delete('mobile_shortcut_data');
        ecjia_config::delete('mobile_launch_adsense');
        ecjia_config::delete('mobile_home_adsense1');
        ecjia_config::delete('mobile_home_adsense2');
        ecjia_config::delete('mobile_cycleimage_data');
        ecjia_config::delete('mobile_topic_adsense');
        ecjia_config::delete('mobile_cycleimage_phone_data');
        ecjia_config::delete('mobile_home_adsense_group');
        ecjia_config::delete('addon_cycleimage_plugins');
        
    }


    /**
     * 获取更新日志文件路径
     */
    public function upgradeLogPath()
    {
        return __DIR__ . '/ecjia-daojia-patch-v1.6.0.log';
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
