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
use PhpSpec\Process\Context\JsonExecutionContext;
use PhpSpec\Process\Context\ExecutionContextInterface;
use PhpSpec\Util\Filesystem;
use PhpSpec\Locator\ResourceInterface;
=======
use PhpSpec\Console\ConsoleIO;
use PhpSpec\CodeGenerator\TemplateRenderer;
use PhpSpec\Process\Context\ExecutionContext;
use PhpSpec\Util\Filesystem;
use PhpSpec\Locator\Resource;
>>>>>>> v2-test

/**
 * Base class with common behaviour for generating class and spec class
 */
<<<<<<< HEAD
abstract class PromptingGenerator implements GeneratorInterface
{
    /**
     * @var IO
=======
abstract class PromptingGenerator implements Generator
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
<<<<<<< HEAD
     * @var ExecutionContextInterface
=======
     * @var ExecutionContext
>>>>>>> v2-test
     */
    private $executionContext;

    /**
<<<<<<< HEAD
     * @param IO $io
     * @param TemplateRenderer $templates
     * @param Filesystem $filesystem
     * @param ExecutionContextInterface $executionContext
     */
    public function __construct(IO $io, TemplateRenderer $templates, Filesystem $filesystem = null, ExecutionContextInterface $executionContext = null)
    {
        $this->io         = $io;
        $this->templates  = $templates;
        $this->filesystem = $filesystem ?: new Filesystem();
        $this->executionContext = $executionContext ?: new JsonExecutionContext();
    }

    /**
     * @param ResourceInterface $resource
     * @param array             $data
     */
    public function generate(ResourceInterface $resource, array $data = array())
=======
     * @param ConsoleIO $io
     * @param TemplateRenderer $templates
     * @param Filesystem $filesystem
     * @param ExecutionContext $executionContext
     */
    public function __construct(ConsoleIO $io, TemplateRenderer $templates, Filesystem $filesystem, ExecutionContext $executionContext)
    {
        $this->io         = $io;
        $this->templates  = $templates;
        $this->filesystem = $filesystem;
        $this->executionContext = $executionContext;
    }

    /**
     * @param Resource $resource
     * @param array             $data
     */
    public function generate(Resource $resource, array $data = array()): void
>>>>>>> v2-test
    {
        $filepath = $this->getFilePath($resource);

        if ($this->fileAlreadyExists($filepath)) {
            if ($this->userAborts($filepath)) {
                return;
            }

            $this->io->writeln();
        }

        $this->createDirectoryIfItDoesExist($filepath);
        $this->generateFileAndRenderTemplate($resource, $filepath);
        $this->executionContext->addGeneratedType($resource->getSrcClassname());
    }

<<<<<<< HEAD
    /**
     * @return TemplateRenderer
     */
    protected function getTemplateRenderer()
=======
    protected function getTemplateRenderer(): TemplateRenderer
>>>>>>> v2-test
    {
        return $this->templates;
    }

<<<<<<< HEAD
    /**
     * @param ResourceInterface $resource
     *
     * @return string
     */
    abstract protected function getFilePath(ResourceInterface $resource);

    /**
     * @param ResourceInterface $resource
     * @param string            $filepath
     *
     * @return string
     */
    abstract protected function renderTemplate(ResourceInterface $resource, $filepath);

    /**
     * @param ResourceInterface $resource
=======
    abstract protected function getFilePath(Resource $resource): string;

    abstract protected function renderTemplate(Resource $resource, string $filepath): string;

    /**
     * @param Resource $resource
>>>>>>> v2-test
     * @param string            $filepath
     *
     * @return string
     */
<<<<<<< HEAD
    abstract protected function getGeneratedMessage(ResourceInterface $resource, $filepath);

    /**
     * @param string $filepath
     *
     * @return bool
     */
    private function fileAlreadyExists($filepath)
=======
    abstract protected function getGeneratedMessage(Resource $resource, string $filepath): string;

    private function fileAlreadyExists(string $filepath): bool
>>>>>>> v2-test
    {
        return $this->filesystem->pathExists($filepath);
    }

<<<<<<< HEAD
    /**
     * @param string $filepath
     *
     * @return bool
     */
    private function userAborts($filepath)
=======
    private function userAborts(string $filepath): bool
>>>>>>> v2-test
    {
        $message = sprintf('File "%s" already exists. Overwrite?', basename($filepath));

        return !$this->io->askConfirmation($message, false);
    }

<<<<<<< HEAD
    /**
     * @param string $filepath
     */
    private function createDirectoryIfItDoesExist($filepath)
=======
    private function createDirectoryIfItDoesExist(string $filepath)
>>>>>>> v2-test
    {
        $path = dirname($filepath);
        if (!$this->filesystem->isDirectory($path)) {
            $this->filesystem->makeDirectory($path);
        }
    }

<<<<<<< HEAD
    /**
     * @param ResourceInterface $resource
     * @param string            $filepath
     */
    private function generateFileAndRenderTemplate(ResourceInterface $resource, $filepath)
=======
    private function generateFileAndRenderTemplate(Resource $resource, string $filepath)
>>>>>>> v2-test
    {
        $content = $this->renderTemplate($resource, $filepath);

        $this->filesystem->putFileContents($filepath, $content);
        $this->io->writeln($this->getGeneratedMessage($resource, $filepath));
    }
}
