<?php

namespace Royalcms\Component\Foundation\Bootstrap;

use Royalcms\Component\Support\Facades\Facade;
use Royalcms\Component\Foundation\AliasLoader;
use Royalcms\Component\Contracts\Foundation\Royalcms;

class RegisterFacades
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function bootstrap(Royalcms $royalcms)
    {
        Facade::clearResolvedInstances();

        Facade::setFacadeRoyalcms($royalcms);

        AliasLoader::getInstance($royalcms->make('config')->get('coreservice.aliases'));
        AliasLoader::getInstance($royalcms->make('config')->get('facade'));
        AliasLoader::getInstance()->register();
    }
}
