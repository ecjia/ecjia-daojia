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
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Config\FileLocatorInterface;
=======
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Routing\RouteCollection;
>>>>>>> v2-test

/**
 * AnnotationFileLoader loads routing information from annotations set
 * on a PHP class and its methods.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class AnnotationFileLoader extends FileLoader
{
    protected $loader;

    /**
<<<<<<< HEAD
     * Constructor.
     *
     * @param FileLocatorInterface  $locator A FileLocator instance
     * @param AnnotationClassLoader $loader  An AnnotationClassLoader instance
     *
=======
>>>>>>> v2-test
     * @throws \RuntimeException
     */
    public function __construct(FileLocatorInterface $locator, AnnotationClassLoader $loader)
    {
<<<<<<< HEAD
        if (!function_exists('token_get_all')) {
            throw new \RuntimeException('The Tokenizer extension is required for the routing annotation loaders.');
=======
        if (!\function_exists('token_get_all')) {
            throw new \LogicException('The Tokenizer extension is required for the routing annotation loaders.');
>>>>>>> v2-test
        }

        parent::__construct($locator);

        $this->loader = $loader;
    }

    /**
     * Loads from annotations from a file.
     *
     * @param string      $file A PHP file path
     * @param string|null $type The resource type
     *
<<<<<<< HEAD
     * @return RouteCollection A RouteCollection instance
     *
     * @throws \InvalidArgumentException When the file does not exist or its routes cannot be parsed
     */
    public function load($file, $type = null)
=======
     * @return RouteCollection|null A RouteCollection instance
     *
     * @throws \InvalidArgumentException When the file does not exist or its routes cannot be parsed
     */
    public function load($file, string $type = null)
>>>>>>> v2-test
    {
        $path = $this->locator->locate($file);

        $collection = new RouteCollection();
        if ($class = $this->findClass($path)) {
<<<<<<< HEAD
            $collection->addResource(new FileResource($path));
            $collection->addCollection($this->loader->load($class, $type));
        }
        if (PHP_VERSION_ID >= 70000) {
            // PHP 7 memory manager will not release after token_get_all(), see https://bugs.php.net/70098
            gc_mem_caches();
        }
=======
            $refl = new \ReflectionClass($class);
            if ($refl->isAbstract()) {
                return null;
            }

            $collection->addResource(new FileResource($path));
            $collection->addCollection($this->loader->load($class, $type));
        }

        gc_mem_caches();
>>>>>>> v2-test

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'php' === pathinfo($resource, PATHINFO_EXTENSION) && (!$type || 'annotation' === $type);
=======
    public function supports($resource, string $type = null)
    {
        return \is_string($resource) && 'php' === pathinfo($resource, \PATHINFO_EXTENSION) && (!$type || 'annotation' === $type);
>>>>>>> v2-test
    }

    /**
     * Returns the full class name for the first class in the file.
     *
<<<<<<< HEAD
     * @param string $file A PHP file path
     *
     * @return string|false Full class name if found, false otherwise
     */
    protected function findClass($file)
=======
     * @return string|false Full class name if found, false otherwise
     */
    protected function findClass(string $file)
>>>>>>> v2-test
    {
        $class = false;
        $namespace = false;
        $tokens = token_get_all(file_get_contents($file));
<<<<<<< HEAD
=======

        if (1 === \count($tokens) && \T_INLINE_HTML === $tokens[0][0]) {
            throw new \InvalidArgumentException(sprintf('The file "%s" does not contain PHP code. Did you forgot to add the "<?php" start tag at the beginning of the file?', $file));
        }

        $nsTokens = [\T_NS_SEPARATOR => true, \T_STRING => true];
        if (\defined('T_NAME_QUALIFIED')) {
            $nsTokens[\T_NAME_QUALIFIED] = true;
        }

>>>>>>> v2-test
        for ($i = 0; isset($tokens[$i]); ++$i) {
            $token = $tokens[$i];

            if (!isset($token[1])) {
                continue;
            }

<<<<<<< HEAD
            if (true === $class && T_STRING === $token[0]) {
                return $namespace.'\\'.$token[1];
            }

            if (true === $namespace && T_STRING === $token[0]) {
                $namespace = $token[1];
                while (isset($tokens[++$i][1]) && in_array($tokens[$i][0], array(T_NS_SEPARATOR, T_STRING))) {
=======
            if (true === $class && \T_STRING === $token[0]) {
                return $namespace.'\\'.$token[1];
            }

            if (true === $namespace && isset($nsTokens[$token[0]])) {
                $namespace = $token[1];
                while (isset($tokens[++$i][1], $nsTokens[$tokens[$i][0]])) {
>>>>>>> v2-test
                    $namespace .= $tokens[$i][1];
                }
                $token = $tokens[$i];
            }

<<<<<<< HEAD
            if (T_CLASS === $token[0]) {
                // Skip usage of ::class constant
                $isClassConstant = false;
=======
            if (\T_CLASS === $token[0]) {
                // Skip usage of ::class constant and anonymous classes
                $skipClassToken = false;
>>>>>>> v2-test
                for ($j = $i - 1; $j > 0; --$j) {
                    if (!isset($tokens[$j][1])) {
                        break;
                    }

<<<<<<< HEAD
                    if (T_DOUBLE_COLON === $tokens[$j][0]) {
                        $isClassConstant = true;
                        break;
                    } elseif (!in_array($tokens[$j][0], array(T_WHITESPACE, T_DOC_COMMENT, T_COMMENT))) {
=======
                    if (\T_DOUBLE_COLON === $tokens[$j][0] || \T_NEW === $tokens[$j][0]) {
                        $skipClassToken = true;
                        break;
                    } elseif (!\in_array($tokens[$j][0], [\T_WHITESPACE, \T_DOC_COMMENT, \T_COMMENT])) {
>>>>>>> v2-test
                        break;
                    }
                }

<<<<<<< HEAD
                if (!$isClassConstant) {
=======
                if (!$skipClassToken) {
>>>>>>> v2-test
                    $class = true;
                }
            }

<<<<<<< HEAD
            if (T_NAMESPACE === $token[0]) {
=======
            if (\T_NAMESPACE === $token[0]) {
>>>>>>> v2-test
                $namespace = true;
            }
        }

        return false;
    }
}
