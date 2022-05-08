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
use PhpSpec\ObjectBehavior;
>>>>>>> v2-test

/**
 * Generates spec classes from resources and puts them into the appropriate
 * folder using the appropriate template.
 */
<<<<<<< HEAD
class SpecificationGenerator extends PromptingGenerator
{
    /**
     * @param ResourceInterface $resource
     * @param string            $generation
     * @param array             $data
     *
     * @return bool
     */
    public function supports(ResourceInterface $resource, $generation, array $data)
=======
final class SpecificationGenerator extends PromptingGenerator
{
    public function supports(Resource $resource, string $generation, array $data): bool
>>>>>>> v2-test
    {
        return 'specification' === $generation;
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

    /**
<<<<<<< HEAD
     * @param ResourceInterface $resource
=======
     * @param Resource $resource
>>>>>>> v2-test
     * @param string            $filepath
     *
     * @return string
     */
<<<<<<< HEAD
    protected function renderTemplate(ResourceInterface $resource, $filepath)
=======
    protected function renderTemplate(Resource $resource, string $filepath): string
>>>>>>> v2-test
    {
        $values = array(
            '%filepath%'      => $filepath,
            '%name%'          => $resource->getSpecName(),
            '%namespace%'     => $resource->getSpecNamespace(),
<<<<<<< HEAD
            '%subject%'       => $resource->getSrcClassname(),
            '%subject_class%' => $resource->getName()
=======
            '%imports%'       => $this->getImports($resource),
            '%subject%'       => $resource->getSrcClassname(),
            '%subject_class%' => $resource->getName(),
>>>>>>> v2-test
        );

        if (!$content = $this->getTemplateRenderer()->render('specification', $values)) {
            $content = $this->getTemplateRenderer()->renderString($this->getTemplate(), $values);
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
        return file_get_contents(__DIR__.'/templates/specification.template');
    }

<<<<<<< HEAD
    /**
     * @param  ResourceInterface $resource
     * @return mixed
     */
    protected function getFilePath(ResourceInterface $resource)
=======
    protected function getFilePath(Resource $resource): string
>>>>>>> v2-test
    {
        return $resource->getSpecFilename();
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
            "<info>Specification for <value>%s</value> created in <value>%s</value>.</info>\n",
            $resource->getSrcClassname(),
            $filepath
        );
    }
<<<<<<< HEAD
=======

    protected function getImports(Resource $resource): string
    {
        $imports = [$resource->getSrcClassname(), ObjectBehavior::class];
        asort($imports);

        foreach ($imports as &$import) {
            $import = sprintf('use %s;', $import);
        }

        return implode("\n", $imports);
    }
>>>>>>> v2-test
}
