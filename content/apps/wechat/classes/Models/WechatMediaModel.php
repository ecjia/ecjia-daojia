<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatMedia
 * @property wechat_id
 * @property title
 * @property command
 * @property author
 * @property is_show
 * @property digest
 * @property content
 * @property link
 * @property file
 * @property size
 * @property file_name
 * @property thumb
 * @property add_time
 * @property edit_time
 * @property type
 * @property article_id
 * @property sort
 */
class WechatMediaModel extends Model
{
    protected $table = 'wechat_media';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'title',
        'command',
        'author',
        'is_show',
        'digest',
        'content',
        'link',
        'file',
        'size',
        'file_name',
        'thumb',
        'add_time',
        'edit_time',
        'type',
        'article_id',
        'sort',
        'media_id',
        'is_material',
        'media_url',
        'thumb_url',
        'need_open_comment',
        'only_fans_can_comment',
        'wait_upload_article',
        'parent_id',
    ];

    protected $guarded = [];


    /**
     * 获取素材的子图文。
     */
    public function subNews()
    {
        return $this->hasMany('Ecjia\App\Wechat\Models\WechatMediaModel', 'parent_id', 'id');
    }

    /**
     * 获取素材的父图文。
     */
    public function parentNews()
    {
        return $this->belongsTo('Ecjia\App\Wechat\Models\WechatMediaModel', 'parent_id', 'id');
    }

    /**
     * 限制查询只包括指定缩略图素材ID。
     *
     * @return \Royalcms\Component\Database\Eloquent\Builder
     */
    public function scopeThumbMediaId($query, $media_id)
    {
        return $query->where('type', 'thumb')->where('media_id', $media_id);
    }

}