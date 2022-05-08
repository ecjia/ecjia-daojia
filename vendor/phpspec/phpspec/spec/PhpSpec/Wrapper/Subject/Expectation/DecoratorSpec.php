<?php

namespace spec\PhpSpec\Wrapper\Subject\Expectation;

use PhpSpec\ObjectBehavior;
<<<<<<< HEAD
use Prophecy\Argument;

use PhpSpec\Wrapper\Subject\Expectation\Decorator as AbstractDecorator;
use PhpSpec\Wrapper\Subject\Expectation\ExpectationInterface;

class DecoratorSpec extends ObjectBehavior
{
    function let(ExpectationInterface $expectation)
=======

use PhpSpec\Wrapper\Subject\Expectation\Decorator as AbstractDecorator;
use PhpSpec\Wrapper\Subject\Expectation\Expectation;

class DecoratorSpec extends ObjectBehavior
{
    function let(Expectation $expectation)
>>>>>>> v2-test
    {
        $this->beAnInstanceOf('spec\PhpSpec\Wrapper\Subject\Expectation\Decorator');
        $this->beConstructedWith($expectation);
    }

<<<<<<< HEAD
    function it_returns_the_decorated_expectation(ExpectationInterface $expectation)
=======
    function it_returns_the_decorated_expectation(Expectation $expectation)
>>>>>>> v2-test
    {
        $this->getExpectation()->shouldReturn($expectation);
    }

<<<<<<< HEAD
    function it_keeps_looking_for_nested_expectations(AbstractDecorator $decorator, ExpectationInterface $expectation)
=======
    function it_keeps_looking_for_nested_expectations(AbstractDecorator $decorator, Expectation $expectation)
>>>>>>> v2-test
    {
        $decorator->getExpectation()->willReturn($expectation);
        $this->beAnInstanceOf('spec\PhpSpec\Wrapper\Subject\Expectation\Decorator');
        $this->beConstructedWith($decorator);

        $this->getNestedExpectation()->shouldReturn($expectation);
    }
}

class Decorator extends AbstractDecorator
{
<<<<<<< HEAD
    public function match($alias, $subject, array $arguments = array())
=======
    public function match(string $alias, $subject, array $arguments = array())
>>>>>>> v2-test
    {
    }
}
