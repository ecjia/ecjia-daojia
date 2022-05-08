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

namespace PhpSpec\Loader;

<<<<<<< HEAD
use PhpSpec\Util\MethodAnalyser;
use PhpSpec\Locator\ResourceManagerInterface;
=======
use PhpSpec\Locator\Resource;
use PhpSpec\Specification\ErrorSpecification;
use PhpSpec\Util\MethodAnalyser;
use PhpSpec\Locator\ResourceManager;
>>>>>>> v2-test
use ReflectionClass;
use ReflectionMethod;

class ResourceLoader
{
    /**
<<<<<<< HEAD
     * @var ResourceManagerInterface
=======
     * @var ResourceManager
>>>>>>> v2-test
     */
    private $manager;
    /**
     * @var MethodAnalyser
     */
    private $methodAnalyser;

    /**
<<<<<<< HEAD
     * @param ResourceManagerInterface $manager
     */
    public function __construct(ResourceManagerInterface $manager, MethodAnalyser $methodAnalyser = null)
    {
        $this->manager = $manager;
        $this->methodAnalyser = $methodAnalyser ?: new MethodAnalyser();
=======
     * @param ResourceManager $manager
     * @param MethodAnalyser $methodAnalyser
     */
    public function __construct(ResourceManager $manager, MethodAnalyser $methodAnalyser)
    {
        $this->manager = $manager;
        $this->methodAnalyser = $methodAnalyser;
>>>>>>> v2-test
    }

    /**
     * @param string       $locator
     * @param integer|null $line
     *
     * @return Suite
     */
<<<<<<< HEAD
    public function load($locator, $line = null)
=======
    public function load(string $locator = '', int $line = null): Suite
>>>>>>> v2-test
    {
        $suite = new Suite();
        foreach ($this->manager->locateResources($locator) as $resource) {
            if (!class_exists($resource->getSpecClassname(), false) && is_file($resource->getSpecFilename())) {
<<<<<<< HEAD
                require_once StreamWrapper::wrapPath($resource->getSpecFilename());
=======
                try {
                    require_once StreamWrapper::wrapPath($resource->getSpecFilename());
                }
                catch (\Error $e) {
                    $this->addErrorThrowingExampleToSuite($resource, $suite, $e);
                    continue;
                }
>>>>>>> v2-test
            }
            if (!class_exists($resource->getSpecClassname(), false)) {
                continue;
            }

            $reflection = new ReflectionClass($resource->getSpecClassname());

            if ($reflection->isAbstract()) {
                continue;
            }
<<<<<<< HEAD
            if (!$reflection->implementsInterface('PhpSpec\SpecificationInterface')) {
=======
            if (!$reflection->implementsInterface('PhpSpec\Specification')) {
>>>>>>> v2-test
                continue;
            }

            $spec = new Node\SpecificationNode($resource->getSrcClassname(), $reflection, $resource);
            foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                if (!preg_match('/^(it|its)[^a-zA-Z]/', $method->getName())) {
                    continue;
                }
                if (null !== $line && !$this->lineIsInsideMethod($line, $method)) {
                    continue;
                }

                $example = new Node\ExampleNode(str_replace('_', ' ', $method->getName()), $method);

                if ($this->methodAnalyser->reflectionMethodIsEmpty($method)) {
                    $example->markAsPending();
                }

                $spec->addExample($example);
            }

            $suite->addSpecification($spec);
        }

        return $suite;
    }

    /**
     * @param int              $line
     * @param ReflectionMethod $method
     *
     * @return bool
     */
<<<<<<< HEAD
    private function lineIsInsideMethod($line, ReflectionMethod $method)
    {
        $line = intval($line);

        return $line >= $method->getStartLine() && $line <= $method->getEndLine();
    }
=======
    private function lineIsInsideMethod(int $line, ReflectionMethod $method): bool
    {
        $line = \intval($line);

        return $line >= $method->getStartLine() && $line <= $method->getEndLine();
    }

    private function addErrorThrowingExampleToSuite(Resource $resource, Suite $suite, \Error $error)
    {
        $reflection = new ReflectionClass(ErrorSpecification::class);
        $spec = new Node\SpecificationNode($resource->getSrcClassname(), $reflection, $resource);

        $errorFunction = new \ReflectionFunction(
            function () use ($error) {
                throw $error;
            }
        );
        $example = new Node\ExampleNode('Loading specification', $errorFunction);

        $spec->addExample($example);
        $suite->addSpecification($spec);
    }
>>>>>>> v2-test
}
