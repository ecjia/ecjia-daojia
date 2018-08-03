<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatMenu
 */
class WechatMenuModel extends Model
{
    protected $table = 'wechat_menu';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'pid',
        'name',
        'type',
        'key',
        'url',
        'sort',
        'status'
    ];

    protected $guarded = [];

    

}