<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatTemplate
 */
class WechatTemplateModel extends Model
{
    protected $table = 'wechat_template';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'template_id',
        'code',
        'content',
        'template',
        'title',
        'add_time',
        'status'
    ];

    protected $guarded = [];

    

}