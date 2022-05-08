<?php

namespace spec\PhpSpec\Formatter\Presenter\Exception;

use PhpSpec\Formatter\Presenter\Exception\ExceptionElementPresenter;
use PhpSpec\ObjectBehavior;
<<<<<<< HEAD
use Prophecy\Argument;
=======
>>>>>>> v2-test

class GenericPhpSpecExceptionPresenterSpec extends ObjectBehavior
{
    function let(ExceptionElementPresenter $elementPresenter)
    {
        $this->beConstructedWith($elementPresenter);
    }

    function it_is_a_phpspec_exception_presenter()
    {
        $this->shouldImplement('PhpSpec\Formatter\Presenter\Exception\PhpSpecExceptionPresenter');
    }
}
