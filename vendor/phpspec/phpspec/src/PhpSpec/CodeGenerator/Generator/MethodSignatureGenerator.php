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
use PhpSpec\Util\Filesystem;
use PhpSpec\Locator\ResourceInterface;
=======
use PhpSpec\Console\ConsoleIO;
use PhpSpec\CodeGenerator\TemplateRenderer;
use PhpSpec\Util\Filesystem;
use PhpSpec\Locator\Resource;
>>>>>>> v2-test

/**
 * Generates interface method signatures from a resource
 */
<<<<<<< HEAD
class MethodSignatureGenerator implements GeneratorInterface
{
    /**
     * @var IO
=======
final class MethodSignatureGenerator implements Generator
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
     * @param IO               $io
     * @param TemplateRenderer $templates
     * @param Filesystem       $filesystem
     */
    public function __construct(IO $io, TemplateRenderer $templates, Filesystem $filesystem = null)
    {
        $this->io         = $io;
        $this->templates  = $templates;
        $this->filesystem = $filesystem ?: new Filesystem();
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
     * @param ConsoleIO               $io
     * @param TemplateRenderer $templates
     * @param Filesystem       $filesystem
     */
    public function __construct(ConsoleIO $io, TemplateRenderer $templates, Filesystem $filesystem)
    {
        $this->io         = $io;
        $this->templates  = $templates;
        $this->filesystem = $filesystem;
    }

    public function supports(Resource $resource, string $generation, array $data): bool
>>>>>>> v2-test
    {
        return 'method-signature' === $generation;
    }

<<<<<<< HEAD
    /**
     * @param ResourceInterface $resource
     * @param array             $data
     */
    public function generate(ResourceInterface $resource, array $data = array())
=======
    public function generate(Resource $resource, array $data = array()): void
>>>>>>> v2-test
    {
        $filepath  = $resource->getSrcFilename();
        $name      = $data['name'];
        $arguments = $data['arguments'];

        $argString = $this->buildArgumentString($arguments);

        $values = array('%name%' => $name, '%arguments%' => $argString);
        if (!$content = $this->templates->render('interface-method-signature', $values)) {
            $content = $this->templates->renderString(
                $this->getTemplate(), $values
            );
        }

        $this->insertMethodSignature($filepath, $content);

        $this->io->writeln(sprintf(
            "<info>Method signature <value>%s::%s()</value> has been created.</info>\n",
            $resource->getSrcClassname(), $name
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
        return file_get_contents(__DIR__.'/templates/interface_method_signature.template');
    }

<<<<<<< HEAD
    /**
     * @param string $filepath
     * @param string $content
     */
    private function insertMethodSignature($filepath, $content)
=======
    private function insertMethodSignature(string $filepath, string $content)
>>>>>>> v2-test
    {
        $code = $this->filesystem->getFileContents($filepath);
        $code = preg_replace('/}[ \n]*$/', rtrim($content) . "\n}\n", trim($code));
        $this->filesystem->putFileContents($filepath, $code);
    }

<<<<<<< HEAD
    /**
     * @param array $arguments
     * @return string
     */
    private function buildArgumentString($arguments)
    {
        $argString = count($arguments)
            ? '$argument' . implode(', $argument', range(1, count($arguments)))
=======
    private function buildArgumentString(array $arguments): string
    {
        $argString = \count($arguments)
            ? '$argument' . implode(', $argument', range(1, \count($arguments)))
>>>>>>> v2-test
            : '';
        return $argString;
    }
}
