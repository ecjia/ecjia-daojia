<?php

namespace Royalcms\Component\Cron\Models;

use \Royalcms\Component\Database\Eloquent\Model;

class Job extends Model {
    
    protected $table = 'cron_job';
    
    public $timestamps = false;
    
    public function manager() {
        return $this->belongsTo('\Royalcms\Component\Cron\Models\Manager', 'cron_manager_id');
    }
    
    
}
