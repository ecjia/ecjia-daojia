<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel;

use Symfony\Bridge\ProxyManager\LazyProxy\Instantiator\RuntimeInstantiator;
use Symfony\Bridge\ProxyManager\LazyProxy\PhpDumper\ProxyDumper;
<<<<<<< HEAD
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Loader\IniFileLoader;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\ClosureLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Config\EnvParametersResource;
use Symfony\Component\HttpKernel\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\MergeExtensionConfigurationPass;
use Symfony\Component\HttpKernel\DependencyInjection\AddClassesToCachePass;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\ClassLoader\ClassCollectionLoader;
=======
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Debug\DebugClassLoader as LegacyDebugClassLoader;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Dumper\Preloader;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\ClosureLoader;
use Symfony\Component\DependencyInjection\Loader\DirectoryLoader;
use Symfony\Component\DependencyInjection\Loader\GlobFileLoader;
use Symfony\Component\DependencyInjection\Loader\IniFileLoader;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\ErrorHandler\DebugClassLoader;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\CacheWarmer\WarmableInterface;
use Symfony\Component\HttpKernel\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\AddAnnotatedClassesToCachePass;
use Symfony\Component\HttpKernel\DependencyInjection\MergeExtensionConfigurationPass;

// Help opcache.preload discover always-needed symbols
class_exists(ConfigCache::class);
>>>>>>> v2-test

/**
 * The Kernel is the heart of the Symfony system.
 *
 * It manages an environment made of bundles.
 *
<<<<<<< HEAD
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class Kernel implements KernelInterface, TerminableInterface
=======
 * Environment names must always start with a letter and
 * they must only contain letters and numbers.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class Kernel implements KernelInterface, RebootableInterface, TerminableInterface
>>>>>>> v2-test
{
    /**
     * @var BundleInterface[]
     */
<<<<<<< HEAD
    protected $bundles = array();

    protected $bundleMap;
    protected $container;
    protected $rootDir;
    protected $environment;
    protected $debug;
    protected $booted = false;
    protected $name;
    protected $startTime;
    protected $loadClassCache;

    const VERSION = '2.7.18';
    const VERSION_ID = 20718;
    const MAJOR_VERSION = 2;
    const MINOR_VERSION = 7;
    const RELEASE_VERSION = 18;
    const EXTRA_VERSION = '';

    const END_OF_MAINTENANCE = '05/2018';
    const END_OF_LIFE = '05/2019';

    /**
     * Constructor.
     *
     * @param string $environment The environment
     * @param bool   $debug       Whether to enable debugging or not
     */
    public function __construct($environment, $debug)
    {
        $this->environment = $environment;
        $this->debug = (bool) $debug;
        $this->rootDir = $this->getRootDir();
        $this->name = $this->getName();

        if ($this->debug) {
            $this->startTime = microtime(true);
        }

        $defClass = new \ReflectionMethod($this, 'init');
        $defClass = $defClass->getDeclaringClass()->name;

        if (__CLASS__ !== $defClass) {
            @trigger_error(sprintf('Calling the %s::init() method is deprecated since version 2.3 and will be removed in 3.0. Move your logic to the constructor method instead.', $defClass), E_USER_DEPRECATED);
            $this->init();
        }
    }

    /**
     * @deprecated since version 2.3, to be removed in 3.0. Move your logic in the constructor instead.
     */
    public function init()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 2.3 and will be removed in 3.0. Move your logic to the constructor method instead.', E_USER_DEPRECATED);
=======
    protected $bundles = [];

    protected $container;
    protected $environment;
    protected $debug;
    protected $booted = false;
    protected $startTime;

    private $projectDir;
    private $warmupDir;
    private $requestStackSize = 0;
    private $resetServices = false;

    private static $freshCache = [];

    public const VERSION = '5.2.2';
    public const VERSION_ID = 50202;
    public const MAJOR_VERSION = 5;
    public const MINOR_VERSION = 2;
    public const RELEASE_VERSION = 2;
    public const EXTRA_VERSION = '';

    public const END_OF_MAINTENANCE = '07/2021';
    public const END_OF_LIFE = '07/2021';

    public function __construct(string $environment, bool $debug)
    {
        $this->environment = $environment;
        $this->debug = $debug;
>>>>>>> v2-test
    }

    public function __clone()
    {
<<<<<<< HEAD
        if ($this->debug) {
            $this->startTime = microtime(true);
        }

        $this->booted = false;
        $this->container = null;
    }

    /**
     * Boots the current kernel.
=======
        $this->booted = false;
        $this->container = null;
        $this->requestStackSize = 0;
        $this->resetServices = false;
    }

    /**
     * {@inheritdoc}
>>>>>>> v2-test
     */
    public function boot()
    {
        if (true === $this->booted) {
<<<<<<< HEAD
            return;
        }

        if ($this->loadClassCache) {
            $this->doLoadClassCache($this->loadClassCache[0], $this->loadClassCache[1]);
        }

        // init bundles
        $this->initializeBundles();

        // init container
        $this->initializeContainer();

=======
            if (!$this->requestStackSize && $this->resetServices) {
                if ($this->container->has('services_resetter')) {
                    $this->container->get('services_resetter')->reset();
                }
                $this->resetServices = false;
                if ($this->debug) {
                    $this->startTime = microtime(true);
                }
            }

            return;
        }

        if (null === $this->container) {
            $this->preBoot();
        }

