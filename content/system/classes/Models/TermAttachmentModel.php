<?php


namespace Ecjia\System\Models;


use Royalcms\Component\Database\Eloquent\Model;

class TermAttachmentModel extends Model
{

    protected $table = 'term_attachment';

    protected $primaryKey = 'attach_id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'attach_label',
        'attach_description',
        'object_app',
        'object_group',
        'object_id',
        'file_name',
        'file_path',
        'file_size',
        'file_ext',
        'file_hash',
        'file_mime',
        'is_image',
        'user_id',
        'user_type',
        'add_time',
        'add_ip',
        'in_status',
        'sort_by',
        'downloads',
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

}