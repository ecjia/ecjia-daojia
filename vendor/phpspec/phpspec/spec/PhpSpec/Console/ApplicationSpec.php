<?php

namespace spec\PhpSpec\Console;

use PhpSpec\ObjectBehavior;
<<<<<<< HEAD
use Prophecy\Argument;
=======
>>>>>>> v2-test

class ApplicationSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('test');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('PhpSpec\Console\Application');
    }
}
