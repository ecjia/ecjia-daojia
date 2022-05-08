<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing;

<<<<<<< HEAD
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\ConfigCacheInterface;
use Symfony\Component\Config\ConfigCacheFactoryInterface;
use Symfony\Component\Config\ConfigCacheFactory;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Generator\ConfigurableRequirementsInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Generator\Dumper\GeneratorDumperInterface;
use Symfony\Component\Routing\Matcher\RequestMatcherInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\Matcher\Dumper\MatcherDumperInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
=======
use Psr\Log\LoggerInterface;
use Symfony\Component\Config\ConfigCacheFactory;
use Symfony\Component\Config\ConfigCacheFactoryInterface;
use Symfony\Component\Config\ConfigCacheInterface;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\CompiledUrlGenerator;
use Symfony\Component\Routing\Generator\ConfigurableRequirementsInterface;
use Symfony\Component\Routing\Generator\Dumper\CompiledUrlGeneratorDumper;
use Symfony\Component\Routing\Generator\Dumper\GeneratorDumperInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Matcher\CompiledUrlMatcher;
use Symfony\Component\Routing\Matcher\Dumper\CompiledUrlMatcherDumper;
use Symfony\Component\Routing\Matcher\Dumper\MatcherDumperInterface;
use Symfony\Component\Routing\Matcher\RequestMatcherInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
>>>>>>> v2-test

/**
 * The Router class is an example of the integration of all pieces of the
 * routing system for easier use.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Router implements RouterInterface, RequestMatcherInterface
{
    /**
     * @var UrlMatcherInterface|null
     */
    protected $matcher;

    /**
     * @var UrlGeneratorInterface|null
     */
    protected $generator;

    /**
     * @var RequestContext
     */
    protected $context;

    /**
     * @var LoaderInterface
     */
    protected $loader;

    /**
     * @var RouteCollection|null
     */
    protected $collection;

    /**
     * @var mixed
     */
    protected $resource;

    /**
     * @var array
     */
<<<<<<< HEAD
    protected $options = array();
=======
    protected $options = [];
>>>>>>> v2-test

    /**
     * @var LoggerInterface|null
     */
    protected $logger;

    /**
<<<<<<< HEAD
=======
     * @var string|null
     */
    protected $defaultLocale;

    /**
>>>>>>> v2-test
     * @var ConfigCacheFactoryInterface|null
     */
    private $configCacheFactory;

    /**
     * @var ExpressionFunctionProviderInterface[]
     */
<<<<<<< HEAD
    private $expressionLanguageProviders = array();

    /**
     * Constructor.
     *
     * @param LoaderInterface $loader   A LoaderInterface instance
     * @param mixed           $resource The main resource to load
     * @param array           $options  An array of options
     * @param RequestContext  $context  The context
     * @param LoggerInterface $logger   A logger instance
     */
    public function __construct(LoaderInterface $loader, $resource, array $options = array(), RequestContext $context = null, LoggerInterface $logger = null)
=======
    private $expressionLanguageProviders = [];

    private static $cache = [];

    /**
     * @param mixed $resource The main resource to load
     */
    public function __construct(LoaderInterface $loader, $resource, array $options = [], RequestContext $context = null, LoggerInterface $logger = null, string $defaultLocale = null)
