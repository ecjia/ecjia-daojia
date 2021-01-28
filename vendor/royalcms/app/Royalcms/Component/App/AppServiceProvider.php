<?php

namespace Royalcms\Component\App;

use Facade\Ignition\Commands\TestCommand;
use Royalcms\Component\App\Commands\AppPackageDiscoverCommand;
use Royalcms\Component\App\Commands\AppPackageScanerCommand;
use Royalcms\Component\ClassLoader\ClassManager;
use Royalcms\Component\Foundation\AliasLoader;
use Royalcms\Component\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function boot()
    {
        //注册命名空间
        $psr4 = $this->royalcms->make(AppPackageManifest::class)->autoload_psr4();

        foreach ($psr4 as $namesacpe => $path) {
            $path = $this->royalcms->basePath() . $path;
            ClassManager::getLoader()->setPsr4($namesacpe, $path);
        }

        //注册别名
        AliasLoader::getInstance($this->royalcms->make(AppPackageManifest::class)->aliases());

        //注册Provider
        $providers = $this->royalcms->make(AppPackageManifest::class)->providers();

        foreach ($providers as $provider) {
            if (class_exists($provider)) $this->royalcms->register($provider);
        }
    }
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->forgetInstance('app');

        $this->royalcms->singleton('app', function($royalcms) {
            return new AppManager($royalcms);
        });

        $this->royalcms->instance(AppPackageManifest::class, new AppPackageManifest(
            new \Royalcms\Component\Filesystem\Filesystem, $this->royalcms->basePath(), $this->royalcms->getCachedAppPackagesPath()
        ));

        $this->registerCommands();
    }

    protected function registerCommands()
    {
        $this->royalcms->bind('command.package:app-discover', AppPackageDiscoverCommand::class);
        $this->royalcms->bind('command.package:app-scaner', AppPackageScanerCommand::class);

        $this->commands(['command.package:app-discover']);
        $this->commands(['command.package:app-scaner']);
    }


    /**
     * Get a list of files that should be compiled for the package.
     *
     * @return array
     */
    public static function compiles()
    {
        $dir = static::guessPackageClassPath('royalcms/app');

        return [
            $dir . "/Facades/App.php",
            $dir . "/AppManager.php",
            $dir . "/BundleAbstract.php",
            $dir . "/Bundles/AppBundle.php",
            $dir . "/Contracts/BundlePackage.php",
            $dir . "/AppControllerDispatcher.php",
            $dir . "/AppServiceProvider.php",
            $dir . "/AppParentServiceProvider.php",
        ];
    }
}
