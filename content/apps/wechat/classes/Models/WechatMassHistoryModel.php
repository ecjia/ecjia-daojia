<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatMassHistory
 */
class WechatMassHistoryModel extends Model
{
    protected $table = 'wechat_mass_history';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'media_id',
        'type',
        'status',
        'send_time',
        'msg_id',
        'totalcount',
        'filtercount',
        'sentcount',
        'errorcount'
    ];

    protected $guarded = [];

    /**
     * 群发消息记录
     * $result["msg_id"]:34182,
     * $result["msg_data_id"]: 206227730
     */
    public static function massSendRecord($wechat_id, $media_id, $type, $content = null, $result = null)
    {

        $data = array(
            'wechat_id'  => $wechat_id,
            'media_id'   => $media_id,
            'tag_id'     => array_get($content, 'tag_id', 0),
            'type'       => $type,
            'send_time'  => \RC_Time::gmtime(),
            'content'    => [
                'media_content' => $content,
            ],
            'msg_id'      => $result['msg_id'],
            'msg_data_id' => $result['msg_data_id'],
        );

        $data['content'] = serialize($data['content']);

        WechatMassHistoryModel::insert($data);
    }

}