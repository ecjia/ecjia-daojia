<?php

namespace spec\PhpSpec\Process\Prerequisites;

use PhpSpec\ObjectBehavior;
<<<<<<< HEAD
use PhpSpec\Process\Context\ExecutionContextInterface;
use Prophecy\Argument;

class SuitePrerequisitesSpec extends ObjectBehavior
{
    function let(ExecutionContextInterface $executionContext)
=======
use PhpSpec\Process\Context\ExecutionContext;

class SuitePrerequisitesSpec extends ObjectBehavior
{
    function let(ExecutionContext $executionContext)
>>>>>>> v2-test
    {
        $this->beConstructedWith($executionContext);
    }

<<<<<<< HEAD
    function it_does_nothing_when_types_exist(ExecutionContextInterface $executionContext)
=======
    function it_does_nothing_when_types_exist(ExecutionContext $executionContext)
>>>>>>> v2-test
    {
        $executionContext->getGeneratedTypes()->willReturn(array('stdClass'));

        $this->guardPrerequisites();
    }

<<<<<<< HEAD
    function it_throws_execption_when_types_do_not_exist(ExecutionContextInterface $executionContext)
=======
    function it_throws_execption_when_types_do_not_exist(ExecutionContext $executionContext)
>>>>>>> v2-test
    {
        $executionContext->getGeneratedTypes()->willReturn(array('stdClassXXX'));

        $this->shouldThrow('PhpSpec\Process\Prerequisites\PrerequisiteFailedException')->duringGuardPrerequisites();
    }
}
