<?php

namespace spec\PhpSpec\Listener;

use PhpSpec\CodeGenerator\GeneratorManager;
<<<<<<< HEAD
use PhpSpec\Console\IO;
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Event\SuiteEvent;
use PhpSpec\Exception\Locator\ResourceCreationException;
use PhpSpec\Locator\ResourceInterface;
use PhpSpec\Locator\ResourceManager;
use PhpSpec\Locator\ResourceManagerInterface;
use PhpSpec\ObjectBehavior;
use PhpSpec\Util\NameCheckerInterface;
=======
use PhpSpec\Console\ConsoleIO;
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Event\SuiteEvent;
use PhpSpec\Exception\Locator\ResourceCreationException;
use PhpSpec\Locator\Resource;
use PhpSpec\Locator\ResourceManager;
use PhpSpec\ObjectBehavior;
use PhpSpec\Util\NameChecker;
>>>>>>> v2-test
use Prophecy\Argument;
use Prophecy\Doubler\DoubleInterface;
use Prophecy\Exception\Doubler\MethodNotFoundException;

class CollaboratorMethodNotFoundListenerSpec extends ObjectBehavior
{
    function let(
<<<<<<< HEAD
        IO $io, ResourceManagerInterface $resources, ExampleEvent $event,
        MethodNotFoundException $exception, ResourceInterface $resource, GeneratorManager $generator,
        NameCheckerInterface $nameChecker
=======
        ConsoleIO $io, ResourceManager $resources, ExampleEvent $event,
        MethodNotFoundException $exception, Resource $resource, GeneratorManager $generator,
        NameChecker $nameChecker
>>>>>>> v2-test
    ) {
        $this->beConstructedWith($io, $resources, $generator, $nameChecker);
        $event->getException()->willReturn($exception);

        $io->isCodeGenerationEnabled()->willReturn(true);
        $io->askConfirmation(Argument::any())->willReturn(false);

        $resources->createResource(Argument::any())->willReturn($resource);

        $exception->getArguments()->willReturn(array());
        $nameChecker->isNameValid('aMethod')->willReturn(true);
    }

    function it_is_an_event_subscriber()
    {
        $this->shouldHaveType('Symfony\Component\EventDispatcher\EventSubscriberInterface');
    }

    function it_listens_to_afterexample_events()
    {
        $this->getSubscribedEvents()->shouldReturn(array(
            'afterExample' => array('afterExample', 10),
            'afterSuite' => array('afterSuite', -10)
        ));
    }

<<<<<<< HEAD
    function it_does_not_prompt_when_no_exception_is_thrown(IO $io, ExampleEvent $event, SuiteEvent $suiteEvent)
=======
    function it_does_not_prompt_when_no_exception_is_thrown(ConsoleIO $io, ExampleEvent $event, SuiteEvent $suiteEvent)
>>>>>>> v2-test
    {
        $event->getException()->willReturn(null);

        $this->afterExample($event);
        $this->afterSuite($suiteEvent);

        $io->askConfirmation(Argument::any())->shouldNotHaveBeenCalled();
    }

    function it_prompts_the_user_when_a_prophecy_method_exception_is_thrown(
<<<<<<< HEAD
        IO $io, ExampleEvent $event, SuiteEvent $suiteEvent, MethodNotFoundException $exception
=======
        ConsoleIO $io, ExampleEvent $event, SuiteEvent $suiteEvent, MethodNotFoundException $exception
>>>>>>> v2-test
    )
    {
        $exception->getClassname()->willReturn('spec\PhpSpec\Listener\DoubleOfInterface');
        $exception->getMethodName()->willReturn('aMethod');

        $this->afterExample($event);
        $this->afterSuite($suiteEvent);

        $io->askConfirmation(Argument::any())->shouldHaveBeenCalled();
    }

<<<<<<< HEAD
    function it_does_not_prompt_when_wrong_exception_is_thrown(IO $io, ExampleEvent $event, SuiteEvent $suiteEvent)
=======
    function it_does_not_prompt_when_wrong_exception_is_thrown(ConsoleIO $io, ExampleEvent $event, SuiteEvent $suiteEvent)
>>>>>>> v2-test
    {
        $event->getException()->willReturn(new \RuntimeException());

        $this->afterExample($event);
        $this->afterSuite($suiteEvent);

        $io->askConfirmation(Argument::any())->shouldNotHaveBeenCalled();
    }

    function it_does_not_prompt_when_collaborator_is_not_an_interface(
<<<<<<< HEAD
        IO $io, ExampleEvent $event, SuiteEvent $suiteEvent, MethodNotFoundException $exception
=======
        ConsoleIO $io, ExampleEvent $event, SuiteEvent $suiteEvent, MethodNotFoundException $exception
>>>>>>> v2-test
    )
    {
        $exception->getClassname()->willReturn('spec\PhpSpec\Listener\DoubleOfStdClass');
        $exception->getMethodName()->willReturn('aMethod');

        $this->afterExample($event);
        $this->afterSuite($suiteEvent);

        $io->askConfirmation(Argument::any())->shouldNotHaveBeenCalled();
    }

