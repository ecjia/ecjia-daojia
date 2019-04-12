<?php

namespace Royalcms\Component\View;

use Royalcms\Component\View\Engines\PhpEngine;
use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\View\Engines\FileEngine;
use Royalcms\Component\View\Engines\CompilerEngine;
use Royalcms\Component\View\Engines\EngineResolver;
use Royalcms\Component\View\Compilers\BladeCompiler;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerEngineResolver();

        $this->registerViewFinder();

        $this->registerFactory();
    }

    /**
     * Register the view environment.
     *
     * @return void
     */
    public function registerFactory()
    {
        $this->royalcms->singleton('view', function ($royalcms) {
            // Next we need to grab the engine resolver instance that will be used by the
            // environment. The resolver will be used by an environment to get each of
            // the various engine implementations such as plain PHP or Blade engine.
            $resolver = $royalcms['view.engine.resolver'];

            $finder = $royalcms['view.finder'];

            $factory = $this->createFactory($resolver, $finder, $royalcms['events']);

            // We will also set the container instance on this view environment since the
            // view composers may be classes registered in the container, which allows
            // for great testable, flexible composers for the application developer.
            $factory->setContainer($royalcms);

            $factory->share('royalcms', $royalcms);

            return $factory;
        });
    }

    /**
     * Create a new Factory Instance.
     *
     * @param  \Royalcms\Component\View\Engines\EngineResolver  $resolver
     * @param  \Royalcms\Component\View\ViewFinderInterface  $finder
     * @param  \Royalcms\Component\Contracts\Events\Dispatcher  $events
     * @return \Royalcms\Component\View\Factory
     */
    protected function createFactory($resolver, $finder, $events)
    {
        return new Factory($resolver, $finder, $events);
    }

    /**
     * Register the view finder implementation.
     *
     * @return void
     */
    public function registerViewFinder()
    {
        $this->royalcms->bind('view.finder', function ($royalcms) {
            return new FileViewFinder($royalcms['files'], $royalcms['config']['view.paths']);
        });
    }

    /**
     * Register the engine resolver instance.
     *
     * @return void
     */
    public function registerEngineResolver()
    {
        $this->royalcms->singleton('view.engine.resolver', function () {
            $resolver = new EngineResolver;

            // Next, we will register the various view engines with the resolver so that the
            // environment will resolve the engines needed for various views based on the
            // extension of view file. We call a method for each of the view's engines.
            foreach (['file', 'php', 'blade'] as $engine) {
                $this->{'register'.ucfirst($engine).'Engine'}($resolver);
            }

            return $resolver;
        });
    }

    /**
     * Register the file engine implementation.
     *
     * @param  \Royalcms\Component\View\Engines\EngineResolver  $resolver
     * @return void
     */
    public function registerFileEngine($resolver)
    {
        $resolver->register('file', function () {
            return new FileEngine;
        });
    }

    /**
     * Register the PHP engine implementation.
     *
     * @param  \Royalcms\Component\View\Engines\EngineResolver  $resolver
     * @return void
     */
    public function registerPhpEngine($resolver)
    {
        $resolver->register('php', function () {
            return new PhpEngine;
        });
    }

    /**
     * Register the Blade engine implementation.
     *
     * @param  \Royalcms\Component\View\Engines\EngineResolver  $resolver
     * @return void
     */
    public function registerBladeEngine($resolver)
    {
        // The Compiler engine requires an instance of the CompilerInterface, which in
        // this case will be the Blade compiler, so we'll first create the compiler
        // instance to pass into the engine so it can compile the views properly.
        $this->royalcms->singleton('blade.compiler', function () {
            return new BladeCompiler(
                $this->royalcms['files'], $this->royalcms['config']['view.compiled']
            );
        });

        $resolver->register('blade', function () {
            return new CompilerEngine($this->royalcms['blade.compiler']);
        });
    }
}
