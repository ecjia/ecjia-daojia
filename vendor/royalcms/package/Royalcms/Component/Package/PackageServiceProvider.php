<<<<<<< HEAD
<?php namespace Royalcms\Component\Package;

use Royalcms\Component\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider {
    
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;
    
=======
<?php

namespace Royalcms\Component\Package;

use Illuminate\Contracts\Support\DeferrableProvider;
use Royalcms\Component\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider implements DeferrableProvider
{

>>>>>>> v2-test
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
<<<<<<< HEAD
        $this->royalcms->bindShared('package', function($royalcms)
        {
            return new PackageManager($royalcms);
        });
    }
    
=======
        $this->royalcms->singleton('package', function ($royalcms) {
            return new PackageManager($royalcms);
        });
    }

>>>>>>> v2-test
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('package');
    }

    /**
     * Get a list of files that should be compiled for the package.
     *
     * @return array
     */
    public static function compiles()
    {
        $dir = static::guessPackageClassPath('royalcms/package');

        return [
<<<<<<< HEAD
            $dir . "/PackageServiceProvider.php",
            $dir . "/PackageManager.php",
            $dir . "/FileLoader.php",
            $dir . "/LoaderInterface.php",
            $dir . "/SystemPackage.php",
            $dir . "/Package.php",
            $dir . "/PackageInterface.php",
            $dir . "/ApplicationPackage.php",
            $dir . "/Facades/Package.php",
=======
            $dir . "/Contracts/LoaderInterface.php",
            $dir . "/Contracts/PackageInterface.php",
            $dir . "/PackageServiceProvider.php",
            $dir . "/PackageManager.php",
            $dir . "/FileLoader.php",
            $dir . "/SystemPackage.php",
            $dir . "/Package.php",
            $dir . "/ApplicationPackage.php",
            $dir . "/Facades/Package.php",
            $dir . "/Facades/Loader.php",
>>>>>>> v2-test
        ];
    }
}
