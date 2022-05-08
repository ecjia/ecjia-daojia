<?php

namespace spec\PhpSpec\Listener;

<<<<<<< HEAD
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use PhpSpec\Console\IO;
use PhpSpec\Locator\ResourceManager;
=======
use PhpSpec\Locator\Resource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use PhpSpec\Console\ConsoleIO;
>>>>>>> v2-test
use PhpSpec\CodeGenerator\GeneratorManager;
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Event\SuiteEvent;
use PhpSpec\Exception\Fracture\MethodNotFoundException;
<<<<<<< HEAD
use PhpSpec\Util\NameCheckerInterface;
=======
use PhpSpec\Locator\ResourceManager;
use PhpSpec\Util\NameChecker;
>>>>>>> v2-test

class MethodNotFoundListenerSpec extends ObjectBehavior
{
    function let(
<<<<<<< HEAD
        IO $io,
        ResourceManager $resourceManager,
        GeneratorManager $generatorManager,
        SuiteEvent $suiteEvent,
        ExampleEvent $exampleEvent,
        NameCheckerInterface $nameChecker
    ) {
        $io->writeln(Argument::any())->willReturn();
        $io->askConfirmation(Argument::any())->willReturn();

        $this->beConstructedWith($io, $resourceManager, $generatorManager, $nameChecker);
        $io->isCodeGenerationEnabled()->willReturn(true);
=======
        ConsoleIO $io,
        ResourceManager $resourceManager,
        Resource $resource,
        GeneratorManager $generatorManager,
        SuiteEvent $suiteEvent,
        ExampleEvent $exampleEvent,
        NameChecker $nameChecker
    ) {
        $io->writeln(Argument::any())->should(function() {});
        $io->askConfirmation(Argument::any())->willReturn(false);

        $this->beConstructedWith($io, $resourceManager, $generatorManager, $nameChecker);
        $io->isCodeGenerationEnabled()->willReturn(true);

        $nameChecker->isNameValid(Argument::any())->willReturn(false);

        $resourceManager->createResource(Argument::cetera())->willReturn($resource);
>>>>>>> v2-test
    }

    function it_does_not_prompt_for_method_generation_if_no_exception_was_thrown($exampleEvent, $suiteEvent, $io)
    {
        $this->afterExample($exampleEvent);
        $this->afterSuite($suiteEvent);

        $io->askConfirmation(Argument::any())->shouldNotBeenCalled();
    }

    function it_does_not_prompt_for_method_generation_if_non_methodnotfoundexception_was_thrown($exampleEvent, $suiteEvent, $io, \InvalidArgumentException $exception)
    {
        $exampleEvent->getException()->willReturn($exception);

        $this->afterExample($exampleEvent);
        $this->afterSuite($suiteEvent);

        $io->askConfirmation(Argument::any())->shouldNotBeenCalled();
    }

    function it_prompts_for_method_generation_if_methodnotfoundexception_was_thrown_and_input_is_interactive(
        $exampleEvent,
        $suiteEvent,
        $io,
<<<<<<< HEAD
        NameCheckerInterface $nameChecker
=======
        NameChecker $nameChecker
>>>>>>> v2-test
    ) {
        $exception = new MethodNotFoundException('Error', new \stdClass(), 'bar');

        $exampleEvent->getException()->willReturn($exception);
        $nameChecker->isNameValid('bar')->willReturn(true);

<<<<<<< HEAD
        $this->afterExample($exampleEvent);
        $this->afterSuite($suiteEvent);

        $io->askConfirmation(Argument::any())->shouldHaveBeenCalled();
=======
        $io->askConfirmation(Argument::any())->shouldBeCalled()->willReturn(false);

        $this->afterExample($exampleEvent);
        $this->afterSuite($suiteEvent);
>>>>>>> v2-test
    }

    function it_does_not_prompt_for_method_generation_if_input_is_not_interactive($exampleEvent, $suiteEvent, $io, MethodNotFoundException $exception)
    {
        $exampleEvent->getException()->willReturn($exception);
<<<<<<< HEAD
=======
        $exception->getMethodName()->willReturn('someMethod');
        $exception->getSubject()->willReturn(new \stdClass);
        $exception->getArguments()->willReturn([]);

>>>>>>> v2-test
        $io->isCodeGenerationEnabled()->willReturn(false);

        $this->afterExample($exampleEvent);
        $this->afterSuite($suiteEvent);

        $io->askConfirmation(Argument::any())->shouldNotBeenCalled();
    }

    function it_warns_when_method_name_is_reserved(
        $exampleEvent,
        $suiteEvent,
<<<<<<< HEAD
        IO $io,
        NameCheckerInterface $nameChecker
=======
        ConsoleIO $io,
        NameChecker $nameChecker
>>>>>>> v2-test
    ) {
        $this->callAfterExample($exampleEvent, $nameChecker, 'throw', false);

        $io->writeBrokenCodeBlock("I cannot generate the method 'throw' for you because it is a reserved keyword", 2)->shouldBeCalled();

        $this->afterSuite($suiteEvent);
    }

    function it_prompts_and_warns_when_one_method_name_is_correct_but_other_reserved(
        $exampleEvent,
        SuiteEvent $suiteEvent,
<<<<<<< HEAD
        IO $io,
        NameCheckerInterface $nameChecker
=======
        ConsoleIO $io,
        NameChecker $nameChecker
>>>>>>> v2-test
    ) {
        $this->callAfterExample($exampleEvent, $nameChecker, 'throw', false);
        $this->callAfterExample($exampleEvent, $nameChecker, 'foo');

        $io->writeBrokenCodeBlock("I cannot generate the method 'throw' for you because it is a reserved keyword", 2)->shouldBeCalled();
        $io->askConfirmation('Do you want me to create `stdClass::foo()` for you?')->shouldBeCalled();
        $suiteEvent->markAsNotWorthRerunning()->shouldBeCalled();

        $this->afterSuite($suiteEvent);
    }

    private function callAfterExample($exampleEvent, $nameChecker, $method, $isNameValid = true)
    {
        $exception = new MethodNotFoundException('Error', new \stdClass(), $method);
        $exampleEvent->getException()->willReturn($exception);
        $nameChecker->isNameValid($method)->willReturn($isNameValid);

        $this->afterExample($exampleEvent);
    }
}
