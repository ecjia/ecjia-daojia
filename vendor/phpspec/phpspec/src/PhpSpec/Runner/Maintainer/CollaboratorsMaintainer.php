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

namespace PhpSpec\Runner\Maintainer;

<<<<<<< HEAD
use PhpSpec\CodeAnalysis\DisallowedScalarTypehintException;
use PhpSpec\Exception\Fracture\CollaboratorNotFoundException;
use PhpSpec\Exception\Wrapper\CollaboratorException;
use PhpSpec\Exception\Wrapper\InvalidCollaboratorTypeException;
use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\Loader\Transformer\InMemoryTypeHintIndex;
use PhpSpec\Loader\Transformer\TypeHintIndex;
use PhpSpec\SpecificationInterface;
=======
use PhpSpec\CodeAnalysis\DisallowedNonObjectTypehintException;
use PhpSpec\CodeAnalysis\DisallowedUnionTypehintException;
use PhpSpec\Exception\Fracture\CollaboratorNotFoundException;
use PhpSpec\Exception\Wrapper\InvalidCollaboratorTypeException;
use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\Loader\Transformer\TypeHintIndex;
use PhpSpec\Specification;
>>>>>>> v2-test
use PhpSpec\Runner\MatcherManager;
use PhpSpec\Runner\CollaboratorManager;
use PhpSpec\Wrapper\Collaborator;
use PhpSpec\Wrapper\Unwrapper;
use Prophecy\Exception\Doubler\ClassNotFoundException;
use Prophecy\Prophet;
<<<<<<< HEAD
use ReflectionException;

class CollaboratorsMaintainer implements MaintainerInterface
=======
use ReflectionNamedType;

