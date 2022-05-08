<?php

namespace spec\PhpSpec\Listener;

use PhpSpec\CodeGenerator\GeneratorManager;
<<<<<<< HEAD
use PhpSpec\Console\IO;
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Event\SuiteEvent;
use PhpSpec\Exception\Fracture\CollaboratorNotFoundException;
use PhpSpec\Locator\ResourceInterface;
use PhpSpec\Locator\ResourceManagerInterface;
=======
use PhpSpec\Console\ConsoleIO;
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Event\SuiteEvent;
use PhpSpec\Exception\Fracture\CollaboratorNotFoundException;
use PhpSpec\Locator\Resource;
use PhpSpec\Locator\ResourceManager;
>>>>>>> v2-test
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CollaboratorNotFoundListenerSpec extends ObjectBehavior
{
    function let(
<<<<<<< HEAD
        IO $io, CollaboratorNotFoundException $exception, ExampleEvent $exampleEvent,
        ResourceManagerInterface $resources, GeneratorManager $generator, ResourceInterface $resource
=======
        ConsoleIO $io, CollaboratorNotFoundException $exception, ExampleEvent $exampleEvent,
        ResourceManager $resources, GeneratorManager $generator, Resource $resource
>>>>>>> v2-test
    )
    {
        $this->beConstructedWith($io, $resources, $generator);

        $resources->createResource(Argument::any())->willReturn($resource);
        $resource->getSpecNamespace()->willReturn('spec');

        $exampleEvent->getException()->willReturn($exception);
        $exception->getCollaboratorName()->willReturn('Example\ExampleClass');

        $io->isCodeGenerationEnabled()->willReturn(true);
        $io->askConfirmation(Argument::any())->willReturn(false);
<<<<<<< HEAD
        $io->writeln(Argument::any())->willReturn(null);
=======
        $io->writeln(Argument::any())->should(function() {});
>>>>>>> v2-test
    }

    function it_listens_to_afterexample_and_aftersuite_events()
    {
        $this->getSubscribedEvents()->shouldReturn(array(
            'afterExample' => array('afterExample', 10),
            'afterSuite'   => array('afterSuite', -10)
        ));
    }

    function it_prompts_to_generate_missing_collaborator(
<<<<<<< HEAD
        IO $io, ExampleEvent $exampleEvent, SuiteEvent $suiteEvent
=======
        ConsoleIO $io, ExampleEvent $exampleEvent, SuiteEvent $suiteEvent
>>>>>>> v2-test
    )
    {
        $this->afterExample($exampleEvent);
        $this->afterSuite($suiteEvent);

        $io->askConfirmation(
            'Would you like me to generate an interface `Example\ExampleClass` for you?'
        )->shouldHaveBeenCalled();
    }

    function it_does_not_prompt_to_generate_when_there_was_no_exception(
<<<<<<< HEAD
        IO $io, ExampleEvent $exampleEvent, SuiteEvent $suiteEvent
=======
        ConsoleIO $io, ExampleEvent $exampleEvent, SuiteEvent $suiteEvent
>>>>>>> v2-test
    )
    {
        $exampleEvent->getException()->willReturn(null);

        $this->afterExample($exampleEvent);
        $this->afterSuite($suiteEvent);

        $io->askConfirmation(Argument::any())->shouldNotHaveBeenCalled();
    }

    function it_does_not_prompt_to_generate_when_there_was_an_exception_of_the_wrong_type(
<<<<<<< HEAD
        IO $io, ExampleEvent $exampleEvent, SuiteEvent $suiteEvent, \InvalidArgumentException $otherException
=======
        ConsoleIO $io, ExampleEvent $exampleEvent, SuiteEvent $suiteEvent, \InvalidArgumentException $otherException
>>>>>>> v2-test
    )
    {
        $exampleEvent->getException()->willReturn($otherException);

        $this->afterExample($exampleEvent);
        $this->afterSuite($suiteEvent);

        $io->askConfirmation(Argument::any())->shouldNotHaveBeenCalled();
    }

    function it_does_not_prompt_when_code_generation_is_disabled(
<<<<<<< HEAD
        IO $io, ExampleEvent $exampleEvent, SuiteEvent $suiteEvent
=======
        ConsoleIO $io, ExampleEvent $exampleEvent, SuiteEvent $suiteEvent
>>>>>>> v2-test
    )
    {
        $io->isCodeGenerationEnabled()->willReturn(false);

        $this->afterExample($exampleEvent);
        $this->afterSuite($suiteEvent);

        $io->askConfirmation(Argument::any())->shouldNotHaveBeenCalled();
    }

    function it_does_not_prompt_when_collaborator_is_in_spec_namespace(
<<<<<<< HEAD
        IO $io, ExampleEvent $exampleEvent, SuiteEvent $suiteEvent, CollaboratorNotFoundException $exception
=======
        ConsoleIO $io, ExampleEvent $exampleEvent, SuiteEvent $suiteEvent, CollaboratorNotFoundException $exception
>>>>>>> v2-test
    )
    {
        $exception->getCollaboratorName()->willReturn('spec\Example\ExampleClass');

        $this->afterExample($exampleEvent);
        $this->afterSuite($suiteEvent);

        $io->askConfirmation(Argument::any())->shouldNotHaveBeenCalled();
    }

    function it_generates_interface_when_prompt_is_answered_with_yes(
<<<<<<< HEAD
        IO $io, ExampleEvent $exampleEvent, SuiteEvent $suiteEvent,
        GeneratorManager $generator, ResourceInterface $resource
=======
        ConsoleIO $io, ExampleEvent $exampleEvent, SuiteEvent $suiteEvent,
        GeneratorManager $generator, Resource $resource
>>>>>>> v2-test
    )
    {
        $io->askConfirmation(
            'Would you like me to generate an interface `Example\ExampleClass` for you?'
        )->willReturn(true);

        $this->afterExample($exampleEvent);
        $this->afterSuite($suiteEvent);

        $generator->generate($resource, 'interface')->shouldHaveBeenCalled();
        $suiteEvent->markAsWorthRerunning()->shouldHaveBeenCalled();
    }

    function it_does_not_generate_interface_when_prompt_is_answered_with_no(
<<<<<<< HEAD
        IO $io, ExampleEvent $exampleEvent, SuiteEvent $suiteEvent,
=======
        ConsoleIO $io, ExampleEvent $exampleEvent, SuiteEvent $suiteEvent,
>>>>>>> v2-test
        GeneratorManager $generator
    )
    {
        $io->askConfirmation(
            'Would you like me to generate an interface `Example\ExampleClass` for you?'
        )->willReturn(false);

        $this->afterExample($exampleEvent);
        $this->afterSuite($suiteEvent);

        $generator->generate(Argument::cetera())->shouldNotHaveBeenCalled();
        $suiteEvent->markAsWorthRerunning()->shouldNotHaveBeenCalled();
    }
}
