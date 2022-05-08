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

use ReflectionFunctionAbstract;

class ExampleNode
{
    /**
     * @var string
     */
    private $title;
    /**
     * @var \ReflectionFunctionAbstract
     */
    private $function;
    /**
     * @var SpecificationNode|null
     */
    private $specification;
    /**
     * @var bool
     */
    private $isPending = false;

    /**
     * @param string                     $title
     * @param ReflectionFunctionAbstract $function
     */
<<<<<<< HEAD
    public function __construct($title, ReflectionFunctionAbstract $function)
    {
        $this->title    = $title;
=======
    public function __construct(string $title, ReflectionFunctionAbstract $function)
    {
        $this->setTitle($title);
>>>>>>> v2-test
        $this->function = $function;
    }

    /**
<<<<<<< HEAD
     * @return string
     */
    public function getTitle()
=======
     * @param string $title
     */
    public function setTitle(string $title)
    {
      $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle(): string
>>>>>>> v2-test
    {
        return $this->title;
    }

    /**
     * @param bool $isPending
     */
<<<<<<< HEAD
    public function markAsPending($isPending = true)
=======
    public function markAsPending(bool $isPending = true): void
>>>>>>> v2-test
    {
        $this->isPending = $isPending;
    }

    /**
     * @return bool
     */
<<<<<<< HEAD
    public function isPending()
=======
    public function isPending(): bool
>>>>>>> v2-test
    {
        return $this->isPending;
    }

    /**
     * @return ReflectionFunctionAbstract
     */
<<<<<<< HEAD
    public function getFunctionReflection()
=======
    public function getFunctionReflection(): ReflectionFunctionAbstract
>>>>>>> v2-test
    {
        return $this->function;
    }

    /**
     * @param SpecificationNode $specification
     */
<<<<<<< HEAD
    public function setSpecification(SpecificationNode $specification)
=======
    public function setSpecification(SpecificationNode $specification): void
>>>>>>> v2-test
    {
        $this->specification = $specification;
    }

    /**
     * @return SpecificationNode|null
     */
    public function getSpecification()
    {
        return $this->specification;
    }
<<<<<<< HEAD
=======

    /**
     * @return int
     */
    public function getLineNumber(): int
    {
        return $this->function->isClosure() ? 0 : $this->function->getStartLine();
    }
>>>>>>> v2-test
}
