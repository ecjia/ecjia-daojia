<?php

/**
 * WeApp.php.
 *
 */
namespace Royalcms\Component\WeApp;

use Royalcms\Component\Support\Str;
use Royalcms\Component\WeChat\Foundation\WeChat;
use Royalcms\Component\WeApp\QRCode\QRCode;
use Royalcms\Component\WeApp\Core\AccessToken;

/**
 * Class WeApp.
 *
 * @property \Royalcms\Component\WeApp\Server\Guard $server
 * @property \Royalcms\Component\WeApp\Sns\Sns $sns
 * @property \Royalcms\Component\WeApp\Notice\Notice $notice
 * @property \Royalcms\Component\WeApp\Staff\Staff $staff
 * @property \Royalcms\Component\WeApp\QRCode\QRCode $qrcode
 * @property \Royalcms\Component\WeApp\Material\Temporary $material_temporary
 * @property \Royalcms\Component\WeApp\Stats\Stats $stats
 */
class WeApp
{
    /**
     * Wechat Container.
     *
     * @var \Royalcms\Component\WeChat\Foundation\WeChat
     */
    protected $wechat;
    
    /**
     * ContainerAccess constructor.
     *
     * @param \Royalcms\Component\WeChat\Foundation\WeChat $wechat
     */
    public function __construct(WeChat $wechat)
    {
        $this->wechat = $wechat;
        
        $wechat->bindShared('weapp.access_token', function($wechat)
        {
            $app_id = $wechat->config['app_id'];
            $app_secret = $wechat->config['app_secret'];
            return new AccessToken($app_id, $app_secret);
        });
        
        $wechat->bindShared('weapp.qrcode', function($wechat)
        {
            return new QRCode($wechat['weapp.access_token'], []);
        });
    }
    
    /**
     * Fetches from pimple container.
     *
     * @param string        $key
     * @param callable|null $callable
     *
     * @return mixed
     */
    public function fetch($key, callable $callable = null)
    {
        $instance = $this->$key;
    
        if (!is_null($callable)) {
            $callable($instance);
        }
    
        return $instance;
    }
    
    /**
     * Gets a parameter or an object from pimple container.
     *
     * Get the `class basename` of the current class.
     * Convert `class basename` to snake-case and concatenation with dot notation.
     *
     * E.g. Class 'EasyWechat', $key foo -> 'easy_wechat.foo'
     *
     * @param string $key The unique identifier for the parameter or object
     *
     * @return mixed The value of the parameter or an object
     *
     * @throws \InvalidArgumentException If the identifier is not defined
     */
    public function __get($key)
    {
        $name = 'weapp.'.$key;
    
        return $this->wechat->offsetGet($name);
    }
    
    
    
}
