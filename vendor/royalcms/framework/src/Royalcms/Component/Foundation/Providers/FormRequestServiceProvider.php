<?php

namespace Royalcms\Component\Foundation\Providers;

use Royalcms\Component\Routing\Redirector;
use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;

class FormRequestServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->royalcms['events']->listen('router.matched', function () {
            $this->royalcms->resolving(function (FormRequest $request, $royalcms) {
                $this->initializeRequest($request, $royalcms['request']);

                $request->setContainer($royalcms)->setRedirector($royalcms->make(Redirector::class));
            });
        });
    }

    /**
     * Initialize the form request with data from the given request.
     *
     * @param  \Royalcms\Component\Foundation\Http\FormRequest  $form
     * @param  \Symfony\Component\HttpFoundation\Request  $current
     * @return void
     */
    protected function initializeRequest(FormRequest $form, Request $current)
    {
        $files = $current->files->all();

        $files = is_array($files) ? array_filter($files) : $files;

        $form->initialize(
            $current->query->all(), $current->request->all(), $current->attributes->all(),
            $current->cookies->all(), $files, $current->server->all(), $current->getContent()
        );

        if ($session = $current->getSession()) {
            $form->setSession($session);
        }

        $form->setUserResolver($current->getUserResolver());

        $form->setRouteResolver($current->getRouteResolver());
    }
}
