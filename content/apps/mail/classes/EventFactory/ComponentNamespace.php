<?php


namespace Ecjia\App\Mail\EventFactory;


class ComponentNamespace extends \Ecjia\Component\ComponentFactory\ComponentNamespace
{

    /**
     * 获取默认的目录
     */
    protected function getDefaultDir()
    {
        return royalcms()->resourcePath('components/MailEvents');
    }

    /**
     * 获取默认的命名空间
     */
    protected function getDefaultNamespace()
    {
        return 'Ecjia\Resources\Components\MailEvents';
    }

}