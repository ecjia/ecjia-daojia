<?php

namespace Royalcms\Component\Package;

use Illuminate\Contracts\Support\DeferrableProvider;
use Royalcms\Component\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider implements DeferrableProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->singleton('package', function ($royalcms) {
            return new PackageManager($royalcms);
        });
    }

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
        ];
    }
}
