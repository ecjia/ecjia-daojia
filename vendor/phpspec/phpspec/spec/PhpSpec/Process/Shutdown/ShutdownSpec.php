<?php

namespace spec\PhpSpec\Process\Shutdown;

use PhpSpec\ObjectBehavior;
<<<<<<< HEAD
use PhpSpec\Process\Shutdown\ShutdownActionInterface;
use Prophecy\Argument;
=======
use PhpSpec\Process\Shutdown\ShutdownAction;
>>>>>>> v2-test

class ShutdownSpec extends ObjectBehavior
{
    function it_has_type_shutdown()
    {
        $this->beAnInstanceOf('PhpSpec/Process/Shutdown/Shutdown');
    }

<<<<<<< HEAD
    function it_runs_through_all_registered_actions(ShutdownActionInterface $action)
=======
    function it_runs_through_all_registered_actions(ShutdownAction $action)
>>>>>>> v2-test
    {
        $action->runAction(null)->shouldBeCalled();
        $this->registerAction($action);
        $this->runShutdown();
    }
}
