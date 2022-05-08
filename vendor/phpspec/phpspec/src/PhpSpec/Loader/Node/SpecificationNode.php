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

namespace PhpSpec\Loader\Node;

use PhpSpec\Loader\Suite;
<<<<<<< HEAD
use PhpSpec\Locator\ResourceInterface;
=======
use PhpSpec\Locator\Resource;
>>>>>>> v2-test
use ReflectionClass;

class SpecificationNode implements \Countable
{
    /**
     * @var string
     */
    private $title;
    /**
     * @var \ReflectionClass
     */
    private $class;
    /**
<<<<<<< HEAD
     * @var ResourceInterface
=======
     * @var Resource
>>>>>>> v2-test
     */
    private $resource;
    /**
     * @var Suite
     */
    private $suite;
    /**
     * @var ExampleNode[]
     */
    private $examples = array();

    /**
     * @param string            $title
     * @param ReflectionClass   $class
<<<<<<< HEAD
     * @param ResourceInterface $resource
     */
    public function __construct($title, ReflectionClass $class, ResourceInterface $resource)
=======
     * @param Resource $resource
     */
    public function __construct(string $title, ReflectionClass $class, Resource $resource)
>>>>>>> v2-test
    {
        $this->title    = $title;
        $this->class    = $class;
        $this->resource = $resource;
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    public function getTitle()
=======
    public function getTitle(): string
>>>>>>> v2-test
    {
        return $this->title;
    }

    /**
     * @return ReflectionClass
     */
<<<<<<< HEAD
    public function getClassReflection()
=======
    public function getClassReflection(): ReflectionClass
>>>>>>> v2-test
    {
        return $this->class;
    }

    /**
<<<<<<< HEAD
     * @return ResourceInterface
     */
    public function getResource()
=======
     * @return Resource
     */
    public function getResource(): Resource
>>>>>>> v2-test
    {
        return $this->resource;
    }

    /**
     * @param ExampleNode $example
     */
<<<<<<< HEAD
    public function addExample(ExampleNode $example)
=======
    public function addExample(ExampleNode $example): void
>>>>>>> v2-test
    {
        $this->examples[] = $example;
        $example->setSpecification($this);
    }

    /**
     * @return ExampleNode[]
     */
<<<<<<< HEAD
    public function getExamples()
=======
    public function getExamples(): array
>>>>>>> v2-test
    {
        return $this->examples;
    }

    /**
     * @param Suite $suite
     */
    public function setSuite(Suite $suite)
    {
        $this->suite = $suite;
    }

    /**
     * @return Suite|null
     */
    public function getSuite()
    {
        return $this->suite;
    }

    /**
     * @return int
     */
<<<<<<< HEAD
    public function count()
    {
        return count($this->examples);
=======
    public function count(): int
    {
        return \count($this->examples);
>>>>>>> v2-test
    }
}
