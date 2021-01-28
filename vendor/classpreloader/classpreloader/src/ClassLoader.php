<?php

declare(strict_types=1);

/*
 * This file is part of Class Preloader.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 * (c) Michael Dowling <mtdowling@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ClassPreloader;

use ClassPreloader\ClassLoader\ClassList;
use ClassPreloader\ClassLoader\Config;

/**
 * This is the class loader class.
 *
 * This creates an autoloader that intercepts and keeps track of each include
 * in order that files must be included. This autoloader proxies to all other
 * underlying autoloaders.
 */
final class ClassLoader
{
    /**
     * The list of loaded classes.
     *
     * @var \ClassPreloader\ClassLoader\ClassList
     */
    public $classList;

    /**
     * Create a new class loader instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->classList = new ClassList();
    }

    /**
     * Destroy the class loader.
     *
     * This makes sure we're unregistered from the autoloader.
     *
     * @return void
     */
    public function __destruct()
    {
        $this->unregister();
    }

    /**
     * Wrap a block of code in the autoloader and get a list of loaded classes.
     *
     * @param callable $func
     *
     * @return \ClassPreloader\ClassLoader\Config
     */
    public static function getIncludes(callable $func)
    {
        $loader = new self();
        $func($loader);
        $loader->unregister();

        $config = new Config();
        foreach ($loader->getFilenames() as $file) {
            $config->addFile($file);
        }

        return $config;
    }

    /**
     * Registers this instance as an autoloader.
     *
     * @return void
     */
    public function register()
    {
        spl_autoload_register([$this, 'loadClass'], true, true);
    }

    /**
     * Unregisters this instance as an autoloader.
     *
     * @return void
     */
    public function unregister()
    {
        spl_autoload_unregister([$this, 'loadClass']);
    }

    /**
     * Loads the given class, interface or trait.
     *
     * We'll return true if it was loaded.
     *
     * @param string $class
     *
     * @return void
     */
    public function loadClass(string $class)
    {
        $funcs = spl_autoload_functions();

        if ($funcs !== false) {
            foreach ($funcs as $func) {
                if (is_array($func) && $func[0] === $this) {
                    continue;
                }
                $this->classList->push($class);
                if ($func($class)) {
                    break;
                }
            }
        }

        $this->classList->next();
    }

    /**
     * Get an array of loaded file names in order of loading.
     *
     * @return string[]
     */
    public function getFilenames()
    {
        /** @var string[] */
        $files = [];

        foreach ($this->classList->getClasses() as $class) {
            // Push interfaces before classes if not already loaded
            try {
                $r = new \ReflectionClass($class);
                foreach ($r->getInterfaces() as $inf) {
                    $name = $inf->getFileName();
                    if ($name !== false && !in_array($name, $files, true)) {
                        $files[] = $name;
                    }
                }
                $name = $r->getFileName();
                if ($name !== false && !in_array($name, $files, true)) {
                    $files[] = $name;
                }
            } catch (\ReflectionException $e) {
                // We ignore all exceptions related to reflection because in
                // some cases class doesn't need to exist. We're ignoring all
                // problems with classes, interfaces and traits.
            }
        }

        return $files;
    }
}
