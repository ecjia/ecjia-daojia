<?php

namespace spec\PhpSpec\Listener;

<<<<<<< HEAD
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use PhpSpec\Console\IO;
use PhpSpec\Locator\ResourceManager;
=======
use PhpSpec\Locator\Resource;
use PhpSpec\Locator\ResourceManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use PhpSpec\Console\ConsoleIO;
>>>>>>> v2-test
use PhpSpec\CodeGenerator\GeneratorManager;
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Event\SuiteEvent;
use PhpSpec\Exception\Fracture\ClassNotFoundException as PhpSpecClassException;
<<<<<<< HEAD

=======
>>>>>>> v2-test
use Prophecy\Exception\Doubler\ClassNotFoundException as ProphecyClassException;

class ClassNotFoundListenerSpec extends ObjectBehavior
{
<<<<<<< HEAD
    function let(IO $io, ResourceManager $resourceManager, GeneratorManager $generatorManager,
                 SuiteEvent $suiteEvent, ExampleEvent $exampleEvent)
    {
        $io->writeln(Argument::any())->willReturn();
        $io->askConfirmation(Argument::any())->willReturn();
=======
    function let(
        ConsoleIO $io,
        ResourceManager $resourceManager,
        GeneratorManager $generatorManager,
        SuiteEvent $suiteEvent,
        ExampleEvent $exampleEvent,
        PhpSpecClassException $exception,
        Resource $resource
    )
    {
        $io->writeln(Argument::any())->should(function () {});
        $io->askConfirmation(Argument::any())->willReturn(false);

        $exception->getClassname()->willReturn('SomeClass');

        $resourceManager->createResource(Argument::cetera())->willReturn($resource);
>>>>>>> v2-test

        $this->beConstructedWith($io, $resourceManager, $generatorManager);
    }

    function it_does_not_prompt_for_class_generation_if_no_exception_was_thrown($exampleEvent, $suiteEvent, $io)
    {
        $io->isCodeGenerationEnabled()->willReturn(true);

        $this->afterExample($exampleEvent);
        $this->afterSuite($suiteEvent);

        $io->askConfirmation(Argument::any())->shouldNotBeenCalled();
    }

<<<<<<< HEAD
    function it_does_not_prompt_for_class_generation_if_non_class_exception_was_thrown($exampleEvent, $suiteEvent, $io, \InvalidArgumentException $exception)
    {
        $exampleEvent->getException()->willReturn($exception);
=======
    function it_does_not_prompt_for_class_generation_if_non_class_exception_was_thrown($exampleEvent, $suiteEvent, $io, \InvalidArgumentException $invalidArgumentException)
    {
        $exampleEvent->getException()->willReturn($invalidArgumentException);
>>>>>>> v2-test
        $io->isCodeGenerationEnabled()->willReturn(true);

        $this->afterExample($exampleEvent);
        $this->afterSuite($suiteEvent);

        $io->askConfirmation(Argument::any())->shouldNotBeenCalled();
    }

<<<<<<< HEAD
    function it_prompts_for_class_generation_if_prophecy_classnotfoundexception_was_thrown_and_input_is_interactive($exampleEvent, $suiteEvent, $io, ProphecyClassException $exception)
    {
        $exampleEvent->getException()->willReturn($exception);
        $io->isCodeGenerationEnabled()->willReturn(true);

        $this->afterExample($exampleEvent);
        $this->afterSuite($suiteEvent);

        $io->askConfirmation(Argument::any())->shouldHaveBeenCalled();
    }

    function it_prompts_for_method_generation_if_phpspec_classnotfoundexception_was_thrown_and_input_is_interactive($exampleEvent, $suiteEvent, $io, PhpspecClassException $exception)
=======
    function it_prompts_for_class_generation_if_prophecy_classnotfoundexception_was_thrown_and_input_is_interactive($exampleEvent, $suiteEvent, $io, ProphecyClassException $prophecyException)
    {
        $exampleEvent->getException()->willReturn($prophecyException);
        $io->isCodeGenerationEnabled()->willReturn(true);

        $io->askConfirmation(Argument::any())->shouldBeCalled()->willReturn(false);

        $this->afterExample($exampleEvent);
        $this->afterSuite($suiteEvent);
    }

    function it_prompts_for_method_generation_if_phpspec_classnotfoundexception_was_thrown_and_input_is_interactive($exampleEvent, $suiteEvent, $io, PhpSpecClassException $exception)
>>>>>>> v2-test
    {
        $exampleEvent->getException()->willReturn($exception);
        $io->isCodeGenerationEnabled()->willReturn(true);

<<<<<<< HEAD
        $this->afterExample($exampleEvent);
        $this->afterSuite($suiteEvent);

        $io->askConfirmation(Argument::any())->shouldHaveBeenCalled();
    }

    function it_does_not_prompt_for_class_generation_if_input_is_not_interactive($exampleEvent, $suiteEvent, $io, PhpspecClassException $exception)
=======
        $io->askConfirmation(Argument::any())->shouldBeCalled()->willReturn(false);

        $this->afterExample($exampleEvent);
        $this->afterSuite($suiteEvent);
    }

    function it_does_not_prompt_for_class_generation_if_input_is_not_interactive($exampleEvent, $suiteEvent, $io, PhpSpecClassException $exception)
>>>>>>> v2-test
    {
        $exampleEvent->getException()->willReturn($exception);
        $io->isCodeGenerationEnabled()->willReturn(false);

        $this->afterExample($exampleEvent);
        $this->afterSuite($suiteEvent);

        $io->askConfirmation(Argument::any())->shouldNotBeenCalled();
    }
}
