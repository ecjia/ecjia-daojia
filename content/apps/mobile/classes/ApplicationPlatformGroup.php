<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-18
 * Time: 10:54
 */

namespace Ecjia\App\Mobile;


class ApplicationPlatformGroup
{


    /**
     * 获取group标签
     */
    public static function getGroupLabel($group)
    {
        $labels = config('app-mobile::platform_group');

        $labels = \RC_Hook::apply_filters('application_platform_group_label_filter', $labels);

        return array_get($labels, $group, $group);
    }

    /**
     * 获取group排序
     * @param $group
     */
    public static function getGroupSort($group)
    {

        $labels = config('app-mobile::platform_group');

        $labels = \RC_Hook::apply_filters('application_platform_group_label_filter', $labels);

        $keys = array_keys($labels);

        $groups = array_flip($keys);

        return array_get($groups, $group);
    }

}