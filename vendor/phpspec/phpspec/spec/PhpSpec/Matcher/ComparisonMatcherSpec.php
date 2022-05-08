<?php

namespace spec\PhpSpec\Matcher;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

<<<<<<< HEAD
use PhpSpec\Formatter\Presenter\PresenterInterface;
=======
use PhpSpec\Formatter\Presenter\Presenter;
>>>>>>> v2-test
use PhpSpec\Exception\Example\FailureException;

class ComparisonMatcherSpec extends ObjectBehavior
{
<<<<<<< HEAD
    function let(PresenterInterface $presenter)
=======
    function let(Presenter $presenter)
>>>>>>> v2-test
    {
        $presenter->presentValue(Argument::any())->willReturn('val1', 'val2');

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

    function it_responds_to_beLike()
    {
        $this->supports('beLike', '', array(''))->shouldReturn(true);
    }

    function it_matches_empty_string_using_comparison_operator()
    {
        $this->shouldNotThrow()->duringPositiveMatch('beLike', '', array(''));
    }

    function it_matches_not_empty_string_using_comparison_operator()
    {
        $this->shouldNotThrow()->duringPositiveMatch('beLike', 'chuck', array('chuck'));
    }

    function it_matches_empty_string_with_emptish_values_using_comparison_operator()
    {
<<<<<<< HEAD
        $this->shouldNotThrow()->duringPositiveMatch('beLike', '', array(0));
=======
        $expectation = (\PHP_VERSION_ID >= 80000) ? $this->shouldThrow() : $this->shouldNotThrow();


        $expectation->duringPositiveMatch('beLike', '', array(0));
>>>>>>> v2-test
    }

    function it_matches_zero_with_emptish_values_using_comparison_operator()
    {
<<<<<<< HEAD
        $this->shouldNotThrow()->duringPositiveMatch('beLike', 0, array(''));
=======
        $expectation = (\PHP_VERSION_ID >= 80000) ? $this->shouldThrow() : $this->shouldNotThrow();

        $expectation->duringPositiveMatch('beLike', 0, array(''));
>>>>>>> v2-test
    }

    function it_matches_null_with_emptish_values_using_comparison_operator()
    {
        $this->shouldNotThrow()->duringPositiveMatch('beLike', null, array(''));
    }

    function it_matches_false_with_emptish_values_using_comparison_operator()
    {
        $this->shouldNotThrow()->duringPositiveMatch('beLike', false, array(''));
    }

    function it_does_not_match_non_empty_different_value()
    {
        $this->shouldThrow(new FailureException('Expected val1, but got val2.'))
            ->duringPositiveMatch('beLike', 'one_value', array('different_value'));
    }

    function it_mismatches_empty_string_using_comparison_operator()
    {
        $this->shouldThrow(new FailureException('Did not expect val1, but got one.'))
            ->duringNegativeMatch('beLike', '', array(''));
    }

    function it_mismatches_not_empty_string_using_comparison_operator($matcher)
    {
        $this->shouldThrow(new FailureException('Did not expect val1, but got one.'))
            ->duringNegativeMatch('beLike', 'chuck', array('chuck'));
    }

    function it_mismatches_empty_string_with_emptish_values_using_comparison_operator()
    {
        $this->shouldThrow(new FailureException('Did not expect val1, but got one.'))
            ->duringNegativeMatch('beLike', '', array(''));
    }

    function it_mismatches_zero_with_emptish_values_using_comparison_operator()
    {
<<<<<<< HEAD
        $this->shouldThrow(new FailureException('Did not expect val1, but got one.'))
            ->duringNegativeMatch('beLike', 0, array(''));
=======
        $expectation = (\PHP_VERSION_ID >= 80000) ? $this->shouldNotThrow() : $this->shouldThrow(new FailureException('Did not expect val1, but got one.'));

        $expectation->duringNegativeMatch('beLike', 0, array(''));
>>>>>>> v2-test
    }

    function it_mismatches_null_with_emptish_values_using_comparison_operator()
    {
        $this->shouldThrow(new FailureException('Did not expect val1, but got one.'))
            ->duringNegativeMatch('beLike', null, array(''));
    }

    function it_mismatches_false_with_emptish_values_using_comparison_operator()
    {
        $this->shouldThrow(new FailureException('Did not expect val1, but got one.'))
            ->duringNegativeMatch('beLike', false, array(''));
    }

    function it_mismatches_on_non_empty_different_value()
    {
        $this->shouldNotThrow()->duringNegativeMatch('beLike', 'one_value', array('another'));
    }
}
