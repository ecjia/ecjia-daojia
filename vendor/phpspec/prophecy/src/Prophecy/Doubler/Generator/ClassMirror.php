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
use Prophecy\Doubler\Generator\Node\ArgumentTypeNode;
use Prophecy\Doubler\Generator\Node\ReturnTypeNode;
>>>>>>> v2-test
use Prophecy\Exception\InvalidArgumentException;
use Prophecy\Exception\Doubler\ClassMirrorException;
use ReflectionClass;
use ReflectionMethod;
<<<<<<< HEAD
use ReflectionParameter;
=======
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionType;
use ReflectionUnionType;
>>>>>>> v2-test

/**
 * Class mirror.
 * Core doubler class. Mirrors specific class and/or interfaces into class node tree.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class ClassMirror
{
    private static $reflectableMethods = array(
        '__construct',
        '__destruct',
        '__sleep',
        '__wakeup',
        '__toString',
        '__call',
        '__invoke'
    );

    /**
     * Reflects provided arguments into class node.
     *
<<<<<<< HEAD
     * @param ReflectionClass   $class
=======
     * @param ReflectionClass|null $class
>>>>>>> v2-test
     * @param ReflectionClass[] $interfaces
     *
     * @return Node\ClassNode
     *
<<<<<<< HEAD
     * @throws \Prophecy\Exception\InvalidArgumentException
     */
    public function reflect(ReflectionClass $class = null, array $interfaces)
=======
     */
    public function reflect(?ReflectionClass $class, array $interfaces)
