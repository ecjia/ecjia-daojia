<?php


namespace Ecjia\System\Hookers;


use ecjia;
use ecjia_front;
use RC_Hook;
use RC_Theme;

class EcjiaFrontCompatibleProcessAction
{

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        ecjia_front::$view_object->assign('ecs_charset', RC_CHARSET);

        if (ecjia::config(RC_Hook::apply_filters('ecjia_theme_stylename_code', 'stylename'), ecjia::CONFIG_EXISTS))
        {
            ecjia_front::$view_object->assign('ecs_css_path', RC_Theme::get_template_directory_uri() . '/style_' . ecjia::config(RC_Hook::apply_filters('ecjia_theme_stylename_code', 'stylename')) . '.css');
        }
        else
        {
            ecjia_front::$view_object->assign('ecs_css_path', RC_Theme::get_template_directory_uri() . '/style.css');
        }

    }
}