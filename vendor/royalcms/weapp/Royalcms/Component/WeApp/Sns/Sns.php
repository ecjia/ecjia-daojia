<?php

/**
 * User.php.
 *
 */

namespace Royalcms\Component\WeApp\Sns;

use Royalcms\Component\WeApp\Core\AbstractWeApp;

class Sns extends AbstractWeApp
{
    /**
     * Api.
     */
    const JSCODE_TO_SESSION = 'https://api.weixin.qq.com/sns/jscode2session';

    /**
     * JsCode 2 session key.
     *
     * @param string $jsCode
     *
     * @return \Royalcms\Component\Support\Collection
     */
    public function getSessionKey($jsCode)
    {
        $params = [
            'appid' => $this->config['app_id'],
            'secret' => $this->config['secret'],
            'js_code' => $jsCode,
            'grant_type' => 'authorization_code',
        ];

        return $this->parseJSON('GET', [self::JSCODE_TO_SESSION, $params]);
    }
}
