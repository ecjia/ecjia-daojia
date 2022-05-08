<?php

namespace spec\PhpSpec\Event;

use PhpSpec\ObjectBehavior;
<<<<<<< HEAD
use Prophecy\Argument;
=======
>>>>>>> v2-test

class FileCreationEventSpec extends ObjectBehavior
{
    private $filepath = 'foo/bar.php';

    function let()
    {
        $this->beConstructedWith($this->filepath);
    }

    function it_should_be_a_symfony_event()
    {
<<<<<<< HEAD
        $this->shouldHaveType('Symfony\Component\EventDispatcher\Event');
=======
        $this->shouldHaveType('PhpSpec\Event\BaseEvent');
>>>>>>> v2-test
    }

    function it_should_be_a_phpspec_event()
    {
<<<<<<< HEAD
        $this->shouldImplement('PhpSpec\Event\EventInterface');
=======
        $this->shouldImplement('PhpSpec\Event\PhpSpecEvent');
>>>>>>> v2-test
    }

    function it_should_return_the_created_file_path()
    {
        $this->getFilePath()->shouldReturn($this->filepath);
    }
}
