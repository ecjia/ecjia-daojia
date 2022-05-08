<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Loader;

use Doctrine\Common\Annotations\Reader;
<<<<<<< HEAD
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
=======
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Routing\Annotation\Route as RouteAnnotation;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
>>>>>>> v2-test

/**
 * AnnotationClassLoader loads routing information from a PHP class and its methods.
 *
<<<<<<< HEAD
 * You need to define an implementation for the getRouteDefaults() method. Most of the
=======
 * You need to define an implementation for the configureRoute() method. Most of the
>>>>>>> v2-test
 * time, this method should define some PHP callable to be called for the route
 * (a controller in MVC speak).
 *
 * The @Route annotation can be set on the class (for global parameters),
 * and on each method.
 *
 * The @Route annotation main value is the route path. The annotation also
 * recognizes several parameters: requirements, options, defaults, schemes,
 * methods, host, and name. The name parameter is mandatory.
 * Here is an example of how you should be able to use it:
<<<<<<< HEAD
 *
=======
>>>>>>> v2-test
 *     /**
 *      * @Route("/Blog")
 *      * /
 *     class Blog
 *     {
 *         /**
 *          * @Route("/", name="blog_index")
 *          * /
 *         public function index()
 *         {
 *         }
<<<<<<< HEAD
 *
=======
>>>>>>> v2-test
 *         /**
 *          * @Route("/{id}", name="blog_post", requirements = {"id" = "\d+"})
 *          * /
 *         public function show()
 *         {
 *         }
 *     }
 *
<<<<<<< HEAD
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class AnnotationClassLoader implements LoaderInterface
{
    /**
     * @var Reader
     */
=======
 * On PHP 8, the annotation class can be used as an attribute as well:
 *     #[Route('/Blog')]
 *     class Blog
 *     {
 *         #[Route('/', name: 'blog_index')]
 *         public function index()
 *         {
 *         }
 *         #[Route('/{id}', name: 'blog_post', requirements: ["id" => '\d+'])]
 *         public function show()
 *         {
 *         }
 *     }

 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Alexander M. Turek <me@derrabus.de>
 */
abstract class AnnotationClassLoader implements LoaderInterface
{
>>>>>>> v2-test
    protected $reader;

    /**
     * @var string
     */
<<<<<<< HEAD
    protected $routeAnnotationClass = 'Symfony\\Component\\Routing\\Annotation\\Route';
=======
    protected $routeAnnotationClass = RouteAnnotation::class;
>>>>>>> v2-test

    /**
     * @var int
     */
    protected $defaultRouteIndex = 0;

<<<<<<< HEAD
    /**
     * Constructor.
     *
     * @param Reader $reader
     */
    public function __construct(Reader $reader)
=======
    public function __construct(Reader $reader = null)
>>>>>>> v2-test
    {
        $this->reader = $reader;
    }

    /**
     * Sets the annotation class to read route properties from.
<<<<<<< HEAD
     *
     * @param string $class A fully-qualified class name
     */
    public function setRouteAnnotationClass($class)
=======
     */
    public function setRouteAnnotationClass(string $class)
>>>>>>> v2-test
    {
        $this->routeAnnotationClass = $class;
    }