>>>>>>> v2-test
    {
        $node = new Node\ClassNode;

        if (null !== $class) {
            if (true === $class->isInterface()) {
                throw new InvalidArgumentException(sprintf(
                    "Could not reflect %s as a class, because it\n".
                    "is interface - use the second argument instead.",
                    $class->getName()
                ));
            }

            $this->reflectClassToNode($class, $node);
        }

        foreach ($interfaces as $interface) {
            if (!$interface instanceof ReflectionClass) {
                throw new InvalidArgumentException(sprintf(
                    "[ReflectionClass \$interface1 [, ReflectionClass \$interface2]] array expected as\n".
                    "a second argument to `ClassMirror::reflect(...)`, but got %s.",
                    is_object($interface) ? get_class($interface).' class' : gettype($interface)
                ));
            }
            if (false === $interface->isInterface()) {
                throw new InvalidArgumentException(sprintf(
                    "Could not reflect %s as an interface, because it\n".
                    "is class - use the first argument instead.",
                    $interface->getName()
                ));
            }

            $this->reflectInterfaceToNode($interface, $node);
        }

        $node->addInterface('Prophecy\Doubler\Generator\ReflectionInterface');

        return $node;
    }

    private function reflectClassToNode(ReflectionClass $class, Node\ClassNode $node)
    {
        if (true === $class->isFinal()) {
            throw new ClassMirrorException(sprintf(
                'Could not reflect class %s as it is marked final.', $class->getName()
            ), $class);
        }

        $node->setParentClass($class->getName());

        foreach ($class->getMethods(ReflectionMethod::IS_ABSTRACT) as $method) {
            if (false === $method->isProtected()) {
                continue;
            }

            $this->reflectMethodToNode($method, $node);
        }

        foreach ($class->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if (0 === strpos($method->getName(), '_')
                && !in_array($method->getName(), self::$reflectableMethods)) {
                continue;
            }

            if (true === $method->isFinal()) {
                $node->addUnextendableMethod($method->getName());
                continue;
            }

            $this->reflectMethodToNode($method, $node);
        }
    }

    private function reflectInterfaceToNode(ReflectionClass $interface, Node\ClassNode $node)
    {
        $node->addInterface($interface->getName());

        foreach ($interface->getMethods() as $method) {
            $this->reflectMethodToNode($method, $node);
        }
    }

    private function reflectMethodToNode(ReflectionMethod $method, Node\ClassNode $classNode)
    {
        $node = new Node\MethodNode($method->getName());

        if (true === $method->isProtected()) {
            $node->setVisibility('protected');
        }

        if (true === $method->isStatic()) {
            $node->setStatic();
        }

        if (true === $method->returnsReference()) {
            $node->setReturnsReference();
        }

<<<<<<< HEAD
        if (version_compare(PHP_VERSION, '7.0', '>=') && true === $method->hasReturnType()) {
            $returnType = (string) $method->getReturnType();
            $returnTypeLower = strtolower($returnType);

            if ('self' === $returnTypeLower) {
                $returnType = $method->getDeclaringClass()->getName();
            }
            if ('parent' === $returnTypeLower) {
                $returnType = $method->getDeclaringClass()->getParentClass()->getName();
            }

            $node->setReturnType($returnType);
=======
        if ($method->hasReturnType()) {
            $returnTypes = $this->getTypeHints($method->getReturnType(), $method->getDeclaringClass(), $method->getReturnType()->allowsNull());
            $node->setReturnTypeNode(new ReturnTypeNode(...$returnTypes));
>>>>>>> v2-test
        }

        if (is_array($params = $method->getParameters()) && count($params)) {
            foreach ($params as $param) {
                $this->reflectArgumentToNode($param, $node);
            }
        }

        $classNode->addMethod($node);
    }

    private function reflectArgumentToNode(ReflectionParameter $parameter, Node\MethodNode $methodNode)
    {
        $name = $parameter->getName() == '...' ? '__dot_dot_dot__' : $parameter->getName();
        $node = new Node\ArgumentNode($name);

<<<<<<< HEAD
        $node->setTypeHint($this->getTypeHint($parameter));

        if ($this->isVariadic($parameter)) {
=======
        $typeHints = $this->getTypeHints($parameter->getType(), $parameter->getDeclaringClass(), $parameter->allowsNull());

        $node->setTypeNode(new ArgumentTypeNode(...$typeHints));

        if ($parameter->isVariadic()) {
>>>>>>> v2-test
            $node->setAsVariadic();
        }

        if ($this->hasDefaultValue($parameter)) {
            $node->setDefault($this->getDefaultValue($parameter));
        }

        if ($parameter->isPassedByReference()) {
            $node->setAsPassedByReference();
        }

<<<<<<< HEAD
=======

>>>>>>> v2-test
        $methodNode->addArgument($node);
    }

    private function hasDefaultValue(ReflectionParameter $parameter)
    {
<<<<<<< HEAD
        if ($this->isVariadic($parameter)) {
=======
        if ($parameter->isVariadic()) {
>>>>>>> v2-test
            return false;
        }

        if ($parameter->isDefaultValueAvailable()) {
            return true;
        }

<<<<<<< HEAD
        return $parameter->isOptional() || $this->isNullable($parameter);
=======
        return $parameter->isOptional() || ($parameter->allowsNull() && $parameter->getType());
>>>>>>> v2-test
    }

    private function getDefaultValue(ReflectionParameter $parameter)
    {
        if (!$parameter->isDefaultValueAvailable()) {
            return null;
        }

        return $parameter->getDefaultValue();
    }

<<<<<<< HEAD
    private function getTypeHint(ReflectionParameter $parameter)
    {
        if (null !== $className = $this->getParameterClassName($parameter)) {
            return $className;
        }

        if (true === $parameter->isArray()) {
            return 'array';
        }

        if (version_compare(PHP_VERSION, '5.4', '>=') && true === $parameter->isCallable()) {
            return 'callable';
        }

        if (version_compare(PHP_VERSION, '7.0', '>=') && true === $parameter->hasType()) {
            return (string) $parameter->getType();
        }

        return null;
    }

    private function isVariadic(ReflectionParameter $parameter)
    {
        return PHP_VERSION_ID >= 50600 && $parameter->isVariadic();
    }

    private function isNullable(ReflectionParameter $parameter)
    {
        return $parameter->allowsNull() && null !== $this->getTypeHint($parameter);
    }

    private function getParameterClassName(ReflectionParameter $parameter)
    {
        try {
            return $parameter->getClass() ? $parameter->getClass()->getName() : null;
        } catch (\ReflectionException $e) {
            preg_match('/\[\s\<\w+?>\s([\w,\\\]+)/s', $parameter, $matches);

            return isset($matches[1]) ? $matches[1] : null;
        }
=======
    private function getTypeHints(?ReflectionType $type, ?ReflectionClass $class, bool $allowsNull) : array
    {
        $types = [];

        if ($type instanceof ReflectionNamedType) {
            $types = [$type->getName()];

        }
        elseif ($type instanceof ReflectionUnionType) {
            $types = $type->getTypes();
        }

        $types = array_map(
            function(string $type) use ($class) {
                if ($type === 'self') {
                    return $class->getName();
                }
                if ($type === 'parent') {
                    return $class->getParentClass()->getName();
                }

                return $type;
            },
            $types
        );

        if ($types && $types != ['mixed'] && $allowsNull) {
            $types[] = 'null';
        }

        return $types;
>>>>>>> v2-test
    }
}
