<?php namespace Royalcms\Component\Package;

use Royalcms\Component\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider {
    
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
        $this->royalcms->bindShared('package', function($royalcms)
        {
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
            $dir . "/PackageServiceProvider.php",
            $dir . "/PackageManager.php",
            $dir . "/FileLoader.php",
            $dir . "/LoaderInterface.php",
            $dir . "/SystemPackage.php",
            $dir . "/Package.php",
            $dir . "/PackageInterface.php",
            $dir . "/ApplicationPackage.php",
            $dir . "/Facades/Package.php",
        ];
    }
}
