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

namespace PhpSpec\Wrapper\Subject;

<<<<<<< HEAD
use PhpSpec\CodeAnalysis\MagicAwareAccessInspector;
use PhpSpec\CodeAnalysis\AccessInspectorInterface;
use PhpSpec\CodeAnalysis\VisibilityAccessInspector;
use PhpSpec\Exception\ExceptionFactory;
use PhpSpec\Loader\Node\ExampleNode;
=======
use PhpSpec\CodeAnalysis\AccessInspector;
use PhpSpec\Exception\ExceptionFactory;
use PhpSpec\Exception\Fracture\NamedConstructorNotFoundException;
use PhpSpec\Factory\ObjectFactory;
use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\Util\DispatchTrait;
>>>>>>> v2-test
use PhpSpec\Wrapper\Subject;
use PhpSpec\Wrapper\Wrapper;
use PhpSpec\Wrapper\Unwrapper;
use PhpSpec\Event\MethodCallEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Dispatcher;
use ReflectionClass;
use ReflectionException;

class Caller
{
<<<<<<< HEAD
=======
    use DispatchTrait;

>>>>>>> v2-test
    /**
     * @var WrappedObject
     */
    private $wrappedObject;
    /**
     * @var ExampleNode
     */
    private $example;
    /**
     * @var Dispatcher
     */
    private $dispatcher;
    /**
     * @var Wrapper
     */
    private $wrapper;
    /**
     * @var ExceptionFactory
     */
    private $exceptionFactory;
    /**
<<<<<<< HEAD
     * @var AccessInspectorInterface
=======
     * @var AccessInspector
>>>>>>> v2-test
     */
    private $accessInspector;

    /**
     * @param WrappedObject $wrappedObject
     * @param ExampleNode $example
     * @param Dispatcher $dispatcher
     * @param ExceptionFactory $exceptions
     * @param Wrapper $wrapper
<<<<<<< HEAD
     * @param AccessInspectorInterface $accessInspector
=======
     * @param AccessInspector $accessInspector
>>>>>>> v2-test
     */
    public function __construct(
        WrappedObject $wrappedObject,
        ExampleNode $example,
        Dispatcher $dispatcher,
        ExceptionFactory $exceptions,
        Wrapper $wrapper,
<<<<<<< HEAD
        AccessInspectorInterface $accessInspector = null
=======
        AccessInspector $accessInspector
>>>>>>> v2-test
    ) {
        $this->wrappedObject    = $wrappedObject;
        $this->example          = $example;
        $this->dispatcher       = $dispatcher;
        $this->wrapper          = $wrapper;
        $this->exceptionFactory = $exceptions;
<<<<<<< HEAD
        $this->accessInspector  = $accessInspector ?: new MagicAwareAccessInspector(new VisibilityAccessInspector());
=======
        $this->accessInspector  = $accessInspector;
>>>>>>> v2-test
    }

