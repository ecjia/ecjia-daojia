<?php


namespace Ecjia\Component\ScriptLoader;


use ecjia;
use RC_Uri;
use Royalcms\Component\Script\HandleScripts;
use Royalcms\Component\Script\HandleStyles;

abstract class AbstractLoader
{

    /**
     * @var HandleStyles|HandleScripts
     */
    protected $handler;

    protected $suffix;

    protected $version;

    public function __construct($handler)
    {
        $this->handler = $handler;
        $this->version = ecjia::VERSION;

        $this->setHandlerParams();

        $this->suffix = self::developMode();
    }

    protected function setHandlerParams()
    {
        $this->handler->base_url = RC_Uri::system_static_url();
        $this->handler->content_url = RC_Uri::system_static_url();
        $this->handler->default_version = $this->version;
        $this->handler->text_direction = function_exists( 'is_rtl' ) && is_rtl() ? 'rtl' : 'ltr';
        $this->handler->default_dirs = array('/');
    }

    public static function developMode()
    {
        if ( ! config('system.script_debug') ) {
            $suffix = '.min';
        } else {
            $suffix = '';
        }

        return $suffix;
    }

    /**
     * @return string
     */
    public function getSuffix(): string
    {
        return $this->suffix;
    }



}