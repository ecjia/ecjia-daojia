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

<<<<<<< HEAD
use Symfony\Component\EventDispatcher\Event;
use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\Matcher\MatcherInterface;
=======
use PhpSpec\Loader\Node\SpecificationNode;
use PhpSpec\Loader\Suite;
use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\Matcher\Matcher;
>>>>>>> v2-test

/**
 * Class ExpectationEvent holds information about the expectation event
 */
<<<<<<< HEAD
class ExpectationEvent extends Event implements EventInterface
=======
final class ExpectationEvent extends BaseEvent implements PhpSpecEvent
>>>>>>> v2-test
{
    /**
     * Expectation passed
     */
    const PASSED  = 0;

    /**
     * Expectation failed
     */
    const FAILED  = 1;

    /**
     * Expectation broken
     */
    const BROKEN  = 2;

    /**
     * @var ExampleNode
     */
    private $example;

    /**
<<<<<<< HEAD
     * @var MatcherInterface
=======
     * @var Matcher
>>>>>>> v2-test
     */
    private $matcher;

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
     * @var integer
     */
    private $result;

    /**
     * @var \Exception
     */
    private $exception;

    /**
     * @param ExampleNode      $example
<<<<<<< HEAD
     * @param MatcherInterface $matcher
=======
     * @param Matcher $matcher
>>>>>>> v2-test
     * @param mixed            $subject
     * @param string           $method
     * @param array            $arguments
     * @param integer          $result
     * @param \Exception       $exception
     */
    public function __construct(
        ExampleNode $example,
<<<<<<< HEAD
        MatcherInterface $matcher,
        $subject,
        $method,
        $arguments,
        $result = null,
=======
        Matcher $matcher,
        $subject,
        $method,
        $arguments,
        $result = self::PASSED,
>>>>>>> v2-test
        $exception = null
    ) {
        $this->example = $example;
        $this->matcher = $matcher;
        $this->subject = $subject;
        $this->method = $method;
        $this->arguments = $arguments;
        $this->result = $result;
        $this->exception = $exception;
    }

    /**
<<<<<<< HEAD
     * @return MatcherInterface
     */
    public function getMatcher()
=======
     * @return Matcher
     */
    public function getMatcher(): Matcher
>>>>>>> v2-test
    {
        return $this->matcher;
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
<<<<<<< HEAD
     * @return \Exception
=======
     * @return \Exception|null
>>>>>>> v2-test
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @return integer
     */
<<<<<<< HEAD
    public function getResult()
=======
    public function getResult(): int
>>>>>>> v2-test
    {
        return $this->result;
    }
}
