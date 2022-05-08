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
=======
use PhpSpec\Loader\Node\SpecificationNode;
use PhpSpec\Loader\Suite;
>>>>>>> v2-test
use PhpSpec\Loader\Node\ExampleNode;

/**
 * Class ExampleEvent holds the information about the example event
 */
<<<<<<< HEAD
class ExampleEvent extends Event implements EventInterface
=======
class ExampleEvent extends BaseEvent implements PhpSpecEvent
>>>>>>> v2-test
{
    /**
     * Spec passed
     */
    const PASSED  = 0;

    /**
     * Spec is pending
     */
    const PENDING = 1;

    /**
     * Spec is skipped
     */
    const SKIPPED = 2;

    /**
     * Spec failed
     */
    const FAILED  = 3;

    /**
     * Spec is broken
     */
    const BROKEN  = 4;

    /**
     * @var ExampleNode
     */
    private $example;

    /**
     * @var float
     */
    private $time;

    /**
     * @var integer
     */
    private $result;

    /**
     * @var \Exception
     */
    private $exception;

    /**
     * @param ExampleNode  $example
     * @param float|null   $time
     * @param integer|null $result
     * @param \Exception   $exception
     */
    public function __construct(
        ExampleNode $example,
<<<<<<< HEAD
        $time = null,
        $result = null,
=======
        float $time = 0.0,
        int $result = self::PASSED,
>>>>>>> v2-test
        \Exception $exception = null
    ) {
        $this->example   = $example;
        $this->time      = $time;
        $this->result    = $result;
        $this->exception = $exception;
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
        return $this->getSpecification()->getSuite();
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
        return $this->example->getTitle();
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    public function getMessage()
=======
    public function getMessage(): string
>>>>>>> v2-test
    {
        return $this->exception->getMessage();
    }

    /**
     * @return array
     */
<<<<<<< HEAD
    public function getBacktrace()
=======
    public function getBacktrace(): array
>>>>>>> v2-test
    {
        return $this->exception->getTrace();
    }

    /**
     * @return float
     */
<<<<<<< HEAD
    public function getTime()
=======
    public function getTime(): float
>>>>>>> v2-test
    {
        return $this->time;
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
}
