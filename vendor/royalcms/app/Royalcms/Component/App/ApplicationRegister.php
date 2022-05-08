<?php


namespace Royalcms\Component\App;


use Royalcms\Component\ClassLoader\ClassManager;
use Royalcms\Component\Foundation\AliasLoader;

class ApplicationRegister
{

    protected $app;

    /**
     * @var BundleAbstract
     */
    protected $bundle;

    public function __construct($app, $bundle)
    {
        $this->app = $app;
        $this->bundle = $bundle;
    }

    public function register()
    {
        $this->registerApplication();

        $this->registerApplicationNamespace();

        $this->registerApplicationProvider();

        $this->registerApplicationAlias();
    }

    /**
     * @param $app
     */
    public function registerApplication()
    {
        if (!empty($this->bundle)) {
            $this->app->extend($this->bundle->getAlias(), function () {
                return $this->bundle;
            });

            if ($this->bundle->getAlias() != $this->bundle->getDirectory()) {
                $this->app->extend($this->bundle->getDirectory(), function () {
                    return $this->bundle;
                });
            }
        }
    }

    /**
     * Register Application namespace.
     */
    public function registerApplicationNamespace()
    {
        foreach ($this->getNamespace() as $namesacpe => $path) {
            ClassManager::getLoader()->setPsr4($namesacpe, $path);
        }
    }

    /**
     * Register Application provider.
     */
    public function registerApplicationProvider()
    {
        foreach ($this->getProviders() as $provider) {
            if (class_exists($provider)) royalcms()->register($provider);
        }
    }

    /**
     * Register Application alias.
     */
    public function registerApplicationAlias()
    {
        AliasLoader::getInstance($this->getAliases());
    }


    protected function getProviders()
    {
        $providers = $this->bundle->getPackage('discover.providers');

        return $providers;
    }


    protected function getAliases()
    {
        $aliases = $this->bundle->getPackage('discover.aliases');

        return $aliases;
    }

    protected function getNamespace()
    {
        $namespace = $this->bundle->getPackage('autoload.psr-4');

        $namespace = $this->normalizePsr4NamespacePath($this->bundle, $namespace);

        return $namespace;
    }

    /**
     * Normalize a relative or absolute path to a cache file.
     *
     * @param  array  $psr4
     * @return string
     */
    protected function normalizePsr4NamespacePath($bundle, $psr4)
    {
        return collect($psr4)->map(function ($item) use ($bundle) {
            $path = $bundle->getAbsolutePath() . $item;
            $path = str_replace($this->basePath, '', $path);

            return $path;
        })->all();
    }

}