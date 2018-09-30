<?php

namespace Ecjia\App\Setting\Maintains;

use Ecjia\App\Maintain\AbstractCommand;
use Ecjia\System\Config\ConfigModel;

class SettingShopConfigSeeder extends AbstractCommand
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'setting_shop_config_seeder';
    
    /**
     * 名称
     * @var string
     */
    protected $name = '商店配置字段填充';
    
    /**
     * 描述
     * @var string
     */
    protected $description = '自动添加商店配置项的未有的配置项';
    
    /**
     * 图标
     * @var string
     */
    protected $icon = '/statics/images/setting_shop.png';
    

    public function run() {

        \Ecjia\App\Setting\SettingSeeder::seeder();
        
        return true;
    }
    
}

// end