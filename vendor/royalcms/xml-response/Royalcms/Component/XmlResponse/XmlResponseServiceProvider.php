<?php namespace Royalcms\Component\XmlResponse;

use Royalcms\Component\Support\Facades\Response;
use Royalcms\Component\Support\ServiceProvider;

/**
 * Class XmlResponseServiceProvider
 * @package XmlResponse
 */
class XmlResponseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadConfig();
        
        Response::macro('xml', function ($value, $headerTemplate = array()) {
            return with(new XmlResponse())->array2xml($value, false, $headerTemplate);
        });
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
    
    /**
     * Load the custom Config file
     */
    protected function loadConfig()
    {
        $this->royalcms['config']->package('royalcms/xml-response', __DIR__ . '/Config');
    }

}