<?php

namespace spec\PhpSpec\Listener;

use PhpSpec\Event\SuiteEvent;
use PhpSpec\ObjectBehavior;
<<<<<<< HEAD
use PhpSpec\Process\Prerequisites\SuitePrerequisitesInterface;
use PhpSpec\Process\ReRunner;
use Prophecy\Argument;

class RerunListenerSpec extends ObjectBehavior
{
    function let(ReRunner $reRunner, SuitePrerequisitesInterface $suitePrerequisites)
=======
use PhpSpec\Process\Prerequisites\PrerequisiteTester;
use PhpSpec\Process\ReRunner;

class RerunListenerSpec extends ObjectBehavior
{
    function let(ReRunner $reRunner, PrerequisiteTester $suitePrerequisites)
>>>>>>> v2-test
    {
        $this->beConstructedWith($reRunner, $suitePrerequisites);
    }

    function it_subscribes_to_aftersuite()
    {
        $this->shouldHaveType('Symfony\Component\EventDispatcher\EventSubscriberInterface');
        $this->getSubscribedEvents()->shouldHaveKey('afterSuite');
    }

    function it_does_not_tell_the_rerunner_to_rerun_if_it_is_not_worth_doing_so(SuiteEvent $suiteEvent, ReRunner $reRunner)
    {
        $suiteEvent->isWorthRerunning()->willReturn(false);

        $this->afterSuite($suiteEvent);

        $reRunner->reRunSuite()->shouldNotHaveBeenCalled();
    }

    function it_tells_the_rerunner_to_rerun_if_it_is_worth_doing_so(SuiteEvent $suiteEvent, ReRunner $reRunner)
    {
        $suiteEvent->isWorthRerunning()->willReturn(true);

        $this->afterSuite($suiteEvent);

        $reRunner->reRunSuite()->shouldHaveBeenCalled();
    }
}
