<?php

namespace Ecjia\System\Admins\AdminNotifiable;

use Illuminate\Notifications\Notifiable;
use Royalcms\Component\Database\Eloquent\Model;

class AdminNotifiable extends Model
{

    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_user';

    protected $primaryKey = 'user_id';



    /**
     * 模型的日期字段保存格式。
     *
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

}