<?php

namespace Royalcms\Component\SmartyView;

use Smarty;
use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\View\Engines\EngineResolver;
use Royalcms\Component\SmartyView\Engines\SmartyEngine;

/**
 * Class SmartyServiceProvider
 *
 */
class SmartyServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;
    
    /**
     * boot
     */
    public function boot()
    {
        // add Smarty Extension
        $extensions = $this->royalcms['config']->get('smarty-view::smarty.extensions', array('tpl'));
        
        foreach ($extensions as $extension) {
            $this->royalcms['view']->addExtension($extension, 'smarty');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->package('royalcms/smarty-view');

        $this->registerEngineResolver();
        
        $this->registerViewFinder();
        
        $this->registerFactory();
    }
    
    /**
     * Register the engine resolver instance.
     *
     * @return void
     */
    public function registerEngineResolver()
    {
        $me = $this;
    
        $this->royalcms->bindShared('view.engine.resolver', function($royalcms) use ($me)
        {
            $resolver = new EngineResolver;
    
            // Next we will register the various engines with the resolver so that the
            // environment can resolve the engines it needs for various views based
            // on the extension of view files. We call a method for each engines.
            $me->registerSmartyEngine($resolver);
    
            return $resolver;
        });
    }
    
    /**
     * Register the PHP engine implementation.
     *
     * @param  \Royalcms\Component\View\Engines\EngineResolver  $resolver
     * @return void
     */
    public function registerSmartyEngine($resolver)
    {
        $royalcms = $this->royalcms;
         
        $resolver->register('smarty', function() use ($royalcms) {
            $smarty = $royalcms->make('view');
            return new SmartyEngine($smarty->getSmarty());
        });
    }

    /**
     * Register the view finder implementation.
     *
     * @return void
     */
    public function registerViewFinder()
    {
        $this->royalcms->bindShared('view.finder', function($royalcms)
        {
            $path = $royalcms['config']['smarty-view::smarty.template_path'];
    
            return new FileViewFinder($royalcms['files'], array($path));
        });
    }
    
    /**
     * Register the view environment.
     *
     * @return void
     */
    public function registerFactory()
    {
        require_once $this->royalcms['path.vendor'] . '/smarty/smarty/Smarty.class.php';
        
        $this->royalcms->singleton('view', function ($royalcms) {
            $factory = new SmartyFactory(
                $royalcms['view.engine.resolver'],
                $royalcms['view.finder'],
                $royalcms['events'],
                new Smarty,
                $royalcms['config']
            );

            // Pass the container to the factory so it can be used to resolve view composers.
            $factory->setContainer($royalcms);

            $factory->share('royalcms', $royalcms);
            // resolve cache storage
            $factory->resolveSmartyCache();
            // smarty configure(use smarty.php)
            $factory->setSmartyConfigure();

            return $factory;
        });
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('smarty', 'view', 'view.finder');
    }
}
