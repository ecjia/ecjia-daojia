<?php

/*
 * This file is part of PhpSpec, A php toolset to drive emergent
 * design by specification.
 *
 * (c) Marcello Duarte <marcello.duarte@gmail.com>
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpSpec\Locator\PSR0;

<<<<<<< HEAD
use PhpSpec\Locator\ResourceInterface;
use PhpSpec\Locator\ResourceLocatorInterface;
use PhpSpec\Util\Filesystem;
use InvalidArgumentException;

class PSR0Locator implements ResourceLocatorInterface
=======
use PhpSpec\Locator\ResourceLocator;
use PhpSpec\Locator\SrcPathLocator;
use PhpSpec\Util\Filesystem;
use InvalidArgumentException;

class PSR0Locator implements ResourceLocator, SrcPathLocator
>>>>>>> v2-test
{
    /**
     * @var string
     */
    private $srcPath;
    /**
     * @var string
     */
    private $specPath;
    /**
     * @var string
     */
    private $srcNamespace;
    /**
     * @var string
     */
    private $specNamespace;
    /**
     * @var string
     */
    private $fullSrcPath;
    /**
     * @var string
     */
    private $fullSpecPath;
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var string
     */
    private $psr4Prefix;

    /**
<<<<<<< HEAD
=======
     * @param Filesystem $filesystem
>>>>>>> v2-test
     * @param string     $srcNamespace
     * @param string     $specNamespacePrefix
     * @param string     $srcPath
     * @param string     $specPath
<<<<<<< HEAD
     * @param Filesystem $filesystem
     * @param string     $psr4Prefix
     */
    public function __construct(
        $srcNamespace = '',
        $specNamespacePrefix = 'spec',
        $srcPath = 'src',
        $specPath = '.',
        Filesystem $filesystem = null,
        $psr4Prefix = null
    ) {
        $this->filesystem = $filesystem ?: new Filesystem();
=======
     * @param string     $psr4Prefix
     */
    public function __construct(
        Filesystem $filesystem,
        string $srcNamespace = '',
        string $specNamespacePrefix = 'spec',
        string $srcPath = 'src',
        string $specPath = '.',
        string $psr4Prefix = null
    ) {
        $this->filesystem = $filesystem;
>>>>>>> v2-test
        $sepr = DIRECTORY_SEPARATOR;

        $this->srcPath       = rtrim(realpath($srcPath), '/\\').$sepr;
        $this->specPath      = rtrim(realpath($specPath), '/\\').$sepr;
        $this->srcNamespace  = ltrim(trim($srcNamespace, ' \\').'\\', '\\');
        $this->psr4Prefix    = (null === $psr4Prefix) ? null : ltrim(trim($psr4Prefix, ' \\').'\\', '\\');
<<<<<<< HEAD
        if (null !== $this->psr4Prefix  && substr($this->srcNamespace, 0, strlen($psr4Prefix)) !== $psr4Prefix) {
=======
        if (null !== $this->psr4Prefix  && substr($this->srcNamespace, 0, \strlen($this->psr4Prefix)) !== $this->psr4Prefix) {
>>>>>>> v2-test
            throw new InvalidArgumentException('PSR4 prefix doesn\'t match given class namespace.'.PHP_EOL);
        }
        $srcNamespacePath = null === $this->psr4Prefix ?
            $this->srcNamespace :
<<<<<<< HEAD
            substr($this->srcNamespace, strlen($this->psr4Prefix));
=======
            substr($this->srcNamespace, \strlen($this->psr4Prefix));
>>>>>>> v2-test
        $this->specNamespace = $specNamespacePrefix ?
            trim($specNamespacePrefix, ' \\').'\\'.$this->srcNamespace :
            $this->srcNamespace;
        $specNamespacePath = $specNamespacePrefix ?
            trim($specNamespacePrefix, ' \\').'\\'.$srcNamespacePath :
            $srcNamespacePath;

        $this->fullSrcPath   = $this->srcPath.str_replace('\\', $sepr, $srcNamespacePath);
        $this->fullSpecPath  = $this->specPath.str_replace('\\', $sepr, $specNamespacePath);

        if ($sepr === $this->srcPath) {
            throw new InvalidArgumentException(sprintf(
                'Source code path should be existing filesystem path, but "%s" given.',
                $srcPath
            ));
        }

        if ($sepr === $this->specPath) {
            throw new InvalidArgumentException(sprintf(
                'Specs code path should be existing filesystem path, but "%s" given.',
                $specPath
            ));
        }
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    public function getFullSrcPath()
=======
    public function getFullSrcPath(): string
>>>>>>> v2-test
    {
        return $this->fullSrcPath;
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    public function getFullSpecPath()
=======
    public function getFullSpecPath(): string
>>>>>>> v2-test
    {
        return $this->fullSpecPath;
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    public function getSrcNamespace()
=======
    public function getSrcNamespace(): string
>>>>>>> v2-test
    {
        return $this->srcNamespace;
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    public function getSpecNamespace()
=======
    public function getSpecNamespace(): string
>>>>>>> v2-test
    {
        return $this->specNamespace;
    }

    /**
<<<<<<< HEAD
     * @return ResourceInterface[]
     */
    public function getAllResources()
=======
     * @return Resource[]
     */
    public function getAllResources(): array
>>>>>>> v2-test
    {
        return $this->findSpecResources($this->fullSpecPath);
    }

    /**
     * @param string $query
     *
     * @return bool
     */
<<<<<<< HEAD
    public function supportsQuery($query)
=======
    public function supportsQuery(string $query): bool
>>>>>>> v2-test
    {
        $path = $this->getQueryPath($query);

        if (null === $path) {
            return false;
        }

        return 0 === strpos($path, $this->srcPath)
            || 0 === strpos($path, $this->specPath)
        ;
    }

    /**
     * @return boolean
     */
<<<<<<< HEAD
    public function isPSR4()
=======
    public function isPSR4(): bool
>>>>>>> v2-test
    {
        return $this->psr4Prefix !== null;
    }

    /**
     * @param string $query
     *
<<<<<<< HEAD
     * @return ResourceInterface[]
     */
    public function findResources($query)
=======
     * @return Resource[]
     */
    public function findResources(string $query)
>>>>>>> v2-test
    {
        $path = $this->getQueryPath($query);

        if ('.php' !== substr($path, -4)) {
            $path .= DIRECTORY_SEPARATOR;
        }

        if ($path && 0 === strpos($path, $this->fullSpecPath)) {
            return $this->findSpecResources($path);
        }

        if ($path && 0 === strpos($path, $this->fullSrcPath)) {
<<<<<<< HEAD
            $path = $this->fullSpecPath.substr($path, strlen($this->fullSrcPath));
=======
            $path = $this->fullSpecPath.substr($path, \strlen($this->fullSrcPath));
>>>>>>> v2-test
            $path = preg_replace('/\.php/', 'Spec.php', $path);

            return $this->findSpecResources($path);
        }

        if ($path && 0 === strpos($path, $this->srcPath)) {
<<<<<<< HEAD
            $path = $this->fullSpecPath.substr($path, strlen($this->srcPath));
=======
            $path = $this->fullSpecPath.substr($path, \strlen($this->srcPath));
>>>>>>> v2-test
            $path = preg_replace('/\.php/', 'Spec.php', $path);

            return $this->findSpecResources($path);
        }

        return array();
    }

    /**
     * @param string $classname
     *
     * @return bool
     */
<<<<<<< HEAD
    public function supportsClass($classname)
=======
    public function supportsClass(string $classname): bool
>>>>>>> v2-test
    {
        $classname = str_replace('/', '\\', $classname);

        return '' === $this->srcNamespace
            || 0  === strpos($classname, $this->srcNamespace)
            || 0  === strpos($classname, $this->specNamespace)
        ;
    }

    /**
     * @param string $classname
     *
     * @return null|PSR0Resource
     */
<<<<<<< HEAD
    public function createResource($classname)
=======
    public function createResource(string $classname)
>>>>>>> v2-test
    {
        $classname = ltrim($classname, '\\');
        $this->validatePsr0Classname($classname);

        $classname = str_replace('/', '\\', $classname);

        if (0 === strpos($classname, $this->specNamespace)) {
<<<<<<< HEAD
            $relative = substr($classname, strlen($this->specNamespace));
=======
            $relative = substr($classname, \strlen($this->specNamespace));
>>>>>>> v2-test

            return new PSR0Resource(explode('\\', $relative), $this);
        }

        if ('' === $this->srcNamespace || 0 === strpos($classname, $this->srcNamespace)) {
<<<<<<< HEAD
            $relative = substr($classname, strlen($this->srcNamespace));
=======
            $relative = substr($classname, \strlen($this->srcNamespace));
>>>>>>> v2-test

            return new PSR0Resource(explode('\\', $relative), $this);
        }

        return null;
    }

    /**
     * @return int
     */
<<<<<<< HEAD
    public function getPriority()
=======
    public function getPriority(): int
>>>>>>> v2-test
    {
        return 0;
    }

    /**
     * @param string $path
     *
     * @return PSR0Resource[]
     */
<<<<<<< HEAD
    protected function findSpecResources($path)
=======
    protected function findSpecResources(string $path)
>>>>>>> v2-test
    {
        if (!$this->filesystem->pathExists($path)) {
            return array();
        }

        if ('.php' === substr($path, -4)) {
            return array($this->createResourceFromSpecFile(realpath($path)));
        }

        $resources = array();
        foreach ($this->filesystem->findSpecFilesIn($path) as $file) {
            $resources[] = $this->createResourceFromSpecFile($file->getRealPath());
        }

        return $resources;
    }

    /**
     * @param $path
     *
     * @return null|string
     */
    private function findSpecClassname($path)
    {
        // Find namespace and class name
        $namespace = '';
        $content   = $this->filesystem->getFileContents($path);
        $tokens    = token_get_all($content);
<<<<<<< HEAD
        $count     = count($tokens);
=======
        $count     = \count($tokens);
>>>>>>> v2-test

        for ($i = 0; $i < $count; $i++) {
            if ($tokens[$i][0] === T_NAMESPACE) {
                for ($j = $i + 1; $j < $count; $j++) {
<<<<<<< HEAD
                    if ($tokens[$j][0] === T_STRING) {
=======
                    if ($tokens[$j][0] === T_STRING
                        || \PHP_VERSION_ID >= 80000 && ($tokens[$j][0] === T_NAME_FULLY_QUALIFIED || $tokens[$j][0] === T_NAME_QUALIFIED)) {
>>>>>>> v2-test
                        $namespace .= $tokens[$j][1].'\\';
                    } elseif ($tokens[$j] === '{' || $tokens[$j] === ';') {
                        break;
                    }
                }
            }

            if ($tokens[$i][0] === T_CLASS) {
                for ($j = $i+1; $j < $count; $j++) {
                    if ($tokens[$j] === '{') {
                        return $namespace.$tokens[$i+2][1];
                    }
                }
            }
        }

        // No class found
        return null;
    }

    /**
     * @param string $path
     *
     * @return PSR0Resource
     */
<<<<<<< HEAD
    private function createResourceFromSpecFile($path)
=======
    private function createResourceFromSpecFile(string $path): PSR0Resource
>>>>>>> v2-test
    {
        $classname = $this->findSpecClassname($path);

        if (null === $classname) {
            throw new \RuntimeException(sprintf('Spec file "%s" does not contains any class definition.', $path));
        }

        // Remove spec namespace from the begining of the classname.
        $specNamespace = trim($this->getSpecNamespace(), '\\').'\\';

        if (0 !== strpos($classname, $specNamespace)) {
            throw new \RuntimeException(sprintf(
                'Spec class `%s` must be in the base spec namespace `%s`.',
                $classname,
                $this->getSpecNamespace()
            ));
        }

<<<<<<< HEAD
        $classname = substr($classname, strlen($specNamespace));
=======
        $classname = substr($classname, \strlen($specNamespace));
>>>>>>> v2-test

        // cut "Spec" from the end
        $classname = preg_replace('/Spec$/', '', $classname);

        // Create the resource
        return new PSR0Resource(explode('\\', $classname), $this);
    }

    /**
     * @param string $classname
     *
     * @throws InvalidArgumentException
     */
<<<<<<< HEAD
    private function validatePsr0Classname($classname)
    {
        $pattern = '/^([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*[\/\\\\]?)*[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/';
=======
    private function validatePsr0Classname(string $classname)
    {
        $pattern = '/\A([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*[\/\\\\]?)*[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*\z/';
>>>>>>> v2-test

        if (!preg_match($pattern, $classname)) {
            throw new InvalidArgumentException(
                sprintf('String "%s" is not a valid class name.', $classname).PHP_EOL.
                'Please see reference document: '.
                'https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md'
            );
        }
    }

    /**
     * @param string $query
     *
     * @return string
     */
<<<<<<< HEAD
    private function getQueryPath($query)
=======
    private function getQueryPath(string $query): string
>>>>>>> v2-test
    {
        $sepr = DIRECTORY_SEPARATOR;
        $replacedQuery = str_replace(array('\\', '/'), $sepr, $query);

        if ($this->queryContainsQualifiedClassName($query)) {
            $namespacedQuery = null === $this->psr4Prefix ?
                $replacedQuery :
<<<<<<< HEAD
                substr($replacedQuery, strlen($this->srcNamespace));
=======
                substr($replacedQuery, \strlen($this->srcNamespace));
>>>>>>> v2-test

            $path = $this->fullSpecPath . $namespacedQuery . 'Spec.php';

            if ($this->filesystem->pathExists($path)) {
                return $path;
            }
        }

        return rtrim(realpath($replacedQuery), $sepr);
    }

    /**
     * @param string $query
     *
     * @return bool
     */
<<<<<<< HEAD
    private function queryContainsQualifiedClassName($query)
=======
    private function queryContainsQualifiedClassName(string $query): bool
>>>>>>> v2-test
    {
        return $this->queryContainsBlackslashes($query) && !$this->isWindowsPath($query);
    }

    /**
     * @param string $query
     *
     * @return bool
     */
<<<<<<< HEAD
    private function queryContainsBlackslashes($query)
=======
    private function queryContainsBlackslashes(string $query): bool
>>>>>>> v2-test
    {
        return false !== strpos($query, '\\');
    }

    /**
     * @param string $query
     *
     * @return bool
     */
<<<<<<< HEAD
    private function isWindowsPath($query)
=======
    private function isWindowsPath(string $query): bool
>>>>>>> v2-test
    {
        return preg_match('/^\w:/', $query);
    }
}
