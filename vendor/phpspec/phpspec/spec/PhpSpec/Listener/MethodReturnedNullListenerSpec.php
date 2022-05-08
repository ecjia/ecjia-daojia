<?php

namespace spec\PhpSpec\Listener;

use PhpSpec\CodeGenerator\GeneratorManager;
<<<<<<< HEAD
use PhpSpec\Console\IO;
=======
use PhpSpec\Console\ConsoleIO;
>>>>>>> v2-test
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Event\MethodCallEvent;
use PhpSpec\Event\SuiteEvent;
use PhpSpec\Exception\Example\NotEqualException;
<<<<<<< HEAD
use PhpSpec\Locator\ResourceInterface;
=======
use PhpSpec\Locator\Resource;
>>>>>>> v2-test
use PhpSpec\Locator\ResourceManager;
use PhpSpec\ObjectBehavior;
use PhpSpec\Util\MethodAnalyser;
use Prophecy\Argument;
<<<<<<< HEAD
=======
use PhpSpec\Exception\Example\MethodFailureException;
>>>>>>> v2-test

class MethodReturnedNullListenerSpec extends ObjectBehavior
{
    function let(
<<<<<<< HEAD
        IO $io, ResourceManager $resourceManager, GeneratorManager $generatorManager,
        ExampleEvent $exampleEvent, NotEqualException $notEqualException, MethodAnalyser $methodAnalyser
    ) {
        $this->beConstructedWith($io, $resourceManager, $generatorManager, $methodAnalyser);

        $exampleEvent->getException()->willReturn($notEqualException);
        $notEqualException->getActual()->willReturn(null);
        $notEqualException->getExpected()->willReturn(100);
=======
        ConsoleIO $io,
        ResourceManager $resourceManager,
        Resource $resource,
        GeneratorManager $generatorManager,
        ExampleEvent $exampleEvent,
        MethodFailureException $methodFailureException,
        MethodAnalyser $methodAnalyser,
        MethodCallEvent $methodCallEvent
    ) {
        $this->beConstructedWith($io, $resourceManager, $generatorManager, $methodAnalyser);

        $exampleEvent->getException()->willReturn($methodFailureException);
        $methodFailureException->getActual()->willReturn(null);
        $methodFailureException->getExpected()->willReturn(100);
        $methodFailureException->getSubject()->willReturn(null);
        $methodFailureException->getMethod()->willReturn(null);

        $methodCallEvent->getMethod()->willReturn('foo');
        $methodCallEvent->getSubject()->willReturn(new \stdClass);
>>>>>>> v2-test

        $io->isCodeGenerationEnabled()->willReturn(true);

        $io->askConfirmation(Argument::any())->willReturn(false);

        $io->isFakingEnabled()->willReturn(true);

        $methodAnalyser->methodIsEmpty(Argument::cetera())->willReturn(true);
<<<<<<< HEAD
        $methodAnalyser->getMethodOwnerName(Argument::cetera())->willReturn('Foo');;
=======
        $methodAnalyser->getMethodOwnerName(Argument::cetera())->willReturn('Foo');

        $resourceManager->createResource(Argument::cetera())->willReturn($resource);
>>>>>>> v2-test
    }

    function it_is_an_event_listener()
    {
        $this->shouldHaveType('Symfony\Component\EventDispatcher\EventSubscriberInterface');
    }

    function it_listens_to_examples_to_spot_failures()
    {
        $this->getSubscribedEvents()->shouldHaveKey('afterExample');
    }

    function it_listens_to_suites_to_know_when_to_prompt()
    {
        $this->getSubscribedEvents()->shouldHaveKey('afterSuite');
    }

    function it_listens_to_method_calls_to_see_what_has_failed()
    {
        $this->getSubscribedEvents()->shouldHaveKey('afterMethodCall');
    }

    function it_does_not_prompt_when_wrong_type_of_exception_is_thrown(
<<<<<<< HEAD
        MethodCallEvent $methodCallEvent, ExampleEvent $exampleEvent, IO $io, SuiteEvent $event
=======
        MethodCallEvent $methodCallEvent, ExampleEvent $exampleEvent, ConsoleIO $io, SuiteEvent $event
>>>>>>> v2-test
    ) {
        $exampleEvent->getException()->willReturn(new \Exception());

        $this->afterMethodCall($methodCallEvent);
        $this->afterExample($exampleEvent);
        $this->afterSuite($event);

        $io->askConfirmation(Argument::any())->shouldNotHaveBeenCalled();
    }

