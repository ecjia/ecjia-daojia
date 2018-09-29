<?php

/**
 * WeApp.php.
 *
 */
namespace Royalcms\Component\WeChat\MiniProgram;

use Royalcms\Component\WeChat\Foundation\WeChat;
use Royalcms\Component\WeChat\MiniProgram\QRCode\QRCode;
use Royalcms\Component\WeChat\MiniProgram\Core\AccessToken;

/**
 * Class WeApp.
 *
 * @property \Royalcms\Component\WeChat\MiniProgram\Server\Guard $server
 * @property \Royalcms\Component\WeChat\MiniProgram\Sns\Sns $sns
 * @property \Royalcms\Component\WeChat\MiniProgram\Notice\Notice $notice
 * @property \Royalcms\Component\WeChat\MiniProgram\Staff\Staff $staff
 * @property \Royalcms\Component\WeChat\MiniProgram\QRCode\QRCode $qrcode
 * @property \Royalcms\Component\WeChat\MiniProgram\Material\Temporary $material_temporary
 * @property \Royalcms\Component\WeChat\MiniProgram\Stats\Stats $stats
 */
class MiniProgram
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
        
        $this->registerAccessToken();
        
        $this->registerQrcode();
    }

    private function registerAccessToken()
    {
        $this->wechat->singleton('weapp.access_token', function($wechat)
        {
            $app_id = $wechat->config['app_id'];
            $app_secret = $wechat->config['app_secret'];
            return new AccessToken($app_id, $app_secret);
        });
    }

    private function registerQrcode()
    {
        $this->wechat->singleton('weapp.qrcode', function($wechat)
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
     * E.g. Class 'Wechat', $key foo -> 'wechat.foo'
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
