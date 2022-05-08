<?php

namespace spec\PhpSpec\Matcher;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

<<<<<<< HEAD
use PhpSpec\Formatter\Presenter\PresenterInterface;
=======
use PhpSpec\Formatter\Presenter\Presenter;
>>>>>>> v2-test

use ArrayObject;

class ArrayKeyMatcherSpec extends ObjectBehavior
{
<<<<<<< HEAD
    function let(PresenterInterface $presenter)
=======
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

    function it_responds_to_haveKey()
    {
        $this->supports('haveKey', array(), array(''))->shouldReturn(true);
    }

    function it_matches_array_with_specified_key()
    {
        $this->shouldNotThrow()->duringPositiveMatch('haveKey', array('abc' => 123), array('abc'));
    }

    function it_matches_array_with_specified_key_even_if_there_is_no_value()
    {
        $this->shouldNotThrow()->duringPositiveMatch('haveKey', array('abc' => null), array('abc'));
    }

    function it_matches_ArrayObject_with_provided_offset(ArrayObject $array)
    {
        $array->offsetExists('abc')->willReturn(true);

        $this->shouldNotThrow()->duringPositiveMatch('haveKey', $array, array('abc'));
    }

    function it_does_not_match_array_without_specified_key()
    {
        $this->shouldThrow()->duringPositiveMatch('haveKey', array(1,2,3), array('abc'));
    }

    function it_does_not_match_ArrayObject_without_provided_offset(ArrayObject $array)
    {
        $array->offsetExists('abc')->willReturn(false);

        $this->shouldThrow()->duringPositiveMatch('haveKey', $array, array('abc'));
    }

    function it_matches_array_without_specified_key()
    {
        $this->shouldNotThrow()->duringNegativeMatch('haveKey', array(1,2,3), array('abc'));
    }

    function it_matches_ArrayObject_without_specified_offset(ArrayObject $array)
    {
        $array->offsetExists('abc')->willReturn(false);

        $this->shouldNotThrow()->duringNegativeMatch('haveKey', $array, array('abc'));
    }
}