    function it_does_not_prompt_when_actual_value_is_not_null(
<<<<<<< HEAD
        MethodCallEvent $methodCallEvent, ExampleEvent $exampleEvent, NotEqualException $notEqualException, IO $io, SuiteEvent $event
=======
        MethodCallEvent $methodCallEvent, ExampleEvent $exampleEvent, NotEqualException $notEqualException, ConsoleIO $io, SuiteEvent $event
>>>>>>> v2-test
    ) {
        $exampleEvent->getException()->willReturn($notEqualException);
        $notEqualException->getActual()->willReturn(90);
        $notEqualException->getExpected()->willReturn(100);

        $this->afterMethodCall($methodCallEvent);
        $this->afterExample($exampleEvent);
        $this->afterSuite($event);

        $io->askConfirmation(Argument::any())->shouldNotHaveBeenCalled();
    }

    function it_does_not_prompt_when_expected_value_is_an_object(
<<<<<<< HEAD
        MethodCallEvent $methodCallEvent, ExampleEvent $exampleEvent, NotEqualException $notEqualException, IO $io, SuiteEvent $event
=======
        MethodCallEvent $methodCallEvent, ExampleEvent $exampleEvent, NotEqualException $notEqualException, ConsoleIO $io, SuiteEvent $event
>>>>>>> v2-test
    ) {
        $exampleEvent->getException()->willReturn($notEqualException);
        $notEqualException->getActual()->willReturn(null);
        $notEqualException->getExpected()->willReturn(new \DateTime());

        $this->afterMethodCall($methodCallEvent);
        $this->afterExample($exampleEvent);
        $this->afterSuite($event);

        $io->askConfirmation(Argument::any())->shouldNotHaveBeenCalled();
    }

<<<<<<< HEAD
    function it_does_not_prompt_if_no_method_was_called_beforehand(ExampleEvent $exampleEvent, IO $io, SuiteEvent $event)
    {
=======
    function it_does_not_prompt_if_no_method_was_called_beforehand(
        ExampleEvent $exampleEvent, ConsoleIO $io, SuiteEvent $event
    ) {
>>>>>>> v2-test
        $this->afterExample($exampleEvent);
        $this->afterSuite($event);

        $io->askConfirmation(Argument::any())->shouldNotHaveBeenCalled();
    }

    function it_does_not_prompt_when_there_is_a_problem_creating_the_resource(
<<<<<<< HEAD
        MethodCallEvent $methodCallEvent, ExampleEvent $exampleEvent, IO $io, ResourceManager $resourceManager, SuiteEvent $event
    ) {
        $resourceManager->createResource(Argument::any())->willThrow(new \RuntimeException());
=======
        MethodCallEvent $methodCallEvent, ExampleEvent $exampleEvent, ConsoleIO $io, ResourceManager $resourceManager, SuiteEvent $event
    ) {
        $resourceManager->createResource(Argument::any())->willThrow(new \RuntimeException());
        $methodCallEvent->getSubject()->willReturn(new \stdClass());
        $methodCallEvent->getMethod()->willReturn('');
>>>>>>> v2-test

        $this->afterMethodCall($methodCallEvent);
        $this->afterExample($exampleEvent);
        $this->afterSuite($event);

        $io->askConfirmation(Argument::any())->shouldNotHaveBeenCalled();
    }

    function it_does_not_prompt_when_input_is_not_interactive(
<<<<<<< HEAD
        MethodCallEvent $methodCallEvent, ExampleEvent $exampleEvent, IO $io, SuiteEvent $event
    ) {
        $io->isCodeGenerationEnabled()->willReturn(false);
=======
        MethodCallEvent $methodCallEvent, ExampleEvent $exampleEvent, ConsoleIO $io, SuiteEvent $event
    ) {
        $io->isCodeGenerationEnabled()->willReturn(false);
        $methodCallEvent->getSubject()->willReturn(new \stdClass());
        $methodCallEvent->getMethod()->willReturn('');
>>>>>>> v2-test

        $this->afterMethodCall($methodCallEvent);
        $this->afterExample($exampleEvent);
        $this->afterSuite($event);

        $io->askConfirmation(Argument::any())->shouldNotHaveBeenCalled();
    }

    function it_does_not_prompt_when_method_is_not_empty(
<<<<<<< HEAD
        MethodCallEvent $methodCallEvent, ExampleEvent $exampleEvent, IO $io, MethodAnalyser $methodAnalyser, SuiteEvent $event
=======
        MethodCallEvent $methodCallEvent, ExampleEvent $exampleEvent, ConsoleIO $io, MethodAnalyser $methodAnalyser, SuiteEvent $event
>>>>>>> v2-test
    ) {
        $methodCallEvent->getMethod()->willReturn('myMethod');
        $methodCallEvent->getSubject()->willReturn(new \DateTime());

        $methodAnalyser->methodIsEmpty('DateTime', 'myMethod')->willReturn(false);

        $this->afterMethodCall($methodCallEvent);
        $this->afterExample($exampleEvent);
        $this->afterSuite($event);

        $io->askConfirmation(Argument::any())->shouldNotHaveBeenCalled();
    }

    function it_does_not_prompt_when_multiple_contradictory_examples_are_found(
<<<<<<< HEAD
        MethodCallEvent $methodCallEvent, ExampleEvent $exampleEvent, NotEqualException $notEqualException, IO $io,
=======
        MethodCallEvent $methodCallEvent, ExampleEvent $exampleEvent, NotEqualException $notEqualException, ConsoleIO $io,
>>>>>>> v2-test
        ExampleEvent $exampleEvent2, NotEqualException $notEqualException2, SuiteEvent $event
    ) {
        $exampleEvent->getException()->willReturn($notEqualException);
        $exampleEvent2->getException()->willReturn($notEqualException2);

        $notEqualException->getActual()->willReturn(null);
        $notEqualException2->getActual()->willReturn(null);

        $notEqualException->getExpected()->willReturn('foo');
        $notEqualException2->getExpected()->willReturn('bar');

<<<<<<< HEAD
=======
        $methodCallEvent->getSubject()->willReturn(new \stdClass());
        $methodCallEvent->getMethod()->willReturn('');

>>>>>>> v2-test
        $this->afterMethodCall($methodCallEvent);
        $this->afterExample($exampleEvent);

        $this->afterMethodCall($methodCallEvent);
        $this->afterExample($exampleEvent2);

        $this->afterSuite($event);

        $io->askConfirmation(Argument::any())->shouldNotHaveBeenCalled();
    }

    function it_does_not_prompt_when_io_has_faking_disabled(
<<<<<<< HEAD
        MethodCallEvent $methodCallEvent, ExampleEvent $exampleEvent, IO $io, SuiteEvent $event
    ) {
        $io->isFakingEnabled()->willReturn(false);
=======
        MethodCallEvent $methodCallEvent, ExampleEvent $exampleEvent, ConsoleIO $io, SuiteEvent $event
    ) {
        $io->isFakingEnabled()->willReturn(false);
        $methodCallEvent->getSubject()->willReturn(new \stdClass());
        $methodCallEvent->getMethod()->willReturn('');
>>>>>>> v2-test

        $this->afterMethodCall($methodCallEvent);
        $this->afterExample($exampleEvent);
        $this->afterSuite($event);

        $io->askConfirmation(Argument::any())->shouldNotHaveBeenCalled();
    }

    function it_prompts_when_correct_type_of_exception_is_thrown(
<<<<<<< HEAD
        MethodCallEvent $methodCallEvent, ExampleEvent $exampleEvent, IO $io, SuiteEvent $event
    ) {
=======
        MethodCallEvent $methodCallEvent, ExampleEvent $exampleEvent, ConsoleIO $io, SuiteEvent $event
    ) {
        $methodCallEvent->getSubject()->willReturn(new \stdClass());
        $methodCallEvent->getMethod()->willReturn('');

>>>>>>> v2-test
        $this->afterMethodCall($methodCallEvent);
        $this->afterExample($exampleEvent);
        $this->afterSuite($event);

        $io->askConfirmation(Argument::any())->shouldHaveBeenCalled();
    }

<<<<<<< HEAD
    function it_invokes_method_body_generation_when_prompt_is_answered_yes(
        MethodCallEvent $methodCallEvent, ExampleEvent $exampleEvent, IO $io,
        GeneratorManager $generatorManager, ResourceManager $resourceManager, ResourceInterface $resource, SuiteEvent $event
=======
    function it_prompts_if_no_method_was_called_beforehand_but_subject_and_method_are_set_on_the_exception(
        ExampleEvent $exampleEvent, ConsoleIO $io, SuiteEvent $event, MethodFailureException $methodFailureException
    ) {
        $methodFailureException->getSubject()->willReturn(new \stdClass());
        $methodFailureException->getMethod()->willReturn('myMethod');

        $this->afterExample($exampleEvent);
        $this->afterSuite($event);

        $io->askConfirmation(Argument::any())->shouldHaveBeenCalled();
    }

    function it_invokes_method_body_generation_when_prompt_is_answered_yes(
        MethodCallEvent $methodCallEvent, ExampleEvent $exampleEvent, ConsoleIO $io,
        GeneratorManager $generatorManager, ResourceManager $resourceManager, Resource $resource, SuiteEvent $event
>>>>>>> v2-test
    ) {
        $io->askConfirmation(Argument::any())->willReturn(true);
        $resourceManager->createResource(Argument::any())->willReturn($resource);

        $methodCallEvent->getSubject()->willReturn(new \StdClass());
        $methodCallEvent->getMethod()->willReturn('myMethod');

        $this->afterMethodCall($methodCallEvent);
        $this->afterExample($exampleEvent);
        $this->afterSuite($event);

        $generatorManager->generate($resource, 'returnConstant', array('method' => 'myMethod', 'expected' => 100))
            ->shouldHaveBeenCalled();
    }
}
