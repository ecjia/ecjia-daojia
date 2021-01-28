<?php

namespace Royalcms\Component\App\Contracts;

interface BundlePackage
{
    
    /**
     * 获取目录的绝对路径
     *
     * @param string $name
     */
    public function getAbsolutePath();
    
    
    
    public function getNamespace();
    
    
}