    /**
     * Loads from annotations from a class.
     *
<<<<<<< HEAD
     * @param string      $class A class name
     * @param string|null $type  The resource type
=======
     * @param string $class A class name
>>>>>>> v2-test
     *
     * @return RouteCollection A RouteCollection instance
     *
     * @throws \InvalidArgumentException When route can't be parsed
     */
<<<<<<< HEAD
    public function load($class, $type = null)
=======
    public function load($class, string $type = null)
>>>>>>> v2-test
    {
        if (!class_exists($class)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" does not exist.', $class));
        }

        $class = new \ReflectionClass($class);
        if ($class->isAbstract()) {
            throw new \InvalidArgumentException(sprintf('Annotations from class "%s" cannot be read as it is abstract.', $class->getName()));
        }

        $globals = $this->getGlobals($class);

        $collection = new RouteCollection();
        $collection->addResource(new FileResource($class->getFileName()));

        foreach ($class->getMethods() as $method) {
            $this->defaultRouteIndex = 0;
<<<<<<< HEAD
            foreach ($this->reader->getMethodAnnotations($method) as $annot) {
                if ($annot instanceof $this->routeAnnotationClass) {
                    $this->addRoute($collection, $annot, $globals, $class, $method);
                }
=======
            foreach ($this->getAnnotations($method) as $annot) {
                $this->addRoute($collection, $annot, $globals, $class, $method);
            }
        }

        if (0 === $collection->count() && $class->hasMethod('__invoke')) {
            $globals = $this->resetGlobals();
            foreach ($this->getAnnotations($class) as $annot) {
                $this->addRoute($collection, $annot, $globals, $class, $class->getMethod('__invoke'));
>>>>>>> v2-test
            }
        }

        return $collection;
    }

<<<<<<< HEAD
    protected function addRoute(RouteCollection $collection, $annot, $globals, \ReflectionClass $class, \ReflectionMethod $method)
=======
    /**
     * @param RouteAnnotation $annot or an object that exposes a similar interface
     */
    protected function addRoute(RouteCollection $collection, object $annot, array $globals, \ReflectionClass $class, \ReflectionMethod $method)
>>>>>>> v2-test
    {
        $name = $annot->getName();
        if (null === $name) {
            $name = $this->getDefaultRouteName($class, $method);
        }
<<<<<<< HEAD

        $defaults = array_replace($globals['defaults'], $annot->getDefaults());
        foreach ($method->getParameters() as $param) {
            if (!isset($defaults[$param->getName()]) && $param->isDefaultValueAvailable()) {
                $defaults[$param->getName()] = $param->getDefaultValue();
            }
        }
        $requirements = array_replace($globals['requirements'], $annot->getRequirements());
=======
        $name = $globals['name'].$name;

        $requirements = $annot->getRequirements();

        foreach ($requirements as $placeholder => $requirement) {
            if (\is_int($placeholder)) {
                throw new \InvalidArgumentException(sprintf('A placeholder name must be a string (%d given). Did you forget to specify the placeholder key for the requirement "%s" of route "%s" in "%s::%s()"?', $placeholder, $requirement, $name, $class->getName(), $method->getName()));
            }
        }

        $defaults = array_replace($globals['defaults'], $annot->getDefaults());
        $requirements = array_replace($globals['requirements'], $requirements);
>>>>>>> v2-test
        $options = array_replace($globals['options'], $annot->getOptions());
        $schemes = array_merge($globals['schemes'], $annot->getSchemes());
        $methods = array_merge($globals['methods'], $annot->getMethods());

        $host = $annot->getHost();
        if (null === $host) {
            $host = $globals['host'];
        }

<<<<<<< HEAD
        $condition = $annot->getCondition();
        if (null === $condition) {
            $condition = $globals['condition'];
        }

        $route = $this->createRoute($globals['path'].$annot->getPath(), $defaults, $requirements, $options, $host, $schemes, $methods, $condition);

        $this->configureRoute($route, $class, $method, $annot);

        $collection->add($name, $route);
=======
        $condition = $annot->getCondition() ?? $globals['condition'];
        $priority = $annot->getPriority() ?? $globals['priority'];

        $path = $annot->getLocalizedPaths() ?: $annot->getPath();
        $prefix = $globals['localized_paths'] ?: $globals['path'];
        $paths = [];

        if (\is_array($path)) {
            if (!\is_array($prefix)) {
                foreach ($path as $locale => $localePath) {
                    $paths[$locale] = $prefix.$localePath;
                }
            } elseif ($missing = array_diff_key($prefix, $path)) {
                throw new \LogicException(sprintf('Route to "%s" is missing paths for locale(s) "%s".', $class->name.'::'.$method->name, implode('", "', array_keys($missing))));
            } else {
                foreach ($path as $locale => $localePath) {
                    if (!isset($prefix[$locale])) {
                        throw new \LogicException(sprintf('Route to "%s" with locale "%s" is missing a corresponding prefix in class "%s".', $method->name, $locale, $class->name));
                    }

                    $paths[$locale] = $prefix[$locale].$localePath;
                }
            }
        } elseif (\is_array($prefix)) {
            foreach ($prefix as $locale => $localePrefix) {
                $paths[$locale] = $localePrefix.$path;
            }
        } else {
            $paths[] = $prefix.$path;
        }

        foreach ($method->getParameters() as $param) {
            if (isset($defaults[$param->name]) || !$param->isDefaultValueAvailable()) {
                continue;
            }
            foreach ($paths as $locale => $path) {
                if (preg_match(sprintf('/\{%s(?:<.*?>)?\}/', preg_quote($param->name)), $path)) {
                    $defaults[$param->name] = $param->getDefaultValue();
                    break;
                }
            }
        }

        foreach ($paths as $locale => $path) {
            $route = $this->createRoute($path, $defaults, $requirements, $options, $host, $schemes, $methods, $condition);
            $this->configureRoute($route, $class, $method, $annot);
            if (0 !== $locale) {
                $route->setDefault('_locale', $locale);
                $route->setRequirement('_locale', preg_quote($locale));
                $route->setDefault('_canonical_route', $name);
                $collection->add($name.'.'.$locale, $route, $priority);
            } else {
                $collection->add($name, $route, $priority);
            }
        }
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function supports($resource, $type = null)
    {
        return is_string($resource) && preg_match('/^(?:\\\\?[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)+$/', $resource) && (!$type || 'annotation' === $type);
=======
    public function supports($resource, string $type = null)
    {
        return \is_string($resource) && preg_match('/^(?:\\\\?[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)+$/', $resource) && (!$type || 'annotation' === $type);
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
    public function setResolver(LoaderResolverInterface $resolver)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getResolver()
    {
    }

    /**
     * Gets the default route name for a class method.
     *
<<<<<<< HEAD
     * @param \ReflectionClass  $class
     * @param \ReflectionMethod $method
     *
=======
>>>>>>> v2-test
     * @return string
     */
    protected function getDefaultRouteName(\ReflectionClass $class, \ReflectionMethod $method)
    {
<<<<<<< HEAD
        $name = strtolower(str_replace('\\', '_', $class->name).'_'.$method->name);
=======
        $name = str_replace('\\', '_', $class->name).'_'.$method->name;
        $name = \function_exists('mb_strtolower') && preg_match('//u', $name) ? mb_strtolower($name, 'UTF-8') : strtolower($name);
>>>>>>> v2-test
        if ($this->defaultRouteIndex > 0) {
            $name .= '_'.$this->defaultRouteIndex;
        }
        ++$this->defaultRouteIndex;

        return $name;
    }

    protected function getGlobals(\ReflectionClass $class)
    {
<<<<<<< HEAD
        $globals = array(
            'path' => '',
            'requirements' => array(),
            'options' => array(),
            'defaults' => array(),
            'schemes' => array(),
            'methods' => array(),
            'host' => '',
            'condition' => '',
        );

        if ($annot = $this->reader->getClassAnnotation($class, $this->routeAnnotationClass)) {
            // for BC reasons
            if (null !== $annot->getPath()) {
                $globals['path'] = $annot->getPath();
            } elseif (null !== $annot->getPattern()) {
                $globals['path'] = $annot->getPattern();
            }

=======
        $globals = $this->resetGlobals();

        $annot = null;
        if (\PHP_VERSION_ID >= 80000 && ($attribute = $class->getAttributes($this->routeAnnotationClass)[0] ?? null)) {
            $annot = $attribute->newInstance();
        }
        if (!$annot && $this->reader) {
            $annot = $this->reader->getClassAnnotation($class, $this->routeAnnotationClass);
        }

        if ($annot) {
            if (null !== $annot->getName()) {
                $globals['name'] = $annot->getName();
            }

            if (null !== $annot->getPath()) {
                $globals['path'] = $annot->getPath();
            }

            $globals['localized_paths'] = $annot->getLocalizedPaths();

>>>>>>> v2-test
            if (null !== $annot->getRequirements()) {
                $globals['requirements'] = $annot->getRequirements();
            }

            if (null !== $annot->getOptions()) {
                $globals['options'] = $annot->getOptions();
            }

            if (null !== $annot->getDefaults()) {
                $globals['defaults'] = $annot->getDefaults();
            }

            if (null !== $annot->getSchemes()) {
                $globals['schemes'] = $annot->getSchemes();
            }

            if (null !== $annot->getMethods()) {
                $globals['methods'] = $annot->getMethods();
            }

            if (null !== $annot->getHost()) {
                $globals['host'] = $annot->getHost();
            }

            if (null !== $annot->getCondition()) {
                $globals['condition'] = $annot->getCondition();
            }
<<<<<<< HEAD
=======

            $globals['priority'] = $annot->getPriority() ?? 0;

            foreach ($globals['requirements'] as $placeholder => $requirement) {
                if (\is_int($placeholder)) {
                    throw new \InvalidArgumentException(sprintf('A placeholder name must be a string (%d given). Did you forget to specify the placeholder key for the requirement "%s" in "%s"?', $placeholder, $requirement, $class->getName()));
                }
            }
>>>>>>> v2-test
        }

        return $globals;
    }

<<<<<<< HEAD
    protected function createRoute($path, $defaults, $requirements, $options, $host, $schemes, $methods, $condition)
=======
    private function resetGlobals(): array
    {
        return [
            'path' => null,
            'localized_paths' => [],
            'requirements' => [],
            'options' => [],
            'defaults' => [],
            'schemes' => [],
            'methods' => [],
            'host' => '',
            'condition' => '',
            'name' => '',
            'priority' => 0,
        ];
    }

    protected function createRoute(string $path, array $defaults, array $requirements, array $options, ?string $host, array $schemes, array $methods, ?string $condition)
>>>>>>> v2-test
    {
        return new Route($path, $defaults, $requirements, $options, $host, $schemes, $methods, $condition);
    }

<<<<<<< HEAD
    abstract protected function configureRoute(Route $route, \ReflectionClass $class, \ReflectionMethod $method, $annot);
=======
    abstract protected function configureRoute(Route $route, \ReflectionClass $class, \ReflectionMethod $method, object $annot);

    /**
     * @param \ReflectionClass|\ReflectionMethod $reflection
     *
     * @return iterable|RouteAnnotation[]
     */
    private function getAnnotations(object $reflection): iterable
    {
        if (\PHP_VERSION_ID >= 80000) {
            foreach ($reflection->getAttributes($this->routeAnnotationClass) as $attribute) {
                yield $attribute->newInstance();
            }
        }

        if (!$this->reader) {
            return;
        }

        $anntotations = $reflection instanceof \ReflectionClass
            ? $this->reader->getClassAnnotations($reflection)
            : $this->reader->getMethodAnnotations($reflection);

        foreach ($anntotations as $annotation) {
            if ($annotation instanceof $this->routeAnnotationClass) {
                yield $annotation;
            }
        }
    }
>>>>>>> v2-test
}
