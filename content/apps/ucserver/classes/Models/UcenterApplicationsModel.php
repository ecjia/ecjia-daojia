<?php

namespace Ecjia\App\Ucserver\Models;

use Royalcms\Component\Database\Eloquent\Model;

class UcenterApplicationsModel extends Model
{
    protected $table = 'ucenter_applications';

    protected $primaryKey = 'appid';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
    
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    
    
    
    
}

// end