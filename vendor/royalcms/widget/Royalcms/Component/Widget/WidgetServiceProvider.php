<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/9/6
 * Time: 2:05 PM
 */

namespace Royalcms\Component\Widget;

use Royalcms\Component\Support\ServiceProvider;
use RC_Hook;

class WidgetServiceProvider extends ServiceProvider
{

    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->royalcms['widget'] = $this->royalcms->share(function($royalcms)
        {
            return new WidgetManager($royalcms);
        });

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['widget'];
    }

}