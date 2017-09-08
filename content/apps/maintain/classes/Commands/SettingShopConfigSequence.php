<?php

namespace Ecjia\App\Maintain\Commands;

use Ecjia\App\Maintain\AbstractCommand;
use Ecjia\System\Config\ConfigModel;

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
    protected $description = '自动更新商店配置表的主键ID';
    
    /**
     * 图标
     * @var string
     */
    protected $icon = '/statics/images/setting_shop.png';
    
    // 更新shop_config数据表主键ID顺序
    public function run() {
        
        $model = new ConfigModel();
        
        $data = $model->where('id', '>', 100)->get();
        
        $data->map(function ($item) use ($model) {
        
            $id = $item['id'] + 30000;
            $model->where('code', $item['code'])->update(['id' => $id]);
        });
        
        $data = $model->where('parent_id', 0)->get();
    
        $data->map(function ($item) {
            $this->update_group_id($item['id']);
        });
        
        return true;
    }
    
    protected function update_group_id($group_id)
    {
        $model = new ConfigModel();
        $data = $model->where('id', '>', 100)->where('parent_id', $group_id)->get();
        $data->map(function ($item, $key) use ($model) {
    
            $id = $key + 1;
    
            $id = $item['parent_id'] * 100 + $id;
    
            $model->where('code', $item['code'])->update(['id' => $id]);
        });
    }
    
}

// end