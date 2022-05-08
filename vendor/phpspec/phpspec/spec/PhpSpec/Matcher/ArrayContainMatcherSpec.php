<?php

namespace spec\PhpSpec\Matcher;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

<<<<<<< HEAD
use PhpSpec\Formatter\Presenter\PresenterInterface;

class ArrayContainMatcherSpec extends ObjectBehavior
{
    function let(PresenterInterface $presenter)
=======
use PhpSpec\Formatter\Presenter\Presenter;

class ArrayContainMatcherSpec extends ObjectBehavior
{
    function let(Presenter $presenter)
>>>>>>> v2-test
    {
        $presenter->presentValue(Argument::any())->willReturn('countable');
        $presenter->presentString(Argument::any())->willReturnArgument();

        $this->beConstructedWith($presenter);
    }

    function it_is_a_matcher()
    {
<<<<<<< HEAD
        $this->shouldBeAnInstanceOf('PhpSpec\Matcher\MatcherInterface');
=======
        $this->shouldBeAnInstanceOf('PhpSpec\Matcher\Matcher');
>>>>>>> v2-test
    }

    function it_responds_to_contain()
    {
        $this->supports('contain', array(), array(''))->shouldReturn(true);
    }

    function it_matches_array_with_specified_value()
    {
        $this->shouldNotThrow()->duringPositiveMatch('contain', array('abc'), array('abc'));
    }

    function it_does_not_match_array_without_specified_value()
    {
        $this->shouldThrow()->duringPositiveMatch('contain', array(1,2,3), array('abc'));
        $this->shouldThrow('PhpSpec\Exception\Example\FailureException')
            ->duringPositiveMatch('contain', array(1,2,3), array(new \stdClass()));
    }

    function it_matches_array_without_specified_value()
    {
        $this->shouldNotThrow()->duringNegativeMatch('contain', array(1,2,3), array('abc'));
    }
}
