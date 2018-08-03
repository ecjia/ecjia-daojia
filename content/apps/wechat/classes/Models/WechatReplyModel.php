<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatReply
 */
class WechatReplyModel extends Model
{
    protected $table = 'wechat_reply';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'type',
        'content',
        'media_id',
        'rule_name',
        'add_time',
        'reply_type'
    ];

    protected $guarded = [];
    
    
    /**
     * 获取博客文章的评论。
     */
    public function keywords()
    {
        return $this->hasMany('Ecjia\App\Wechat\Models\WechatRuleKeywordsModel', 'rid', 'id');
    }

    

}