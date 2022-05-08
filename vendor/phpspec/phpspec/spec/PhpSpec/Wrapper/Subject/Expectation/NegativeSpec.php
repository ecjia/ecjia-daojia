<?php

namespace spec\PhpSpec\Wrapper\Subject\Expectation;

use PhpSpec\ObjectBehavior;
<<<<<<< HEAD
use PhpSpec\Wrapper\Subject;
use Prophecy\Argument;

use PhpSpec\Matcher\MatcherInterface;

class NegativeSpec extends ObjectBehavior
{
    function let(MatcherInterface $matcher)
=======

use PhpSpec\Matcher\Matcher;

class NegativeSpec extends ObjectBehavior
{
    function let(Matcher $matcher)
>>>>>>> v2-test
    {
        $this->beConstructedWith($matcher);
    }

<<<<<<< HEAD
    function it_calls_a_negative_match_on_matcher(MatcherInterface $matcher)
=======
    function it_calls_a_negative_match_on_matcher(Matcher $matcher)
>>>>>>> v2-test
    {
        $alias = 'somealias';
        $subject = 'subject';
        $arguments = array();

        $matcher->negativeMatch($alias, $subject, $arguments)->shouldBeCalled();
        $this->match($alias, $subject, $arguments);
    }
}
