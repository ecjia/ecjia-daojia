<?php

namespace spec\PhpSpec\Util;

use PhpSpec\ObjectBehavior;
<<<<<<< HEAD
use Prophecy\Argument;
=======
>>>>>>> v2-test

class ReservedWordsMethodNameCheckerSpec extends ObjectBehavior
{
    function it_is_restriction_provider()
    {
<<<<<<< HEAD
        $this->shouldHaveType('PhpSpec\Util\NameCheckerInterface');
=======
        $this->shouldHaveType('PhpSpec\Util\NameChecker');
>>>>>>> v2-test
    }

    function it_returns_true_for_not_php_restricted_name()
    {
        $this->isNameValid('foo')->shouldReturn(true);
    }

<<<<<<< HEAD
    function it_returns_false_for_php_restricted_name()
    {
        $this->isNameValid('function')->shouldReturn(false);
    }

    function it_returns_false_for_php_predefined_constant()
    {
        $this->isNameValid('__CLASS__')->shouldReturn(false);
    }

    function it_returns_false_for_php_restricted_name_case_insensitive()
    {
        $this->isNameValid('instanceof')->shouldReturn(false);
        $this->isNameValid('instanceOf')->shouldReturn(false);
=======
    function it_returns_false_for___halt_compiler_function()
    {
        $this->isNameValid('__halt_compiler')->shouldReturn(false);
>>>>>>> v2-test
    }
}
