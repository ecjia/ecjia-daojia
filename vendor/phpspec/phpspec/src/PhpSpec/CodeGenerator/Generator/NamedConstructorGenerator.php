<?php

/*
 * This file is part of PhpSpec, A php toolset to drive emergent
 * design by specification.
 *
 * (c) Marcello Duarte <marcello.duarte@gmail.com>
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpSpec\CodeGenerator\Generator;

use PhpSpec\CodeGenerator\TemplateRenderer;
<<<<<<< HEAD
use PhpSpec\Console\IO;
use PhpSpec\Exception\Generator\NamedMethodNotFoundException;
use PhpSpec\Locator\ResourceInterface;
use PhpSpec\CodeGenerator\Writer\CodeWriter;
use PhpSpec\Util\Filesystem;
use PhpSpec\CodeGenerator\Writer\TokenizedCodeWriter;

class NamedConstructorGenerator implements GeneratorInterface
{
    /**
     * @var IO
=======
use PhpSpec\Console\ConsoleIO;
use PhpSpec\Exception\Generator\NamedMethodNotFoundException;
use PhpSpec\Locator\Resource;
use PhpSpec\CodeGenerator\Writer\CodeWriter;
use PhpSpec\Util\Filesystem;

final class NamedConstructorGenerator implements Generator
{
    /**
     * @var ConsoleIO
>>>>>>> v2-test
     */
    private $io;

    /**
     * @var TemplateRenderer
     */
    private $templates;

    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var CodeWriter
     */
    private $codeWriter;

    /**
<<<<<<< HEAD
     * @param IO $io
=======
     * @param ConsoleIO $io
>>>>>>> v2-test
     * @param TemplateRenderer $templates
     * @param Filesystem $filesystem
     * @param CodeWriter $codeWriter
     */
<<<<<<< HEAD
    public function __construct(IO $io, TemplateRenderer $templates, Filesystem $filesystem = null, CodeWriter $codeWriter = null)
    {
        $this->io         = $io;
        $this->templates  = $templates;
        $this->filesystem = $filesystem ?: new Filesystem();
        $this->codeWriter = $codeWriter ?: new TokenizedCodeWriter();
    }

    /**
     * @param ResourceInterface $resource
     * @param string            $generation
     * @param array             $data
     *
     * @return bool
     */
    public function supports(ResourceInterface $resource, $generation, array $data)
=======
    public function __construct(ConsoleIO $io, TemplateRenderer $templates, Filesystem $filesystem, CodeWriter $codeWriter)
    {
        $this->io         = $io;
        $this->templates  = $templates;
        $this->filesystem = $filesystem;
        $this->codeWriter = $codeWriter;
    }

    public function supports(Resource $resource, string $generation, array $data): bool
>>>>>>> v2-test
    {
        return 'named_constructor' === $generation;
    }

    /**
<<<<<<< HEAD
     * @param ResourceInterface $resource
     * @param array             $data
     */
    public function generate(ResourceInterface $resource, array $data = array())
=======
     * @param Resource $resource
     * @param array             $data
     */
    public function generate(Resource $resource, array $data = array()): void
>>>>>>> v2-test
    {
        $filepath   = $resource->getSrcFilename();
        $methodName = $data['name'];
        $arguments  = $data['arguments'];

        $content = $this->getContent($resource, $methodName, $arguments);


        $code = $this->appendMethodToCode(
            $this->filesystem->getFileContents($filepath),
            $content
        );
        $this->filesystem->putFileContents($filepath, $code);

        $this->io->writeln(sprintf(
            "<info>Method <value>%s::%s()</value> has been created.</info>\n",
            $resource->getSrcClassname(),
            $methodName
        ), 2);
    }

<<<<<<< HEAD
    /**
     * @return int
     */
    public function getPriority()
=======
    public function getPriority(): int
>>>>>>> v2-test
    {
        return 0;
    }

<<<<<<< HEAD
    /**
     * @param  ResourceInterface $resource
     * @param  string            $methodName
     * @param  array             $arguments
     * @return string
     */
    private function getContent(ResourceInterface $resource, $methodName, $arguments)
=======
    private function getContent(Resource $resource, string $methodName, array $arguments): string
>>>>>>> v2-test
    {
        $className = $resource->getName();
        $class = $resource->getSrcClassname();

        $template = new CreateObjectTemplate($this->templates, $methodName, $arguments, $className);

        if (method_exists($class, '__construct')) {
            $template = new ExistingConstructorTemplate(
                $this->templates,
                $methodName,
                $arguments,
                $className,
                $class
            );
        }

        return $template->getContent();
    }

<<<<<<< HEAD
    /**
     * @param string $code
     * @param string $method
     * @return string
     */
    private function appendMethodToCode($code, $method)
=======
    private function appendMethodToCode(string $code, string $method): string
>>>>>>> v2-test
    {
        try {
            return $this->codeWriter->insertAfterMethod($code, '__construct', $method);
        } catch (NamedMethodNotFoundException $e) {
            return $this->codeWriter->insertMethodFirstInClass($code, $method);
        }
    }
}
