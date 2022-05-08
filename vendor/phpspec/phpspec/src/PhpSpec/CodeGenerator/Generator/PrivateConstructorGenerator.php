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
use PhpSpec\Locator\ResourceInterface;
use PhpSpec\CodeGenerator\Writer\CodeWriter;
use PhpSpec\Util\Filesystem;
use PhpSpec\CodeGenerator\Writer\TokenizedCodeWriter;

final class PrivateConstructorGenerator implements GeneratorInterface
{
    /**
     * @var IO
=======
use PhpSpec\Console\ConsoleIO;
use PhpSpec\Locator\Resource;
use PhpSpec\CodeGenerator\Writer\CodeWriter;
use PhpSpec\Util\Filesystem;

final class PrivateConstructorGenerator implements Generator
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
     * @param IO               $io
     * @param TemplateRenderer $templates
     * @param Filesystem       $filesystem
     */
    public function __construct(IO $io, TemplateRenderer $templates, Filesystem $filesystem = null, CodeWriter $codeWriter = null)
    {
        $this->io         = $io;
        $this->templates  = $templates;
        $this->filesystem = $filesystem ?: new Filesystem();
        $this->codeWriter = $codeWriter ?: new TokenizedCodeWriter();
    }

    /**
     * @param ResourceInterface $resource
     * @param string $generation
     * @param array $data
     *
     * @return bool
     */
    public function supports(ResourceInterface $resource, $generation, array $data)
=======
     * @param ConsoleIO $io
     * @param TemplateRenderer $templates
     * @param Filesystem $filesystem
     * @param CodeWriter $codeWriter
     */
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
        return 'private-constructor' === $generation;
    }

    /**
<<<<<<< HEAD
     * @param ResourceInterface $resource
     * @param array $data
     */
    public function generate(ResourceInterface $resource, array $data)
=======
     * @param Resource $resource
     * @param array $data
     */
    public function generate(Resource $resource, array $data): void
>>>>>>> v2-test
    {
        $filepath  = $resource->getSrcFilename();

        if (!$content = $this->templates->render('private-constructor', array())) {
            $content = $this->templates->renderString(
                $this->getTemplate(),
                array()
            );
        }

        $code = $this->filesystem->getFileContents($filepath);
        $code = $this->codeWriter->insertMethodFirstInClass($code, $content);
        $this->filesystem->putFileContents($filepath, $code);

        $this->io->writeln("<info>Private constructor has been created.</info>\n", 2);
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
        return file_get_contents(__DIR__.'/templates/private-constructor.template');
    }
}
