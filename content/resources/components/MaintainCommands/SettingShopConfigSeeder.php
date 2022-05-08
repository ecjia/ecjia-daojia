<?php

namespace Ecjia\Resources\Components\MaintainCommands;

use Ecjia\App\Maintain\EventFactory\EventAbstract;
use Ecjia\Component\Config\Seeder\SettingSeeder;

class SettingShopConfigSeeder extends EventAbstract
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
    protected $icon = null;
    

    public function run()
    {

        (new SettingSeeder())->seeder();
        
        return true;
    }
    
}

// end