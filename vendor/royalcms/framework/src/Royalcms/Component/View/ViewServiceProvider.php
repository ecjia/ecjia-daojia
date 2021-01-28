<?php

namespace Royalcms\Component\View;

class ViewServiceProvider extends \Illuminate\View\ViewServiceProvider
{
    /**
     * The application instance.
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * Create a new service provider instance.
     * @param \Royalcms\Component\Contracts\Foundation\Royalcms|\Illuminate\Contracts\Foundation\Application $royalcms
     * @return void
     */
    public function __construct($royalcms)
    {
        parent::__construct($royalcms);

        $this->royalcms = $royalcms;
    }


    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        parent::register();

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
            'Royalcms\Component\View\Compilers\BladeCompiler'                   => 'Illuminate\View\Compilers\BladeCompiler',
            'Royalcms\Component\View\Compilers\Compiler'                        => 'Illuminate\View\Compilers\Compiler',
            'Royalcms\Component\View\Compilers\CompilerInterface'               => 'Illuminate\View\Compilers\CompilerInterface',
            'Royalcms\Component\View\Compilers\Concerns\CompilesAuthorizations' => 'Illuminate\View\Compilers\Concerns\CompilesAuthorizations',
            'Royalcms\Component\View\Compilers\Concerns\CompilesComments'       => 'Illuminate\View\Compilers\Concerns\CompilesComments',
            'Royalcms\Component\View\Compilers\Concerns\CompilesComponents'     => 'Illuminate\View\Compilers\Concerns\CompilesComponents',
            'Royalcms\Component\View\Compilers\Concerns\CompilesConditionals'   => 'Illuminate\View\Compilers\Concerns\CompilesConditionals',
            'Royalcms\Component\View\Compilers\Concerns\CompilesEchos'          => 'Illuminate\View\Compilers\Concerns\CompilesEchos',
            'Royalcms\Component\View\Compilers\Concerns\CompilesHelpers'        => 'Illuminate\View\Compilers\Concerns\CompilesHelpers',
            'Royalcms\Component\View\Compilers\Concerns\CompilesIncludes'       => 'Illuminate\View\Compilers\Concerns\CompilesIncludes',
            'Royalcms\Component\View\Compilers\Concerns\CompilesInjections'     => 'Illuminate\View\Compilers\Concerns\CompilesInjections',
            'Royalcms\Component\View\Compilers\Concerns\CompilesJson'           => 'Illuminate\View\Compilers\Concerns\CompilesJson',
            'Royalcms\Component\View\Compilers\Concerns\CompilesLayouts'        => 'Illuminate\View\Compilers\Concerns\CompilesLayouts',
            'Royalcms\Component\View\Compilers\Concerns\CompilesLoops'          => 'Illuminate\View\Compilers\Concerns\CompilesLoops',
            'Royalcms\Component\View\Compilers\Concerns\CompilesRawPhp'         => 'Illuminate\View\Compilers\Concerns\CompilesRawPhp',
            'Royalcms\Component\View\Compilers\Concerns\CompilesStacks'         => 'Illuminate\View\Compilers\Concerns\CompilesStacks',
            'Royalcms\Component\View\Compilers\Concerns\CompilesTranslations'   => 'Illuminate\View\Compilers\Concerns\CompilesTranslations',
            'Royalcms\Component\View\Concerns\ManagesComponents'                => 'Illuminate\View\Concerns\ManagesComponents',
            'Royalcms\Component\View\Concerns\ManagesEvents'                    => 'Illuminate\View\Concerns\ManagesEvents',
            'Royalcms\Component\View\Concerns\ManagesLayouts'                   => 'Illuminate\View\Concerns\ManagesLayouts',
            'Royalcms\Component\View\Concerns\ManagesLoops'                     => 'Illuminate\View\Concerns\ManagesLoops',
            'Royalcms\Component\View\Concerns\ManagesStacks'                    => 'Illuminate\View\Concerns\ManagesStacks',
            'Royalcms\Component\View\Concerns\ManagesTranslations'              => 'Illuminate\View\Concerns\ManagesTranslations',
            'Royalcms\Component\View\Engines\CompilerEngine'                    => 'Illuminate\View\Engines\CompilerEngine',
            'Royalcms\Component\View\Engines\Engine'                            => 'Illuminate\View\Engines\Engine',
            'Royalcms\Component\View\Engines\EngineResolver'                    => 'Illuminate\View\Engines\EngineResolver',
            'Royalcms\Component\View\Engines\FileEngine'                        => 'Illuminate\View\Engines\FileEngine',
            'Royalcms\Component\View\Engines\PhpEngine'                         => 'Illuminate\View\Engines\PhpEngine',
            'Royalcms\Component\View\Factory'                                   => 'Illuminate\View\Factory',
            'Royalcms\Component\View\Middleware\ShareErrorsFromSession'         => 'Illuminate\View\Middleware\ShareErrorsFromSession',
            'Royalcms\Component\View\View'                                      => 'Illuminate\View\View',
            'Royalcms\Component\View\ViewName'                                  => 'Illuminate\View\ViewName',
        ];
    }

}
