<?php

namespace Royalcms\Component\Swoole\Foundation\Database;

use Royalcms\Component\Database\DatabaseManager as RoyalcmsDatabaseManager;

class DatabaseManager extends RoyalcmsDatabaseManager
{
    public function __construct($app, ConnectionFactory $factory)
    {
        parent::__construct($app, $factory);
    }

//    public function connection($name = null)
//    {
//        $this->connections = [];
//        return parent::connection($name);
//    }
}