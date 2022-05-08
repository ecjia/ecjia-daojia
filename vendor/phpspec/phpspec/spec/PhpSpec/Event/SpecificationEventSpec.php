<?php

namespace spec\PhpSpec\Event;

use PhpSpec\ObjectBehavior;

use PhpSpec\Event\ExampleEvent as Example;
use PhpSpec\Loader\Node\SpecificationNode;
use PhpSpec\Loader\Suite;

class SpecificationEventSpec extends ObjectBehavior
{
    function let(Suite $suite, SpecificationNode $specification)
    {
        $this->beConstructedWith($specification, 10, Example::FAILED);

        $specification->getSuite()->willReturn($suite);
    }

    function it_is_an_event()
    {
<<<<<<< HEAD
        $this->shouldBeAnInstanceOf('Symfony\Component\EventDispatcher\Event');
        $this->shouldBeAnInstanceOf('PhpSpec\Event\EventInterface');
=======
        $this->shouldBeAnInstanceOf('PhpSpec\Event\BaseEvent');
        $this->shouldBeAnInstanceOf('PhpSpec\Event\PhpSpecEvent');
>>>>>>> v2-test
    }

    function it_provides_a_link_to_suite($suite)
    {
        $this->getSuite()->shouldReturn($suite);
    }

    function it_provides_a_link_to_specification($specification)
    {
        $this->getSpecification()->shouldReturn($specification);
    }

    function it_provides_a_link_to_time()
    {
<<<<<<< HEAD
        $this->getTime()->shouldReturn(10);
=======
        $this->getTime()->shouldReturn(10.0);
>>>>>>> v2-test
    }

    function it_provides_a_link_to_result()
    {
        $this->getResult()->shouldReturn(Example::FAILED);
    }
<<<<<<< HEAD
=======

    function it_initializes_a_default_result(SpecificationNode $specification)
    {
        $this->beConstructedWith($specification);

        $this->getResult()->shouldReturn(Example::PASSED);
    }

    function it_initializes_a_default_time(SpecificationNode $specification)
    {
        $this->beConstructedWith($specification);

        $this->getTime()->shouldReturn((double) 0.0);
    }
>>>>>>> v2-test
}
