<?php 

namespace Royalcms\Component\Ftp;

use Royalcms\Component\Support\ServiceProvider;

class FtpServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('royalcms/ftp');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->singleton('ftp', function ($royalcms) {
            return new FtpManager($royalcms);
        });

        $this->royalcms->booting(function () {
            $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();
            $loader->alias('RC_FTP', 'Royalcms\Component\Ftp\Facades\Ftp');
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('ftp');
    }
}