final class CollaboratorsMaintainer implements Maintainer
>>>>>>> v2-test
{
    /**
     * @var string
     */
    private static $docex = '#@param *([^ ]*) *\$([^ ]*)#';
    /**
     * @var Unwrapper
     */
    private $unwrapper;
    /**
     * @var Prophet
     */
    private $prophet;

    /**
     * @var TypeHintIndex
     */
    private $typeHintIndex;

    /**
     * @param Unwrapper $unwrapper
     * @param TypeHintIndex $typeHintIndex
     */
<<<<<<< HEAD
    public function __construct(Unwrapper $unwrapper, TypeHintIndex $typeHintIndex = null)
    {
        $this->unwrapper = $unwrapper;
        $this->typeHintIndex = $typeHintIndex ? $typeHintIndex : new InMemoryTypeHintIndex();
=======
    public function __construct(Unwrapper $unwrapper, TypeHintIndex $typeHintIndex)
    {
        $this->unwrapper = $unwrapper;
        $this->typeHintIndex = $typeHintIndex;
>>>>>>> v2-test
    }

    /**
     * @param ExampleNode $example
     *
     * @return bool
     */
<<<<<<< HEAD
    public function supports(ExampleNode $example)
=======
    public function supports(ExampleNode $example): bool
>>>>>>> v2-test
    {
        return true;
    }

    /**
     * @param ExampleNode            $example
<<<<<<< HEAD
     * @param SpecificationInterface $context
=======
     * @param Specification $context
>>>>>>> v2-test
     * @param MatcherManager         $matchers
     * @param CollaboratorManager    $collaborators
     */
    public function prepare(
        ExampleNode $example,
<<<<<<< HEAD
        SpecificationInterface $context,
        MatcherManager $matchers,
        CollaboratorManager $collaborators
    ) {
=======
        Specification $context,
        MatcherManager $matchers,
        CollaboratorManager $collaborators
    ): void {
>>>>>>> v2-test
        $this->prophet = new Prophet(null, $this->unwrapper, null);

        $classRefl = $example->getSpecification()->getClassReflection();

        if ($classRefl->hasMethod('let')) {
            $this->generateCollaborators($collaborators, $classRefl->getMethod('let'), $classRefl);
        }

        $this->generateCollaborators($collaborators, $example->getFunctionReflection(), $classRefl);
    }

    /**
     * @param ExampleNode            $example
<<<<<<< HEAD
     * @param SpecificationInterface $context
=======
     * @param Specification $context
>>>>>>> v2-test
     * @param MatcherManager         $matchers
     * @param CollaboratorManager    $collaborators
     */
    public function teardown(
        ExampleNode $example,
<<<<<<< HEAD
        SpecificationInterface $context,
        MatcherManager $matchers,
        CollaboratorManager $collaborators
    ) {
=======
        Specification $context,
        MatcherManager $matchers,
        CollaboratorManager $collaborators
    ): void {
>>>>>>> v2-test
        $this->prophet->checkPredictions();
    }

    /**
     * @return int
     */
<<<<<<< HEAD
    public function getPriority()
=======
    public function getPriority(): int
>>>>>>> v2-test
    {
        return 50;
    }

    /**
     * @param CollaboratorManager         $collaborators
     * @param \ReflectionFunctionAbstract $function
     * @param \ReflectionClass            $classRefl
     */
<<<<<<< HEAD
    private function generateCollaborators(CollaboratorManager $collaborators, \ReflectionFunctionAbstract $function, \ReflectionClass $classRefl)
    {
        if ($comment = $function->getDocComment()) {
            $comment = str_replace("\r\n", "\n", $comment);
            foreach (explode("\n", trim($comment)) as $line) {
                if (preg_match(self::$docex, $line, $match)) {
                    $collaborator = $this->getOrCreateCollaborator($collaborators, $match[2]);
                    $collaborator->beADoubleOf($match[1]);
                }
            }
        }

=======
    private function generateCollaborators(CollaboratorManager $collaborators, \ReflectionFunctionAbstract $function, \ReflectionClass $classRefl): void
    {
>>>>>>> v2-test
        foreach ($function->getParameters() as $parameter) {

            $collaborator = $this->getOrCreateCollaborator($collaborators, $parameter->getName());
            try {
                if ($this->isUnsupportedTypeHinting($parameter)) {
                    throw new InvalidCollaboratorTypeException($parameter, $function);
                }
                if (($indexedClass = $this->getParameterTypeFromIndex($classRefl, $parameter))
                    || ($indexedClass = $this->getParameterTypeFromReflection($parameter))) {
                    $collaborator->beADoubleOf($indexedClass);
                }
            }
            catch (ClassNotFoundException $e) {
                $this->throwCollaboratorNotFound($e, null, $e->getClassname());
            }
<<<<<<< HEAD
            catch (DisallowedScalarTypehintException $e) {
=======
            catch (DisallowedUnionTypehintException $e) {
                throw new InvalidCollaboratorTypeException($parameter, $function, $e->getMessage(), 'Use a specific type');
            }
            catch (DisallowedNonObjectTypehintException $e) {
>>>>>>> v2-test
                throw new InvalidCollaboratorTypeException($parameter, $function);
            }
        }
    }

<<<<<<< HEAD
    private function isUnsupportedTypeHinting(\ReflectionParameter $parameter)
    {
        return $parameter->isArray() || version_compare(PHP_VERSION, '5.4.0', '>') && $parameter->isCallable();
=======
    private function isUnsupportedTypeHinting(\ReflectionParameter $parameter): bool
    {
        $type = $parameter->getType();

        if (null === $type) {
            return false;
        }

        return !$type instanceof ReflectionNamedType || in_array($type->getName(), ['array', 'callable'], true);
>>>>>>> v2-test
    }

    /**
     * @param CollaboratorManager $collaborators
     * @param string              $name
     *
     * @return Collaborator
     */
<<<<<<< HEAD
    private function getOrCreateCollaborator(CollaboratorManager $collaborators, $name)
=======
    private function getOrCreateCollaborator(CollaboratorManager $collaborators, string $name): Collaborator
>>>>>>> v2-test
    {
        if (!$collaborators->has($name)) {
            $collaborator = new Collaborator($this->prophet->prophesize());
            $collaborators->set($name, $collaborator);
        }

        return $collaborators->get($name);
    }

    /**
<<<<<<< HEAD
     * @param Exception $e
     * @param ReflectionParameter|null $parameter
     * @param string $className
     * @throws CollaboratorNotFoundException
     */
    private function throwCollaboratorNotFound($e, $parameter, $className = null)
=======
     * @param \Exception $e
     * @param \ReflectionParameter|null $parameter
     * @param string $className
     * @throws CollaboratorNotFoundException
     */
    private function throwCollaboratorNotFound(\Exception $e, \ReflectionParameter $parameter = null, string $className = null): void
>>>>>>> v2-test
    {
        throw new CollaboratorNotFoundException(
            sprintf('Collaborator does not exist '),
            0, $e,
            $parameter,
            $className
        );
    }

    /**
     * @param \ReflectionClass $classRefl
     * @param \ReflectionParameter $parameter
     *
     * @return string
     */
<<<<<<< HEAD
    private function getParameterTypeFromIndex(\ReflectionClass $classRefl, \ReflectionParameter $parameter)
=======
    private function getParameterTypeFromIndex(\ReflectionClass $classRefl, \ReflectionParameter $parameter): string
>>>>>>> v2-test
    {
        return $this->typeHintIndex->lookup(
            $classRefl->getName(),
            $parameter->getDeclaringFunction()->getName(),
            '$' . $parameter->getName()
        );
    }

    /**
     * @param \ReflectionParameter $parameter
     *
<<<<<<< HEAD
     * @return string
     */
    private function getParameterTypeFromReflection(\ReflectionParameter $parameter)
    {
        try {
            if (null === $class = $parameter->getClass()) {
                return null;
            }

            return $class->getName();
        }
        catch (ReflectionException $e) {
            $this->throwCollaboratorNotFound($e, $parameter);
        }
    }

=======
     * @return string|null
     */
    private function getParameterTypeFromReflection(\ReflectionParameter $parameter): string
    {
        $type = $parameter->getType();

        if (null === $type) {
            return '';
        }

        // this is safe due to isUnsupportedTypeHinting
        $name = $class->getName();

        if ($type->isBuiltin() || class_exists($name)) {
            return $name;
        }

        $this->throwCollaboratorNotFound($e, $parameter);
    }
>>>>>>> v2-test
}
