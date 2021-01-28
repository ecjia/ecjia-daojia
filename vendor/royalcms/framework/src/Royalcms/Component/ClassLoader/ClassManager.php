<?php

namespace Royalcms\Component\ClassLoader;

use Royalcms\Component\Support\Str;

/**
 * Class ClassManager
 * PSR-4
 * @package Royalcms\Component\ClassLoader
 */
class ClassManager
{
    /**
     * @var \Composer\Autoload\ClassLoader
     */
    private static $loader;

    /**
     * 自动注册类加载
     */
    public static function register()
    {
        self::autoLoaderClass();
    }

    /**
     * 实现类的自动加载
     *
     * @return \Composer\Autoload\ClassLoader
     */
    public static function autoLoaderClass()
    {
        if (is_null(self::$loader)) {
            self::$loader = new \Composer\Autoload\ClassLoader();
            self::$loader->register(true);
        }

        return self::$loader;
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        return self::$loader;
    }
    
    /**
     * 手动类和文件加载
     *
     * @param string $class
     */
    public static function import($class)
    {
        if (! self::$loader->loadClass($class)) {
            rc_throw_exception($class . __('加载失败'));
        }
    }
    
    /**
     * Add namespace to the class loader.
     *
     * @param  string|array  $directories
     * @return void
     */
    public static function addNamespace($namespace, $directorie)
    {
        if (! Str::endsWith($namespace, "\\")) {
            $namespace = $namespace . "\\";
        }

        self::$loader->addPsr4($namespace, $directorie);
    }
    
    /**
     * Add namespaces to the class loader.
     *
     * @param  string|array  $directories
     * @return void
     */
    public static function addNamespaces(array $namespaces)
    {
        foreach ($namespaces as $namespace => $directorie) {
            self::addNamespace($namespace, $directorie);
        }
    }
    
    /**
     * Gets all the namespaces registered with the loader.
     *
     * @return array
     */
    public static function getNamespaces()
    {
        return self::$loader->getPrefixesPsr4();
    }
}

// end