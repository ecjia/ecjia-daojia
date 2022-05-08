<?php


namespace Ecjia\Component\BrowserEvent;


class PageScriptPrint
{

    private $event_manager;

    public function __construct(PageEventManager $event_manager)
    {
        $this->event_manager = $event_manager;
    }

    /**
     * 打印脚本到页面上
     */
    public function printFooterScripts()
    {
        echo '<script type="text/javascript">' . PHP_EOL;
        echo $this->event_manager->getPageScript() . PHP_EOL;
        echo '</script>' . PHP_EOL;
    }

}