<?php


namespace Royalcms\Component\App;

use Royalcms\Component\Contracts\Foundation\Royalcms as RoyalcmsContract;
use Royalcms\Component\Filesystem\Filesystem;
use RC_File;

class SiteApplications
{
    /**
     * The royalcms implementation.
     *
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * Create a new service repository instance.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
//     * @param  \Royalcms\Component\Filesystem\Filesystem  $files
//     * @param  string  $manifestPath
     * @return void
     */
    public function __construct(RoyalcmsContract $royalcms)
    {
        $this->royalcms = $royalcms;


    }


    public function load()
    {

        $app_roots = array(
            rtrim(RC_APP_PATH, DS),
            rtrim(SITE_APP_PATH, DS)
        );

//        dd($app_roots);

        $apps = collect($app_roots)
            ->unique()
            ->filter(function($item) {
                return RC_File::exists($item);
            })
            ->map(function($item) {
            return RC_File::directories($item);
        })->collapse()->all();

//        dd($apps);

        $site = defined('RC_SITE') ? RC_SITE : '';

        return $this->registerApplicationProviders($apps, $site);
    }

    /**
     * Register all of the configured providers.
     *
     * @return array
     */
    public function registerApplicationProviders($apps, $site = null)
    {
        $manifestPath = $this->getCachedApplicationBundlesPath($site);

        return (new ApplicationRepository($this->royalcms, new Filesystem(), $manifestPath))
            ->load($apps);
    }


    /**
     * Get the path to the cached services.json file.
     *
     * @return string
     */
    public function getCachedApplicationBundlesPath($site = null)
    {
        $site = !empty($site) ? '_'.$site : '';

        if ($this->royalcms->vendorIsWritableForOptimizations())
        {
            return $this->royalcms->contentPath()."/bootstrap/cache/application{$site}.json";
        }
        else
        {
            return $this->royalcms->storagePath()."/framework/application{$site}.json";
        }
    }

}