    function it_does_not_prompt_when_code_generation_is_disabled(
<<<<<<< HEAD
        IO $io, ExampleEvent $event, SuiteEvent $suiteEvent, MethodNotFoundException $exception
=======
        ConsoleIO $io, ExampleEvent $event, SuiteEvent $suiteEvent, MethodNotFoundException $exception
>>>>>>> v2-test
    )
    {
        $io->isCodeGenerationEnabled()->willReturn(false);

        $exception->getClassname()->willReturn('spec\PhpSpec\Listener\DoubleOfInterface');
        $exception->getMethodName()->willReturn('aMethod');

        $this->afterExample($event);
        $this->afterSuite($suiteEvent);

        $io->askConfirmation(Argument::any())->shouldNotHaveBeenCalled();
    }

    function it_does_not_prompt_if_it_cannot_generate_the_resource(
<<<<<<< HEAD
        IO $io, ResourceManager $resources, ExampleEvent $event, SuiteEvent $suiteEvent, MethodNotFoundException $exception
=======
        ConsoleIO $io, ResourceManager $resources, ExampleEvent $event, SuiteEvent $suiteEvent, MethodNotFoundException $exception
>>>>>>> v2-test
    )
    {
        $resources->createResource(Argument::any())->willThrow(new ResourceCreationException());

        $exception->getClassname()->willReturn('spec\PhpSpec\Listener\DoubleOfInterface');
        $exception->getMethodName()->willReturn('aMethod');

        $this->afterExample($event);
        $this->afterSuite($suiteEvent);

        $io->askConfirmation(Argument::any())->shouldNotHaveBeenCalled();
    }

    function it_generates_the_method_signature_when_user_says_yes_at_prompt(
<<<<<<< HEAD
        IO $io, ExampleEvent $event, SuiteEvent $suiteEvent, MethodNotFoundException $exception,
        ResourceInterface $resource, GeneratorManager $generator
=======
        ConsoleIO $io, ExampleEvent $event, SuiteEvent $suiteEvent, MethodNotFoundException $exception,
        Resource $resource, GeneratorManager $generator
>>>>>>> v2-test
    )
    {
        $io->askConfirmation(Argument::any())->willReturn(true);

        $exception->getClassname()->willReturn('spec\PhpSpec\Listener\DoubleOfInterface');
        $exception->getMethodName()->willReturn('aMethod');

        $this->afterExample($event);
        $this->afterSuite($suiteEvent);

        $generator->generate($resource, 'method-signature', Argument::any())->shouldHaveBeenCalled();
    }

    function it_marks_the_suite_as_being_worth_rerunning_when_generation_happens(
<<<<<<< HEAD
        IO $io, ExampleEvent $event, SuiteEvent $suiteEvent, MethodNotFoundException $exception
=======
        ConsoleIO $io, ExampleEvent $event, SuiteEvent $suiteEvent, MethodNotFoundException $exception
>>>>>>> v2-test
    )
    {
        $io->askConfirmation(Argument::any())->willReturn(true);

        $exception->getClassname()->willReturn('spec\PhpSpec\Listener\DoubleOfInterface');
        $exception->getMethodName()->willReturn('aMethod');

        $this->afterExample($event);
        $this->afterSuite($suiteEvent);

        $suiteEvent->markAsWorthRerunning()->shouldHaveBeenCalled();
    }

    function it_warns_if_a_method_name_is_wrong(
        ExampleEvent $event,
        SuiteEvent $suiteEvent,
<<<<<<< HEAD
        IO $io,
        NameCheckerInterface $nameChecker
=======
        ConsoleIO $io,
        NameChecker $nameChecker
>>>>>>> v2-test
    ) {
        $exception = new MethodNotFoundException('Error', new DoubleOfInterface(), 'throw');

        $event->getException()->willReturn($exception);
        $nameChecker->isNameValid('throw')->willReturn(false);

        $io->writeBrokenCodeBlock("I cannot generate the method 'throw' for you because it is a reserved keyword", 2)->shouldBeCalled();
        $io->askConfirmation(Argument::any())->shouldNotBeCalled();

        $this->afterExample($event);
        $this->afterSuite($suiteEvent);
    }

    function it_prompts_and_warns_when_one_method_name_is_correct_but_other_reserved(
        ExampleEvent $event,
        SuiteEvent $suiteEvent,
<<<<<<< HEAD
        IO $io,
        NameCheckerInterface $nameChecker
=======
        ConsoleIO $io,
        NameChecker $nameChecker
>>>>>>> v2-test
    ) {
        $this->callAfterExample($event, $nameChecker, 'throw', false);
        $this->callAfterExample($event, $nameChecker, 'foo');

        $io->writeBrokenCodeBlock("I cannot generate the method 'throw' for you because it is a reserved keyword", 2)->shouldBeCalled();
        $io->askConfirmation(Argument::any())->shouldBeCalled();
        $suiteEvent->markAsNotWorthRerunning()->shouldBeCalled();

        $this->afterSuite($suiteEvent);
    }

    private function callAfterExample($event, $nameChecker, $method, $isNameValid = true)
    {
<<<<<<< HEAD
        $exception = new MethodNotFoundException('Error', new DoubleOfInterface(), $method);
=======
        $exception = new MethodNotFoundException('Error', DoubleOfInterface::class, $method);
>>>>>>> v2-test
        $event->getException()->willReturn($exception);
        $nameChecker->isNameValid($method)->willReturn($isNameValid);

        $this->afterExample($event);
    }
}

interface ExampleInterface {}

class DoubleOfInterface extends \stdClass implements ExampleInterface, DoubleInterface {}

class DoubleOfStdClass extends \stdClass implements DoubleInterface {}
