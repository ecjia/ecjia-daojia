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
use PhpSpec\Locator\ResourceInterface;
=======
use PhpSpec\Locator\Resource;
>>>>>>> v2-test

/**
 * The Class Generator is responsible for generating the classes from a resource
 * in the appropriate folder using the template provided
 */
<<<<<<< HEAD
class ClassGenerator extends PromptingGenerator
{
    /**
     * @param ResourceInterface $resource
=======
final class ClassGenerator extends PromptingGenerator
{
    /**
     * @param Resource $resource
>>>>>>> v2-test
     * @param string            $generation
     * @param array             $data
     *
     * @return bool
     */
<<<<<<< HEAD
    public function supports(ResourceInterface $resource, $generation, array $data)
=======
    public function supports(Resource $resource, string $generation, array $data): bool
>>>>>>> v2-test
    {
        return 'class' === $generation;
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
     * @param ResourceInterface $resource
     * @param string            $filepath
     *
     * @return string
     */
    protected function renderTemplate(ResourceInterface $resource, $filepath)
=======
    protected function renderTemplate(Resource $resource, string $filepath): string
>>>>>>> v2-test
    {
        $values = array(
            '%filepath%'        => $filepath,
            '%name%'            => $resource->getName(),
            '%namespace%'       => $resource->getSrcNamespace(),
            '%namespace_block%' => '' !== $resource->getSrcNamespace()
                                ?  sprintf("\n\nnamespace %s;", $resource->getSrcNamespace())
                                : '',
        );

        if (!$content = $this->getTemplateRenderer()->render('class', $values)) {
            $content = $this->getTemplateRenderer()->renderString(
                $this->getTemplate(),
                $values
            );
        }

        return $content;
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
        return file_get_contents(__DIR__.'/templates/class.template');
    }

<<<<<<< HEAD
    /**
     * @param ResourceInterface $resource
     *
     * @return string
     */
    protected function getFilePath(ResourceInterface $resource)
=======
    protected function getFilePath(Resource $resource): string
>>>>>>> v2-test
    {
        return $resource->getSrcFilename();
    }

<<<<<<< HEAD
    /**
     * @param ResourceInterface $resource
     * @param string            $filepath
     *
     * @return string
     */
    protected function getGeneratedMessage(ResourceInterface $resource, $filepath)
=======
    protected function getGeneratedMessage(Resource $resource, string $filepath): string
>>>>>>> v2-test
    {
        return sprintf(
            "<info>Class <value>%s</value> created in <value>%s</value>.</info>\n",
            $resource->getSrcClassname(),
            $filepath
        );
    }
}
