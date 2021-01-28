<?php

namespace Royalcms\Component\Translation;

use Illuminate\Translation\Translator;
use Royalcms\Component\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
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
        $this->loadAlias();

        $this->registerLoader();

        $this->royalcms->singleton('translator', function ($royalcms) {
            $loader = $royalcms['translation.loader'];

            // When registering the translator component, we'll need to set the default
            // locale as well as the fallback locale. So, we'll grab the application
            // configuration so we can easily get both of these values from there.
            $locale = $royalcms['config']['system.locale'];

            $trans = new Translator($loader, $locale);

            $trans->setFallback($royalcms['config']['system.fallback_locale']);

            return $trans;
        });

    }

    /**
     * Register the translation line loader.
     *
     * @return void
     */
    protected function registerLoader()
    {
        $this->royalcms->singleton('translation.loader', function ($royalcms) {
            return new FileLoader($royalcms['files'], $royalcms['path.lang']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['translator', 'translation.loader'];
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
            'Royalcms\Component\Translation\Translator' => 'Illuminate\Translation\Translator',
        ];
    }

}
