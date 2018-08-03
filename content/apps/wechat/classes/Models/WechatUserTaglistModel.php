<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatUserTaglist
 */
class WechatUserTaglistModel extends Model
{
    protected $table = 'wechat_user_taglist';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'tag_id',
        'name',
        'count',
        'sort'
    ];

    protected $guarded = [];

    

}