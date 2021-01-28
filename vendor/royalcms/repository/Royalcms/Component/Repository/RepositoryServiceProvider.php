<?php

namespace Royalcms\Component\Repository;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Repository\Repositories\AbstractRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();

        // Get caching
        AbstractRepository::setCacheInstance($this->royalcms['cache']);
    }
    
    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $this->package('royalcms/repository');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Get a list of files that should be compiled for the package.
     *
     * @return array
     */
    public static function compiles()
    {
        $dir = static::guessPackageClassPath('royalcms/repository');

        return [
            $dir . "/Repositories/AbstractRepository.php",
            $dir . "/Traits/Cacheable.php",
            $dir . "/Contracts/RepositoryContract.php",
            $dir . "/RepositoryServiceProvider.php",
        ];
    }

}