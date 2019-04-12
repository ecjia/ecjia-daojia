<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/9/30
 * Time: 9:50 AM
 */

namespace Ecjia\App\Setting;

use ecjia_config;

class SettingSeeder
{

    /**
     * shop_config字段填充
     */
    public static function seeder()
    {

        $components = with(new Factory())->getComponents();

        collect($components)->each(function($item) {
            $group = $item->getCode();
            $data = $item->handle();
            collect($data)->each(function($item) use ($group) {
                if (ecjia_config::has($item['code'])) {
                    ecjia_config::change($group, $item['code'], null, $item['options']);
                } else {
                    ecjia_config::add($group, $item['code'], $item['value'], $item['options']);
                }
            });

        });

        ecjia_config::clearCache();
    }

}