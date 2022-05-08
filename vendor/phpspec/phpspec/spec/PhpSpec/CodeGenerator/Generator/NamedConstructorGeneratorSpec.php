<?php

namespace spec\PhpSpec\CodeGenerator\Generator;

use PhpSpec\CodeGenerator\TemplateRenderer;
<<<<<<< HEAD
use PhpSpec\Console\IO;
use PhpSpec\Locator\ResourceInterface;
=======
use PhpSpec\CodeGenerator\Writer\CodeWriter;
use PhpSpec\Console\ConsoleIO;
use PhpSpec\Locator\Resource;
>>>>>>> v2-test
use PhpSpec\ObjectBehavior;
use PhpSpec\Util\Filesystem;
use Prophecy\Argument;

class NamedConstructorGeneratorSpec extends ObjectBehavior
{
<<<<<<< HEAD
    function let(IO $io, TemplateRenderer $tpl, Filesystem $fs)
    {
        $this->beConstructedWith($io, $tpl, $fs);
=======
    function let(ConsoleIO $io, TemplateRenderer $tpl, Filesystem $fs, CodeWriter $codeWriter)
    {
        $this->beConstructedWith($io, $tpl, $fs, $codeWriter);
>>>>>>> v2-test
    }

    function it_is_a_generator()
    {
<<<<<<< HEAD
        $this->shouldBeAnInstanceOf('PhpSpec\CodeGenerator\Generator\GeneratorInterface');
    }

    function it_supports_static_constructor_generation(ResourceInterface $resource)
=======
        $this->shouldBeAnInstanceOf('PhpSpec\CodeGenerator\Generator\Generator');
    }

    function it_supports_static_constructor_generation(Resource $resource)
>>>>>>> v2-test
    {
        $this->supports($resource, 'named_constructor', array())->shouldReturn(true);
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

<<<<<<< HEAD
    function it_generates_static_constructor_method_from_resource($io, $tpl, $fs, ResourceInterface $resource)
=======
    function it_generates_static_constructor_method_from_resource($io, $tpl, $fs, Resource $resource, CodeWriter $codeWriter)
>>>>>>> v2-test
    {
        $codeWithoutMethod = <<<CODE
<?php

namespace Acme;

class App
{
}

CODE;
        $codeWithMethod = <<<CODE
<?php

namespace Acme;

class App
{
METHOD
}

CODE;
        $values = array(
            '%methodName%' => 'setName',
            '%arguments%'  => '$argument1',
            '%returnVar%'  => '$app',
            '%className%'  => 'App',
            '%constructorArguments%' => ''
        );

        $resource->getSrcFilename()->willReturn('/project/src/Acme/App.php');
        $resource->getSrcClassname()->willReturn('Acme\App');
        $resource->getName()->willReturn('App');

<<<<<<< HEAD
        $tpl->render('named_constructor_create_object', $values)->willReturn(null);
        $tpl->renderString(Argument::type('string'), $values)->willReturn('METHOD');

=======
        $tpl->render('named_constructor_create_object', $values)->willReturn('');
        $tpl->renderString(Argument::type('string'), $values)->willReturn('METHOD');

        $codeWriter->insertAfterMethod($codeWithoutMethod, '__construct', 'METHOD')->willReturn($codeWithMethod);

>>>>>>> v2-test
        $fs->getFileContents('/project/src/Acme/App.php')->willReturn($codeWithoutMethod);
        $fs->putFileContents('/project/src/Acme/App.php', $codeWithMethod)->shouldBeCalled();

        $this->generate($resource, array('name' => 'setName', 'arguments' => array('jmurphy')));
    }
}
