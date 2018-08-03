<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatQrcode
 */
class WechatQrcodeModel extends Model
{
    protected $table = 'wechat_qrcode';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'type',
        'expire_seconds',
        'scene_id',
        'username',
        'function',
        'ticket',
        'qrcode_url',
        'endtime',
        'scan_num',
        'status',
        'sort'
    ];

    protected $guarded = [];

    

}