<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatUser
 */
class WechatUserModel extends Model
{
    protected $table = 'wechat_user';

    protected $primaryKey = 'uid';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'subscribe',
        'openid',
        'nickname',
        'sex',
        'city',
        'country',
        'province',
        'language',
        'headimgurl',
        'subscribe_time',
        'remark',
        'privilege',
        'unionid',
        'groupid',
        'ect_uid',
        'bein_kefu',
        'subscribe_scene',
        'qr_scene',
        'qr_scene_str',
        'popularize_uid',
        'location_latitude',
        'location_longitude',
        'location_precision',
        'location_updatetime',
    ];

    protected $guarded = [];

    /**
     * 限制查询只包括指定用户。
     *
     * @return \Royalcms\Component\Database\Eloquent\Builder
     */
    public function scopeWechat($query, $wechat_id)
    {
        return $query->where('wechat_id', $wechat_id);
    }
    
    /**
     * 限制查询只包括指定用户。
     *
     * @return \Royalcms\Component\Database\Eloquent\Builder
     */
    public function scopeOpenid($query, $openid)
    {
        return $query->where('openid', $openid);
    }
    
    /**
     * 限制查询只包括指定用户。
     *
     * @return \Royalcms\Component\Database\Eloquent\Builder
     */
    public function scopeUnionid($query, $unionid)
    {
        return $query->where('unionid', $unionid);
    }
    

}