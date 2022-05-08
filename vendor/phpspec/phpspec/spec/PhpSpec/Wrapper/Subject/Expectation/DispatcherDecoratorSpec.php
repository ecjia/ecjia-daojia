<?php

namespace spec\PhpSpec\Wrapper\Subject\Expectation;

use PhpSpec\ObjectBehavior;
<<<<<<< HEAD
use Prophecy\Argument;

use PhpSpec\Wrapper\Subject\Expectation\ExpectationInterface;
use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\Matcher\MatcherInterface;
=======
use PhpSpec\Util\DispatchTrait;
use Prophecy\Argument;

use PhpSpec\Wrapper\Subject\Expectation\Expectation;
use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\Matcher\Matcher;
>>>>>>> v2-test
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use PhpSpec\Event\ExpectationEvent;

class DispatcherDecoratorSpec extends ObjectBehavior
{
<<<<<<< HEAD
    function let(ExpectationInterface $expectation, EventDispatcherInterface $dispatcher, MatcherInterface $matcher, ExampleNode $example)
    {
=======
    use DispatchTrait;

    function let(Expectation $expectation, EventDispatcherInterface $dispatcher, Matcher $matcher, ExampleNode $example)
    {
        $dispatcher->dispatch(Argument::any(), Argument::any())->willReturnArgument(0);
>>>>>>> v2-test
        $this->beConstructedWith($expectation, $dispatcher, $matcher, $example);
    }

    function it_implements_the_interface_of_the_decorated()
    {
<<<<<<< HEAD
        $this->shouldImplement('PhpSpec\Wrapper\Subject\Expectation\ExpectationInterface');
=======
        $this->shouldImplement('PhpSpec\Wrapper\Subject\Expectation\Expectation');
>>>>>>> v2-test
    }

    function it_dispatches_before_and_after_events(EventDispatcherInterface $dispatcher)
    {
        $alias = 'be';
        $subject = new \stdClass();
        $arguments = array();

<<<<<<< HEAD
        $dispatcher->dispatch('beforeExpectation', Argument::type('PhpSpec\Event\ExpectationEvent'))->shouldBeCalled();
        $dispatcher->dispatch('afterExpectation', Argument::which('getResult', ExpectationEvent::PASSED))->shouldBeCalled();
        $this->match($alias, $subject, $arguments);
    }

    function it_decorates_expectation_with_failed_event(ExpectationInterface $expectation, EventDispatcherInterface $dispatcher)
=======
        $this->dispatch($dispatcher, Argument::type('PhpSpec\Event\ExpectationEvent'), 'beforeExpectation')->shouldBeCalled();
        $this->dispatch($dispatcher, Argument::which('getResult', ExpectationEvent::PASSED), 'afterExpectation')->shouldBeCalled();
        $this->match($alias, $subject, $arguments);
    }

    function it_decorates_expectation_with_failed_event(Expectation $expectation, EventDispatcherInterface $dispatcher)
>>>>>>> v2-test
    {
        $alias = 'be';
        $subject = new \stdClass();
        $arguments = array();

        $expectation->match(Argument::cetera())->willThrow('PhpSpec\Exception\Example\FailureException');

<<<<<<< HEAD
        $dispatcher->dispatch('beforeExpectation', Argument::type('PhpSpec\Event\ExpectationEvent'))->shouldBeCalled();
        $dispatcher->dispatch('afterExpectation', Argument::which('getResult', ExpectationEvent::FAILED))->shouldBeCalled();
=======
        $this->dispatch($dispatcher, Argument::type('PhpSpec\Event\ExpectationEvent'), 'beforeExpectation')->shouldBeCalled();
        $this->dispatch($dispatcher, Argument::which('getResult', ExpectationEvent::FAILED), 'afterExpectation')->shouldBeCalled();
>>>>>>> v2-test

        $this->shouldThrow('PhpSpec\Exception\Example\FailureException')->duringMatch($alias, $subject, $arguments);
    }

<<<<<<< HEAD
    function it_decorates_expectation_with_broken_event(ExpectationInterface $expectation, EventDispatcherInterface $dispatcher)
=======
    function it_decorates_expectation_with_broken_event(Expectation $expectation, EventDispatcherInterface $dispatcher)
>>>>>>> v2-test
    {
        $alias = 'be';
        $subject = new \stdClass();
        $arguments = array();

        $expectation->match(Argument::cetera())->willThrow('\RuntimeException');

<<<<<<< HEAD
        $dispatcher->dispatch('beforeExpectation', Argument::type('PhpSpec\Event\ExpectationEvent'))->shouldBeCalled();
        $dispatcher->dispatch('afterExpectation', Argument::which('getResult', ExpectationEvent::BROKEN))->shouldBeCalled();
=======
        $this->dispatch($dispatcher, Argument::type('PhpSpec\Event\ExpectationEvent'), 'beforeExpectation')->shouldBeCalled();
        $this->dispatch($dispatcher, Argument::which('getResult', ExpectationEvent::BROKEN), 'afterExpectation')->shouldBeCalled();
>>>>>>> v2-test

        $this->shouldThrow('\RuntimeException')->duringMatch($alias, $subject, $arguments);
    }
}
