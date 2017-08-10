<?php

namespace Ecjia\App\Maintain\Commands;

use Ecjia\App\Maintain\AbstractCommand;
use Ecjia\System\Database\Seeder;

class SettingShopConfigSequence extends AbstractCommand
{
    
    
    /**
     * 代号标识
     * @var string
     */
    protected $code = 'setting_shop_config_sequence';
    
    /**
     * 名称
     * @var string
     */
    protected $name = '商店配置主键排序';
    
    /**
     * 描述
     * @var string
     */
    protected $description = '自动更新商品配置表的主键ID';
    
    /**
     * 图标
     * @var string
     */
    protected $icon = '/statics/images/setting_shop.png';
    
    
    public function run() {
        // 更新shop_config数据表主键ID顺序
        $seeder = new Seeder('FixShopConfigTableSeeder');
        $seeder->fire();
        
        return true;
    }
    
}

// end