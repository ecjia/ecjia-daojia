<?php

namespace Royalcms\Component\Auth;

use Royalcms\Component\Auth\Access\Gate;
use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Contracts\Auth\Access\Gate as GateContract;
use Royalcms\Component\Contracts\Auth\Authenticatable as AuthenticatableContract;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAuthenticator();

        $this->registerUserResolver();

        $this->registerAccessGate();

        $this->registerRequestRebindHandler();
    }

    /**
     * Register the authenticator services.
     *
     * @return void
     */
    protected function registerAuthenticator()
    {
        $this->royalcms->singleton('auth', function ($royalcms) {
            // Once the authentication service has actually been requested by the developer
            // we will set a variable in the application indicating such. This helps us
            // know that we need to set any queued cookies in the after event later.
            $royalcms['auth.loaded'] = true;

            return new AuthManager($royalcms);
        });

        $this->royalcms->singleton('auth.driver', function ($royalcms) {
            return $royalcms['auth']->driver();
        });
    }

    /**
     * Register a resolver for the authenticated user.
     *
     * @return void
     */
    protected function registerUserResolver()
    {
        $this->royalcms->bind(AuthenticatableContract::class, function ($royalcms) {
            return $royalcms['auth']->user();
        });
    }

    /**
     * Register the access gate service.
     *
     * @return void
     */
    protected function registerAccessGate()
    {
        $this->royalcms->singleton(GateContract::class, function ($royalcms) {
            return new Gate($royalcms, function () use ($royalcms) {
                return $royalcms['auth']->user();
            });
        });
    }

    /**
     * Register a resolver for the authenticated user.
     *
     * @return void
     */
    protected function registerRequestRebindHandler()
    {
        $this->royalcms->rebinding('request', function ($royalcms, $request) {
            $request->setUserResolver(function () use ($royalcms) {
                return $royalcms['auth']->user();
            });
        });
    }
}
