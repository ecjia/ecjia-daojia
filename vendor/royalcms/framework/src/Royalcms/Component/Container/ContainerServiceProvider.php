<?php

namespace Royalcms\Component\Container;

use Royalcms\Component\Support\ServiceProvider;

class ContainerServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {

        $this->loadAlias();
    }

    /**
     * Load the alias = One less install step for the user
     */
    protected function loadAlias()
    {
        $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();

        foreach (self::aliases() as $class => $alias) {
            $loader->alias($class, $alias);
        }
    }

    /**
     * Load the alias = One less install step for the user
     */
    public static function aliases()
    {

        return [
            'Royalcms\Component\Container\Container'                => 'Illuminate\Container\Container',
            'Royalcms\Component\Container\ContextualBindingBuilder' => 'Illuminate\Container\ContextualBindingBuilder'
        ];
    }

}
