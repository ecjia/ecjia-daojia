<?php

namespace Royalcms\Component\NativeSession;

use Royalcms\Component\Support\ServiceProvider;

class NativeSessionServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerSessionManager();
        $this->registerSessionDriver();
        $this->registerStartSession();
    }

    private function registerSessionManager()
    {
        unset($this->royalcms['session']);
        
<<<<<<< HEAD
        $this->royalcms->bindShared('session', function ($royalcms) {
=======
        $this->royalcms->singleton('session', function ($royalcms) {
>>>>>>> v2-test
            return new SessionManager($royalcms);
        });
    }

    private function registerSessionDriver()
    {
        unset($this->royalcms['session.store']);
        
<<<<<<< HEAD
        $this->royalcms->bindShared('session.store', function ($royalcms) {
=======
        $this->royalcms->singleton('session.store', function ($royalcms) {
>>>>>>> v2-test
            $manager = $royalcms['session'];
            return $manager->driver();
        });
    }
    
    /**
     * Register the session middleware instance.
     *
     * @return void
     */
    protected function registerStartSession()
    {
        unset($this->royalcms['session.start']);
        
<<<<<<< HEAD
        $this->royalcms->bindShared('session.start', function($royalcms)
=======
        $this->royalcms->singleton('session.start', function($royalcms)
>>>>>>> v2-test
        {
            // First, we will create the session manager which is responsible for the
            // creation of the various session drivers when they are needed by the
            // application instance, and will resolve them on a lazy load basis.
            $manager = $royalcms['session'];
    
            return new StartSession($manager);
        });
    }

    /**
     * Get a list of files that should be compiled for the package.
     *
     * @return array
     */
    public static function compiles()
    {
        $dir = static::guessPackageClassPath('royalcms/native-session');

        return [
            $dir . "/Store.php",
            $dir . "/CompatibleTrait.php",
            $dir . "/Serialize.php",
            $dir . "/SessionManager.php",
            $dir . "/StartSession.php",
            $dir . "/NativeSessionServiceProvider.php",
        ];
    }
    
}