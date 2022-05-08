<?php

namespace spec\PhpSpec\Formatter;

<<<<<<< HEAD
use PhpSpec\Formatter\Presenter\PresenterInterface;
use PhpSpec\Console\IO;
use PhpSpec\Listener\StatisticsCollector;
use PhpSpec\Event\SuiteEvent;
use PhpSpec\Event\ExampleEvent;
=======
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Console\ConsoleIO;
use PhpSpec\Listener\StatisticsCollector;
use PhpSpec\Event\SuiteEvent;
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Loader\Suite;
>>>>>>> v2-test
use PhpSpec\ObjectBehavior;
use PhpSpec\Exception\Example\PendingException;
use PhpSpec\Loader\Node\SpecificationNode;
use PhpSpec\Loader\Node\ExampleNode;
use Prophecy\Argument;
<<<<<<< HEAD
=======
use Prophecy\Prophecy\MethodProphecy;
use Prophecy\Prophecy\ObjectProphecy;
>>>>>>> v2-test
use ReflectionFunctionAbstract;

class DotFormatterSpec extends ObjectBehavior
{
<<<<<<< HEAD
    function let(PresenterInterface $presenter, IO $io, StatisticsCollector $stats)
    {
        $this->beConstructedWith($presenter, $io, $stats);
=======
    function let(
        Presenter $presenter,
        ConsoleIO $io,
        StatisticsCollector $stats,
        SuiteEvent $event
    )
    {
        $this->beConstructedWith($presenter, $io, $stats);
        $presenter->presentString(Argument::cetera())->willReturn('presented string');
        $presenter->presentException(Argument::cetera())->willReturn('presented exception');
        $io->askConfirmation(Argument::any())->willReturn(false);
        $io->write(Argument::any())->should(function() {
            return;
        });
        $io->writeln(Argument::cetera())->should(function() {
            return;
        });
        $io->getBlockWidth()->willReturn(80);
        $event->getTime()->willReturn(10.0);
>>>>>>> v2-test
    }

    function it_is_a_console_formatter()
    {
        $this->shouldHaveType('PhpSpec\Formatter\ConsoleFormatter');
    }

    function it_outputs_a_dot_for_a_passed_example(
        ExampleEvent $event,
<<<<<<< HEAD
        IO $io,
        StatisticsCollector $stats
    ) {
        $event->getResult()->willReturn(ExampleEvent::PASSED);
=======
        ConsoleIO $io,
        StatisticsCollector $stats
    ) {
        $event->getResult()->willReturn(ExampleEvent::PASSED);
        $stats->getEventsCount()->willReturn(1);
>>>>>>> v2-test

        $this->afterExample($event);

        $io->write("<passed>.</passed>")->shouldHaveBeenCalled();
    }

    function it_outputs_a_p_for_a_pending_example(
        ExampleEvent $event,
<<<<<<< HEAD
        IO $io,
        StatisticsCollector $stats
    ) {
        $event->getResult()->willReturn(ExampleEvent::PENDING);
=======
        ConsoleIO $io,
        StatisticsCollector $stats
    ) {
        $event->getResult()->willReturn(ExampleEvent::PENDING);
        $stats->getEventsCount()->willReturn(1);
>>>>>>> v2-test

        $this->afterExample($event);

        $io->write('<pending>P</pending>')->shouldHaveBeenCalled();
    }

    function it_outputs_an_s_for_a_skipped_example(
        ExampleEvent $event,
<<<<<<< HEAD
        IO $io,
        StatisticsCollector $stats
    ) {
        $event->getResult()->willReturn(ExampleEvent::SKIPPED);
=======
        ConsoleIO $io,
        StatisticsCollector $stats
    ) {
        $event->getResult()->willReturn(ExampleEvent::SKIPPED);
        $stats->getEventsCount()->willReturn(1);
>>>>>>> v2-test

        $this->afterExample($event);

        $io->write('<skipped>S</skipped>')->shouldHaveBeenCalled();
    }

    function it_outputs_an_f_for_a_failed_example(
        ExampleEvent $event,
<<<<<<< HEAD
        IO $io,
        StatisticsCollector $stats
    ) {
        $event->getResult()->willReturn(ExampleEvent::FAILED);
=======
        ConsoleIO $io,
        StatisticsCollector $stats
    ) {
        $event->getResult()->willReturn(ExampleEvent::FAILED);
        $stats->getEventsCount()->willReturn(1);
>>>>>>> v2-test

        $this->afterExample($event);

        $io->write('<failed>F</failed>')->shouldHaveBeenCalled();
    }

    function it_outputs_a_b_for_a_broken_example(
        ExampleEvent $event,
<<<<<<< HEAD
        IO $io,
        StatisticsCollector $stats
    ) {
        $event->getResult()->willReturn(ExampleEvent::BROKEN);
=======
        ConsoleIO $io,
        StatisticsCollector $stats
    ) {
        $event->getResult()->willReturn(ExampleEvent::BROKEN);
        $stats->getEventsCount()->willReturn(1);
>>>>>>> v2-test

        $this->afterExample($event);

        $io->write('<broken>B</broken>')->shouldHaveBeenCalled();
    }

    function it_outputs_the_progress_every_50_examples(
        ExampleEvent $exampleEvent,
        SuiteEvent $suiteEvent,
<<<<<<< HEAD
        IO $io,
        StatisticsCollector $stats
    ) {
        $exampleEvent->getResult()->willReturn(ExampleEvent::PASSED);
        $suiteEvent->getSuite()->willReturn(range(1, 100));
=======
        ConsoleIO $io,
        StatisticsCollector $stats,
        Suite $suite
    ) {
        $exampleEvent->getResult()->willReturn(ExampleEvent::PASSED);

        $suiteEvent->getSuite()->willReturn($suite);
        $suite->count()->willReturn(100);

>>>>>>> v2-test
        $stats->getEventsCount()->willReturn(50);

        $this->beforeSuite($suiteEvent);
        $this->afterExample($exampleEvent);

        $io->write('  50 / 100')->shouldHaveBeenCalled();
    }

    function it_outputs_exceptions_for_failed_examples(
        SuiteEvent $event,
        ExampleEvent $pendingEvent,
<<<<<<< HEAD
        IO $io,
        StatisticsCollector $stats,
        SpecificationNode $specification,
        ExampleNode $example,
        ReflectionFunctionAbstract $reflectionFunction
    ) {
        $reflectionFunction->getStartLine()->willReturn(37);
        $example->getFunctionReflection()->willReturn($reflectionFunction);
        $example->getTitle()->willReturn('it tests something');
=======
        ConsoleIO $io,
        StatisticsCollector $stats,
        SpecificationNode $specification,
        ExampleNode $example
    ) {
        $example->getLineNumber()->willReturn(37);
        $example->getTitle()->willReturn('it tests something');

        $specification->getTitle()->willReturn('specification title');

>>>>>>> v2-test
        $pendingEvent->getException()->willReturn(new PendingException());
        $pendingEvent->getSpecification()->willReturn($specification);
        $pendingEvent->getExample()->willReturn($example);

<<<<<<< HEAD
=======
        $io->isVerbose()->willReturn(false);
        $io->getBlockWidth()->willReturn(10);
        $io->write(Argument::type('string'))->should(function () {});
        $io->writeln(Argument::cetera())->should(function () {});

>>>>>>> v2-test
        $stats->getEventsCount()->willReturn(1);
        $stats->getFailedEvents()->willReturn(array());
        $stats->getBrokenEvents()->willReturn(array());
        $stats->getPendingEvents()->willReturn(array($pendingEvent));
        $stats->getSkippedEvents()->willReturn(array());
        $stats->getTotalSpecs()->willReturn(1);

        $stats->getCountsHash()->willReturn(array(
            'passed'  => 0,
            'pending' => 1,
            'skipped' => 0,
            'failed'  => 0,
            'broken'  => 0,
        ));

        $this->afterSuite($event);

        $expected = '<lineno>  37</lineno>  <pending>- it tests something</pending>';
        $io->writeln($expected)->shouldHaveBeenCalled();
    }

    function it_outputs_a_suite_summary(
        SuiteEvent $event,
<<<<<<< HEAD
        IO $io,
=======
        ConsoleIO $io,
>>>>>>> v2-test
        StatisticsCollector $stats
    ) {
        $stats->getEventsCount()->willReturn(1);
        $stats->getFailedEvents()->willReturn(array());
        $stats->getBrokenEvents()->willReturn(array());
        $stats->getPendingEvents()->willReturn(array());
        $stats->getSkippedEvents()->willReturn(array());
        $stats->getTotalSpecs()->willReturn(15);
        $event->getTime()->willReturn(12.345);

        $stats->getCountsHash()->willReturn(array(
            'passed'  => 1,
            'pending' => 0,
            'skipped' => 0,
            'failed'  => 2,
            'broken'  => 0,
        ));

        $this->afterSuite($event);

        $io->writeln('15 specs')->shouldHaveBeenCalled();
        $io->writeln("\n12345ms")->shouldHaveBeenCalled();
        $io->write('1 example ')->shouldHaveBeenCalled();
        $expected = '(<passed>1 passed</passed>, <failed>2 failed</failed>)';
        $io->write($expected)->shouldHaveBeenCalled();
    }
}
