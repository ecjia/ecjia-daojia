<?php

namespace Royalcms\Component\Validation;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Contracts\Validation\ValidatesWhenResolved;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerValidationResolverHook();

        $this->registerPresenceVerifier();

        $this->registerValidationFactory();
    }

    /**
     * Register the "ValidatesWhenResolved" container hook.
     *
     * @return void
     */
    protected function registerValidationResolverHook()
    {
        $this->royalcms->afterResolving(function (ValidatesWhenResolved $resolved) {
            $resolved->validate();
        });
    }

    /**
     * Register the validation factory.
     *
     * @return void
     */
    protected function registerValidationFactory()
    {
        $this->royalcms->singleton('validator', function ($royalcms) {
            $validator = new Factory($royalcms['translator'], $royalcms);

            // The validation presence verifier is responsible for determining the existence
            // of values in a given data collection, typically a relational database or
            // other persistent data stores. And it is used to check for uniqueness.
            if (isset($royalcms['validation.presence'])) {
                $validator->setPresenceVerifier($royalcms['validation.presence']);
            }

            return $validator;
        });
    }

    /**
     * Register the database presence verifier.
     *
     * @return void
     */
    protected function registerPresenceVerifier()
    {
        $this->royalcms->singleton('validation.presence', function ($royalcms) {
            return new DatabasePresenceVerifier($royalcms['db']);
        });
    }
}
