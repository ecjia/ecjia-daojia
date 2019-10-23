<?php

namespace Royalcms\Component\WeChat\User;

use Royalcms\Component\WeChat\Core\AbstractAPI;

/**
 * Class User.
 */
class User extends AbstractAPI
{
    const API_GET = 'https://api.weixin.qq.com/cgi-bin/user/info';
    const API_BATCH_GET = 'https://api.weixin.qq.com/cgi-bin/user/info/batchget';
    const API_LIST = 'https://api.weixin.qq.com/cgi-bin/user/get';
    const API_GROUP = 'https://api.weixin.qq.com/cgi-bin/groups/getid';
    const API_REMARK = 'https://api.weixin.qq.com/cgi-bin/user/info/updateremark';
    const API_OAUTH_GET = 'https://api.weixin.qq.com/sns/userinfo';

    /**
     * Fetch a user by open id.
     *
     * @param string $openId
     * @param string $lang
     *
     * @return array
     */
    public function get($openId, $lang = 'zh_CN')
    {
        $params = [
                   'openid' => $openId,
                   'lang' => $lang,
                  ];

        return $this->parseJSON('get', [self::API_GET, $params]);
    }

    /**
     * Batch get users.
     *
     * @param array  $openIds
     * @param string $lang
     *
     * @return \Royalcms\Component\Support\Collection
     */
    public function batchGet(array $openIds, $lang = 'zh_CN')
    {
        $params = [];

        $params['user_list'] = array_map(function ($openId) use ($lang) {
            return [
                    'openid' => $openId,
                    'lang' => $lang,
                    ];
        }, $openIds);

        return $this->parseJSON('json', [self::API_BATCH_GET, $params]);
    }

    /**
     * List users.
     *
     * @param string $nextOpenId
     *
     * @return \Royalcms\Component\Support\Collection
     */
    public function lists($nextOpenId = null)
    {
        $params = ['next_openid' => $nextOpenId];

        return $this->parseJSON('get', [self::API_LIST, $params]);
    }

    /**
     * Set user remark.
     *
     * @param string $openId
     * @param string $remark
     *
     * @return bool
     */
    public function remark($openId, $remark)
    {
        $params = [
                   'openid' => $openId,
                   'remark' => $remark,
                  ];

        return $this->parseJSON('json', [self::API_REMARK, $params]);
    }

    /**
     * Get user's group id.
     *
     * @param string $openId
     *
     * @return int
     */
    public function group($openId)
    {
        return $this->getGroup($openId);
    }

    /**
     * Get user's group.
     *
     * @param string $openId
     *
     * @return array
     */
    public function getGroup($openId)
    {
        $params = ['openid' => $openId];

        return $this->parseJSON('json', [self::API_GROUP, $params]);
    }
}
