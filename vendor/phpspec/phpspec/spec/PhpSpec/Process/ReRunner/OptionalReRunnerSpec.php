<?php

namespace spec\PhpSpec\Process\ReRunner;

<<<<<<< HEAD
use PhpSpec\Console\IO;
use PhpSpec\ObjectBehavior;
use PhpSpec\Process\ReRunner;
use Prophecy\Argument;

class OptionalReRunnerSpec extends ObjectBehavior
{
    function let(IO $io, ReRunner $decoratedReRunner)
=======
use PhpSpec\Console\ConsoleIO;
use PhpSpec\ObjectBehavior;
use PhpSpec\Process\ReRunner;

class OptionalReRunnerSpec extends ObjectBehavior
{
    function let(ConsoleIO $io, ReRunner $decoratedReRunner)
>>>>>>> v2-test
    {
        $this->beconstructedWith($decoratedReRunner, $io);
    }

<<<<<<< HEAD
    function it_reruns_the_suite_if_it_is_enabled_in_the_config(IO $io, ReRunner $decoratedReRunner)
=======
    function it_reruns_the_suite_if_it_is_enabled_in_the_config(ConsoleIO $io, ReRunner $decoratedReRunner)
>>>>>>> v2-test
    {
        $io->isRerunEnabled()->willReturn(true);

        $this->reRunSuite();

        $decoratedReRunner->reRunSuite()->shouldHaveBeenCalled();
    }

<<<<<<< HEAD
    function it_does_not_rerun_the_suite_if_it_is_disabled_in_the_config(IO $io, ReRunner $decoratedReRunner)
=======
    function it_does_not_rerun_the_suite_if_it_is_disabled_in_the_config(ConsoleIO $io, ReRunner $decoratedReRunner)
>>>>>>> v2-test
    {
        $io->isRerunEnabled()->willReturn(false);

        $this->reRunSuite();

        $decoratedReRunner->reRunSuite()->shouldNotHaveBeenCalled();
    }
}
