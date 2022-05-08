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

namespace PhpSpec\Exception;

use PhpSpec\Exception\Wrapper\SubjectException;
<<<<<<< HEAD
use PhpSpec\Formatter\Presenter\PresenterInterface;
=======
use PhpSpec\Formatter\Presenter\Presenter;
>>>>>>> v2-test
use PhpSpec\Util\Instantiator;

/**
 * ExceptionFactory is responsible for creating various exceptions
 */
class ExceptionFactory
{
    /**
<<<<<<< HEAD
     * @var PresenterInterface
=======
     * @var Presenter
>>>>>>> v2-test
     */
    private $presenter;

    /**
<<<<<<< HEAD
     * @param PresenterInterface $presenter
     */
    public function __construct(PresenterInterface $presenter)
=======
     * @param Presenter $presenter
     */
    public function __construct(Presenter $presenter)
>>>>>>> v2-test
    {
        $this->presenter = $presenter;
    }

    /**
     * @param string $classname
     * @param string $method
     * @param array  $arguments
     *
     * @return Fracture\NamedConstructorNotFoundException
     */
<<<<<<< HEAD
    public function namedConstructorNotFound($classname, $method, array $arguments = array())
=======
    public function namedConstructorNotFound(string $classname, string $method, array $arguments = array()): Fracture\NamedConstructorNotFoundException
>>>>>>> v2-test
    {
        $instantiator = new Instantiator();
        $subject = $instantiator->instantiate($classname);

        $message = sprintf('Named constructor %s not found.', $this->presenter->presentString($classname.'::'.$method));

        return new Fracture\NamedConstructorNotFoundException(
            $message,
            $subject,
            $method,
            $arguments
        );
    }

    /**
     * @param string $classname
     * @param string $method
     * @param array  $arguments
     *
     * @return Fracture\MethodNotFoundException
     */
<<<<<<< HEAD
    public function methodNotFound($classname, $method, array $arguments = array())
=======
    public function methodNotFound(string $classname, string $method, array $arguments = array()): Fracture\MethodNotFoundException
>>>>>>> v2-test
    {
        $instantiator = new Instantiator();
        $subject = $instantiator->instantiate($classname);
        $message = sprintf('Method %s not found.', $this->presenter->presentString($classname.'::'.$method));

        return new Fracture\MethodNotFoundException(
            $message,
            $subject,
            $method,
            $arguments
        );
    }

    /**
     * @param string $classname
     * @param string $method
     * @param array  $arguments
     *
     * @return Fracture\MethodNotVisibleException
     */
<<<<<<< HEAD
    public function methodNotVisible($classname, $method, array $arguments = array())
=======
    public function methodNotVisible(string $classname, string $method, array $arguments = array()): Fracture\MethodNotVisibleException
>>>>>>> v2-test
    {
        $instantiator = new Instantiator();
        $subject = $instantiator->instantiate($classname);
        $message = sprintf('Method %s not visible.', $this->presenter->presentString($classname.'::'.$method));

        return new Fracture\MethodNotVisibleException(
            $message,
            $subject,
            $method,
            $arguments
        );
    }

    /**
     * @param string $classname
     *
     * @return Fracture\ClassNotFoundException
     */
<<<<<<< HEAD
    public function classNotFound($classname)
=======
    public function classNotFound(string $classname): Fracture\ClassNotFoundException
>>>>>>> v2-test
    {
        $message = sprintf('Class %s does not exist.', $this->presenter->presentString($classname));

        return new Fracture\ClassNotFoundException($message, $classname);
    }

    /**
     * @param mixed  $subject
     * @param string $property
     *
     * @return Fracture\PropertyNotFoundException
     */
<<<<<<< HEAD
    public function propertyNotFound($subject, $property)
=======
    public function propertyNotFound($subject, $property): Fracture\PropertyNotFoundException
>>>>>>> v2-test
    {
        $message = sprintf('Property %s not found.', $this->presenter->presentString($property));

        return new Fracture\PropertyNotFoundException($message, $subject, $property);
    }

    /**
     * @param string $method
     *
     * @return SubjectException
     */
<<<<<<< HEAD
    public function callingMethodOnNonObject($method)
=======
    public function callingMethodOnNonObject(string $method): SubjectException
>>>>>>> v2-test
    {
        return new SubjectException(sprintf(
            'Call to a member function %s on a non-object.',
            $this->presenter->presentString($method.'()')
        ));
    }

    /**
     * @param string $property
     *
     * @return SubjectException
     */
<<<<<<< HEAD
    public function settingPropertyOnNonObject($property)
=======
    public function settingPropertyOnNonObject(string $property): SubjectException
>>>>>>> v2-test
    {
        return new SubjectException(sprintf(
            'Setting property %s on a non-object.',
            $this->presenter->presentString($property)
        ));
    }

    /**
     * @param string $property
     *
     * @return SubjectException
     */
<<<<<<< HEAD
    public function gettingPropertyOnNonObject($property)
=======
    public function gettingPropertyOnNonObject(string $property): SubjectException
>>>>>>> v2-test
    {
        return new SubjectException(sprintf(
            'Getting property %s on a non-object.',
            $this->presenter->presentString($property)
        ));
    }
}
