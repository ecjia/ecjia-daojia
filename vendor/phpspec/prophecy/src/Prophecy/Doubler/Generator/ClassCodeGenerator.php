<?php

/*
 * This file is part of the Prophecy.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *     Marcello Duarte <marcello.duarte@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Prophecy\Doubler\Generator;

<<<<<<< HEAD
=======
use Prophecy\Doubler\Generator\Node\ReturnTypeNode;
use Prophecy\Doubler\Generator\Node\TypeNodeAbstract;

>>>>>>> v2-test
/**
 * Class code creator.
 * Generates PHP code for specific class node tree.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class ClassCodeGenerator
{
<<<<<<< HEAD
=======
    public function __construct(TypeHintReference $typeHintReference = null)
    {
    }

>>>>>>> v2-test
    /**
     * Generates PHP code for class node.
     *
     * @param string         $classname
     * @param Node\ClassNode $class
     *
     * @return string
     */
    public function generate($classname, Node\ClassNode $class)
    {
        $parts     = explode('\\', $classname);
        $classname = array_pop($parts);
        $namespace = implode('\\', $parts);

        $code = sprintf("class %s extends \%s implements %s {\n",
            $classname, $class->getParentClass(), implode(', ',
                array_map(function ($interface) {return '\\'.$interface;}, $class->getInterfaces())
            )
        );

        foreach ($class->getProperties() as $name => $visibility) {
            $code .= sprintf("%s \$%s;\n", $visibility, $name);
        }
        $code .= "\n";

        foreach ($class->getMethods() as $method) {
            $code .= $this->generateMethod($method)."\n";
        }
        $code .= "\n}";

        return sprintf("namespace %s {\n%s\n}", $namespace, $code);
    }

    private function generateMethod(Node\MethodNode $method)
    {
        $php = sprintf("%s %s function %s%s(%s)%s {\n",
            $method->getVisibility(),
            $method->isStatic() ? 'static' : '',
            $method->returnsReference() ? '&':'',
            $method->getName(),
            implode(', ', $this->generateArguments($method->getArguments())),
<<<<<<< HEAD
            version_compare(PHP_VERSION, '7.0', '>=') && $method->hasReturnType()
                ? sprintf(': %s', $method->getReturnType())
                : ''
=======
            ($ret = $this->generateTypes($method->getReturnTypeNode())) ? ': '.$ret : ''
>>>>>>> v2-test
        );
        $php .= $method->getCode()."\n";

        return $php.'}';
    }

<<<<<<< HEAD
    private function generateArguments(array $arguments)
    {
        return array_map(function (Node\ArgumentNode $argument) {
            $php = '';

            if ($hint = $argument->getTypeHint()) {
                switch ($hint) {
                    case 'array':
                    case 'callable':
                        $php .= $hint;
                        break;

                    case 'string':
                    case 'int':
                    case 'float':
                    case 'bool':
                        if (version_compare(PHP_VERSION, '7.0', '>=')) {
                            $php .= $hint;
                            break;
                        }
                        // Fall-through to default case for PHP 5.x

                    default:
                        $php .= '\\'.$hint;
                }
            }
=======
    private function generateTypes(TypeNodeAbstract $typeNode): string
    {
        if (!$typeNode->getTypes()) {
            return '';
        }

        // When we require PHP 8 we can stop generating ?foo nullables and remove this first block
        if ($typeNode->canUseNullShorthand()) {
            return sprintf( '?%s', $typeNode->getNonNullTypes()[0]);
        } else {
            return join('|', $typeNode->getTypes());
        }
    }

    private function generateArguments(array $arguments)
    {
        return array_map(function (Node\ArgumentNode $argument){

            $php = $this->generateTypes($argument->getTypeNode());
>>>>>>> v2-test

            $php .= ' '.($argument->isPassedByReference() ? '&' : '');

            $php .= $argument->isVariadic() ? '...' : '';

            $php .= '$'.$argument->getName();

            if ($argument->isOptional() && !$argument->isVariadic()) {
                $php .= ' = '.var_export($argument->getDefault(), true);
            }

            return $php;
        }, $arguments);
    }
}
