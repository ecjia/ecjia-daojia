<?php namespace Royalcms\Component\DbExporter\Facades;

use Royalcms\Component\Support\Facades\Facade;

class DbMigrations extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'DbMigrations'; }

}