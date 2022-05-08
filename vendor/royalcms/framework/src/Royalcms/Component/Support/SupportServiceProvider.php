<?php

namespace Royalcms\Component\Support;

use Illuminate\Support\Collection;

class SupportServiceProvider extends \Illuminate\Support\ServiceProvider
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


    public function boot()
    {

        Collection::mixin(new \Royalcms\Component\Support\Mixins\CollectionMixin());

    }

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
            'Royalcms\Component\Support\Collection'                 => 'Illuminate\Support\Collection',
            'Royalcms\Component\Support\MessageBag'                 => 'Illuminate\Support\MessageBag',
//            'Royalcms\Component\Support\Fluent'                     => 'Illuminate\Support\Fluent',
            'Royalcms\Component\Support\ViewErrorBag'               => 'Illuminate\Support\ViewErrorBag',
            'Royalcms\Component\Support\Pluralizer'                 => 'Illuminate\Support\Pluralizer',
            'Royalcms\Component\Support\Optional'                   => 'Illuminate\Support\Optional',
            'Royalcms\Component\Support\NamespacedItemResolver'     => 'Illuminate\Support\NamespacedItemResolver',
            'Royalcms\Component\Support\HtmlString'                 => 'Illuminate\Support\HtmlString',
            'Royalcms\Component\Support\HigherOrderTapProxy'        => 'Illuminate\Support\HigherOrderTapProxy',
            'Royalcms\Component\Support\HigherOrderCollectionProxy' => 'Illuminate\Support\HigherOrderCollectionProxy',
            'Royalcms\Component\Support\Carbon'                     => 'Illuminate\Support\Carbon',
            'Royalcms\Component\Support\Traits\CapsuleManagerTrait' => 'Illuminate\Support\Traits\CapsuleManagerTrait',
            'Royalcms\Component\Support\Traits\Macroable'           => 'Illuminate\Support\Traits\Macroable',
            'Royalcms\Component\Support\ClassLoader'                => 'Royalcms\Component\ClassLoader\ClassLoader'
        ];
    }


}
