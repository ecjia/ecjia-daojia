<?php namespace Royalcms\Component\Debugbar\DataCollector;

use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;
use Royalcms\Component\Foundation\Royalcms;

class RoyalcmsCollector extends DataCollector implements Renderable
{
    /** 
     * @var \Royalcms\Component\Foundation\Royalcms $royalcms 
     */
    protected $royalcms;

    /**
     * @param \Royalcms\Component\Foundation\Royalcms $royalcms
     */
    public function __construct(Royalcms $royalcms = null)
    {
        $this->royalcms = $royalcms;
    }

    /**
     * {@inheritDoc}
     */
    public function collect()
    {
        // Fallback if not injected
        $royalcms = $this->royalcms ?: royalcms();

        return array(
            "version" => $royalcms::VERSION,
            "environment" => $royalcms->environment(),
            "locale" => $royalcms->getLocale(),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'royalcms';
    }

    /**
     * {@inheritDoc}
     */
    public function getWidgets()
    {
        return array(
            "version" => array(
                "icon" => "github",
                "tooltip" => "Version",
                "map" => "royalcms.version",
                "default" => ""
            ),
            "environment" => array(
                "icon" => "desktop",
                "tooltip" => "Environment",
                "map" => "royalcms.environment",
                "default" => ""
            ),
            "locale" => array(
                "icon" => "flag",
                "tooltip" => "Current locale",
                "map" => "royalcms.locale",
                "default" => "",
            ),
        );
    }
}
