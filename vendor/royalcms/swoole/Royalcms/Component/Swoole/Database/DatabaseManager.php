<?php

namespace Royalcms\Component\Swoole\Database;

use Royalcms\Component\Database\DatabaseManager as RoyalcmsDatabaseManager;

class DatabaseManager extends RoyalcmsDatabaseManager
{
    public function __construct($royalcms, ConnectionFactory $factory)
    {
        parent::__construct($royalcms, $factory);
    }
}