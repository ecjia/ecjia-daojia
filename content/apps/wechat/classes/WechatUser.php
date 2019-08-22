<?php

namespace Ecjia\App\Wechat;

use Ecjia\App\Wechat\Exceptions\WechatUserNotFoundException;
use Ecjia\App\Wechat\Models\WechatUserModel;
use Royalcms\Component\Support\Collection;

/**
 * 微信用户类
 * @author royalwang
 *
 */
class WechatUser
{
    protected $wechat_id;

    protected $open_id;

    protected $user;

    protected $wechatUUID;

    public function __construct($wechat_id, $openid)
    {
        $this->wechat_id = $wechat_id;
        $this->open_id   = $openid;

        $this->wechatUUID = new WechatID($this->wechat_id);
        $this->user       = $this->findOpenidUser();
    }

    /**
     * 获取微信用户数据模型，没有会自动创建数据模型
     * @return \Royalcms\Component\Database\Eloquent\Model|static
     */
    public function getWechatUser()
    {
        //新关注用户，获取用户信息，插入资料
        if (empty($this->user)) {

            $wechat   = $this->wechatUUID->getWechatInstance();
            $userinfo = $wechat->user->get($this->open_id);

            if (!empty($userinfo)) {
                $userModel = $this->createWechatUser(0, $userinfo, 0);

                $this->user = $userModel;
            } else {
                RC_WeChat::log()->error(__('获取微信用户信息失败，微信用户尚未关注或已取消关注！', 'wechat'));
            }

        }

        return $this->user;
    }

    /**
     * 获取用户数据模型，没有会返回null
     */
    public function getUserModel()
    {
        return $this->user;
    }

    /**
     * @return mixed
     * @throws WechatUserNotFoundException
     */
    protected function findOpenidUser()
    {
        $user = WechatUserModel::wechat($this->wechat_id)->openid($this->open_id)->first();
        if (! empty($user)) {
            return $user;
        }

        throw new WechatUserNotFoundException('微信关注用户获取失败，请重新关注公众号再试。');
    }

    public function findUnionidUser($unionid)
    {
        $user = WechatUserModel::leftJoin('platform_account', 'wechat_user.wechat_id', '=', 'platform_account.id')
            ->unionid($unionid)->first();
        return $user;
    }

    public function getConnectUser($unionid = null)
    {
        if (is_null($unionid)) {
            if ($this->user->unionid) {
                $connect_user = new \Ecjia\App\Connect\ConnectUser('sns_wechat', $this->user->unionid, 'user');
            } else {
                $connect_user = new \Ecjia\App\Connect\ConnectUser('sns_wechat', $this->user->openid, 'user');
            }
        } else {
            $connect_user = new \Ecjia\App\Connect\ConnectUser('sns_wechat', $unionid, 'user');
        }

        return $connect_user;
    }


    public function getUnionid()
    {
        return $this->user->unionid;
    }

    public function getImage()
    {
        return $this->user->headimgurl;
    }

    public function getNickname()
    {
        return $this->user->nickname;
    }

    public function sex()
    {
        return $this->user->sex;
    }

    /**
     * 获取ecajia用户id
     */
    public function getEcjiaUserId()
    {
        return $this->user->ect_uid;
    }

    /**
     * 设置与微信关联的ecjia用户id
     * @param integer $userid
     */
    public function setEcjiaUserId($userid)
    {
        $this->user->ect_uid = $userid;
        return $this->user->update(array('ect_uid' => $userid));
    }

    /**
     * 获取EcjiaUser用户数据模型
     * @return \Royalcms\Component\Database\Eloquent\Model|\Royalcms\Component\Database\Eloquent\Collection|\Ecjia\App\User\Models\UsersModel
     */
    public function getEcjiaUser()
    {
        return \Ecjia\App\User\Models\UsersModel::find($this->getEcjiaUserId());
    }

    /**
     * 生成用户名
     * @return string
     */
    public static function generateUsername()
    {
        /* 不是用户注册，则创建随机用户名*/
        return 'a' . rc_random(10, 'abcdefghijklmnopqrstuvwxyz0123456789');
    }

    /**
     * 生成用户名
     * @return string
     */
    public static function generatePassword()
    {
        /* 不是用户注册，则创建随机用户名*/
        return md5(rc_random(13, 'abcdefghijklmnopqrstuvwxyz0123456789'));
    }

    /**
     * 生成邮箱
     * @return string
     */
    public static function generateEmail()
    {
        /* 不是用户注册，则创建随机用户名*/
        $string = 'a' . rc_random(10, 'abcdefghijklmnopqrstuvwxyz0123456789');
        $email  = $string . '@163.com';
        return $email;
    }

    /**
     * 创建用户
     * @param $ecjia_userid
     * @param $userinfo 微信用户信息
     * @param $popularize_uid 推荐人ID
     */
    public function createWechatUser($ecjia_userid, Collection $userinfo, $popularize_uid = 0)
    {
        $model = WechatUserModel::create([
            'wechat_id'       => $this->wechat_id,
            'group_id'        => $userinfo->get('groupid'),
            'subscribe'       => 1,
            'openid'          => $this->open_id,
            'nickname'        => $userinfo->get('nickname'),
            'sex'             => $userinfo->get('sex'),
            'city'            => $userinfo->get('city'),
            'country'         => $userinfo->get('country'),
            'province'        => $userinfo->get('province'),
            'language'        => $userinfo->get('language'),
            'headimgurl'      => $userinfo->get('headimgurl'),
            'subscribe_time'  => $userinfo->get('subscribe_time'),
            'remark'          => $userinfo->get('remark'),
            'unionid'         => $userinfo->get('unionid'),
            'ect_uid'         => $ecjia_userid,
            'subscribe_scene' => $userinfo->get('subscribe_scene'),
            'qr_scene'        => $userinfo->get('qr_scene'),
            'qr_scene_str'    => $userinfo->get('qr_scene_str'),
            'popularize_uid'  => $popularize_uid,
        ]);

        return $model;
    }


}