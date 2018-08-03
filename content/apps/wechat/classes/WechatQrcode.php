<?php

namespace Ecjia\App\Wechat;

use Ecjia\App\Wechat\Models\WechatQrcodeModel;
use RC_Time;

class WechatQrcode
{
    
    const QR_SCENE = 'QR_SCENE';
    
    const QR_STR_SCENE = 'QR_STR_SCENE';
    
    const QR_LIMIT_SCENE = 'QR_LIMIT_SCENE';
    
    const QR_LIMIT_STR_SCENE = 'QR_LIMIT_STR_SCENE';
    
    protected $wechat_uuid;
    
    public function __construct($uuid = null)
    {
        $this->wechat_uuid = new WechatUUID($uuid);
    }


    public function getWechatUUID()
    {
        return $this->wechat_uuid;
    }


    /**
     * 临时二维码
     */
    public function temporary($sceneValue, $expireSeconds = 86400)
    {
        $qrcode = $this->wechat_uuid->getWechatInstance()->qrcode;
        
        $result = $qrcode->temporary($sceneValue, $expireSeconds);
        
        return $result;
    }
    
    /**
     * 永久二维码
     */
    public function forever($sceneValue)
    {
        $qrcode = $this->wechat_uuid->getWechatInstance()->qrcode;
        
        $result = $qrcode->forever($sceneValue);
        
        return $result;
    }
    
    /**
     * 获取微信用户推广二维码
     * @param string $openid
     */
    public function getUserQrcodeUrl($openid, $function = null)
    {
        $wechat_id = $this->wechat_uuid->getWechatID();

        $model = WechatQrcodeModel::where('scene_id', $openid)->where('wechat_id', $wechat_id)->where('type', 1)->first();
        //用户已经存在，读取用户推广码
        if (! empty($model)) {
            if (! is_null($function)) {
                $data = [
                    'function' => $function,
                ];
                $model->update($data);
            }
        }
        //用户不存在，为用户创建推广码
        else {
            try {
                $ticket = $this->forever($openid);
            } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
                return new \ecjia_error('wechat_qrcode_error', $e->getMessage());
            }

            $wechat_user = new WechatUser($wechat_id, $openid);
            $username = $wechat_user->getNickname();

            $data = [
                'type' => 1,
                'scene_id' => $openid,
                'username' => $username,
                'function' => $function,
                'status' => 1,
                'wechat_id' => $wechat_id,
                'endtime' => RC_Time::gmtime(),
                'expire_seconds' => 0,

                'ticket' => $ticket['ticket'],
                'expire_seconds' => $ticket['expire_seconds'],
                'qrcode_url' => "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $ticket['ticket'],
            ];
            $model = WechatQrcodeModel::create($data);
        }

        return $model->qrcode_url;
    }
    
    
}