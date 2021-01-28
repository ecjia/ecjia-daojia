<?php

namespace Royalcms\Component\Model;

class NullModel extends Model
{
    public $table_name;

    public function __construct()
    {
        parent::__construct();
    }

}
