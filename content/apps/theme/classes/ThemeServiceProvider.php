<?php

namespace Ecjia\App\Theme;

use Ecjia\App\Theme\ThemeOption\ThemeOption;
use Ecjia\App\Theme\ThemeOption\ThemeSetting;
use Ecjia\App\Theme\ThemeOption\ThemeTransient;
use Ecjia\App\Theme\ThemeFramework\ThemeFramework;
use Royalcms\Component\App\AppParentServiceProvider;

class ThemeServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-theme');
    }
    
    public function register()
    {
        $this->registerThemeOption();

        $this->registerThemeSetting();

        $this->registerThemeTransient();

        $this->registerThemeFramework();

        $this->loadAlias();
    }

    /**
     * Register the theme option
     * @return \Ecjia\App\Theme\ThemeOption\ThemeOption
     */
    public function registerThemeOption()
    {
        $this->royalcms->bindShared('ecjia.theme.option', function($royalcms){
            return new ThemeOption();
        });
    }

    /**
     * Register the theme setting
     * @return \Ecjia\App\Theme\ThemeOption\ThemeOption
     */
    public function registerThemeSetting()
    {
        $this->royalcms->bindShared('ecjia.theme.setting', function($royalcms){
            return new ThemeSetting();
        });
    }

    /**
     * Register the theme transient
     * @return \Ecjia\App\Theme\ThemeOption\ThemeOption
     */
    public function registerThemeTransient()
    {
        $this->royalcms->bindShared('ecjia.theme.transient', function($royalcms){
            return new ThemeTransient();
        });
    }

    /**
     * Register the theme framework
     * @return \Ecjia\App\Theme\ThemeFramework\ThemeFramework
     */
    public function registerThemeFramework()
    {
        $this->royalcms->bindShared('ecjia.theme.framework', function($royalcms){
            return new ThemeFramework();
        });
    }


    /**
     * Load the alias = One less install step for the user
     */
    protected function loadAlias()
    {
        $this->royalcms->booting(function()
        {
            $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();
            $loader->alias('ecjia_theme_option', 'Ecjia\App\Theme\Facades\EcjiaThemeOption');
            $loader->alias('ecjia_theme_setting', 'Ecjia\App\Theme\Facades\EcjiaThemeSetting');
            $loader->alias('ecjia_theme_transient', 'Ecjia\App\Theme\Facades\EcjiaThemeTransient');
            $loader->alias('ecjia_theme_framework', 'Ecjia\App\Theme\Facades\EcjiaThemeFramework');
        });
    }

    /**
     * Get a list of files that should be compiled for the package.
     *
     * @return array
     */
    public static function compiles()
    {
        $dir = __DIR__;

        return [
            $dir . '/ThemeOption/Models/TemplateOptionsModel.php',
            $dir . '/ThemeOption/Repositories/TemplateOptionsRepository.php',
            $dir . '/ThemeOption/ThemeOption.php',
            $dir . '/ThemeFramework/ThemeFrameworkAbstract.php',
            $dir . '/ThemeFramework/Foundation/AdminPanel.php',
            $dir . '/ThemeFramework/OptionField.php',
            $dir . '/ThemeFramework/ThemeConstant.php',
            $dir . '/ThemeFramework/ThemeFramework.php',
            $dir . '/Facades/EcjiaThemeOption.php',
            $dir . '/Facades/EcjiaThemeFramework.php',
        ];
    }
    
}