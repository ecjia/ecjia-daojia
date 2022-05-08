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

namespace PhpSpec\Wrapper;

<<<<<<< HEAD
use PhpSpec\CodeAnalysis\AccessInspectorInterface;
use PhpSpec\Exception\ExceptionFactory;
use PhpSpec\Runner\MatcherManager;
use PhpSpec\Formatter\Presenter\PresenterInterface;
=======
use PhpSpec\CodeAnalysis\AccessInspector;
use PhpSpec\Exception\ExceptionFactory;
use PhpSpec\Runner\MatcherManager;
use PhpSpec\Formatter\Presenter\Presenter;
>>>>>>> v2-test
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\Wrapper\Subject\WrappedObject;
use PhpSpec\Wrapper\Subject\Caller;
use PhpSpec\Wrapper\Subject\SubjectWithArrayAccess;
use PhpSpec\Wrapper\Subject\ExpectationFactory;

class Wrapper
{
    /**
     * @var MatcherManager
     */
    private $matchers;
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
     * @var ExampleNode
     */
    private $example;
    /**
<<<<<<< HEAD
     * @var AccessInspectorInterface
=======
     * @var AccessInspector
>>>>>>> v2-test
     */
    private $accessInspector;

    /**
     * @param MatcherManager $matchers
<<<<<<< HEAD
     * @param PresenterInterface $presenter
     * @param EventDispatcherInterface $dispatcher
     * @param ExampleNode $example
     * @param AccessInspectorInterface $accessInspector
     */
    public function __construct(
        MatcherManager $matchers,
        PresenterInterface $presenter,
        EventDispatcherInterface $dispatcher,
        ExampleNode $example,
        AccessInspectorInterface $accessInspector = null
=======
     * @param Presenter $presenter
     * @param EventDispatcherInterface $dispatcher
     * @param ExampleNode $example
     * @param AccessInspector $accessInspector
     */
    public function __construct(
        MatcherManager $matchers,
        Presenter $presenter,
        EventDispatcherInterface $dispatcher,
        ExampleNode $example,
        AccessInspector $accessInspector = null
>>>>>>> v2-test
    ) {
        $this->matchers = $matchers;
        $this->presenter = $presenter;
        $this->dispatcher = $dispatcher;
        $this->example = $example;
        $this->accessInspector = $accessInspector;
    }

    /**
     * @param object $value
     *
     * @return Subject
     */
<<<<<<< HEAD
    public function wrap($value = null)
=======
    public function wrap($value = null): Subject
>>>>>>> v2-test
    {
        $wrappedObject = new WrappedObject($value, $this->presenter);
        $caller = $this->createCaller($wrappedObject);
        $arrayAccess = new SubjectWithArrayAccess($caller, $this->presenter, $this->dispatcher);
        $expectationFactory = new ExpectationFactory($this->example, $this->dispatcher, $this->matchers);

        return new Subject(
            $value,
            $this,
            $wrappedObject,
            $caller,
            $arrayAccess,
            $expectationFactory
        );
    }

    /**
     * @param WrappedObject $wrappedObject
     *
     * @return Caller
     */
<<<<<<< HEAD
    private function createCaller(WrappedObject $wrappedObject)
=======
    private function createCaller(WrappedObject $wrappedObject): Caller
>>>>>>> v2-test
    {
        $exceptionFactory = new ExceptionFactory($this->presenter);

        return new Caller(
            $wrappedObject,
            $this->example,
            $this->dispatcher,
            $exceptionFactory,
            $this,
            $this->accessInspector
        );
    }
}