>>>>>>> v2-test
        foreach ($this->getBundles() as $bundle) {
            $bundle->setContainer($this->container);
            $bundle->boot();
        }

        $this->booted = true;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
=======
    public function reboot(?string $warmupDir)
    {
        $this->shutdown();
        $this->warmupDir = $warmupDir;
        $this->boot();
    }

    /**
     * {@inheritdoc}
     */
>>>>>>> v2-test
    public function terminate(Request $request, Response $response)
    {
        if (false === $this->booted) {
            return;
        }

        if ($this->getHttpKernel() instanceof TerminableInterface) {
            $this->getHttpKernel()->terminate($request, $response);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function shutdown()
    {
        if (false === $this->booted) {
            return;
        }

        $this->booted = false;

        foreach ($this->getBundles() as $bundle) {
            $bundle->shutdown();
            $bundle->setContainer(null);
        }

        $this->container = null;
<<<<<<< HEAD
=======
        $this->requestStackSize = 0;
        $this->resetServices = false;
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        if (false === $this->booted) {
            $this->boot();
        }

        return $this->getHttpKernel()->handle($request, $type, $catch);
=======
    public function handle(Request $request, int $type = HttpKernelInterface::MASTER_REQUEST, bool $catch = true)
    {
        if (!$this->booted) {
            $container = $this->container ?? $this->preBoot();

            if ($container->has('http_cache')) {
                return $container->get('http_cache')->handle($request, $type, $catch);
            }
        }

        $this->boot();
        ++$this->requestStackSize;
        $this->resetServices = true;

        try {
            return $this->getHttpKernel()->handle($request, $type, $catch);
        } finally {
            --$this->requestStackSize;
        }
>>>>>>> v2-test
    }

    /**
     * Gets a HTTP kernel from the container.
     *
<<<<<<< HEAD
     * @return HttpKernel
=======
     * @return HttpKernelInterface
>>>>>>> v2-test
     */
    protected function getHttpKernel()
    {
        return $this->container->get('http_kernel');
    }

    /**
     * {@inheritdoc}
     */
    public function getBundles()
    {
        return $this->bundles;
    }

    /**
     * {@inheritdoc}
<<<<<<< HEAD
     *
     * @deprecated since version 2.6, to be removed in 3.0.
     */
    public function isClassInActiveBundle($class)
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 2.6 and will be removed in version 3.0.', E_USER_DEPRECATED);

        foreach ($this->getBundles() as $bundle) {
            if (0 === strpos($class, $bundle->getNamespace())) {
                return true;
            }
        }

        return false;
=======
     */
    public function getBundle(string $name)
    {
        if (!isset($this->bundles[$name])) {
            throw new \InvalidArgumentException(sprintf('Bundle "%s" does not exist or it is not enabled. Maybe you forgot to add it in the "registerBundles()" method of your "%s.php" file?', $name, get_debug_type($this)));
        }

        return $this->bundles[$name];
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getBundle($name, $first = true)
    {
        if (!isset($this->bundleMap[$name])) {
            throw new \InvalidArgumentException(sprintf('Bundle "%s" does not exist or it is not enabled. Maybe you forgot to add it in the registerBundles() method of your %s.php file?', $name, get_class($this)));
        }

        if (true === $first) {
            return $this->bundleMap[$name][0];
        }

        return $this->bundleMap[$name];
    }

    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException if a custom resource is hidden by a resource in a derived bundle
     */
    public function locateResource($name, $dir = null, $first = true)
=======
    public function locateResource(string $name)
>>>>>>> v2-test
    {
        if ('@' !== $name[0]) {
            throw new \InvalidArgumentException(sprintf('A resource name must start with @ ("%s" given).', $name));
        }

        if (false !== strpos($name, '..')) {
            throw new \RuntimeException(sprintf('File name "%s" contains invalid characters (..).', $name));
        }

        $bundleName = substr($name, 1);
        $path = '';
        if (false !== strpos($bundleName, '/')) {
<<<<<<< HEAD
            list($bundleName, $path) = explode('/', $bundleName, 2);
        }

        $isResource = 0 === strpos($path, 'Resources') && null !== $dir;
        $overridePath = substr($path, 9);
        $resourceBundle = null;
        $bundles = $this->getBundle($bundleName, false);
        $files = array();

        foreach ($bundles as $bundle) {
            if ($isResource && file_exists($file = $dir.'/'.$bundle->getName().$overridePath)) {
                if (null !== $resourceBundle) {
                    throw new \RuntimeException(sprintf('"%s" resource is hidden by a resource from the "%s" derived bundle. Create a "%s" file to override the bundle resource.',
                        $file,
                        $resourceBundle,
                        $dir.'/'.$bundles[0]->getName().$overridePath
                    ));
                }

                if ($first) {
                    return $file;
                }
                $files[] = $file;
            }

            if (file_exists($file = $bundle->getPath().'/'.$path)) {
                if ($first && !$isResource) {
                    return $file;
                }
                $files[] = $file;
                $resourceBundle = $bundle->getName();
            }
        }

        if (count($files) > 0) {
            return $first && $isResource ? $files[0] : $files;
=======
            [$bundleName, $path] = explode('/', $bundleName, 2);
        }

        $bundle = $this->getBundle($bundleName);
        if (file_exists($file = $bundle->getPath().'/'.$path)) {
            return $file;
>>>>>>> v2-test
        }

        throw new \InvalidArgumentException(sprintf('Unable to find file "%s".', $name));
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getName()
    {
        if (null === $this->name) {
            $this->name = preg_replace('/[^a-zA-Z0-9_]+/', '', basename($this->rootDir));
        }

        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
=======
>>>>>>> v2-test
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * {@inheritdoc}
     */
    public function isDebug()
    {
        return $this->debug;
    }

    /**
<<<<<<< HEAD
     * {@inheritdoc}
     */
    public function getRootDir()
    {
        if (null === $this->rootDir) {
            $r = new \ReflectionObject($this);
            $this->rootDir = dirname($r->getFileName());
        }

        return $this->rootDir;
=======
     * Gets the application root dir (path of the project's composer file).
     *
     * @return string The project root dir
     */
    public function getProjectDir()
    {
        if (null === $this->projectDir) {
            $r = new \ReflectionObject($this);

            if (!is_file($dir = $r->getFileName())) {
                throw new \LogicException(sprintf('Cannot auto-detect project dir for kernel of class "%s".', $r->name));
            }

            $dir = $rootDir = \dirname($dir);
            while (!is_file($dir.'/composer.json')) {
                if ($dir === \dirname($dir)) {
                    return $this->projectDir = $rootDir;
                }
                $dir = \dirname($dir);
            }
            $this->projectDir = $dir;
        }

        return $this->projectDir;
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
    public function getContainer()
    {
<<<<<<< HEAD
=======
        if (!$this->container) {
            throw new \LogicException('Cannot retrieve the container from a non-booted kernel.');
        }

>>>>>>> v2-test
        return $this->container;
    }

    /**
<<<<<<< HEAD
     * Loads the PHP class cache.
     *
     * This methods only registers the fact that you want to load the cache classes.
     * The cache will actually only be loaded when the Kernel is booted.
     *
     * That optimization is mainly useful when using the HttpCache class in which
     * case the class cache is not loaded if the Response is in the cache.
     *
     * @param string $name      The cache name prefix
     * @param string $extension File extension of the resulting file
     */
    public function loadClassCache($name = 'classes', $extension = '.php')
    {
        $this->loadClassCache = array($name, $extension);
    }

    /**
     * Used internally.
     */
    public function setClassCache(array $classes)
    {
        file_put_contents($this->getCacheDir().'/classes.map', sprintf('<?php return %s;', var_export($classes, true)));
=======
     * @internal
     */
    public function setAnnotatedClassCache(array $annotatedClasses)
    {
        file_put_contents(($this->warmupDir ?: $this->getBuildDir()).'/annotations.map', sprintf('<?php return %s;', var_export($annotatedClasses, true)));
    }

    /**
     * {@inheritdoc}
     */
    public function getStartTime()
    {
        return $this->debug && null !== $this->startTime ? $this->startTime : -\INF;
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getStartTime()
    {
        return $this->debug ? $this->startTime : -INF;
=======
    public function getCacheDir()
    {
        return $this->getProjectDir().'/var/cache/'.$this->environment;
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getCacheDir()
    {
        return $this->rootDir.'/cache/'.$this->environment;
=======
    public function getBuildDir(): string
    {
        // Returns $this->getCacheDir() for backward compatibility
        return $this->getCacheDir();
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir()
    {
<<<<<<< HEAD
        return $this->rootDir.'/logs';
=======
        return $this->getProjectDir().'/var/log';
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
    public function getCharset()
    {
        return 'UTF-8';
    }

<<<<<<< HEAD
    protected function doLoadClassCache($name, $extension)
    {
        if (!$this->booted && is_file($this->getCacheDir().'/classes.map')) {
            ClassCollectionLoader::load(include($this->getCacheDir().'/classes.map'), $this->getCacheDir(), $name, $this->debug, false, $extension);
        }
    }

    /**
     * Initializes the data structures related to the bundle management.
     *
     *  - the bundles property maps a bundle name to the bundle instance,
     *  - the bundleMap property maps a bundle name to the bundle inheritance hierarchy (most derived bundle first).
     *
     * @throws \LogicException if two bundles share a common name
     * @throws \LogicException if a bundle tries to extend a non-registered bundle
     * @throws \LogicException if a bundle tries to extend itself
     * @throws \LogicException if two bundles extend the same ancestor
=======
    /**
     * Gets the patterns defining the classes to parse and cache for annotations.
     */
    public function getAnnotatedClassesToCompile(): array
    {
        return [];
    }

    /**
     * Initializes bundles.
     *
     * @throws \LogicException if two bundles share a common name
>>>>>>> v2-test
     */
    protected function initializeBundles()
    {
        // init bundles
<<<<<<< HEAD
        $this->bundles = array();
        $topMostBundles = array();
        $directChildren = array();

        foreach ($this->registerBundles() as $bundle) {
            $name = $bundle->getName();
            if (isset($this->bundles[$name])) {
                throw new \LogicException(sprintf('Trying to register two bundles with the same name "%s"', $name));
            }
            $this->bundles[$name] = $bundle;

            if ($parentName = $bundle->getParent()) {
                if (isset($directChildren[$parentName])) {
                    throw new \LogicException(sprintf('Bundle "%s" is directly extended by two bundles "%s" and "%s".', $parentName, $name, $directChildren[$parentName]));
                }
                if ($parentName == $name) {
                    throw new \LogicException(sprintf('Bundle "%s" can not extend itself.', $name));
                }
                $directChildren[$parentName] = $name;
            } else {
                $topMostBundles[$name] = $bundle;
            }
        }

        // look for orphans
        if (!empty($directChildren) && count($diff = array_diff_key($directChildren, $this->bundles))) {
            $diff = array_keys($diff);

            throw new \LogicException(sprintf('Bundle "%s" extends bundle "%s", which is not registered.', $directChildren[$diff[0]], $diff[0]));
        }

        // inheritance
        $this->bundleMap = array();
        foreach ($topMostBundles as $name => $bundle) {
            $bundleMap = array($bundle);
            $hierarchy = array($name);

            while (isset($directChildren[$name])) {
                $name = $directChildren[$name];
                array_unshift($bundleMap, $this->bundles[$name]);
                $hierarchy[] = $name;
            }

            foreach ($hierarchy as $hierarchyBundle) {
                $this->bundleMap[$hierarchyBundle] = $bundleMap;
                array_pop($bundleMap);
            }
        }
=======
        $this->bundles = [];
        foreach ($this->registerBundles() as $bundle) {
            $name = $bundle->getName();
            if (isset($this->bundles[$name])) {
                throw new \LogicException(sprintf('Trying to register two bundles with the same name "%s".', $name));
            }
            $this->bundles[$name] = $bundle;
        }
    }

    /**
     * The extension point similar to the Bundle::build() method.
     *
     * Use this method to register compiler passes and manipulate the container during the building process.
     */
    protected function build(ContainerBuilder $container)
    {
>>>>>>> v2-test
    }

    /**
     * Gets the container class.
     *
<<<<<<< HEAD
=======
     * @throws \InvalidArgumentException If the generated classname is invalid
     *
>>>>>>> v2-test
     * @return string The container class
     */
    protected function getContainerClass()
    {
<<<<<<< HEAD
        return $this->name.ucfirst($this->environment).($this->debug ? 'Debug' : '').'ProjectContainer';
=======
        $class = static::class;
        $class = false !== strpos($class, "@anonymous\0") ? get_parent_class($class).str_replace('.', '_', ContainerBuilder::hash($class)) : $class;
        $class = str_replace('\\', '_', $class).ucfirst($this->environment).($this->debug ? 'Debug' : '').'Container';

        if (!preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $class)) {
            throw new \InvalidArgumentException(sprintf('The environment "%s" contains invalid characters, it can only contain characters allowed in PHP class names.', $this->environment));
        }

        return $class;
>>>>>>> v2-test
    }

    /**
     * Gets the container's base class.
     *
     * All names except Container must be fully qualified.
     *
     * @return string
     */
    protected function getContainerBaseClass()
    {
        return 'Container';
    }

    /**
     * Initializes the service container.
     *
<<<<<<< HEAD
     * The cached version of the service container is used when fresh, otherwise the
=======
     * The built version of the service container is used when fresh, otherwise the
>>>>>>> v2-test
     * container is built.
     */
    protected function initializeContainer()
    {
        $class = $this->getContainerClass();
<<<<<<< HEAD
        $cache = new ConfigCache($this->getCacheDir().'/'.$class.'.php', $this->debug);
        $fresh = true;
        if (!$cache->isFresh()) {
            $container = $this->buildContainer();
            $container->compile();
            $this->dumpContainer($cache, $container, $class, $this->getContainerBaseClass());

            $fresh = false;
        }

        require_once $cache->getPath();

        $this->container = new $class();
        $this->container->set('kernel', $this);

        if (!$fresh && $this->container->has('cache_warmer')) {
            $this->container->get('cache_warmer')->warmUp($this->container->getParameter('kernel.cache_dir'));
=======
        $buildDir = $this->warmupDir ?: $this->getBuildDir();
        $cache = new ConfigCache($buildDir.'/'.$class.'.php', $this->debug);
        $cachePath = $cache->getPath();

        // Silence E_WARNING to ignore "include" failures - don't use "@" to prevent silencing fatal errors
        $errorLevel = error_reporting(\E_ALL ^ \E_WARNING);

        try {
            if (is_file($cachePath) && \is_object($this->container = include $cachePath)
                && (!$this->debug || (self::$freshCache[$cachePath] ?? $cache->isFresh()))
            ) {
                self::$freshCache[$cachePath] = true;
                $this->container->set('kernel', $this);
                error_reporting($errorLevel);

                return;
            }
        } catch (\Throwable $e) {
        }

        $oldContainer = \is_object($this->container) ? new \ReflectionClass($this->container) : $this->container = null;

        try {
            is_dir($buildDir) ?: mkdir($buildDir, 0777, true);

            if ($lock = fopen($cachePath.'.lock', 'w')) {
                flock($lock, \LOCK_EX | \LOCK_NB, $wouldBlock);

                if (!flock($lock, $wouldBlock ? \LOCK_SH : \LOCK_EX)) {
                    fclose($lock);
                    $lock = null;
                } elseif (!\is_object($this->container = include $cachePath)) {
                    $this->container = null;
                } elseif (!$oldContainer || \get_class($this->container) !== $oldContainer->name) {
                    flock($lock, \LOCK_UN);
                    fclose($lock);
                    $this->container->set('kernel', $this);

                    return;
                }
            }
        } catch (\Throwable $e) {
        } finally {
            error_reporting($errorLevel);
        }

        if ($collectDeprecations = $this->debug && !\defined('PHPUNIT_COMPOSER_INSTALL')) {
            $collectedLogs = [];
            $previousHandler = set_error_handler(function ($type, $message, $file, $line) use (&$collectedLogs, &$previousHandler) {
                if (\E_USER_DEPRECATED !== $type && \E_DEPRECATED !== $type) {
                    return $previousHandler ? $previousHandler($type, $message, $file, $line) : false;
                }

                if (isset($collectedLogs[$message])) {
                    ++$collectedLogs[$message]['count'];

                    return null;
                }

                $backtrace = debug_backtrace(\DEBUG_BACKTRACE_IGNORE_ARGS, 5);
                // Clean the trace by removing first frames added by the error handler itself.
                for ($i = 0; isset($backtrace[$i]); ++$i) {
                    if (isset($backtrace[$i]['file'], $backtrace[$i]['line']) && $backtrace[$i]['line'] === $line && $backtrace[$i]['file'] === $file) {
                        $backtrace = \array_slice($backtrace, 1 + $i);
                        break;
                    }
                }
                for ($i = 0; isset($backtrace[$i]); ++$i) {
                    if (!isset($backtrace[$i]['file'], $backtrace[$i]['line'], $backtrace[$i]['function'])) {
                        continue;
                    }
                    if (!isset($backtrace[$i]['class']) && 'trigger_deprecation' === $backtrace[$i]['function']) {
                        $file = $backtrace[$i]['file'];
                        $line = $backtrace[$i]['line'];
                        $backtrace = \array_slice($backtrace, 1 + $i);
                        break;
                    }
                }

                // Remove frames added by DebugClassLoader.
                for ($i = \count($backtrace) - 2; 0 < $i; --$i) {
                    if (\in_array($backtrace[$i]['class'] ?? null, [DebugClassLoader::class, LegacyDebugClassLoader::class], true)) {
                        $backtrace = [$backtrace[$i + 1]];
                        break;
                    }
                }

                $collectedLogs[$message] = [
                    'type' => $type,
                    'message' => $message,
                    'file' => $file,
                    'line' => $line,
                    'trace' => [$backtrace[0]],
                    'count' => 1,
                ];

                return null;
            });
        }

        try {
            $container = null;
            $container = $this->buildContainer();
            $container->compile();
        } finally {
            if ($collectDeprecations) {
                restore_error_handler();

                file_put_contents($buildDir.'/'.$class.'Deprecations.log', serialize(array_values($collectedLogs)));
                file_put_contents($buildDir.'/'.$class.'Compiler.log', null !== $container ? implode("\n", $container->getCompiler()->getLog()) : '');
            }
        }

        $this->dumpContainer($cache, $container, $class, $this->getContainerBaseClass());

        if ($lock) {
            flock($lock, \LOCK_UN);
            fclose($lock);
        }

        $this->container = require $cachePath;
        $this->container->set('kernel', $this);

        if ($oldContainer && \get_class($this->container) !== $oldContainer->name) {
            // Because concurrent requests might still be using them,
            // old container files are not removed immediately,
            // but on a next dump of the container.
            static $legacyContainers = [];
            $oldContainerDir = \dirname($oldContainer->getFileName());
            $legacyContainers[$oldContainerDir.'.legacy'] = true;
            foreach (glob(\dirname($oldContainerDir).\DIRECTORY_SEPARATOR.'*.legacy', \GLOB_NOSORT) as $legacyContainer) {
                if (!isset($legacyContainers[$legacyContainer]) && @unlink($legacyContainer)) {
                    (new Filesystem())->remove(substr($legacyContainer, 0, -7));
                }
            }

            touch($oldContainerDir.'.legacy');
        }

        $preload = $this instanceof WarmableInterface ? (array) $this->warmUp($this->container->getParameter('kernel.cache_dir')) : [];

        if ($this->container->has('cache_warmer')) {
            $preload = array_merge($preload, (array) $this->container->get('cache_warmer')->warmUp($this->container->getParameter('kernel.cache_dir')));
        }

        if ($preload && method_exists(Preloader::class, 'append') && file_exists($preloadFile = $buildDir.'/'.$class.'.preload.php')) {
            Preloader::append($preloadFile, $preload);
>>>>>>> v2-test
        }
    }

    /**
     * Returns the kernel parameters.
     *
     * @return array An array of kernel parameters
     */
    protected function getKernelParameters()
    {
<<<<<<< HEAD
        $bundles = array();
        foreach ($this->bundles as $name => $bundle) {
            $bundles[$name] = get_class($bundle);
        }

        return array_merge(
            array(
                'kernel.root_dir' => realpath($this->rootDir) ?: $this->rootDir,
                'kernel.environment' => $this->environment,
                'kernel.debug' => $this->debug,
                'kernel.name' => $this->name,
                'kernel.cache_dir' => realpath($this->getCacheDir()) ?: $this->getCacheDir(),
                'kernel.logs_dir' => realpath($this->getLogDir()) ?: $this->getLogDir(),
                'kernel.bundles' => $bundles,
                'kernel.charset' => $this->getCharset(),
                'kernel.container_class' => $this->getContainerClass(),
            ),
            $this->getEnvParameters()
        );
    }

    /**
     * Gets the environment parameters.
     *
     * Only the parameters starting with "SYMFONY__" are considered.
     *
     * @return array An array of parameters
     */
    protected function getEnvParameters()
    {
        $parameters = array();
        foreach ($_SERVER as $key => $value) {
            if (0 === strpos($key, 'SYMFONY__')) {
                $parameters[strtolower(str_replace('__', '.', substr($key, 9)))] = $value;
            }
        }

        return $parameters;
=======
        $bundles = [];
        $bundlesMetadata = [];

        foreach ($this->bundles as $name => $bundle) {
            $bundles[$name] = \get_class($bundle);
            $bundlesMetadata[$name] = [
                'path' => $bundle->getPath(),
                'namespace' => $bundle->getNamespace(),
            ];
        }

        return [
            'kernel.project_dir' => realpath($this->getProjectDir()) ?: $this->getProjectDir(),
            'kernel.environment' => $this->environment,
            'kernel.runtime_environment' => '%env(default:kernel.environment:APP_RUNTIME_ENV)%',
            'kernel.debug' => $this->debug,
            'kernel.build_dir' => realpath($buildDir = $this->warmupDir ?: $this->getBuildDir()) ?: $buildDir,
            'kernel.cache_dir' => realpath($cacheDir = ($this->getCacheDir() === $this->getBuildDir() ? ($this->warmupDir ?: $this->getCacheDir()) : $this->getCacheDir())) ?: $cacheDir,
            'kernel.logs_dir' => realpath($this->getLogDir()) ?: $this->getLogDir(),
            'kernel.bundles' => $bundles,
            'kernel.bundles_metadata' => $bundlesMetadata,
            'kernel.charset' => $this->getCharset(),
            'kernel.container_class' => $this->getContainerClass(),
        ];
>>>>>>> v2-test
    }

    /**
     * Builds the service container.
     *
     * @return ContainerBuilder The compiled service container
     *
     * @throws \RuntimeException
     */
    protected function buildContainer()
    {
<<<<<<< HEAD
        foreach (array('cache' => $this->getCacheDir(), 'logs' => $this->getLogDir()) as $name => $dir) {
            if (!is_dir($dir)) {
                if (false === @mkdir($dir, 0777, true) && !is_dir($dir)) {
                    throw new \RuntimeException(sprintf("Unable to create the %s directory (%s)\n", $name, $dir));
                }
            } elseif (!is_writable($dir)) {
                throw new \RuntimeException(sprintf("Unable to write in the %s directory (%s)\n", $name, $dir));
=======
        foreach (['cache' => $this->getCacheDir(), 'build' => $this->warmupDir ?: $this->getBuildDir(), 'logs' => $this->getLogDir()] as $name => $dir) {
            if (!is_dir($dir)) {
                if (false === @mkdir($dir, 0777, true) && !is_dir($dir)) {
                    throw new \RuntimeException(sprintf('Unable to create the "%s" directory (%s).', $name, $dir));
                }
            } elseif (!is_writable($dir)) {
                throw new \RuntimeException(sprintf('Unable to write in the "%s" directory (%s).', $name, $dir));
>>>>>>> v2-test
            }
        }

        $container = $this->getContainerBuilder();
        $container->addObjectResource($this);
        $this->prepareContainer($container);

        if (null !== $cont = $this->registerContainerConfiguration($this->getContainerLoader($container))) {
            $container->merge($cont);
        }

<<<<<<< HEAD
        $container->addCompilerPass(new AddClassesToCachePass($this));
        $container->addResource(new EnvParametersResource('SYMFONY__'));
=======
        $container->addCompilerPass(new AddAnnotatedClassesToCachePass($this));
>>>>>>> v2-test

        return $container;
    }

    /**
     * Prepares the ContainerBuilder before it is compiled.
<<<<<<< HEAD
     *
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    protected function prepareContainer(ContainerBuilder $container)
    {
        $extensions = array();
        foreach ($this->bundles as $bundle) {
            if ($extension = $bundle->getContainerExtension()) {
                $container->registerExtension($extension);
                $extensions[] = $extension->getAlias();
=======
     */
    protected function prepareContainer(ContainerBuilder $container)
    {
        $extensions = [];
        foreach ($this->bundles as $bundle) {
            if ($extension = $bundle->getContainerExtension()) {
                $container->registerExtension($extension);
>>>>>>> v2-test
            }

            if ($this->debug) {
                $container->addObjectResource($bundle);
            }
        }
<<<<<<< HEAD
=======

>>>>>>> v2-test
        foreach ($this->bundles as $bundle) {
            $bundle->build($container);
        }

<<<<<<< HEAD
=======
        $this->build($container);

        foreach ($container->getExtensions() as $extension) {
            $extensions[] = $extension->getAlias();
        }

>>>>>>> v2-test
        // ensure these extensions are implicitly loaded
        $container->getCompilerPassConfig()->setMergePass(new MergeExtensionConfigurationPass($extensions));
    }

    /**
     * Gets a new ContainerBuilder instance used to build the service container.
     *
     * @return ContainerBuilder
     */
    protected function getContainerBuilder()
    {
<<<<<<< HEAD
        $container = new ContainerBuilder(new ParameterBag($this->getKernelParameters()));

        if (class_exists('ProxyManager\Configuration') && class_exists('Symfony\Bridge\ProxyManager\LazyProxy\Instantiator\RuntimeInstantiator')) {
=======
        $container = new ContainerBuilder();
        $container->getParameterBag()->add($this->getKernelParameters());

        if ($this instanceof ExtensionInterface) {
            $container->registerExtension($this);
        }
        if ($this instanceof CompilerPassInterface) {
            $container->addCompilerPass($this, PassConfig::TYPE_BEFORE_OPTIMIZATION, -10000);
        }
        if (class_exists(\ProxyManager\Configuration::class) && class_exists(RuntimeInstantiator::class)) {
>>>>>>> v2-test
            $container->setProxyInstantiator(new RuntimeInstantiator());
        }

        return $container;
    }

    /**
     * Dumps the service container to PHP code in the cache.
     *
<<<<<<< HEAD
     * @param ConfigCache      $cache     The config cache
     * @param ContainerBuilder $container The service container
     * @param string           $class     The name of the class to generate
     * @param string           $baseClass The name of the container's base class
     */
    protected function dumpContainer(ConfigCache $cache, ContainerBuilder $container, $class, $baseClass)
=======
     * @param string $class     The name of the class to generate
     * @param string $baseClass The name of the container's base class
     */
    protected function dumpContainer(ConfigCache $cache, ContainerBuilder $container, string $class, string $baseClass)
>>>>>>> v2-test
    {
        // cache the container
        $dumper = new PhpDumper($container);

<<<<<<< HEAD
        if (class_exists('ProxyManager\Configuration') && class_exists('Symfony\Bridge\ProxyManager\LazyProxy\PhpDumper\ProxyDumper')) {
            $dumper->setProxyDumper(new ProxyDumper(md5($cache->getPath())));
        }

        $content = $dumper->dump(array('class' => $class, 'base_class' => $baseClass, 'file' => $cache->getPath(), 'debug' => $this->debug));

        $cache->write($content, $container->getResources());
=======
        if (class_exists(\ProxyManager\Configuration::class) && class_exists(ProxyDumper::class)) {
            $dumper->setProxyDumper(new ProxyDumper());
        }

        $content = $dumper->dump([
            'class' => $class,
            'base_class' => $baseClass,
            'file' => $cache->getPath(),
            'as_files' => true,
            'debug' => $this->debug,
            'build_time' => $container->hasParameter('kernel.container_build_time') ? $container->getParameter('kernel.container_build_time') : time(),
            'preload_classes' => array_map('get_class', $this->bundles),
        ]);

        $rootCode = array_pop($content);
        $dir = \dirname($cache->getPath()).'/';
        $fs = new Filesystem();

        foreach ($content as $file => $code) {
            $fs->dumpFile($dir.$file, $code);
            @chmod($dir.$file, 0666 & ~umask());
        }
        $legacyFile = \dirname($dir.key($content)).'.legacy';
        if (is_file($legacyFile)) {
            @unlink($legacyFile);
        }

        $cache->write($rootCode, $container->getResources());
>>>>>>> v2-test
    }

    /**
     * Returns a loader for the container.
     *
<<<<<<< HEAD
     * @param ContainerInterface $container The service container
     *
=======
>>>>>>> v2-test
     * @return DelegatingLoader The loader
     */
    protected function getContainerLoader(ContainerInterface $container)
    {
        $locator = new FileLocator($this);
<<<<<<< HEAD
        $resolver = new LoaderResolver(array(
=======
        $resolver = new LoaderResolver([
>>>>>>> v2-test
            new XmlFileLoader($container, $locator),
            new YamlFileLoader($container, $locator),
            new IniFileLoader($container, $locator),
            new PhpFileLoader($container, $locator),
<<<<<<< HEAD
            new ClosureLoader($container),
        ));
=======
            new GlobFileLoader($container, $locator),
            new DirectoryLoader($container, $locator),
            new ClosureLoader($container),
        ]);
>>>>>>> v2-test

        return new DelegatingLoader($resolver);
    }

<<<<<<< HEAD
=======
    private function preBoot(): ContainerInterface
    {
        if ($this->debug) {
            $this->startTime = microtime(true);
        }
        if ($this->debug && !isset($_ENV['SHELL_VERBOSITY']) && !isset($_SERVER['SHELL_VERBOSITY'])) {
            putenv('SHELL_VERBOSITY=3');
            $_ENV['SHELL_VERBOSITY'] = 3;
            $_SERVER['SHELL_VERBOSITY'] = 3;
        }

        $this->initializeBundles();
        $this->initializeContainer();

        $container = $this->container;

        if ($container->hasParameter('kernel.trusted_hosts') && $trustedHosts = $container->getParameter('kernel.trusted_hosts')) {
            Request::setTrustedHosts($trustedHosts);
        }

        if ($container->hasParameter('kernel.trusted_proxies') && $container->hasParameter('kernel.trusted_headers') && $trustedProxies = $container->getParameter('kernel.trusted_proxies')) {
            Request::setTrustedProxies(\is_array($trustedProxies) ? $trustedProxies : array_map('trim', explode(',', $trustedProxies)), $container->getParameter('kernel.trusted_headers'));
        }

        return $container;
    }

>>>>>>> v2-test
    /**
     * Removes comments from a PHP source string.
     *
     * We don't use the PHP php_strip_whitespace() function
     * as we want the content to be readable and well-formatted.
     *
<<<<<<< HEAD
     * @param string $source A PHP string
     *
     * @return string The PHP string with the comments removed
     */
    public static function stripComments($source)
    {
        if (!function_exists('token_get_all')) {
=======
     * @return string The PHP string with the comments removed
     */
    public static function stripComments(string $source)
    {
        if (!\function_exists('token_get_all')) {
>>>>>>> v2-test
            return $source;
        }

        $rawChunk = '';
        $output = '';
        $tokens = token_get_all($source);
        $ignoreSpace = false;
        for ($i = 0; isset($tokens[$i]); ++$i) {
            $token = $tokens[$i];
            if (!isset($token[1]) || 'b"' === $token) {
                $rawChunk .= $token;
<<<<<<< HEAD
            } elseif (T_START_HEREDOC === $token[0]) {
=======
            } elseif (\T_START_HEREDOC === $token[0]) {
>>>>>>> v2-test
                $output .= $rawChunk.$token[1];
                do {
                    $token = $tokens[++$i];
                    $output .= isset($token[1]) && 'b"' !== $token ? $token[1] : $token;
<<<<<<< HEAD
                } while ($token[0] !== T_END_HEREDOC);
                $rawChunk = '';
            } elseif (T_WHITESPACE === $token[0]) {
=======
                } while (\T_END_HEREDOC !== $token[0]);
                $rawChunk = '';
            } elseif (\T_WHITESPACE === $token[0]) {
>>>>>>> v2-test
                if ($ignoreSpace) {
                    $ignoreSpace = false;

                    continue;
                }

                // replace multiple new lines with a single newline
<<<<<<< HEAD
                $rawChunk .= preg_replace(array('/\n{2,}/S'), "\n", $token[1]);
            } elseif (in_array($token[0], array(T_COMMENT, T_DOC_COMMENT))) {
=======
                $rawChunk .= preg_replace(['/\n{2,}/S'], "\n", $token[1]);
            } elseif (\in_array($token[0], [\T_COMMENT, \T_DOC_COMMENT])) {
                if (!\in_array($rawChunk[\strlen($rawChunk) - 1], [' ', "\n", "\r", "\t"], true)) {
                    $rawChunk .= ' ';
                }
>>>>>>> v2-test
                $ignoreSpace = true;
            } else {
                $rawChunk .= $token[1];

                // The PHP-open tag already has a new-line
<<<<<<< HEAD
                if (T_OPEN_TAG === $token[0]) {
                    $ignoreSpace = true;
=======
                if (\T_OPEN_TAG === $token[0]) {
                    $ignoreSpace = true;
                } else {
                    $ignoreSpace = false;
>>>>>>> v2-test
                }
            }
        }

        $output .= $rawChunk;

<<<<<<< HEAD
        if (PHP_VERSION_ID >= 70000) {
            // PHP 7 memory manager will not release after token_get_all(), see https://bugs.php.net/70098
            unset($tokens, $rawChunk);
            gc_mem_caches();
        }
=======
        unset($tokens, $rawChunk);
        gc_mem_caches();
>>>>>>> v2-test

        return $output;
    }

<<<<<<< HEAD
    public function serialize()
    {
        return serialize(array($this->environment, $this->debug));
    }

    public function unserialize($data)
    {
        list($environment, $debug) = unserialize($data);

        $this->__construct($environment, $debug);
=======
    /**
     * @return array
     */
    public function __sleep()
    {
        return ['environment', 'debug'];
    }

    public function __wakeup()
    {
        if (\is_object($this->environment) || \is_object($this->debug)) {
            throw new \BadMethodCallException('Cannot unserialize '.__CLASS__);
        }

        $this->__construct($this->environment, $this->debug);
>>>>>>> v2-test
    }
}
