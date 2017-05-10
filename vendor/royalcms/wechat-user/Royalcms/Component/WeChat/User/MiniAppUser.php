<?php

namespace Royalcms\Component\WeChat\User;

use Royalcms\Component\WeChat\Core\AbstractAPI;

/**
 * Class MiniAppUser.
 */
class MiniAppUser extends AbstractAPI
{
    private $appId;
    private $secret;
    private $grantType = 'authorization_code';
    private $config;

    const API_JSCODE_SESSION = 'https://api.weixin.qq.com/sns/jscode2session';

    public function __construct($config)
    {
        $this->config = $config;
        $this->appId = $this->config['app_id'];
        $this->secret = $this->config['app_secret'];
        !empty($this->config['grant_type']) ? $this->grantType = $this->config['grant_type'] : '';
    }

    /**
     * Get openid session_key expires_in by js_code.
     *
     * @param string $openId
     * @param string $lang
     *
     * @return array
     */
    public function get($jsCode)
    {
        $params = [
                   'appid' => $this->appId,
                   'secret' => $this->secret,
                   'grant_type' => $this->grantType,
                   'js_code' => $jsCode,
                  ];

        return $this->parseJSON('get', [self::API_JSCODE_SESSION, $params]);
    }
}
