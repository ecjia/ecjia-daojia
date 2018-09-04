<?php

namespace Royalcms\Component\Excel;

use PHPExcel_Settings;
use PHPExcel_Shared_Font;
use Royalcms\Component\Excel\Readers\HtmlReader;
use Royalcms\Component\Excel\Classes\Cache;
use Royalcms\Component\Excel\Classes\PHPExcel;
use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Excel\Parsers\CssParser;
use Royalcms\Component\Excel\Parsers\ViewParser;
use Royalcms\Component\Excel\Classes\FormatIdentifier;
use Royalcms\Component\Excel\Readers\ExcelReader;
use Royalcms\Component\Excel\Writers\ExcelWriter;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;
use RC_Config;

/**
 *
 * Excel ServiceProvider
 */
class ExcelServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */

    public function boot()
    {
        // Boot the package
        $this->package('royalcms/excel');

        // Set the autosizing settings
        $this->setAutoSizingSettings();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->bindClasses();
        $this->bindCssParser();
        $this->bindReaders();
        $this->bindParsers();
        $this->bindPHPExcelClass();
        $this->bindWriters();
        $this->bindExcel();
        
        // Load the alias
        $this->loadAlias();
    }

    /**
     * Bind PHPExcel classes
     * @return void
     */
    protected function bindPHPExcelClass()
    {
        // Set object
        $me = $this;

        // Bind the PHPExcel class
        $this->royalcms['phpexcel'] = $this->royalcms->share(function () use ($me)
        {
            // Set locale
            $me->setLocale();

            // Set the caching settings
            $me->setCacheSettings();

            // Init phpExcel
            $excel = new PHPExcel();
            $excel->setDefaultProperties();
            return $excel;
        });
    }

    /**
     * Bind the css parser
     */
    protected function bindCssParser()
    {
        // Bind css parser
        $this->royalcms['excel.parsers.css'] = $this->royalcms->share(function ()
        {
            return new CssParser(
                new CssToInlineStyles()
            );
        });
    }

    /**
     * Bind writers
     * @return void
     */
    protected function bindReaders()
    {
        // Bind the laravel excel reader
        $this->royalcms['excel.reader'] = $this->royalcms->share(function ($royalcms)
        {
            return new ExcelReader(
                $royalcms['files'],
                $royalcms['excel.identifier']
            );
        });

        // Bind the html reader class
        $this->royalcms['excel.readers.html'] = $this->royalcms->share(function ($royalcms)
        {
            return new HtmlReader(
                $royalcms['excel.parsers.css']
            );
        });
    }

    /**
     * Bind writers
     * @return void
     */
    protected function bindParsers()
    {
        // Bind the view parser
        $this->royalcms['excel.parsers.view'] = $this->royalcms->share(function ($royalcms)
        {
            return new ViewParser(
                $royalcms['excel.readers.html']
            );
        });
    }

    /**
     * Bind writers
     * @return void
     */
    protected function bindWriters()
    {
        // Bind the excel writer
        $this->royalcms['excel.writer'] = $this->royalcms->share(function ($royalcms)
        {
            return new ExcelWriter(
                $royalcms->make('response'),
                $royalcms['files'],
                $royalcms['excel.identifier']
            );
        });
    }

    /**
     * Bind Excel class
     * @return void
     */
    protected function bindExcel()
    {
        // Bind the Excel class and inject its dependencies
        $this->royalcms['excel'] = $this->royalcms->share(function ($royalcms)
        {
            $excel = new Excel(
                $royalcms['phpexcel'],
                $royalcms['excel.reader'],
                $royalcms['excel.writer'],
                $royalcms['excel.parsers.view']
            );

            $excel->registerFilters($royalcms['config']->get('excel::filters', array()));

            return $excel;
        });
    }

    /**
     * Bind other classes
     * @return void
     */
    protected function bindClasses()
    {
        // Bind the format identifier
        $this->royalcms['excel.identifier'] = $this->royalcms->share(function ($royalcms)
        {
            return new FormatIdentifier($royalcms['files']);
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
            $loader->alias('RC_Excel', 'Royalcms\Component\Excel\Facades\Excel');
        });
    }

    /**
     * Set cache settings
     * @return Cache
     */
    public function setCacheSettings()
    {
        return new Cache();
    }

    /**
     * Set locale
     */
    public function setLocale()
    {
        $locale = RC_Config::get('system.locale', 'zh_CN');
        PHPExcel_Settings::setLocale($locale);
    }

    /**
     * Set the autosizing settings
     */
    public function setAutoSizingSettings()
    {
        $method = RC_Config::get('excel::export.autosize-method', PHPExcel_Shared_Font::AUTOSIZE_METHOD_APPROX);
        PHPExcel_Shared_Font::setAutoSizeMethod($method);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array(
            'excel',
            'phpexcel',
            'excel.reader',
            'excel.readers.html',
            'excel.parsers.view',
            'excel.writer'
        );
    }
}
