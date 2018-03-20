<?php 

namespace Royalcms\Component\Tcpdf;

use \TCPDF as BaseTCPDF;
use RC_Config;

class TcpdfHelper extends BaseTCPDF
{
    
    //holds custom header string/html
    protected $headerCallback;
    
    protected $footerCallback;
    
    /**
     * TCPDF system constants that map to settings in our config file
     *
     * @var array
     */
    private $config_constant_map = [
        'K_PATH_CACHE'  => 'cache_directory',
        'K_PATH_IMAGES' => 'image_directory',
        'K_BLANK_IMAGE' => 'blank_image',
        'K_SMALL_RATIO' => 'small_font_ratio'
    ];

    /**
     * Constructor
     */
    public function __construct()
    {
        // Initialize TCPDF
        parent::__construct(
            RC_Config::get('tcpdf::config.page_orientation'),
            RC_Config::get('tcpdf::config.page_unit'),
            RC_Config::get('tcpdf::config.page_format'),
            RC_Config::get('tcpdf::config.unicode'),
            RC_Config::get('tcpdf::config.encoding'),
            RC_Config::get('tcpdf::config.enable_disk_cache')
        );

        // default margin settings
        $this->SetMargins(
            RC_Config::get('tcpdf::config.margin_left'),
            RC_Config::get('tcpdf::config.margin_top'),
            RC_Config::get('tcpdf::config.margin_right')
        );

        // default header setting
        $this->headerSettings();

        // default footer settings
        $this->footerSettings();

        // default page break settings
        $this->SetAutoPageBreak(
            RC_Config::get('tcpdf::config.page_break_auto'),
            RC_Config::get('tcpdf::config.footer_margin')
        );

        // default cell settings
        $this->cellSettings();

        // default document properties
        $this->setDocumentProperties();

        // default page font
        $this->setFont(
            RC_Config::get('tcpdf::config.page_font'),
            '',
            RC_Config::get('tcpdf::config.page_font_size')
        );

        // default image scale
        $this->setImageScale(RC_Config::get('tcpdf::config.image_scale'));
    }

    /**
     * Set all the necessary header settings
     *
     * @author Markus Schober
     */
    protected function headerSettings()
    {
        $this->setPrintHeader(
            RC_Config::get('tcpdf::config.header_on')
        );

        $this->setHeaderFont(array(
            RC_Config::get('tcpdf::config.header_font'),
            '',
            RC_Config::get('tcpdf::config.header_font_size')
        ));

        $this->setHeaderMargin(
            RC_Config::get('tcpdf::config.header_margin')
        );

        $this->SetHeaderData(
            RC_Config::get('tcpdf::config.header_logo'),
            RC_Config::get('tcpdf::config.header_logo_width'),
            RC_Config::get('tcpdf::config.header_title'),
            RC_Config::get('tcpdf::config.header_string')
        );
    }

    /**
     * Set all the necessary footer settings
     *
     * @author Markus Schober
     */
    protected function footerSettings()
    {
        $this->setPrintFooter(
            RC_Config::get('tcpdf::config.footer_on')
        );

        $this->setFooterFont(array(
            RC_Config::get('tcpdf::config.footer_font'),
            '',
            RC_Config::get('tcpdf::config.footer_font_size')
        ));

        $this->setFooterMargin(
            RC_Config::get('tcpdf::config.footer_margin')
        );
    }



    /**
     * Set the default cell settings
     *
     * @author Markus Schober
     */
    protected function cellSettings()
    {
        $this->SetCellPadding(
            RC_Config::get('tcpdf::config.cell_padding')
        );

        $this->setCellHeightRatio(
            RC_Config::get('tcpdf::config.cell_height_ratio')
        );
    }



    /**
     * Set default document properties
     *
     * @author Markus Schober
     */
    protected function setDocumentProperties()
    {
        $this->SetCreator(RC_Config::get('tcpdf::config.creator'));
        $this->SetAuthor(RC_Config::get('tcpdf::config.author'));
    }
    
    /**
     * Custom Header
     * 
     */
    //Customize according to your specification
    public function Header()
    {
        if ($this->headerCallback != null && is_callable($this->headerCallback)) {
            $cb = $this->headerCallback;
            $cb($this);
        }
    }
    
    public function Footer()
    {
        if ($this->footerCallback != null && is_callable($this->footerCallback)) {
            $cb = $this->footerCallback;
            $cb($this);
        }
    }
    
    public function setHeaderCallback($callback)
    {
        $this->headerCallback = $callback;
    }
    
    public function setFooterCallback($callback)
    {
        $this->footerCallback = $callback;
    }
     
}
