<?php

namespace spec\PhpSpec\CodeGenerator;

use PhpSpec\ObjectBehavior;
<<<<<<< HEAD
use Prophecy\Argument;

use PhpSpec\CodeGenerator\Generator\GeneratorInterface;
use PhpSpec\Locator\ResourceInterface;
=======

use PhpSpec\CodeGenerator\Generator\Generator;
use PhpSpec\Locator\Resource;
>>>>>>> v2-test

class GeneratorManagerSpec extends ObjectBehavior
{
    function it_uses_registered_generators_to_generate_code(
<<<<<<< HEAD
        GeneratorInterface $generator, ResourceInterface $resource
=======
        Generator $generator, Resource $resource
>>>>>>> v2-test
    ) {
        $generator->getPriority()->willReturn(0);
        $generator->supports($resource, 'specification', array())->willReturn(true);
        $generator->generate($resource, array())->shouldBeCalled();

        $this->registerGenerator($generator);
        $this->generate($resource, 'specification');
    }

    function it_chooses_generator_by_priority(
<<<<<<< HEAD
        GeneratorInterface $generator1, GeneratorInterface $generator2, ResourceInterface $resource
=======
        Generator $generator1, Generator $generator2, Resource $resource
>>>>>>> v2-test
    ) {
        $generator1->supports($resource, 'class', array('class' => 'CustomLoader'))
            ->willReturn(true);
        $generator1->getPriority()->willReturn(0);
        $generator2->supports($resource, 'class', array('class' => 'CustomLoader'))
            ->willReturn(true);
        $generator2->getPriority()->willReturn(2);

        $generator1->generate($resource, array('class' => 'CustomLoader'))->shouldNotBeCalled();
        $generator2->generate($resource, array('class' => 'CustomLoader'))->shouldBeCalled();

        $this->registerGenerator($generator1);
        $this->registerGenerator($generator2);
        $this->generate($resource, 'class', array('class' => 'CustomLoader'));
    }

<<<<<<< HEAD
    function it_throws_exception_if_no_generator_found(ResourceInterface $resource)
=======
    function it_throws_exception_if_no_generator_found(Resource $resource)
>>>>>>> v2-test
    {
        $this->shouldThrow()->duringGenerate($resource, 'class', array('class' => 'CustomLoader'));
    }
}
