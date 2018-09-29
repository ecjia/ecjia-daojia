<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/9/6
 * Time: 3:03 PM
 */

namespace Ecjia\System\Frameworks\Widget;

use Royalcms\Component\Widget\Widget as RoyalcmsWidget;

abstract class Widget extends RoyalcmsWidget
{

    public function save_settings($settings)
    {
        ecjia_config::instance()->get_addon_config( $this->option_name, $settings, true );
    }


    public function get_settings()
    {
        $settings = ecjia_config::instance()->get_addon_config($this->option_name, true);

        if ( false === $settings && isset($this->alt_option_name) )
            $settings = ecjia_config::instance()->get_addon_config($this->alt_option_name, true);

        if ( !is_array($settings) )
            $settings = array();

        return $settings;
    }




}