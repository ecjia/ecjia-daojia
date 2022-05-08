<?php

namespace Royalcms\Component\Filesystem;

class FilesystemServiceProvider extends \Illuminate\Filesystem\FilesystemServiceProvider
{

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->loadAlias();

        parent::register();

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
            'Royalcms\Component\Filesystem\Filesystem'        => 'Illuminate\Filesystem\Filesystem',
            'Royalcms\Component\Filesystem\FilesystemAdapter' => 'Illuminate\Filesystem\FilesystemAdapter',
            'Royalcms\Component\Filesystem\FilesystemManager' => 'Illuminate\Filesystem\FilesystemManager'
        ];
    }

}
