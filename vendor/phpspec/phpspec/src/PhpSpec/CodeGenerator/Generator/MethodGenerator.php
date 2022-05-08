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

<<<<<<< HEAD
use PhpSpec\Console\IO;
use PhpSpec\CodeGenerator\TemplateRenderer;
use PhpSpec\CodeGenerator\Writer\CodeWriter;
use PhpSpec\Util\Filesystem;
use PhpSpec\Locator\ResourceInterface;
use PhpSpec\CodeGenerator\Writer\TokenizedCodeWriter;
=======
use PhpSpec\Console\ConsoleIO;
use PhpSpec\CodeGenerator\TemplateRenderer;
use PhpSpec\CodeGenerator\Writer\CodeWriter;
use PhpSpec\Util\Filesystem;
use PhpSpec\Locator\Resource;
>>>>>>> v2-test

/**
 * Generates class methods from a resource
 */
<<<<<<< HEAD
class MethodGenerator implements GeneratorInterface
{
    /**
     * @var IO
=======
final class MethodGenerator implements Generator
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
        return 'method' === $generation;
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
        $filepath  = $resource->getSrcFilename();
        $name      = $data['name'];
        $arguments = $data['arguments'];

<<<<<<< HEAD
        $argString = count($arguments)
            ? '$argument'.implode(', $argument', range(1, count($arguments)))
=======
        $argString = \count($arguments)
            ? '$argument'.implode(', $argument', range(1, \count($arguments)))
>>>>>>> v2-test
            : ''
        ;

        $values = array('%name%' => $name, '%arguments%' => $argString);
        if (!$content = $this->templates->render('method', $values)) {
            $content = $this->templates->renderString(
                $this->getTemplate(),
                $values
            );
        }

        $code = $this->filesystem->getFileContents($filepath);
        $this->filesystem->putFileContents($filepath, $this->getUpdatedCode($name, $content, $code));

        $this->io->writeln(sprintf(
            "<info>Method <value>%s::%s()</value> has been created.</info>\n",
            $resource->getSrcClassname(),
            $name
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
     * @return string
     */
    protected function getTemplate()
=======
    protected function getTemplate(): string
>>>>>>> v2-test
    {
        return file_get_contents(__DIR__.'/templates/method.template');
    }

<<<<<<< HEAD
    /**
     * @param string $methodName
     * @param string $snippetToInsert
     * @param string $code
     * @return string
     */
    private function getUpdatedCode($methodName, $snippetToInsert, $code)
=======
    private function getUpdatedCode(string $methodName, string $snippetToInsert, string $code): string
>>>>>>> v2-test
    {
        if ('__construct' === $methodName) {
            return $this->codeWriter->insertMethodFirstInClass($code, $snippetToInsert);
        }
        return $this->codeWriter->insertMethodLastInClass($code, $snippetToInsert);
    }
}
