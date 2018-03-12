<?php 

namespace Royalcms\Component\Tcpdf;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Foundation\AliasLoader;
use RC_Config;

class TcpdfServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     * Array map constants - config
     *
     * @var array
     */
    private $config_constant_map = [
        'K_PATH_FONTS'                  => 'fonts_directory',
        'K_PATH_IMAGES'                 => 'image_directory',
        'PDF_HEADER_LOGO'               => 'header_logo',
        'PDF_HEADER_LOGO_WIDTH'         => 'header_logo_width',
        'K_PATH_CACHE'                  => 'cache_directory',
        'K_BLANK_IMAGE'                 => 'blank_image',
        'PDF_PAGE_FORMAT'               => 'page_format',
        'PDF_PAGE_ORIENTATION'          => 'page_orientation',
        'PDF_CREATOR'                   => 'creator',
        'PDF_AUTHOR'                    => 'author',
        'PDF_HEADER_TITLE'              => 'header_title',
        'PDF_HEADER_STRING'             => 'header_string',
        'PDF_UNIT'                      => 'page_unit',
        'PDF_MARGIN_HEADER'             => 'header_margin',
        'PDF_MARGIN_FOOTER'             => 'footer_margin',
        'PDF_MARGIN_TOP'                => 'margin_top',
        'PDF_MARGIN_BOTTOM'             => 'margin_bottom',
        'PDF_MARGIN_LEFT'               => 'margin_left',
        'PDF_MARGIN_RIGHT'              => 'margin_right',
        'PDF_FONT_NAME_MAIN'            => 'page_font',
        'PDF_FONT_SIZE_MAIN'            => 'page_font_size',
        'PDF_FONT_NAME_DATA'            => 'page_font',
        'PDF_FONT_SIZE_DATA'            => 'page_font_size',
        'PDF_FONT_MONOSPACED'           => 'font_monospaced',
        'PDF_IMAGE_SCALE_RATIO'         => 'image_scale',
        'HEAD_MAGNIFICATION'            => 'head_magnification',
        'K_CELL_HEIGHT_RATIO'           => 'cell_height_ratio',
        'K_TITLE_MAGNIFICATION'         => 'title_magnification',
        'K_SMALL_RATIO'                 => 'small_font_ratio',
        'K_THAI_TOPCHARS'               => 'thai_topchars',
        'K_TCPDF_CALLS_IN_HTML'         => 'tcpdf_calls_in_html',
        'K_TCPDF_THROW_EXCEPTION_ERROR' => 'tcpdf_throw_exception_error',
    ];



    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('royalcms/tcpdf');

        /* override the default TCPDF config file
        ------------------------------------- */
        if (!defined('K_TCPDF_EXTERNAL_CONFIG'))
        {
            define('K_TCPDF_EXTERNAL_CONFIG', TRUE);
        }

        $this->setTcpdfConstants();

        AliasLoader::getInstance()->alias('RC_PDF', 'Royalcms\Component\Tcpdf\Facades\Tcpdf');
    }



    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms['tcpdf'] = $this->royalcms->share(function ($royalcms)
        {
            return new Tcpdf($royalcms);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('tcpdf');
    }

    /**
     * Set TCPDF constants based on configuration file.
     * !Notice! Some contants are never used by TCPDF. They are in the config file of TCPDF, but ...
     * This is a bug by TCPDF but we set it for completeness.
     *
     * @author Markus Schober
     */
    private function setTcpdfConstants()
    {
        foreach ($this->config_constant_map as $const => $configkey)
        {
            if (!defined($const))
            {
                if (is_string(RC_Config::get('tcpdf::config.' . $configkey)))
                {
                    if (strlen(RC_Config::get('tcpdf::config.' . $configkey)) > 0)
                    {
                        define($const, RC_Config::get('tcpdf::config.' . $configkey));
                    }
                }
                else
                {
                    define($const, RC_Config::get('tcpdf::config.' . $configkey));
                }
            }
        }
    }

}
