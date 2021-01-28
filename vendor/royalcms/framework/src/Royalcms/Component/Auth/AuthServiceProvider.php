<?php

namespace Royalcms\Component\Auth;


class AuthServiceProvider extends \Illuminate\Auth\AuthServiceProvider
{
    /**
     * The application instance.
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * Create a new service provider instance.
     * @param \Royalcms\Component\Contracts\Foundation\Royalcms $royalcms
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
            'Royalcms\Component\Auth\GenericUser'                            => 'Illuminate\Auth\GenericUser',
            'Royalcms\Component\Auth\DatabaseUserProvider'                   => 'Illuminate\Auth\DatabaseUserProvider',
            'Royalcms\Component\Auth\EloquentUserProvider'                   => 'Illuminate\Auth\EloquentUserProvider',
            'Royalcms\Component\Auth\GeneratorServiceProvider'               => 'Illuminate\Auth\GeneratorServiceProvider',
            'Royalcms\Component\Auth\AuthManager'                            => 'Illuminate\Auth\AuthManager',
            'Royalcms\Component\Auth\Authenticatable'                        => 'Illuminate\Auth\Authenticatable',
            'Royalcms\Component\Auth\Passwords\CanResetPassword'             => 'Illuminate\Auth\Passwords\CanResetPassword',
            'Royalcms\Component\Auth\Passwords\DatabaseTokenRepository'      => 'Illuminate\Auth\Passwords\DatabaseTokenRepository',
            'Royalcms\Component\Auth\Passwords\PasswordBroker'               => 'Illuminate\Auth\Passwords\PasswordBroker',
            'Royalcms\Component\Auth\Passwords\PasswordResetServiceProvider' => 'Illuminate\Auth\Passwords\PasswordResetServiceProvider',
            'Royalcms\Component\Auth\Passwords\TokenRepositoryInterface'     => 'Illuminate\Auth\Passwords\TokenRepositoryInterface',
            'Royalcms\Component\Auth\Middleware\AuthenticateWithBasicAuth'   => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
            'Royalcms\Component\Auth\Access\Gate'                            => 'Illuminate\Auth\Access\Gate',
            'Royalcms\Component\Auth\Access\HandlesAuthorization'            => 'Illuminate\Auth\Access\HandlesAuthorization',
            'Royalcms\Component\Auth\Access\Response'                        => 'Illuminate\Auth\Access\Response',
        ];
    }

}
