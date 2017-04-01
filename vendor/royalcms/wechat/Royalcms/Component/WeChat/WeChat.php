<?php namespace Royalcms\Component\WeChat;

use Exception;

/**
 * @file
 *
 * WeChat
 */

/**

$config = array(
    'token'     => '',
    'appid'     => '',
    'appsecret' => '',
    'aeskey'    => '',
);

$wechat = new WeChat($config);

$wechat
    //普通消息-文字
    ->on('Text', ...)
    //普通消息-图片
    ->on('Image', ...)
    //普通消息-语音
    ->on('Voice', ...)
    //普通消息-视频
    ->on('Video', ...)
    //普通消息-小视频
    ->on('Shortvideo', ...)
    //普通消息-地理位置
    ->on('Location', ...)
    //普通消息-链接
    ->on('Link', ...)
    //上报地理位置事件
    ->on('ReportLocation', ...)
    //关注时
    ->on('Subscribe', ...)
    //用户已关注时的事件
    ->on('Scan', ...)
    //取消关注时
    ->on('Unsubscribe', ...)
    //自定义菜单点击事件
    ->on('Click', ...)
    //自定义菜单跳转链接时的事件
    ->on('View', ...)
    //扫码推事件的事件
    ->on('Scancode_Push', ...)
    //扫码推事件且弹出“消息接收中”提示框的事件
    ->on('Scancode_WaitMsg', ...)
    //弹出系统拍照发图的事件
    ->on('Pic_SysPhoto', ...)
    //弹出拍照或者相册发图的事件
    ->on('pic_photo_or_album', ...)
    //弹出微信相册发图器的事件
    ->on('Pic_Weixin', ...)
    //弹出地理位置选择器的事件
    ->on('Location_Select', ...)
    //模板消息发送成功
    ->on('TemplateSendJobFinish', ...)
    //群发发送成功
    ->on('MassSendJobFinish', ...)

$request  = Request::createFromGlobals();
$response = $wechat->handle($request);
$response->send();

 */
class WeChat extends WeChatAPI {

    /**
     * 配置
     */
    protected $config = array(
        'wid'       => '0', //多账户标识
        'token'     => '',
        'appid'     => '',
        'appsecret' => '',
        'aeskey'    => '',
    );

    /**
     * 事件
     */
    protected $events = array();
    
    /**
     * 回调
     */
    protected $fallbacks = array();

    /**
     * 析构函数
     */
    public function __construct($config = array()) {
        if (is_array($config) || is_object($config)) {
            $this->config = (array) $config + $this->config;
        }
    }

    /**
     * 执行
     */
    public function handle($request) {
        $useEncode = false;
        $encrypted = '';
        //是否为加密模式
        $encryptType = isset($_GET['encrypt_type']) ? $_GET['encrypt_type'] : '';
        if (strtoupper($encryptType) == 'AES') {
            $encrypted = $request->getParameter('Encrypt');
            try {
                $prpcrypt = new Prpcrypt($this->getConfig('aeskey'));
                $xmlData  = $prpcrypt->decrypt($encrypted, $this->getConfig('appid'));
            } catch (Exception $e) {
                exit('Error - ' . $e->getCode() . $e->getMessage());
            }
            $request->initialize($xmlData);
            $useEncode = true;
        }
        $request->wechat = $this;
        //检查签名
        $signResult = $this->checkSignature($encrypted);
        if ($signResult === false) {
            exit('Error - WeChat Signature');
        } else if ($signResult !== true) {
            echo $signResult;
            exit;
        }
        //获取事件
        $event = self::getHandleEvent($request);
        //执行回调
        $wid = $this->getConfig('wid');
        $callback = isset($this->events[$event]) ? $this->events[$event] : false;
        $callback = isset($this->events[$wid][$event]) ? $this->events[$wid][$event] : $callback;
        if ($callback && is_object($callback) && get_class($callback) == 'Closure') {
            $response = $callback($request);
        } elseif ($callback) {
            $response = call_user_func($callback, $request);
        } elseif ($this->fallbacks) {
            $response = '';
            foreach ($this->fallbacks as $fallback) {
                if (is_callable(array($fallback, $event))) {
                    $response = call_user_func(array($fallback, $event), $request); 
                    break;
                }
            }
        } else {
            $response = '';
        }
        if (!($response instanceof Response)) {
            $response = new Response($response);
        }
        $response->wechat = $this;
        $response->request = $request;
        $response->setEncrypt($useEncode);

        return $response;
    }

    /**
     * 添加事件监听
     */
    public function on($event, $callback, $wid = '') {
        $event = strtolower($event);
        if (is_numeric($wid)) {
            $this->events[$wid][$event] = $callback;
        } else {
            $this->events[$event] = $callback;
        }
        return $this;
    }

    /**
     * 注册事件监听类
     */
    public function registerEvents($class) {
        $this->fallbacks[] = $class;
        return $this;
    }

    /**
     * 注消事件监听类
     */
    public function unregisterEvents($class) {
        foreach ($this->fallbacks as $k=>$fallback) {
            if ($class == $fallback) {
                unset($this->fallbacks[$k]);
            }
        }
        return $this;
    }

    /**
     * 获取事件监听
     */
    public function getEvent($event) {
        $event = strtolower($event);
        return isset($this->events[$event]) ? $this->events[$event] : false;
    }

    /*
     * 检查签名
     */
    public function checkSignature($string = '') {
        $signature = isset($_GET["signature"]) ? $_GET["signature"] : '';
        $signature = isset($_GET["msg_signature"]) ? $_GET["msg_signature"] : $signature;
        $timestamp = isset($_GET['timestamp']) ? $_GET['timestamp'] : time();
        $nonce     = isset($_GET['nonce']) ? $_GET['nonce'] : '';
        $sign      = $this->getSHA1($timestamp, $nonce, $string);
        if ($sign !== $signature) {
            return false;
        } else if (isset($_GET['echostr'])) {
            return $_GET['echostr'];
        } else {
            return true;
        }
    }

    /**
     * 获取某项配置
     */
    public function getConfig($name, $default = null) {
        return isset($this->config[$name]) ? $this->config[$name] : $default;
    }

    /**
     * 设置某项配置
     */
    public function setConfig($name, $value) {
        $this->config[$name] = $value;
        return $this;
    }

    /**
     * 获取LIB的event名
     */
    public static function getHandleEvent($request) {
        $event = strtolower($request->getParameter('MsgType'));
        if ($event == 'event') {
            $event = strtolower($request->getParameter('Event'));
            if ($event == 'location') {
                $event = 'reportlocation';
            }
        }
        return $event;
    }

    //获取SHA1码
    public function getSHA1($timestamp, $nonce, $string) {
        $array = array($this->getConfig('token'), $timestamp, $nonce, $string);
        sort($array, SORT_STRING);
        return sha1(implode($array));
    }

}