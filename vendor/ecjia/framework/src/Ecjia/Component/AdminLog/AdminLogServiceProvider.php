<?php


namespace Ecjia\Component\AdminLog;

use Royalcms\Component\Support\ServiceProvider;

class AdminLogServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAdminLog();

    }


    public function registerAdminLog()
    {
        $this->royalcms->singleton('ecjia.admin.log', function($royalcms) {
            return AdminLog::instance();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array(
            'ecjia.admin.log',
        );
    }


    /**
     * Get a list of files that should be compiled for the package.
     *
     * @return array
     */
    public static function compiles()
    {
        $dir = __DIR__ . '';
        return [
            $dir . "/Facades/AdminLog.php",
            $dir . "/AdminLog.php",
            $dir . "/CompatibleTrait.php",
            $dir . "/AdminLogAction.php",
            $dir . "/AdminLogObject.php",
        ];
    }

}