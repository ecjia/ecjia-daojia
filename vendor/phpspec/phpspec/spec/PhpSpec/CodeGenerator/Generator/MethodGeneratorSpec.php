<?php

namespace spec\PhpSpec\CodeGenerator\Generator;

<<<<<<< HEAD
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use PhpSpec\Console\IO;
use PhpSpec\CodeGenerator\TemplateRenderer;
use PhpSpec\Util\Filesystem;
use PhpSpec\Locator\ResourceInterface;

class MethodGeneratorSpec extends ObjectBehavior
{
    function let(IO $io, TemplateRenderer $tpl, Filesystem $fs)
    {
        $this->beConstructedWith($io, $tpl, $fs);
=======
use PhpSpec\CodeGenerator\Writer\CodeWriter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use PhpSpec\Console\ConsoleIO;
use PhpSpec\CodeGenerator\TemplateRenderer;
use PhpSpec\Util\Filesystem;
use PhpSpec\Locator\Resource;

class MethodGeneratorSpec extends ObjectBehavior
{
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

    function it_supports_method_generation(ResourceInterface $resource)
=======
        $this->shouldBeAnInstanceOf('PhpSpec\CodeGenerator\Generator\Generator');
    }

    function it_supports_method_generation(Resource $resource)
>>>>>>> v2-test
    {
        $this->supports($resource, 'method', array())->shouldReturn(true);
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
    function it_generates_class_method_from_resource($io, $tpl, $fs, ResourceInterface $resource)
=======
    function it_generates_class_method_from_resource($io, $tpl, $fs, Resource $resource, CodeWriter $codeWriter)
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
            '%name%'      => 'setName',
            '%arguments%' => '$argument1',
        );

        $resource->getSrcFilename()->willReturn('/project/src/Acme/App.php');
        $resource->getSrcClassname()->willReturn('Acme\App');

<<<<<<< HEAD
        $tpl->render('method', $values)->willReturn(null);
        $tpl->renderString(Argument::type('string'), $values)->willReturn('METHOD');

=======
        $tpl->render('method', $values)->willReturn('');
        $tpl->renderString(Argument::type('string'), $values)->willReturn('METHOD');

        $codeWriter->insertMethodLastInClass($codeWithoutMethod, 'METHOD')->willReturn($codeWithMethod);

>>>>>>> v2-test
        $fs->getFileContents('/project/src/Acme/App.php')->willReturn($codeWithoutMethod);
        $fs->putFileContents('/project/src/Acme/App.php', $codeWithMethod)->shouldBeCalled();

        $this->generate($resource, array('name' => 'setName', 'arguments' => array('everzet')));
    }
}
