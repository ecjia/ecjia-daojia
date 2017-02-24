<?php namespace Royalcms\Component\WeChat;

use Exception;

/**
 * @file
 *
 * WeChatCorpAPI
 * @see http://qydev.weixin.qq.com/wiki/index.php
 */

/**
 * 
 *
 */
class WeChatCorpAPI {
    

    /**
     * 获取access_token
     */
    public function getAccessToken() {
        static $url = 'https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=%s&corpsecret=%s';
        $token = Utility::getCorpAccessToken($this);
        if (empty($token) || time() > $token['expired']) {
            $body= Utility::http(sprintf($url, $this->getConfig('appid'), $this->getConfig('appsecret')));
            $json = json_decode($body, true);
            if (!$json || !empty($json['errcode'])) {
                throw new Exception('Error - WeChatCorp Can not get AccessToken.');            
            } else {
                $token['token']   = $json['access_token'];
                $token['expired'] = time() + $json['expires_in'] - 120;
                Utility::setCorpAccessToken($token, $this);
            }
        }

        return $token['token'];
    }

    /**
     * 验证配置
     */
    public function validateConfig() {
        static $url = 'https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=%s&corpsecret=%s';
        $body = Utility::http(sprintf($url, $this->getConfig('appid'), $this->getConfig('appsecret')));
        $json = json_decode($body, true);
        if (!$json || !empty($json['errcode'])) {
            return false;
        } else {
            return true;
        }
    }

}
