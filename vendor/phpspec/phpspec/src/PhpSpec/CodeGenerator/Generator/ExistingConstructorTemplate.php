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
use ReflectionMethod;

class ExistingConstructorTemplate
{
    private $templates;
    private $class;
    private $className;
    private $arguments;
    private $methodName;

<<<<<<< HEAD
    /**
     * @param TemplateRenderer $templates
     * @param string           $class
     * @param string           $className
     * @param array            $arguments
     * @param string           $methodName
     */
    public function __construct(TemplateRenderer $templates, $methodName, array $arguments, $className, $class)
=======
    public function __construct(TemplateRenderer $templates, string $methodName, array $arguments, string $className, string $class)
>>>>>>> v2-test
    {
        $this->templates  = $templates;
        $this->class      = $class;
        $this->className  = $className;
        $this->arguments  = $arguments;
        $this->methodName = $methodName;
    }

<<<<<<< HEAD
    /**
     * @return string
     */
    public function getContent()
=======
    public function getContent(): string
>>>>>>> v2-test
    {
        if (!$this->numberOfConstructorArgumentsMatchMethod()) {
            return $this->getExceptionContent();
        }

        return $this->getCreateObjectContent();
    }

<<<<<<< HEAD
    /**
     * @return bool
     */
    private function numberOfConstructorArgumentsMatchMethod()
=======
    private function numberOfConstructorArgumentsMatchMethod(): bool
>>>>>>> v2-test
    {
        $constructorArguments = 0;

        $constructor = new ReflectionMethod($this->class, '__construct');
        $params = $constructor->getParameters();

        foreach ($params as $param) {
            if (!$param->isOptional()) {
                $constructorArguments++;
            }
        }

<<<<<<< HEAD
        return $constructorArguments == count($this->arguments);
    }

    /**
     * @return string
     */
    private function getExceptionContent()
=======
        return $constructorArguments == \count($this->arguments);
    }

    private function getExceptionContent(): string
>>>>>>> v2-test
    {
        $values = $this->getValues();

        if (!$content = $this->templates->render('named_constructor_exception', $values)) {
            $content = $this->templates->renderString(
                $this->getExceptionTemplate(),
                $values
            );
        }

        return $content;
    }

<<<<<<< HEAD
    /**
     * @return string
     */
    private function getCreateObjectContent()
=======
    private function getCreateObjectContent(): string
>>>>>>> v2-test
    {
        $values = $this->getValues(true);

        if (!$content = $this->templates->render('named_constructor_create_object', $values)) {
            $content = $this->templates->renderString(
                $this->getCreateObjectTemplate(),
                $values
            );
        }

        return $content;
    }

    /**
<<<<<<< HEAD
     * @param  bool  $constructorArguments
     * @return array
     */
    private function getValues($constructorArguments = false)
    {
        $argString = count($this->arguments)
            ? '$argument'.implode(', $argument', range(1, count($this->arguments)))
=======
     * @return string[]
     */
    private function getValues(bool $constructorArguments = false): array
    {
        $argString = \count($this->arguments)
            ? '$argument'.implode(', $argument', range(1, \count($this->arguments)))
>>>>>>> v2-test
            : ''
        ;

        return array(
            '%methodName%'           => $this->methodName,
            '%arguments%'            => $argString,
            '%returnVar%'            => '$'.lcfirst($this->className),
            '%className%'            => $this->className,
            '%constructorArguments%' => $constructorArguments ? $argString : ''
        );
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    private function getCreateObjectTemplate()
=======
    private function getCreateObjectTemplate(): string
>>>>>>> v2-test
    {
        return file_get_contents(__DIR__.'/templates/named_constructor_create_object.template');
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    private function getExceptionTemplate()
=======
    private function getExceptionTemplate(): string
>>>>>>> v2-test
    {
        return file_get_contents(__DIR__.'/templates/named_constructor_exception.template');
    }
}
