<?php namespace Royalcms\Component\XmlResponse;

use Royalcms\Component\Support\Facades\Response;
use Royalcms\Component\Support\ServiceProvider;

/**
 * Class XmlResponseServiceProvider
 * @package XmlResponse
 */
class XmlResponseServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('royalcms/xml-response');
    }

    public function register()
    {
        Response::macro('xml', function ($value, $headerTemplate = array()) {
            return with(new XmlResponse())->array2xml($value, false, $headerTemplate);
        });
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('xml-response');
    }

}