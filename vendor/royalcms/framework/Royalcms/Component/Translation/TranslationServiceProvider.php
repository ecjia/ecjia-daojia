<?php

namespace Royalcms\Component\Translation;

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
        $this->registerLoader();

        $this->royalcms->singleton('translator', function ($royalcms) {
            $loader = $royalcms['translation.loader'];

            // When registering the translator component, we'll need to set the default
            // locale as well as the fallback locale. So, we'll grab the application
            // configuration so we can easily get both of these values from there.
            $locale = $royalcms['config']['system.locale'];

            $items = [];

            // First we will see if we have a cache translation file. If we do, we'll load
            // the translation items from that file so that it is very quick. Otherwise
            // we will need to spin through every translation file and load them all.
            if (file_exists($cached = $royalcms->getCachedTranslationPath($locale))) {
                $items = require $cached;
            }

            $trans = new Translator($loader, $locale, $items);

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
}
