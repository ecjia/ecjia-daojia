<?php


namespace Ecjia\Component\Framework;


use Ecjia\Component\App\AppManager;
use Ecjia\Component\Site\SiteManager;
use Ecjia\Component\Theme\ThemeManager;
use Ecjia\Component\ThemeFramework\ThemeFramework;
use Ecjia\Component\ThemeOption\ThemeSetting;
use Ecjia\Component\Transient\Transient;
use Ecjia\Component\Version\VersionManager;
use Royalcms\Component\Support\ServiceProvider;

class EcjiaServiceProvider extends ServiceProvider
{

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->registerEcjiaContainer();

        $this->registerAppManager();

        $this->registerThemeManager();

        $this->registerThemeOption();

        $this->registerThemeSetting();

        $this->registerThemeTransient();

        $this->registerThemeFramework();

        $this->registerSiteManager();

        $this->registerVersionManager();

        $this->loadAlias();
    }

    public function registerEcjiaContainer()
    {
        $this->royalcms->singleton('ecjia', function($royalcms){
            return new Ecjia();
        });
    }

    /**
     * Register the App manager
     * \Ecjia\Component\Plugin\PluginManager
     *
     * @return void
     */
    public function registerAppManager()
    {
        $this->royalcms->singleton('ecjia.app.manager', function($royalcms) {
            return new AppManager();
        });
    }

    /**
     * Register the Theme manager
     * \Ecjia\Component\Theme\ThemeManager
     *
     * @return void
     */
    public function registerThemeManager()
    {
        $this->royalcms->singleton('ecjia.theme.manager', function($royalcms) {
            return new ThemeManager($royalcms);
        });
    }

    /**
     * Register the theme option
     */
    public function registerThemeOption()
    {
        $this->royalcms->singleton('ecjia.theme.option', function($royalcms){
            return new ThemeOption();
        });
    }

    /**
     * Register the theme setting
     */
    public function registerThemeSetting()
    {
        $this->royalcms->singleton('ecjia.theme.setting', function($royalcms){
            return new ThemeSetting();
        });
    }

    /**
     * Register the theme transient
     */
    public function registerThemeTransient()
    {
        $this->royalcms->singleton('ecjia.transient', function($royalcms){
            return new Transient();
        });
    }

    /**
     * Register the theme framework
     */
    public function registerThemeFramework()
    {
        $this->royalcms->singleton('ecjia.theme.framework', function($royalcms){
            return new ThemeFramework();
        });
    }

    /**
     * Register the Site manager
     * \Ecjia\Component\Site\SiteManager
     *
     * @return void
     */
    public function registerSiteManager()
    {
        $this->royalcms->singleton('ecjia.site.manager', function($royalcms) {
            return new SiteManager($royalcms);
        });
    }

    /**
     * Register the Site manager
     * \Ecjia\Component\Version\VersionManager
     *
     * @return void
     */
    public function registerVersionManager()
    {
        $this->royalcms->singleton('ecjia.version.manager', function($royalcms) {
            return new VersionManager($royalcms);
        });
    }


    /**
     * Load the alias = One less install step for the user
     */
    protected function loadAlias()
    {
        $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();
        $loader->alias('ecjia_theme_option', 'Ecjia\Component\Facades\EcjiaThemeOption');
        $loader->alias('ecjia_theme_setting', 'Ecjia\Component\Facades\EcjiaThemeSetting');
        $loader->alias('ecjia_theme_framework', 'Ecjia\Component\Facades\EcjiaThemeFramework');
        $loader->alias('ecjia_transient', 'Ecjia\Component\Facades\EcjiaTransient');
    }

    /**
     * Get a list of files that should be compiled for the package.
     *
     * @return array
     */
    public static function compiles()
    {
        $basePath = royalcms()->basePath();

        return [
            $basePath . '/vendor/ecjia/framework/Ecjia/Component/Config/ConfigServiceProvider.php',
            $basePath . '/vendor/ecjia/framework/Ecjia/Component/AdminLog/AdminLogServiceProvider.php',
            $basePath . '/vendor/ecjia/framework/Ecjia/Component/CleanCache/CleanCacheServiceProvider.php',
            $basePath . '/vendor/ecjia/framework/Ecjia/Component/Framework/Ecjia.php',
            $basePath . '/vendor/ecjia/framework/Ecjia/Component/Support/EcjiaLoader.php',
            $basePath . '/vendor/ecjia/framework/Ecjia/Component/App/Facades/AppManager.php',
            $basePath . '/vendor/ecjia/framework/Ecjia/Component/View/Facades/View.php',
            $basePath . '/vendor/ecjia/framework/Ecjia/Component/Notification/Facades/Notification.php',
            $basePath . '/vendor/ecjia/framework/Ecjia/Component/Screen/EcjiaScreen.php',
            $basePath . '/vendor/ecjia/framework/Ecjia/Component/AdminLog/CompatibleTrait.php',
            $basePath . '/vendor/ecjia/framework/Ecjia/Component/AdminLog/AdminLogObject.php',
            $basePath . '/vendor/ecjia/framework/Ecjia/Component/AdminLog/AdminLogAction.php',
            $basePath . '/vendor/ecjia/framework/Ecjia/Component/AdminLog/CompatibleTrait.php',
            $basePath . '/vendor/ecjia/framework/Ecjia/Component/AdminLog/AdminLog.php',
            $basePath . '/vendor/ecjia/framework/Ecjia/Component/AdminLog/Facades/AdminLog.php',
        ];
    }

}