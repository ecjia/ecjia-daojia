<?php

namespace Ecjia\System\Providers;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Hook\Dispatcher;

class HookerServiceProvider extends ServiceProvider
{
    /**
     * The hook action listener mappings for the application.
     *
     * @var array
     */
    protected $actions = [
        'ecjia_loading' => [
            'Ecjia\System\Hookers\EcjiaLoadingScreenAction'
        ],

        'init' => [
            ['Ecjia\System\Hookers\EcjiaInitLoadAction', 2],
            ['Ecjia\System\Hookers\EcjiaLoadLangAction', 9]
        ],

        'ecjia_loaded' => [
            'Ecjia\System\Hookers\EcjiaInstallApplicationLoadAction'
        ],

        'ecjia_compatible_process' => [
            'Ecjia\System\Hookers\EcjiaFrontCompatibleProcessAction'
        ],

        'ecjia_front_access_session' => [
            'Ecjia\System\Hookers\EcjiaFrontAccessSessionAction'
        ],

        'shop_config_updated_after' => [
            'Ecjia\System\Hookers\ShopConfigUpdatedAfterAction'
        ],

        'app_scan_bundles_filter' => [
            'Ecjia\System\Hookers\EcjiaLoadSystemApplicationFilter',
        ],

        'app_activation_bundles' => [
            'Ecjia\System\Hookers\EcjiaInstallApplicationBundleFilter',
        ],

        'activated_application' => [
            'Ecjia\System\Hookers\ActivatedApplicationAction',
        ],

        'deactivate_application' => [
            'Ecjia\System\Hookers\DeactivateApplicationAction',
        ],

        'handle_403_error' => [
            ['Ecjia\System\Hookers\Handle403ErrorAction', 9],
        ],

        'handle_404_error' => [
            ['Ecjia\System\Hookers\Handle404ErrorAction', 9],
        ],

        'handle_500_error' => [
            ['Ecjia\System\Hookers\Handle500ErrorAction', 9],
        ],
    ];

    /**
     * The hook filters listener mappings for the application.
     *
     * @var array
     */
    protected $filters = [
        'set_ecjia_config_filter' => [
            'Ecjia\System\Hookers\SetEcjiaConfigFilter'
        ],

        'system_static_url' => [
            ['Ecjia\System\Hookers\CustomSystemStaticUrlFilter', 10, 2],
        ],

        'admin_url' => [
            ['Ecjia\System\Hookers\CustomAdminUrlFilter', 10, 2],
        ],

        'asset_url' => [
            ['Ecjia\System\Hookers\CustomAssetUrlFilter', 10, 2],
        ],

        'home_url' => [
            ['Ecjia\System\Hookers\CustomHomeUrlFilter', 10, 3],
        ],

        'original_home_url' => [
            ['Ecjia\System\Hookers\CustomOriginalHomeUrlFilter', 10, 3],
        ],

        'site_url' => [
            ['Ecjia\System\Hookers\CustomSiteUrlFilter', 10, 3],
        ],

        'original_site_url' => [
            ['Ecjia\System\Hookers\CustomOriginalSiteUrlFilter', 10, 3],
        ],

        'upload_url' => [
            ['Ecjia\System\Hookers\CustomUploadUrlFilter', 10, 2],
        ],

        'original_upload_url' => [
            ['Ecjia\System\Hookers\CustomOriginalUploadUrlFilter', 10, 2],
        ],

        'upload_path' => [
            ['Ecjia\System\Hookers\CustomUploadPathFilter', 10, 2],
        ],

        'upload_default_random_filename' => [
            'Ecjia\System\Hookers\UploadDefaultRandomFilenameFilter',
        ],

        'set_server_timezone' => [
            'Ecjia\System\Hookers\SetCurrentTimezoneFilter',
        ],

        'set_current_url' => [
            'Ecjia\System\Hookers\SetCurrentUrlFilter'
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        'Ecjia\System\Subscribers\EcjiaAutoloadSubscriber',
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Royalcms\Component\Hook\Dispatcher  $dispatcher
     * @return void
     */
    public function boot(Dispatcher $dispatcher)
    {

        foreach ($this->actions as $event => $listeners) {
            foreach ($listeners as $listener) {
                $dispatcher->addAction($event, $listener);
            }
        }

        foreach ($this->filters as $event => $listeners) {
            foreach ($listeners as $listener) {
                $dispatcher->addFilter($event, $listener);
            }
        }

        foreach ($this->subscribe as $subscriber) {
            $dispatcher->subscribe($subscriber);
        }

    }


    /**
     * {@inheritdoc}
     */
    public function register()
    {
        //
    }

    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function actions()
    {
        return $this->actions;
    }

    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function filters()
    {
        return $this->filters;
    }

}
