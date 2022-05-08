<?php namespace Royalcms\Component\Agent;

use Royalcms\Component\Support\ServiceProvider;

class AgentServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     */
    public function register()
    {
<<<<<<< HEAD
        $this->royalcms['agent'] = $this->royalcms->share(function ($royalcms)
        {
=======
        $this->royalcms->singleton('agent', function ($royalcms) {
>>>>>>> v2-test
            return new Agent($royalcms['request']->server->all());
        });
        
        // Load the alias
        $this->loadAlias();
    }

    /**
     * Load the alias = One less install step for the user
     */
    protected function loadAlias()
    {
<<<<<<< HEAD
        $this->royalcms->booting(function()
        {
=======
        $this->royalcms->booting(function() {
>>>>>>> v2-test
            $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();
            $loader->alias('RC_Agent', 'Royalcms\Component\Agent\Facades\Agent');
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('agent');
    }

    /**
     * Get a list of files that should be compiled for the package.
     *
     * @return array
     */
    public static function compiles()
    {
        $dir = static::guessPackageClassPath('royalcms/agent');

        return [
            $dir . "/Facades/Agent.php",
            $dir . "/Agent.php",
            $dir . "/MobileDetect.php",
            $dir . "/AgentServiceProvider.php",
        ];
    }
    
}
