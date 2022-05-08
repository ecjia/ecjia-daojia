<?php

namespace spec\PhpSpec\Process\ReRunner;

use PhpSpec\ObjectBehavior;
<<<<<<< HEAD
use PhpSpec\Process\Context\ExecutionContextInterface;
use Prophecy\Argument;
=======
use PhpSpec\Process\Context\ExecutionContext;
>>>>>>> v2-test
use Symfony\Component\Process\PhpExecutableFinder;

class PcntlReRunnerSpec extends ObjectBehavior
{
<<<<<<< HEAD
    function let(PhpExecutableFinder $executableFinder, ExecutionContextInterface $executionContext)
=======
    function let(PhpExecutableFinder $executableFinder, ExecutionContext $executionContext)
>>>>>>> v2-test
    {
        $this->beConstructedThrough('withExecutionContext', array($executableFinder, $executionContext));
    }

    function it_is_a_rerunner()
    {
        $this->shouldHaveType('PhpSpec\Process\ReRunner');
    }

    function it_is_not_supported_when_php_process_is_not_found(PhpExecutableFinder $executableFinder)
    {
        $executableFinder->find()->willReturn(false);

        $this->isSupported()->shouldReturn(false);
    }
}
