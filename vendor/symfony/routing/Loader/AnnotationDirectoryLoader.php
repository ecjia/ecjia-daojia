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

<<<<<<< HEAD
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Config\Resource\DirectoryResource;
=======
use Symfony\Component\Config\Resource\DirectoryResource;
use Symfony\Component\Routing\RouteCollection;
>>>>>>> v2-test

/**
 * AnnotationDirectoryLoader loads routing information from annotations set
 * on PHP classes and methods.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class AnnotationDirectoryLoader extends AnnotationFileLoader
{
    /**
     * Loads from annotations from a directory.
     *
     * @param string      $path A directory path
     * @param string|null $type The resource type
     *
     * @return RouteCollection A RouteCollection instance
     *
     * @throws \InvalidArgumentException When the directory does not exist or its routes cannot be parsed
     */
<<<<<<< HEAD
    public function load($path, $type = null)
    {
        $dir = $this->locator->locate($path);

        $collection = new RouteCollection();
        $collection->addResource(new DirectoryResource($dir, '/\.php$/'));
        $files = iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir), \RecursiveIteratorIterator::LEAVES_ONLY));
=======
    public function load($path, string $type = null)
    {
        if (!is_dir($dir = $this->locator->locate($path))) {
            return parent::supports($path, $type) ? parent::load($path, $type) : new RouteCollection();
        }

        $collection = new RouteCollection();
        $collection->addResource(new DirectoryResource($dir, '/\.php$/'));
        $files = iterator_to_array(new \RecursiveIteratorIterator(
            new \RecursiveCallbackFilterIterator(
                new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::FOLLOW_SYMLINKS),
                function (\SplFileInfo $current) {
                    return '.' !== substr($current->getBasename(), 0, 1);
                }
            ),
            \RecursiveIteratorIterator::LEAVES_ONLY
        ));
>>>>>>> v2-test
        usort($files, function (\SplFileInfo $a, \SplFileInfo $b) {
            return (string) $a > (string) $b ? 1 : -1;
        });

        foreach ($files as $file) {
            if (!$file->isFile() || '.php' !== substr($file->getFilename(), -4)) {
                continue;
            }

            if ($class = $this->findClass($file)) {
                $refl = new \ReflectionClass($class);
                if ($refl->isAbstract()) {
                    continue;
                }

                $collection->addCollection($this->loader->load($class, $type));
            }
        }

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function supports($resource, $type = null)
    {
        if (!is_string($resource)) {
=======
    public function supports($resource, string $type = null)
    {
        if ('annotation' === $type) {
            return true;
        }

        if ($type || !\is_string($resource)) {
>>>>>>> v2-test
            return false;
        }

        try {
<<<<<<< HEAD
            $path = $this->locator->locate($resource);
        } catch (\Exception $e) {
            return false;
        }

        return is_dir($path) && (!$type || 'annotation' === $type);
=======
            return is_dir($this->locator->locate($resource));
        } catch (\Exception $e) {
            return false;
        }
>>>>>>> v2-test
    }
}
