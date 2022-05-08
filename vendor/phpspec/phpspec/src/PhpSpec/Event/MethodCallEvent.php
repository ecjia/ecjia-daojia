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

namespace PhpSpec\Event;

use PhpSpec\Loader\Node\ExampleNode;
<<<<<<< HEAD
use Symfony\Component\EventDispatcher\Event;
=======
use PhpSpec\Loader\Node\SpecificationNode;
use PhpSpec\Loader\Suite;
>>>>>>> v2-test

/**
 * Class MethodCallEvent holds information about method call events
 */
<<<<<<< HEAD
class MethodCallEvent extends Event implements EventInterface
=======
class MethodCallEvent extends BaseEvent implements PhpSpecEvent
>>>>>>> v2-test
{
    /**
     * @var ExampleNode
     */
    private $example;

    /**
     * @var mixed
     */
    private $subject;

    /**
     * @var string
     */
    private $method;

    /**
     * @var array
     */
    private $arguments;

    /**
     * @var mixed
     */
    private $returnValue;

    /**
     * @param ExampleNode $example
     * @param mixed       $subject
     * @param string      $method
     * @param array       $arguments
     * @param mixed       $returnValue
     */
    public function __construct(ExampleNode $example, $subject, $method, $arguments, $returnValue = null)
    {
        $this->example = $example;
        $this->subject = $subject;
        $this->method = $method;
        $this->arguments = $arguments;
        $this->returnValue = $returnValue;
    }

    /**
     * @return ExampleNode
     */
<<<<<<< HEAD
    public function getExample()
=======
    public function getExample(): ExampleNode
>>>>>>> v2-test
    {
        return $this->example;
    }

    /**
<<<<<<< HEAD
     * @return \PhpSpec\Loader\Node\SpecificationNode
     */
    public function getSpecification()
=======
     * @return SpecificationNode
     */
    public function getSpecification(): SpecificationNode
>>>>>>> v2-test
    {
        return $this->example->getSpecification();
    }

    /**
<<<<<<< HEAD
     * @return \PhpSpec\Loader\Suite
     */
    public function getSuite()
=======
     * @return Suite
     */
    public function getSuite(): Suite
>>>>>>> v2-test
    {
        return $this->example->getSpecification()->getSuite();
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    public function getMethod()
=======
    public function getMethod(): string
>>>>>>> v2-test
    {
        return $this->method;
    }

    /**
     * @return array
     */
<<<<<<< HEAD
    public function getArguments()
=======
    public function getArguments(): array
>>>>>>> v2-test
    {
        return $this->arguments;
    }

    /**
     * @return mixed
     */
    public function getReturnValue()
    {
        return $this->returnValue;
    }
}
