<?php

namespace Royalcms\Component\Cron\Models;

use \Royalcms\Component\Database\Eloquent\Model;

class Manager extends Model {
    
    protected $table = 'cron_manager';
    
    public $timestamps = false;
    
    public function cronJobs() {
        return $this->hasMany('\Royalcms\Component\Cron\Models\Job', 'cron_manager_id');
    }
    
    
}
