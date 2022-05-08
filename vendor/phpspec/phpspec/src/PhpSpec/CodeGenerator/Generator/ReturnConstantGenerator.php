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
use PhpSpec\Util\Filesystem;

class ReturnConstantGenerator implements GeneratorInterface
{
    /**
     * @var IO
=======
use PhpSpec\Console\ConsoleIO;
use PhpSpec\Locator\Resource;
use PhpSpec\Util\Filesystem;

final class ReturnConstantGenerator implements Generator
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
        $this->io = $io;
        $this->templates = $templates;
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
     * @param ConsoleIO        $io
     * @param TemplateRenderer $templates
     * @param Filesystem       $filesystem
     */
    public function __construct(ConsoleIO $io, TemplateRenderer $templates, Filesystem $filesystem)
    {
        $this->io = $io;
        $this->templates = $templates;
        $this->filesystem = $filesystem;
    }

    public function supports(Resource $resource, string $generation, array $data): bool
>>>>>>> v2-test
    {
        return 'returnConstant' == $generation;
    }

    /**
<<<<<<< HEAD
     * @param ResourceInterface $resource
     * @param array             $data
     */
    public function generate(ResourceInterface $resource, array $data)
=======
     * @param Resource $resource
     * @param array             $data
     */
    public function generate(Resource $resource, array $data): void
>>>>>>> v2-test
    {
        $method = $data['method'];
        $expected = $data['expected'];

        $code = $this->filesystem->getFileContents($resource->getSrcFilename());

        $values = array('%constant%' => var_export($expected, true));
        if (!$content = $this->templates->render('method', $values)) {
            $content = $this->templates->renderString(
                $this->getTemplate(),
                $values
            );
        }

        $pattern = '/'.'(function\s+'.preg_quote($method, '/').'\s*\([^\)]*\))\s+{[^}]*?}/';
        $replacement = '$1'.$content;

        $modifiedCode = preg_replace($pattern, $replacement, $code);

        $this->filesystem->putFileContents($resource->getSrcFilename(), $modifiedCode);

        $this->io->writeln(sprintf(
            "<info>Method <value>%s::%s()</value> has been modified.</info>\n",
            $resource->getSrcClassname(),
            $method
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
        return file_get_contents(__DIR__.'/templates/returnconstant.template');
    }
}
