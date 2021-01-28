<?php


namespace Ecjia\Component\ViewPlugin;


class SmartyPluginAbstract
{

    /**
     * plugin type
     * @var string
     */
    protected $type;

    /**
     * name of template tag
     * @var string
     */
    protected $tag;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    //插件执行方法
    abstract public function handle();

}