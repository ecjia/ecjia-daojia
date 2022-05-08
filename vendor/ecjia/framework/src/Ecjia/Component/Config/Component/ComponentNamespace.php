<?php


namespace Ecjia\Component\Config\Component;


class ComponentNamespace
{

    protected $dir;
    protected $namespace;

    public function __construct($dir = null, $namespace = null)
    {
        $this->dir = $dir ?: $this->getDefaultDir();
        $this->namespace = $namespace ?: $this->getDefaultNamespace();
    }

    /**
     * 获取默认的目录
     */
    protected function getDefaultDir()
    {
        return royalcms()->resourcePath('components/SettingComponents');
    }

    /**
     * 获取默认的命名空间
     */
    protected function getDefaultNamespace()
    {
        return 'Ecjia\Resources\Components\SettingComponents';
    }

    /**
     * @return string
     */
    public function getDir()
    {
        return str_replace('/', DIRECTORY_SEPARATOR, $this->dir);
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

}