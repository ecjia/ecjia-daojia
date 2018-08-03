<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatUserGroup
 */
class WechatUserGroupModel extends Model
{
    protected $table = 'wechat_user_group';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'group_id',
        'name',
        'count',
        'sort'
    ];

    protected $guarded = [];

    

}