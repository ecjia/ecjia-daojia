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

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Config\Resource\FileResource;
<<<<<<< HEAD
=======
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
>>>>>>> v2-test
use Symfony\Component\Routing\RouteCollection;

/**
 * PhpFileLoader loads routes from a PHP file.
 *
 * The file must return a RouteCollection instance.
 *
 * @author Fabien Potencier <fabien@symfony.com>
<<<<<<< HEAD
=======
 * @author Nicolas grekas <p@tchwork.com>
 * @author Jules Pietri <jules@heahprod.com>
>>>>>>> v2-test
 */
class PhpFileLoader extends FileLoader
{
    /**
     * Loads a PHP file.
     *
     * @param string      $file A PHP file path
     * @param string|null $type The resource type
     *
     * @return RouteCollection A RouteCollection instance
     */
<<<<<<< HEAD
    public function load($file, $type = null)
    {
        $path = $this->locator->locate($file);
        $this->setCurrentDir(dirname($path));

        $collection = self::includeFile($path, $this);
=======
    public function load($file, string $type = null)
    {
        $path = $this->locator->locate($file);
        $this->setCurrentDir(\dirname($path));

        // the closure forbids access to the private scope in the included file
        $loader = $this;
        $load = \Closure::bind(static function ($file) use ($loader) {
            return include $file;
        }, null, ProtectedPhpFileLoader::class);

        $result = $load($path);

        if (\is_object($result) && \is_callable($result)) {
            $collection = $this->callConfigurator($result, $path, $file);
        } else {
            $collection = $result;
        }

>>>>>>> v2-test
        $collection->addResource(new FileResource($path));

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'php' === pathinfo($resource, PATHINFO_EXTENSION) && (!$type || 'php' === $type);
    }

    /**
     * Safe include. Used for scope isolation.
     *
     * @param string        $file   File to include
     * @param PhpFileLoader $loader the loader variable is exposed to the included file below
     *
     * @return RouteCollection
     */
    private static function includeFile($file, PhpFileLoader $loader)
    {
        return include $file;
    }
}
=======
    public function supports($resource, string $type = null)
    {
        return \is_string($resource) && 'php' === pathinfo($resource, \PATHINFO_EXTENSION) && (!$type || 'php' === $type);
    }

    protected function callConfigurator(callable $result, string $path, string $file): RouteCollection
    {
        $collection = new RouteCollection();

        $result(new RoutingConfigurator($collection, $this, $path, $file));

        return $collection;
    }
}

/**
 * @internal
 */
final class ProtectedPhpFileLoader extends PhpFileLoader
{
}
>>>>>>> v2-test
