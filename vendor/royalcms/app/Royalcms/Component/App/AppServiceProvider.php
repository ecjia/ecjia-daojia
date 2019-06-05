<?php

namespace Royalcms\Component\App;

use Royalcms\Component\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        
        $this->royalcms['app'] = $this->royalcms->share(function($royalcms)
        {
            return new AppManager($royalcms);
        });
        
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
