<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/8/31
 * Time: 5:32 PM
 */

namespace Royalcms\Component\Config;


trait CompatibleTrait
{

    /**
     * @since 3.9
     * 兼容3.8老的使用方法
     */
    public function load_config($file, $name = '')
    {
        if ($name) {
            return $this->get($file.'.'.strtolower($name));
        }
        else {
            return $this->get($file);
        }
    }


    public function system($name)
    {
        return $this->get('system.'.strtolower($name));
    }


    public function cache($name)
    {
        return $this->get('cache.'.strtolower($name));
    }


    public function database($name)
    {
        return $this->get('database.'.strtolower($name));
    }


    public function mail($name)
    {
        return $this->get('mail.'.strtolower($name));
    }


    public function route($name)
    {
        return $this->get('route.'.strtolower($name));
    }


    public function session($name)
    {
        return $this->get('session.'.strtolower($name));
    }


    public function cookie($name)
    {
        return $this->get('session.'.strtolower($name));
    }

}