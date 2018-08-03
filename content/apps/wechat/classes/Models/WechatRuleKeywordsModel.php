<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatRuleKeywords
 */
class WechatRuleKeywordsModel extends Model
{
    protected $table = 'wechat_rule_keywords';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'rid',
        'rule_keywords'
    ];

    protected $guarded = [];

    

}