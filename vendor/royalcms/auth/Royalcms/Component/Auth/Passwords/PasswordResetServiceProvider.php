<?php

namespace Royalcms\Component\Auth\Passwords;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Auth\Passwords\DatabaseTokenRepository as DbRepository;

class PasswordResetServiceProvider extends ServiceProvider
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
        $this->registerPasswordBroker();

        $this->registerTokenRepository();
    }

    /**
     * Register the password broker instance.
     *
     * @return void
     */
    protected function registerPasswordBroker()
    {
        $this->royalcms->singleton('auth.password', function ($royalcms) {
            // The password token repository is responsible for storing the email addresses
            // and password reset tokens. It will be used to verify the tokens are valid
            // for the given e-mail addresses. We will resolve an implementation here.
            $tokens = $royalcms['auth.password.tokens'];

            $users = $royalcms['auth']->driver()->getProvider();

            $view = $royalcms['config']['auth.password.email'];

            // The password broker uses a token repository to validate tokens and send user
            // password e-mails, as well as validating that password reset process as an
            // aggregate service of sorts providing a convenient interface for resets.
            return new PasswordBroker(
                $tokens, $users, $royalcms['mailer'], $view
            );
        });
    }

    /**
     * Register the token repository implementation.
     *
     * @return void
     */
    protected function registerTokenRepository()
    {
        $this->royalcms->singleton('auth.password.tokens', function ($royalcms) {
            $connection = $royalcms['db']->connection();

            // The database token repository is an implementation of the token repository
            // interface, and is responsible for the actual storing of auth tokens and
            // their e-mail addresses. We will inject this table and hash key to it.
            $table = $royalcms['config']['auth.password.table'];

            $key = $royalcms['config']['app.key'];

            $expire = $royalcms['config']->get('auth.password.expire', 60);

            return new DbRepository($connection, $table, $key, $expire);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['auth.password', 'auth.password.tokens'];
    }
}
