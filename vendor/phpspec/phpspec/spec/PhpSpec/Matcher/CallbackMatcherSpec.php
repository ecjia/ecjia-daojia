<?php

namespace spec\PhpSpec\Matcher;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

<<<<<<< HEAD
use PhpSpec\Formatter\Presenter\PresenterInterface;

class CallbackMatcherSpec extends ObjectBehavior
{
    function let(PresenterInterface $presenter)
=======
use PhpSpec\Formatter\Presenter\Presenter;

class CallbackMatcherSpec extends ObjectBehavior
{
    function let(Presenter $presenter)
>>>>>>> v2-test
    {
        $presenter->presentValue(Argument::any())->willReturn('val');
        $presenter->presentString(Argument::any())->willReturnArgument();

        $this->beConstructedWith('custom', function () {}, $presenter);
    }

    function it_is_a_matcher()
    {
<<<<<<< HEAD
        $this->shouldBeAnInstanceOf('PhpSpec\Matcher\MatcherInterface');
=======
        $this->shouldBeAnInstanceOf('PhpSpec\Matcher\Matcher');
>>>>>>> v2-test
    }

    function it_supports_same_alias_it_was_constructed_with()
    {
        $this->supports('custom', array(), array())->shouldReturn(true);
    }

    function it_does_not_support_anything_else()
    {
        $this->supports('anything_else', array(), array())->shouldReturn(false);
    }

    function it_matches_if_callback_returns_true($presenter)
    {
        $this->beConstructedWith('custom', function () { return true; }, $presenter);

        $this->shouldNotThrow()->duringPositiveMatch('custom', array(), array());
    }

    function it_does_not_match_if_callback_returns_false($presenter)
    {
        $this->beConstructedWith('custom', function () { return false; }, $presenter);

        $this->shouldThrow()->duringPositiveMatch('custom', array(), array());
    }
}
