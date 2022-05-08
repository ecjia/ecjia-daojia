<?php

namespace spec\PhpSpec\Wrapper\Subject\Expectation;

<<<<<<< HEAD
use PhpSpec\Matcher\MatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PositiveSpec extends ObjectBehavior
{
    function let(MatcherInterface $matcher)
=======
use PhpSpec\Matcher\Matcher;
use PhpSpec\ObjectBehavior;

class PositiveSpec extends ObjectBehavior
{
    function let(Matcher $matcher)
>>>>>>> v2-test
    {
        $this->beConstructedWith($matcher);
    }

<<<<<<< HEAD
    function it_calls_a_positive_match_on_matcher(MatcherInterface $matcher)
=======
    function it_calls_a_positive_match_on_matcher(Matcher $matcher)
>>>>>>> v2-test
    {
        $alias = 'somealias';
        $subject = 'subject';
        $arguments = array();

        $matcher->positiveMatch($alias, $subject, $arguments)->shouldBeCalled();
        $this->match($alias, $subject, $arguments);
    }
}
