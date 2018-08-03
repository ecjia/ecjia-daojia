<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatUserTag
 */
class WechatUserTagModel extends Model
{
    protected $table = 'wechat_user_tag';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'tag_id',
        'openid'
    ];

    protected $guarded = [];

    

}