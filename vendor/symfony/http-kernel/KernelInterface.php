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

<<<<<<< HEAD
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\Config\Loader\LoaderInterface;
=======
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
>>>>>>> v2-test

/**
 * The Kernel is the heart of the Symfony system.
 *
<<<<<<< HEAD
 * It manages an environment made of bundles.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface KernelInterface extends HttpKernelInterface, \Serializable
=======
 * It manages an environment made of application kernel and bundles.
 *
 * @method string getBuildDir() Returns the build directory - not implementing it is deprecated since Symfony 5.2.
 *                              This directory should be used to store build artifacts, and can be read-only at runtime.
 *                              Caches written at runtime should be stored in the "cache directory" ({@see KernelInterface::getCacheDir()}).
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface KernelInterface extends HttpKernelInterface
>>>>>>> v2-test
{
    /**
     * Returns an array of bundles to register.
     *
<<<<<<< HEAD
     * @return BundleInterface[] An array of bundle instances
=======
     * @return iterable|BundleInterface[] An iterable of bundle instances
>>>>>>> v2-test
     */
    public function registerBundles();

    /**
     * Loads the container configuration.
<<<<<<< HEAD
     *
     * @param LoaderInterface $loader A LoaderInterface instance
=======
>>>>>>> v2-test
     */
    public function registerContainerConfiguration(LoaderInterface $loader);

    /**
     * Boots the current kernel.
     */
    public function boot();

    /**
     * Shutdowns the kernel.
     *
     * This method is mainly useful when doing functional testing.
     */
    public function shutdown();

    /**
     * Gets the registered bundle instances.
     *
     * @return BundleInterface[] An array of registered bundle instances
     */
    public function getBundles();

    /**
<<<<<<< HEAD
     * Checks if a given class name belongs to an active bundle.
     *
     * @param string $class A class name
     *
     * @return bool true if the class belongs to an active bundle, false otherwise
     *
     * @deprecated since version 2.6, to be removed in 3.0.
     */
    public function isClassInActiveBundle($class);

    /**
     * Returns a bundle and optionally its descendants by its name.
     *
     * @param string $name  Bundle name
     * @param bool   $first Whether to return the first bundle only or together with its descendants
     *
     * @return BundleInterface|BundleInterface[] A BundleInterface instance or an array of BundleInterface instances if $first is false
     *
     * @throws \InvalidArgumentException when the bundle is not enabled
     */
    public function getBundle($name, $first = true);

    /**
     * Returns the file path for a given resource.
=======
     * Returns a bundle.
     *
     * @return BundleInterface A BundleInterface instance
     *
     * @throws \InvalidArgumentException when the bundle is not enabled
     */
    public function getBundle(string $name);

    /**
     * Returns the file path for a given bundle resource.
>>>>>>> v2-test
     *
     * A Resource can be a file or a directory.
     *
     * The resource name must follow the following pattern:
     *
     *     "@BundleName/path/to/a/file.something"
     *
     * where BundleName is the name of the bundle
     * and the remaining part is the relative path in the bundle.
     *
<<<<<<< HEAD
     * If $dir is passed, and the first segment of the path is "Resources",
     * this method will look for a file named:
     *
     *     $dir/<BundleName>/path/without/Resources
     *
     * before looking in the bundle resource folder.
     *
     * @param string $name  A resource name to locate
     * @param string $dir   A directory where to look for the resource first
     * @param bool   $first Whether to return the first path or paths for all matching bundles
     *
     * @return string|array The absolute path of the resource or an array if $first is false
=======
     * @return string The absolute path of the resource
>>>>>>> v2-test
     *
     * @throws \InvalidArgumentException if the file cannot be found or the name is not valid
     * @throws \RuntimeException         if the name contains invalid/unsafe characters
     */
<<<<<<< HEAD
    public function locateResource($name, $dir = null, $first = true);

    /**
     * Gets the name of the kernel.
     *
     * @return string The kernel name
     */
    public function getName();
=======
    public function locateResource(string $name);
>>>>>>> v2-test

    /**
     * Gets the environment.
     *
     * @return string The current environment
     */
    public function getEnvironment();

    /**
     * Checks if debug mode is enabled.
     *
     * @return bool true if debug mode is enabled, false otherwise
     */
    public function isDebug();

    /**
<<<<<<< HEAD
     * Gets the application root dir.
     *
     * @return string The application root dir
     */
    public function getRootDir();
=======
     * Gets the project dir (path of the project's composer file).
     *
     * @return string
     */
    public function getProjectDir();
>>>>>>> v2-test

    /**
     * Gets the current container.
     *
<<<<<<< HEAD
     * @return ContainerInterface A ContainerInterface instance
=======
     * @return ContainerInterface
>>>>>>> v2-test
     */
    public function getContainer();

    /**
     * Gets the request start time (not available if debug is disabled).
     *
<<<<<<< HEAD
     * @return int The request start timestamp
=======
     * @return float The request start timestamp
>>>>>>> v2-test
     */
    public function getStartTime();

    /**
     * Gets the cache directory.
     *
<<<<<<< HEAD
=======
     * Since Symfony 5.2, the cache directory should be used for caches that are written at runtime.
     * For caches and artifacts that can be warmed at compile-time and deployed as read-only,
     * use the new "build directory" returned by the {@see getBuildDir()} method.
     *
>>>>>>> v2-test
     * @return string The cache directory
     */
    public function getCacheDir();

    /**
     * Gets the log directory.
     *
     * @return string The log directory
     */
    public function getLogDir();

    /**
     * Gets the charset of the application.
     *
     * @return string The charset
     */
    public function getCharset();
}
