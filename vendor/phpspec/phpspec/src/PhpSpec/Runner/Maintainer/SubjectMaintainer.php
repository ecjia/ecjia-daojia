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
use PhpSpec\CodeAnalysis\AccessInspectorInterface;
use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\SpecificationInterface;
use PhpSpec\Runner\MatcherManager;
use PhpSpec\Runner\CollaboratorManager;
use PhpSpec\Formatter\Presenter\PresenterInterface;
=======
use PhpSpec\CodeAnalysis\AccessInspector;
use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\Specification;
use PhpSpec\Runner\MatcherManager;
use PhpSpec\Runner\CollaboratorManager;
use PhpSpec\Formatter\Presenter\Presenter;
>>>>>>> v2-test
use PhpSpec\Wrapper\Unwrapper;
use PhpSpec\Wrapper\Wrapper;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

<<<<<<< HEAD
class SubjectMaintainer implements MaintainerInterface
{
    /**
     * @var PresenterInterface
=======
final class SubjectMaintainer implements Maintainer
{
    /**
     * @var Presenter
>>>>>>> v2-test
     */
    private $presenter;
    /**
     * @var Unwrapper
     */
    private $unwrapper;
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;
    /**
<<<<<<< HEAD
     * @var AccessInspectorInterface
=======
     * @var AccessInspector
>>>>>>> v2-test
     */
    private $accessInspector;

    /**
<<<<<<< HEAD
     * @param PresenterInterface       $presenter
=======
     * @param Presenter       $presenter
>>>>>>> v2-test
     * @param Unwrapper                $unwrapper
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
<<<<<<< HEAD
        PresenterInterface $presenter,
        Unwrapper $unwrapper,
        EventDispatcherInterface $dispatcher,
        AccessInspectorInterface $accessInspector
=======
        Presenter $presenter,
        Unwrapper $unwrapper,
        EventDispatcherInterface $dispatcher,
        AccessInspector $accessInspector
>>>>>>> v2-test
    ) {
        $this->presenter = $presenter;
        $this->unwrapper = $unwrapper;
        $this->dispatcher = $dispatcher;
        $this->accessInspector = $accessInspector;
    }

    /**
     * @param ExampleNode $example
     *
     * @return boolean
     */
<<<<<<< HEAD
    public function supports(ExampleNode $example)
    {
        return $example->getSpecification()->getClassReflection()->implementsInterface(
            'PhpSpec\Wrapper\SubjectContainerInterface'
=======
    public function supports(ExampleNode $example): bool
    {
        return $example->getSpecification()->getClassReflection()->implementsInterface(
            'PhpSpec\Wrapper\SubjectContainer'
>>>>>>> v2-test
        );
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
        $subjectFactory = new Wrapper($matchers, $this->presenter, $this->dispatcher, $example, $this->accessInspector);
        $subject = $subjectFactory->wrap(null);
        $subject->beAnInstanceOf(
            $example->getSpecification()->getResource()->getSrcClassname()
        );

        $context->setSpecificationSubject($subject);
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
        return 100;
    }
}
