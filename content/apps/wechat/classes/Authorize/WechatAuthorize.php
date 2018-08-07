<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/8/7
 * Time: 9:58 AM
 */

namespace Ecjia\App\Wechat\Authorize;

use Ecjia\App\Wechat\WechatUUID;
use ecjia_front;

class WechatAuthorize
{

    const SNSAPI_USERINFO   = 'snsapi_userinfo';
    const SNSAPI_BASE       = 'snsapi_base';


    protected $scope;

    protected $uuid;

    public function __construct($uuid, $scope = self::SNSAPI_USERINFO)
    {
        $this->wechat = with(new WechatUUID($uuid))->getWechatInstance();
        $this->scope = $scope;
    }


    /**
     * 生成授权网址
     */
    public function getAuthorizeUrl($callback_url = null)
    {
        if (is_null($callback_url)) {
            $callback_url = '';
        }

        $callback_url = urlencode($callback_url);

        $state = md5(uniqid(rand(), true));

        $_SESSION['wechat_authorize_state'] = $state;


        $params = [
            'appid'         => $this->wechat->config->get('app_id'),
            'redirect_uri'  => $callback_url,
            'response_type' => 'code',
            'scope'         => $this->scope,
            'state'         => $state,
        ];

        static $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=%s&scope=%s&state=%s#wechat_redirect';
        $code_url = vsprintf($url, $params);

        return $code_url;
    }

}