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

use PhpSpec\Wrapper\Unwrapper;
<<<<<<< HEAD
use PhpSpec\Formatter\Presenter\PresenterInterface;
=======
use PhpSpec\Formatter\Presenter\Presenter;
>>>>>>> v2-test
use PhpSpec\Exception\Wrapper\SubjectException;
use PhpSpec\Exception\Fracture\InterfaceNotImplementedException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SubjectWithArrayAccess
{
    /**
     * @var Caller
     */
    private $caller;
    /**
<<<<<<< HEAD
     * @var PresenterInterface
=======
     * @var Presenter
>>>>>>> v2-test
     */
    private $presenter;
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @param Caller                   $caller
<<<<<<< HEAD
     * @param PresenterInterface       $presenter
=======
     * @param Presenter       $presenter
>>>>>>> v2-test
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        Caller $caller,
<<<<<<< HEAD
        PresenterInterface $presenter,
=======
        Presenter $presenter,
>>>>>>> v2-test
        EventDispatcherInterface $dispatcher
    ) {
        $this->caller     = $caller;
        $this->presenter  = $presenter;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param string|integer $key
     *
     * @return bool
     */
<<<<<<< HEAD
    public function offsetExists($key)
=======
    public function offsetExists($key): bool
>>>>>>> v2-test
    {
        $unwrapper = new Unwrapper();
        $subject = $this->caller->getWrappedObject();
        $key     = $unwrapper->unwrapOne($key);

        $this->checkIfSubjectImplementsArrayAccess($subject);

        return isset($subject[$key]);
    }

    /**
     * @param string|integer $key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        $unwrapper = new Unwrapper();
        $subject = $this->caller->getWrappedObject();
        $key     = $unwrapper->unwrapOne($key);

        $this->checkIfSubjectImplementsArrayAccess($subject);

        return $subject[$key];
    }

    /**
     * @param string|integer $key
     * @param mixed          $value
     */
<<<<<<< HEAD
    public function offsetSet($key, $value)
=======
    public function offsetSet($key, $value): void
>>>>>>> v2-test
    {
        $unwrapper = new Unwrapper();
        $subject = $this->caller->getWrappedObject();
        $key     = $unwrapper->unwrapOne($key);
        $value   = $unwrapper->unwrapOne($value);

        $this->checkIfSubjectImplementsArrayAccess($subject);

        $subject[$key] = $value;
    }

    /**
     * @param string|integer $key
     */
<<<<<<< HEAD
    public function offsetUnset($key)
=======
    public function offsetUnset($key): void
>>>>>>> v2-test
    {
        $unwrapper = new Unwrapper();
        $subject = $this->caller->getWrappedObject();
        $key     = $unwrapper->unwrapOne($key);

        $this->checkIfSubjectImplementsArrayAccess($subject);

        unset($subject[$key]);
    }

    /**
     * @param mixed $subject
     *
     * @throws \PhpSpec\Exception\Wrapper\SubjectException
     * @throws \PhpSpec\Exception\Fracture\InterfaceNotImplementedException
     */
<<<<<<< HEAD
    private function checkIfSubjectImplementsArrayAccess($subject)
    {
        if (is_object($subject) && !($subject instanceof \ArrayAccess)) {
            throw $this->interfaceNotImplemented();
        } elseif (!($subject instanceof \ArrayAccess) && !is_array($subject)) {
=======
    private function checkIfSubjectImplementsArrayAccess($subject): void
    {
        if (\is_object($subject) && !($subject instanceof \ArrayAccess)) {
            throw $this->interfaceNotImplemented();
        } elseif (!($subject instanceof \ArrayAccess) && !\is_array($subject)) {
>>>>>>> v2-test
            throw $this->cantUseAsArray($subject);
        }
    }

    /**
     * @return InterfaceNotImplementedException
     */
<<<<<<< HEAD
    private function interfaceNotImplemented()
=======
    private function interfaceNotImplemented(): InterfaceNotImplementedException
>>>>>>> v2-test
    {
        return new InterfaceNotImplementedException(
            sprintf(
                '%s does not implement %s interface, but should.',
                $this->presenter->presentValue($this->caller->getWrappedObject()),
                $this->presenter->presentString('ArrayAccess')
            ),
            $this->caller->getWrappedObject(),
            'ArrayAccess'
        );
    }

    /**
     * @param mixed $subject
     *
     * @return SubjectException
     */
<<<<<<< HEAD
    private function cantUseAsArray($subject)
=======
    private function cantUseAsArray($subject): SubjectException
>>>>>>> v2-test
    {
        return new SubjectException(sprintf(
            'Can not use %s as array.',
            $this->presenter->presentValue($subject)
        ));
    }
}
