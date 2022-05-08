<?php

namespace spec\PhpSpec\Wrapper\Subject\Expectation;

<<<<<<< HEAD
use PhpSpec\ObjectBehavior;
use PhpSpec\Wrapper\Subject;
use PhpSpec\Wrapper\Subject\WrappedObject;
use Prophecy\Argument;

use PhpSpec\Wrapper\Subject\Expectation\ExpectationInterface;

class ConstructorDecoratorSpec extends ObjectBehavior
{
    function let(ExpectationInterface $expectation)
=======
use Error;
use Exception;
use PhpSpec\Exception\ErrorException;
use PhpSpec\Exception\Fracture\FractureException;
use PhpSpec\ObjectBehavior;
use PhpSpec\Wrapper\Subject;
use PhpSpec\Wrapper\Subject\Expectation\Expectation;
use PhpSpec\Wrapper\Subject\WrappedObject;
use Prophecy\Argument;
use stdClass;

class ConstructorDecoratorSpec extends ObjectBehavior
{
    function let(Expectation $expectation)
>>>>>>> v2-test
    {
        $this->beConstructedWith($expectation);
    }

    function it_rethrows_php_errors_as_phpspec_error_exceptions(Subject $subject, WrappedObject $wrapped)
    {
<<<<<<< HEAD
        $subject->callOnWrappedObject('getWrappedObject', array())->willThrow('PhpSpec\Exception\Example\ErrorException');
=======
        $subject->__call('getWrappedObject', array())->willThrow('PhpSpec\Exception\Example\ErrorException');
>>>>>>> v2-test
        $this->shouldThrow('PhpSpec\Exception\Example\ErrorException')->duringMatch('be', $subject, array(), $wrapped);
    }

    function it_rethrows_fracture_errors_as_phpspec_error_exceptions(Subject $subject, WrappedObject $wrapped)
    {
        $subject->__call('getWrappedObject', array())->willThrow('PhpSpec\Exception\Fracture\FractureException');
        $this->shouldThrow('PhpSpec\Exception\Fracture\FractureException')->duringMatch('be', $subject, array(), $wrapped);
    }

    function it_ignores_any_other_exception(Subject $subject, WrappedObject $wrapped)
    {
<<<<<<< HEAD
        $subject->callOnWrappedObject('getWrappedObject', array())->willThrow('\Exception');
=======
        $subject->__call('getWrappedObject', array())->willThrow('\Exception');
>>>>>>> v2-test
        $wrapped->getClassName()->willReturn('\stdClass');
        $this->shouldNotThrow('\Exception')->duringMatch('be', $subject, array(), $wrapped);
    }
}
