<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatMarketing
 */
class WechatMarketingModel extends Model
{
    protected $table = 'wechat_marketing';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'marketing_type',
        'name',
        'keywords',
        'command',
        'description',
        'starttime',
        'endtime',
        'addtime',
        'logo',
        'background',
        'config',
        'support',
        'status',
        'qrcode',
        'url'
    ];

    protected $guarded = [];

    

}