>>>>>>> v2-test
    {
        $this->loader = $loader;
        $this->resource = $resource;
        $this->logger = $logger;
        $this->context = $context ?: new RequestContext();
        $this->setOptions($options);
<<<<<<< HEAD
=======
        $this->defaultLocale = $defaultLocale;
>>>>>>> v2-test
    }

    /**
     * Sets options.
     *
     * Available options:
     *
     *   * cache_dir:              The cache directory (or null to disable caching)
     *   * debug:                  Whether to enable debugging or not (false by default)
     *   * generator_class:        The name of a UrlGeneratorInterface implementation
<<<<<<< HEAD
     *   * generator_base_class:   The base class for the dumped generator class
     *   * generator_cache_class:  The class name for the dumped generator class
     *   * generator_dumper_class: The name of a GeneratorDumperInterface implementation
     *   * matcher_class:          The name of a UrlMatcherInterface implementation
     *   * matcher_base_class:     The base class for the dumped matcher class
     *   * matcher_dumper_class:   The class name for the dumped matcher class
     *   * matcher_cache_class:    The name of a MatcherDumperInterface implementation
=======
     *   * generator_dumper_class: The name of a GeneratorDumperInterface implementation
     *   * matcher_class:          The name of a UrlMatcherInterface implementation
     *   * matcher_dumper_class:   The name of a MatcherDumperInterface implementation
>>>>>>> v2-test
     *   * resource_type:          Type hint for the main resource (optional)
     *   * strict_requirements:    Configure strict requirement checking for generators
     *                             implementing ConfigurableRequirementsInterface (default is true)
     *
<<<<<<< HEAD
     * @param array $options An array of options
     *
=======
>>>>>>> v2-test
     * @throws \InvalidArgumentException When unsupported option is provided
     */
    public function setOptions(array $options)
    {
<<<<<<< HEAD
        $this->options = array(
            'cache_dir' => null,
            'debug' => false,
            'generator_class' => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator',
            'generator_base_class' => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator',
            'generator_dumper_class' => 'Symfony\\Component\\Routing\\Generator\\Dumper\\PhpGeneratorDumper',
            'generator_cache_class' => 'ProjectUrlGenerator',
            'matcher_class' => 'Symfony\\Component\\Routing\\Matcher\\UrlMatcher',
            'matcher_base_class' => 'Symfony\\Component\\Routing\\Matcher\\UrlMatcher',
            'matcher_dumper_class' => 'Symfony\\Component\\Routing\\Matcher\\Dumper\\PhpMatcherDumper',
            'matcher_cache_class' => 'ProjectUrlMatcher',
            'resource_type' => null,
            'strict_requirements' => true,
        );

        // check option names and live merge, if errors are encountered Exception will be thrown
        $invalid = array();
        foreach ($options as $key => $value) {
            if (array_key_exists($key, $this->options)) {
=======
        $this->options = [
            'cache_dir' => null,
            'debug' => false,
            'generator_class' => CompiledUrlGenerator::class,
            'generator_dumper_class' => CompiledUrlGeneratorDumper::class,
            'matcher_class' => CompiledUrlMatcher::class,
            'matcher_dumper_class' => CompiledUrlMatcherDumper::class,
            'resource_type' => null,
            'strict_requirements' => true,
        ];

        // check option names and live merge, if errors are encountered Exception will be thrown
        $invalid = [];
        foreach ($options as $key => $value) {
            if (\array_key_exists($key, $this->options)) {
>>>>>>> v2-test
                $this->options[$key] = $value;
            } else {
                $invalid[] = $key;
            }
        }

        if ($invalid) {
            throw new \InvalidArgumentException(sprintf('The Router does not support the following options: "%s".', implode('", "', $invalid)));
        }
    }

    /**
     * Sets an option.
     *
<<<<<<< HEAD
     * @param string $key   The key
     * @param mixed  $value The value
     *
     * @throws \InvalidArgumentException
     */
    public function setOption($key, $value)
    {
        if (!array_key_exists($key, $this->options)) {
=======
     * @param mixed $value The value
     *
     * @throws \InvalidArgumentException
     */
    public function setOption(string $key, $value)
    {
        if (!\array_key_exists($key, $this->options)) {
>>>>>>> v2-test
            throw new \InvalidArgumentException(sprintf('The Router does not support the "%s" option.', $key));
        }

        $this->options[$key] = $value;
    }

    /**
     * Gets an option value.
     *
<<<<<<< HEAD
     * @param string $key The key
     *
=======
>>>>>>> v2-test
     * @return mixed The value
     *
     * @throws \InvalidArgumentException
     */
<<<<<<< HEAD
    public function getOption($key)
    {
        if (!array_key_exists($key, $this->options)) {
=======
    public function getOption(string $key)
    {
        if (!\array_key_exists($key, $this->options)) {
>>>>>>> v2-test
            throw new \InvalidArgumentException(sprintf('The Router does not support the "%s" option.', $key));
        }

        return $this->options[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function getRouteCollection()
    {
        if (null === $this->collection) {
            $this->collection = $this->loader->load($this->resource, $this->options['resource_type']);
        }

        return $this->collection;
    }

    /**
     * {@inheritdoc}
     */
    public function setContext(RequestContext $context)
    {
        $this->context = $context;

        if (null !== $this->matcher) {
            $this->getMatcher()->setContext($context);
        }
        if (null !== $this->generator) {
            $this->getGenerator()->setContext($context);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Sets the ConfigCache factory to use.
<<<<<<< HEAD
     *
     * @param ConfigCacheFactoryInterface $configCacheFactory The factory to use
=======
>>>>>>> v2-test
     */
    public function setConfigCacheFactory(ConfigCacheFactoryInterface $configCacheFactory)
    {
        $this->configCacheFactory = $configCacheFactory;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
=======
    public function generate(string $name, array $parameters = [], int $referenceType = self::ABSOLUTE_PATH)
>>>>>>> v2-test
    {
        return $this->getGenerator()->generate($name, $parameters, $referenceType);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function match($pathinfo)
=======
    public function match(string $pathinfo)
>>>>>>> v2-test
    {
        return $this->getMatcher()->match($pathinfo);
    }

    /**
     * {@inheritdoc}
     */
    public function matchRequest(Request $request)
    {
        $matcher = $this->getMatcher();
        if (!$matcher instanceof RequestMatcherInterface) {
            // fallback to the default UrlMatcherInterface
            return $matcher->match($request->getPathInfo());
        }

        return $matcher->matchRequest($request);
    }

    /**
<<<<<<< HEAD
     * Gets the UrlMatcher instance associated with this Router.
     *
     * @return UrlMatcherInterface A UrlMatcherInterface instance
=======
     * Gets the UrlMatcher or RequestMatcher instance associated with this Router.
     *
     * @return UrlMatcherInterface|RequestMatcherInterface
>>>>>>> v2-test
     */
    public function getMatcher()
    {
        if (null !== $this->matcher) {
            return $this->matcher;
        }

<<<<<<< HEAD
        if (null === $this->options['cache_dir'] || null === $this->options['matcher_cache_class']) {
            $this->matcher = new $this->options['matcher_class']($this->getRouteCollection(), $this->context);
=======
        if (null === $this->options['cache_dir']) {
            $routes = $this->getRouteCollection();
            $compiled = is_a($this->options['matcher_class'], CompiledUrlMatcher::class, true);
            if ($compiled) {
                $routes = (new CompiledUrlMatcherDumper($routes))->getCompiledRoutes();
            }
            $this->matcher = new $this->options['matcher_class']($routes, $this->context);
>>>>>>> v2-test
            if (method_exists($this->matcher, 'addExpressionLanguageProvider')) {
                foreach ($this->expressionLanguageProviders as $provider) {
                    $this->matcher->addExpressionLanguageProvider($provider);
                }
            }

            return $this->matcher;
        }

<<<<<<< HEAD
        $class = $this->options['matcher_cache_class'];
        $baseClass = $this->options['matcher_base_class'];
        $expressionLanguageProviders = $this->expressionLanguageProviders;
        $that = $this; // required for PHP 5.3 where "$this" cannot be use()d in anonymous functions. Change in Symfony 3.0.

        $cache = $this->getConfigCacheFactory()->cache($this->options['cache_dir'].'/'.$class.'.php',
            function (ConfigCacheInterface $cache) use ($that, $class, $baseClass, $expressionLanguageProviders) {
                $dumper = $that->getMatcherDumperInstance();
                if (method_exists($dumper, 'addExpressionLanguageProvider')) {
                    foreach ($expressionLanguageProviders as $provider) {
=======
        $cache = $this->getConfigCacheFactory()->cache($this->options['cache_dir'].'/url_matching_routes.php',
            function (ConfigCacheInterface $cache) {
                $dumper = $this->getMatcherDumperInstance();
                if (method_exists($dumper, 'addExpressionLanguageProvider')) {
                    foreach ($this->expressionLanguageProviders as $provider) {
>>>>>>> v2-test
                        $dumper->addExpressionLanguageProvider($provider);
                    }
                }

<<<<<<< HEAD
                $options = array(
                    'class' => $class,
                    'base_class' => $baseClass,
                );

                $cache->write($dumper->dump($options), $that->getRouteCollection()->getResources());
            }
        );

        require_once $cache->getPath();

        return $this->matcher = new $class($this->context);
=======
                $cache->write($dumper->dump(), $this->getRouteCollection()->getResources());
            }
        );

        return $this->matcher = new $this->options['matcher_class'](self::getCompiledRoutes($cache->getPath()), $this->context);
>>>>>>> v2-test
    }

    /**
     * Gets the UrlGenerator instance associated with this Router.
     *
     * @return UrlGeneratorInterface A UrlGeneratorInterface instance
     */
    public function getGenerator()
    {
        if (null !== $this->generator) {
            return $this->generator;
        }

<<<<<<< HEAD
        if (null === $this->options['cache_dir'] || null === $this->options['generator_cache_class']) {
            $this->generator = new $this->options['generator_class']($this->getRouteCollection(), $this->context, $this->logger);
        } else {
            $class = $this->options['generator_cache_class'];
            $baseClass = $this->options['generator_base_class'];
            $that = $this; // required for PHP 5.3 where "$this" cannot be use()d in anonymous functions. Change in Symfony 3.0.
            $cache = $this->getConfigCacheFactory()->cache($this->options['cache_dir'].'/'.$class.'.php',
                function (ConfigCacheInterface $cache) use ($that, $class, $baseClass) {
                    $dumper = $that->getGeneratorDumperInstance();

                    $options = array(
                        'class' => $class,
                        'base_class' => $baseClass,
                    );

                    $cache->write($dumper->dump($options), $that->getRouteCollection()->getResources());
                }
            );

            require_once $cache->getPath();

            $this->generator = new $class($this->context, $this->logger);
=======
        if (null === $this->options['cache_dir']) {
            $routes = $this->getRouteCollection();
            $compiled = is_a($this->options['generator_class'], CompiledUrlGenerator::class, true);
            if ($compiled) {
                $routes = (new CompiledUrlGeneratorDumper($routes))->getCompiledRoutes();
            }
            $this->generator = new $this->options['generator_class']($routes, $this->context, $this->logger, $this->defaultLocale);
        } else {
            $cache = $this->getConfigCacheFactory()->cache($this->options['cache_dir'].'/url_generating_routes.php',
                function (ConfigCacheInterface $cache) {
                    $dumper = $this->getGeneratorDumperInstance();

                    $cache->write($dumper->dump(), $this->getRouteCollection()->getResources());
                }
            );

            $this->generator = new $this->options['generator_class'](self::getCompiledRoutes($cache->getPath()), $this->context, $this->logger, $this->defaultLocale);
>>>>>>> v2-test
        }

        if ($this->generator instanceof ConfigurableRequirementsInterface) {
            $this->generator->setStrictRequirements($this->options['strict_requirements']);
        }

        return $this->generator;
    }

    public function addExpressionLanguageProvider(ExpressionFunctionProviderInterface $provider)
    {
        $this->expressionLanguageProviders[] = $provider;
    }

    /**
<<<<<<< HEAD
     * This method is public because it needs to be callable from a closure in PHP 5.3. It should be converted back to protected in 3.0.
     *
     * @internal
     *
     * @return GeneratorDumperInterface
     */
    public function getGeneratorDumperInstance()
=======
     * @return GeneratorDumperInterface
     */
    protected function getGeneratorDumperInstance()
>>>>>>> v2-test
    {
        return new $this->options['generator_dumper_class']($this->getRouteCollection());
    }

    /**
<<<<<<< HEAD
     * This method is public because it needs to be callable from a closure in PHP 5.3. It should be converted back to protected in 3.0.
     *
     * @internal
     *
     * @return MatcherDumperInterface
     */
    public function getMatcherDumperInstance()
=======
     * @return MatcherDumperInterface
     */
    protected function getMatcherDumperInstance()
>>>>>>> v2-test
    {
        return new $this->options['matcher_dumper_class']($this->getRouteCollection());
    }

    /**
     * Provides the ConfigCache factory implementation, falling back to a
     * default implementation if necessary.
<<<<<<< HEAD
     *
     * @return ConfigCacheFactoryInterface $configCacheFactory
     */
    private function getConfigCacheFactory()
=======
     */
    private function getConfigCacheFactory(): ConfigCacheFactoryInterface
>>>>>>> v2-test
    {
        if (null === $this->configCacheFactory) {
            $this->configCacheFactory = new ConfigCacheFactory($this->options['debug']);
        }

        return $this->configCacheFactory;
    }
<<<<<<< HEAD
=======

    private static function getCompiledRoutes(string $path): array
    {
        if ([] === self::$cache && \function_exists('opcache_invalidate') && filter_var(ini_get('opcache.enable'), \FILTER_VALIDATE_BOOLEAN) && (!\in_array(\PHP_SAPI, ['cli', 'phpdbg'], true) || filter_var(ini_get('opcache.enable_cli'), \FILTER_VALIDATE_BOOLEAN))) {
            self::$cache = null;
        }

        if (null === self::$cache) {
            return require $path;
        }

        if (isset(self::$cache[$path])) {
            return self::$cache[$path];
        }

        return self::$cache[$path] = require $path;
    }
>>>>>>> v2-test
}