    /**
     * @param string $method
     * @param array  $arguments
     *
     * @return Subject
     *
     * @throws \PhpSpec\Exception\Fracture\MethodNotFoundException
     * @throws \PhpSpec\Exception\Fracture\MethodNotVisibleException
     * @throws \PhpSpec\Exception\Wrapper\SubjectException
     */
<<<<<<< HEAD
    public function call($method, array $arguments = array())
    {
        if (null === $this->getWrappedObject()) {
=======
    public function call(string $method, array $arguments = array()): Subject
    {
        if (!is_object($this->getWrappedObject())) {
>>>>>>> v2-test
            throw $this->callingMethodOnNonObject($method);
        }

        $subject   = $this->wrappedObject->getInstance();
        $unwrapper = new Unwrapper();
        $arguments = $unwrapper->unwrapAll($arguments);

        if ($this->isObjectMethodCallable($method)) {
            return $this->invokeAndWrapMethodResult($subject, $method, $arguments);
        }

        throw $this->methodNotFound($method, $arguments);
    }

    /**
     * @param string $property
     * @param mixed  $value
     *
     * @return mixed
     *
     * @throws \PhpSpec\Exception\Wrapper\SubjectException
     * @throws \PhpSpec\Exception\Fracture\PropertyNotFoundException
     */
<<<<<<< HEAD
    public function set($property, $value = null)
=======
    public function set(string $property, $value = null): void
>>>>>>> v2-test
    {
        if (null === $this->getWrappedObject()) {
            throw $this->settingPropertyOnNonObject($property);
        }

        $unwrapper = new Unwrapper();
        $value = $unwrapper->unwrapOne($value);

        if ($this->isObjectPropertyWritable($property)) {
<<<<<<< HEAD
            return $this->getWrappedObject()->$property = $value;
=======
            $this->getWrappedObject()->$property = $value;

            return;
>>>>>>> v2-test
        }

        throw $this->propertyNotFound($property);
    }

    /**
     * @param string $property
     *
     * @return Subject|string
     *
     * @throws \PhpSpec\Exception\Fracture\PropertyNotFoundException
     * @throws \PhpSpec\Exception\Wrapper\SubjectException
     */
<<<<<<< HEAD
    public function get($property)
=======
    public function get(string $property)
>>>>>>> v2-test
    {
        if ($this->lookingForConstants($property) && $this->constantDefined($property)) {
            return constant($this->wrappedObject->getClassName().'::'.$property);
        }

        if (null === $this->getWrappedObject()) {
            throw $this->accessingPropertyOnNonObject($property);
        }

        if ($this->isObjectPropertyReadable($property)) {
            return $this->wrap($this->getWrappedObject()->$property);
        }

        throw $this->propertyNotFound($property);
    }

    /**
     * @return object
     *
     * @throws \PhpSpec\Exception\Fracture\ClassNotFoundException
     */
    public function getWrappedObject()
    {
        if ($this->wrappedObject->isInstantiated()) {
            return $this->wrappedObject->getInstance();
        }

<<<<<<< HEAD
        if (null === $this->wrappedObject->getClassName() || !is_string($this->wrappedObject->getClassName())) {
=======
        if (null === $this->wrappedObject->getClassName() || !\is_string($this->wrappedObject->getClassName())) {
>>>>>>> v2-test
            return $this->wrappedObject->getInstance();
        }

        if (!class_exists($this->wrappedObject->getClassName())) {
            throw $this->classNotFound();
        }

<<<<<<< HEAD
        if (is_object($this->wrappedObject->getInstance())) {
=======
        if (\is_object($this->wrappedObject->getInstance())) {
>>>>>>> v2-test
            $this->wrappedObject->setInstantiated(true);
            $instance = $this->wrappedObject->getInstance();
        } else {
            $instance = $this->instantiateWrappedObject();
            $this->wrappedObject->setInstance($instance);
            $this->wrappedObject->setInstantiated(true);
        }

        return $instance;
    }

    /**
     * @param string $property
     *
     * @return bool
     */
<<<<<<< HEAD
    private function isObjectPropertyReadable($property)
    {
        $subject = $this->getWrappedObject();

        return is_object($subject) && $this->accessInspector->isPropertyReadable($subject, $property);
=======
    private function isObjectPropertyReadable(string $property): bool
    {
        $subject = $this->getWrappedObject();

        return \is_object($subject) && $this->accessInspector->isPropertyReadable($subject, $property);
>>>>>>> v2-test
    }

    /**
     * @param string $property
     *
     * @return bool
     */
<<<<<<< HEAD
    private function isObjectPropertyWritable($property)
    {
        $subject = $this->getWrappedObject();

        return is_object($subject) && $this->accessInspector->isPropertyWritable($subject, $property);
=======
    private function isObjectPropertyWritable(string $property): bool
    {
        $subject = $this->getWrappedObject();

        return \is_object($subject) && $this->accessInspector->isPropertyWritable($subject, $property);
>>>>>>> v2-test
    }

    /**
     * @param string $method
     *
     * @return bool
     */
<<<<<<< HEAD
    private function isObjectMethodCallable($method)
=======
    private function isObjectMethodCallable(string $method): bool
>>>>>>> v2-test
    {
        return $this->accessInspector->isMethodCallable($this->getWrappedObject(), $method);
    }

    /**
     * @return object
     */
    private function instantiateWrappedObject()
    {
        if ($this->wrappedObject->getFactoryMethod()) {
            return $this->newInstanceWithFactoryMethod();
        }

        $reflection = new ReflectionClass($this->wrappedObject->getClassName());

<<<<<<< HEAD
        if (count($this->wrappedObject->getArguments())) {
=======
        if (\count($this->wrappedObject->getArguments())) {
>>>>>>> v2-test
            return $this->newInstanceWithArguments($reflection);
        }

        return $reflection->newInstance();
    }

    /**
     * @param object $subject
     * @param string $method
     * @param array  $arguments
     *
     * @return Subject
     */
<<<<<<< HEAD
    private function invokeAndWrapMethodResult($subject, $method, array $arguments = array())
    {
        $this->dispatcher->dispatch(
            'beforeMethodCall',
            new MethodCallEvent($this->example, $subject, $method, $arguments)
        );

        $returnValue = call_user_func_array(array($subject, $method), $arguments);

        $this->dispatcher->dispatch(
            'afterMethodCall',
            new MethodCallEvent($this->example, $subject, $method, $arguments)
=======
    private function invokeAndWrapMethodResult($subject, $method, array $arguments = array()): Subject
    {
        $this->dispatch(
            $this->dispatcher,
            new MethodCallEvent($this->example, $subject, $method, $arguments),
            'beforeMethodCall'
        );

        $returnValue = \call_user_func_array(array($subject, $method), $arguments);

        $this->dispatch(
            $this->dispatcher,
            new MethodCallEvent($this->example, $subject, $method, $arguments),
            'afterMethodCall'
>>>>>>> v2-test
        );

        return $this->wrap($returnValue);
    }

    /**
     * @param mixed $value
     *
     * @return Subject
     */
<<<<<<< HEAD
    private function wrap($value)
=======
    private function wrap($value): Subject
>>>>>>> v2-test
    {
        return $this->wrapper->wrap($value);
    }

    /**
     * @param ReflectionClass $reflection
     *
     * @return object
     *
     * @throws \PhpSpec\Exception\Fracture\MethodNotFoundException
     * @throws \PhpSpec\Exception\Fracture\MethodNotVisibleException
     * @throws \Exception
     * @throws \ReflectionException
     */
    private function newInstanceWithArguments(ReflectionClass $reflection)
    {
        try {
            return $reflection->newInstanceArgs($this->wrappedObject->getArguments());
        } catch (ReflectionException $e) {
            if ($this->detectMissingConstructorMessage($e)) {
                throw $this->methodNotFound(
                    '__construct',
                    $this->wrappedObject->getArguments()
                );
            }
            throw $e;
        }
    }

    /**
     * @return mixed
     * @throws \PhpSpec\Exception\Fracture\MethodNotFoundException
<<<<<<< HEAD
=======
     * @throws \PhpSpec\Exception\Fracture\FactoryDoesNotReturnObjectException
>>>>>>> v2-test
     */
    private function newInstanceWithFactoryMethod()
    {
        $method = $this->wrappedObject->getFactoryMethod();
<<<<<<< HEAD

        if (!is_array($method)) {
            $className = $this->wrappedObject->getClassName();

            if (is_string($method) && !method_exists($className, $method)) {
=======
        $className = $this->wrappedObject->getClassName();

        if (!\is_array($method)) {

            if (\is_string($method) && !method_exists($className, $method)) {
>>>>>>> v2-test
                throw $this->namedConstructorNotFound(
                    $method,
                    $this->wrappedObject->getArguments()
                );
            }
        }

<<<<<<< HEAD
        return call_user_func_array($method, $this->wrappedObject->getArguments());
=======
        return (new ObjectFactory())->instantiateFromCallable(
            $method,
            $this->wrappedObject->getArguments()
        );
>>>>>>> v2-test
    }

    /**
     * @param ReflectionException $exception
     *
     * @return bool
     */
<<<<<<< HEAD
    private function detectMissingConstructorMessage(ReflectionException $exception)
=======
    private function detectMissingConstructorMessage(ReflectionException $exception): bool
>>>>>>> v2-test
    {
        return strpos(
            $exception->getMessage(),
            'does not have a constructor'
        ) !== 0;
    }

    /**
     * @return \PhpSpec\Exception\Fracture\ClassNotFoundException
     */
<<<<<<< HEAD
    private function classNotFound()
=======
    private function classNotFound(): \PhpSpec\Exception\Fracture\ClassNotFoundException
>>>>>>> v2-test
    {
        return $this->exceptionFactory->classNotFound($this->wrappedObject->getClassName());
    }

<<<<<<< HEAD
    /**
     * @param string $method
     * @param array  $arguments
     *
     * @return \PhpSpec\Exception\Fracture\MethodNotFoundException|\PhpSpec\Exception\Fracture\MethodNotVisibleException
     */
    private function namedConstructorNotFound($method, array $arguments = array())
=======
    private function namedConstructorNotFound(string $method, array $arguments = array()) : NamedConstructorNotFoundException
>>>>>>> v2-test
    {
        $className = $this->wrappedObject->getClassName();

        return $this->exceptionFactory->namedConstructorNotFound($className, $method, $arguments);
    }

    /**
     * @param $method
     * @param array $arguments
     * @return \PhpSpec\Exception\Fracture\MethodNotFoundException|\PhpSpec\Exception\Fracture\MethodNotVisibleException
     */
    private function methodNotFound($method, array $arguments = array())
    {
        $className = $this->wrappedObject->getClassName();

        if (!method_exists($className, $method)) {
            return $this->exceptionFactory->methodNotFound($className, $method, $arguments);
        }

        return $this->exceptionFactory->methodNotVisible($className, $method, $arguments);
    }

    /**
     * @param string $property
     *
     * @return \PhpSpec\Exception\Fracture\PropertyNotFoundException
     */
<<<<<<< HEAD
    private function propertyNotFound($property)
=======
    private function propertyNotFound(string $property): \PhpSpec\Exception\Fracture\PropertyNotFoundException
>>>>>>> v2-test
    {
        return $this->exceptionFactory->propertyNotFound($this->getWrappedObject(), $property);
    }

    /**
     * @param string $method
     *
     * @return \PhpSpec\Exception\Wrapper\SubjectException
     */
<<<<<<< HEAD
    private function callingMethodOnNonObject($method)
=======
    private function callingMethodOnNonObject(string $method): \PhpSpec\Exception\Wrapper\SubjectException
>>>>>>> v2-test
    {
        return $this->exceptionFactory->callingMethodOnNonObject($method);
    }

    /**
     * @param string $property
     *
     * @return \PhpSpec\Exception\Wrapper\SubjectException
     */
<<<<<<< HEAD
    private function settingPropertyOnNonObject($property)
=======
    private function settingPropertyOnNonObject(string $property): \PhpSpec\Exception\Wrapper\SubjectException
>>>>>>> v2-test
    {
        return $this->exceptionFactory->settingPropertyOnNonObject($property);
    }

    /**
     * @param string $property
     *
     * @return \PhpSpec\Exception\Wrapper\SubjectException
     */
<<<<<<< HEAD
    private function accessingPropertyOnNonObject($property)
=======
    private function accessingPropertyOnNonObject(string $property): \PhpSpec\Exception\Wrapper\SubjectException
>>>>>>> v2-test
    {
        return $this->exceptionFactory->gettingPropertyOnNonObject($property);
    }

    /**
     * @param string $property
     *
     * @return bool
     */
<<<<<<< HEAD
    private function lookingForConstants($property)
=======
    private function lookingForConstants(string $property): bool
>>>>>>> v2-test
    {
        return null !== $this->wrappedObject->getClassName() &&
            $property === strtoupper($property);
    }

    /**
     * @param string $property
     *
     * @return bool
     */
<<<<<<< HEAD
    public function constantDefined($property)
    {
        return defined($this->wrappedObject->getClassName().'::'.$property);
=======
    public function constantDefined(string $property): bool
    {
        return \defined($this->wrappedObject->getClassName().'::'.$property);
>>>>>>> v2-test
    }
}
