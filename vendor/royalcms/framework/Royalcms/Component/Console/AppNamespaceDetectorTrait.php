<?php

namespace Royalcms\Component\Console;

use Royalcms\Component\Container\Container;

trait AppNamespaceDetectorTrait
{
    /**
     * Get the application namespace.
     *
     * @return string
     */
    protected function getAppNamespace()
    {
        return Container::getInstance()->getNamespace();
    }
}
