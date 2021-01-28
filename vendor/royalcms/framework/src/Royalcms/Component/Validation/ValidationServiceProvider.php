<?php

namespace Royalcms\Component\Validation;

class ValidationServiceProvider extends \Illuminate\Validation\ValidationServiceProvider
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
            'Royalcms\Component\Validation\DatabasePresenceVerifier'   => 'Illuminate\Validation\DatabasePresenceVerifier',
            'Royalcms\Component\Validation\Factory'                    => 'Illuminate\Validation\Factory',
            'Royalcms\Component\Validation\PresenceVerifierInterface'  => 'Illuminate\Validation\PresenceVerifierInterface',
            'Royalcms\Component\Validation\ValidatesWhenResolvedTrait' => 'Illuminate\Validation\ValidatesWhenResolvedTrait',
            'Royalcms\Component\Validation\Validator'                  => 'Illuminate\Validation\Validator',
        ];
    }


}
