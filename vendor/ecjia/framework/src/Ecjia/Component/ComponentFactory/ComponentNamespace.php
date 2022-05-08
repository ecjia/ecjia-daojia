<?php


namespace Ecjia\Component\ComponentFactory;


abstract class ComponentNamespace
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
    abstract protected function getDefaultDir();

    /**
     * 获取默认的命名空间
     */
    abstract protected function getDefaultNamespace();

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