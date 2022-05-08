<?php

namespace spec\PhpSpec\CodeGenerator\Generator;

use PhpSpec\CodeGenerator\TemplateRenderer;
<<<<<<< HEAD
use PhpSpec\Console\IO;
use PhpSpec\ObjectBehavior;
use PhpSpec\Util\Filesystem;
use Prophecy\Argument;
use PhpSpec\Locator\ResourceInterface;

class ReturnConstantGeneratorSpec extends ObjectBehavior
{
    function let(IO $io, TemplateRenderer $templates, Filesystem $filesystem)
=======
use PhpSpec\Console\ConsoleIO;
use PhpSpec\ObjectBehavior;
use PhpSpec\Util\Filesystem;
use PhpSpec\Locator\Resource;

class ReturnConstantGeneratorSpec extends ObjectBehavior
{
    function let(ConsoleIO $io, TemplateRenderer $templates, Filesystem $filesystem)
>>>>>>> v2-test
    {
        $this->beConstructedWith($io, $templates, $filesystem);
    }

    function it_is_a_generator()
    {
<<<<<<< HEAD
        $this->shouldHaveType('PhpSpec\CodeGenerator\Generator\GeneratorInterface');
    }

    function it_supports_returnConstant_generation(ResourceInterface $resource)
=======
        $this->shouldHaveType('PhpSpec\CodeGenerator\Generator\Generator');
    }

    function it_supports_returnConstant_generation(Resource $resource)
>>>>>>> v2-test
    {
        $this->supports($resource, 'returnConstant', array())->shouldReturn(true);
    }

<<<<<<< HEAD
    function it_does_not_support_anything_else(ResourceInterface $resource)
=======
    function it_does_not_support_anything_else(Resource $resource)
>>>>>>> v2-test
    {
        $this->supports($resource, 'anything_else', array())->shouldReturn(false);
    }

    function its_priority_is_0()
    {
        $this->getPriority()->shouldReturn(0);
    }
}
