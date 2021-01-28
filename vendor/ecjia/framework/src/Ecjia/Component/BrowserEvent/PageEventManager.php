<?php

namespace Ecjia\Component\BrowserEvent;


class PageEventManager
{
    protected $events;

    protected $page;

    public function __construct($page = 'default')
    {
        $this->page = $page;
    }

    /**
     * 获取所有的事件
     * @return array
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * 获取某个PAGE的事件
     * @param $page
     * @return mixed|null
     */
    public function getEventsByPage($page)
    {
        if (isset($this->events[$page])) {
            return $this->events[$page];
        }
        return null;
    }

    /**
     * 添加页事事件
     * @param $page
     * @param $handler
     * @return $this
     */
    public function addPageHandler($handler)
    {
        $this->events[$this->page][$handler] = new $handler;
        return $this;
    }

    /**
     * 移除页面事件
     * @param $page
     * @param $handler
     * @return $this
     */
    public function removePageHandler($handler)
    {
        unset($this->events[$this->page][$handler]);
        return $this;
    }

    /**
     * 获取页面脚本
     * @param $page
     * @return string
     */
    public function getPageScript()
    {
        $events = $this->getEventsByPage($this->page);
        if ($events) {
            $script = collect($events)->map(function ($event) {
                return $event();
            })->implode(PHP_EOL);
        }
        else {
            $script = '';
        }
        return $script;
    }

}