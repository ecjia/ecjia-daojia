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

namespace PhpSpec\Runner;

<<<<<<< HEAD
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PhpSpec\Runner\Maintainer\LetAndLetgoMaintainer;
use PhpSpec\Formatter\Presenter\PresenterInterface;
use PhpSpec\SpecificationInterface;
=======
use Error;
use PhpSpec\Exception\ErrorException;
use PhpSpec\Runner\Maintainer\Maintainer;
use PhpSpec\Util\DispatchTrait;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PhpSpec\Runner\Maintainer\LetAndLetgoMaintainer;
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Specification;
>>>>>>> v2-test
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\Exception\Exception as PhpSpecException;
use PhpSpec\Exception\Example as ExampleException;
use Prophecy\Exception as ProphecyException;
use Exception;

class ExampleRunner
{
<<<<<<< HEAD
=======
    use DispatchTrait;

>>>>>>> v2-test
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;
    /**
<<<<<<< HEAD
     * @var PresenterInterface
     */
    private $presenter;
    /**
     * @var Maintainer\MaintainerInterface[]
=======
     * @var Presenter
     */
    private $presenter;
    /**
     * @var Maintainer[]
>>>>>>> v2-test
     */
    private $maintainers = array();

    /**
     * @param EventDispatcherInterface $dispatcher
<<<<<<< HEAD
     * @param PresenterInterface       $presenter
     */
    public function __construct(EventDispatcherInterface $dispatcher, PresenterInterface $presenter)
=======
     * @param Presenter       $presenter
     */
    public function __construct(EventDispatcherInterface $dispatcher, Presenter $presenter)
>>>>>>> v2-test
    {
        $this->dispatcher = $dispatcher;
        $this->presenter  = $presenter;
    }

    /**
<<<<<<< HEAD
     * @param Maintainer\MaintainerInterface $maintainer
     */
    public function registerMaintainer(Maintainer\MaintainerInterface $maintainer)
=======
     * @param Maintainer $maintainer
     */
    public function registerMaintainer(Maintainer $maintainer): void
>>>>>>> v2-test
    {
        $this->maintainers[] = $maintainer;

        @usort($this->maintainers, function ($maintainer1, $maintainer2) {
            return $maintainer2->getPriority() - $maintainer1->getPriority();
        });
    }

    /**
     * @param ExampleNode $example
     *
     * @return int
     */
<<<<<<< HEAD
    public function run(ExampleNode $example)
    {
        $startTime = microtime(true);
        $this->dispatcher->dispatch(
            'beforeExample',
            new ExampleEvent($example)
=======
    public function run(ExampleNode $example): int
    {
        $startTime = microtime(true);
        $this->dispatch(
            $this->dispatcher,
            new ExampleEvent($example),
            'beforeExample'
>>>>>>> v2-test
        );

        try {
            $this->executeExample(
                $example->getSpecification()->getClassReflection()->newInstance(),
                $example
            );

            $status    = ExampleEvent::PASSED;
            $exception = null;
        } catch (ExampleException\PendingException $e) {
            $status    = ExampleEvent::PENDING;
            $exception = $e;
        } catch (ExampleException\SkippingException $e) {
            $status    = ExampleEvent::SKIPPED;
            $exception = $e;
        } catch (ProphecyException\Prediction\PredictionException $e) {
            $status    = ExampleEvent::FAILED;
            $exception = $e;
        } catch (ExampleException\FailureException $e) {
            $status    = ExampleEvent::FAILED;
            $exception = $e;
        } catch (Exception $e) {
            $status    = ExampleEvent::BROKEN;
            $exception = $e;
<<<<<<< HEAD
=======
        } catch (Error $e) {
            $status    = ExampleEvent::BROKEN;
            $exception = new ErrorException($e);
>>>>>>> v2-test
        }

        if ($exception instanceof PhpSpecException) {
            $exception->setCause($example->getFunctionReflection());
        }

        $runTime = microtime(true) - $startTime;
<<<<<<< HEAD
        $this->dispatcher->dispatch(
            'afterExample',
            $event = new ExampleEvent($example, $runTime, $status, $exception)
=======
        $this->dispatch(
            $this->dispatcher,
            $event = new ExampleEvent($example, $runTime, $status, $exception),
            'afterExample'
>>>>>>> v2-test
        );

        return $event->getResult();
    }

    /**
<<<<<<< HEAD
     * @param SpecificationInterface $context
=======
     * @param Specification $context
>>>>>>> v2-test
     * @param ExampleNode            $example
     *
     * @throws \PhpSpec\Exception\Example\PendingException
     * @throws \Exception
     */
<<<<<<< HEAD
    protected function executeExample(SpecificationInterface $context, ExampleNode $example)
=======
    protected function executeExample(Specification $context, ExampleNode $example): void
>>>>>>> v2-test
    {
        if ($example->isPending()) {
            throw new ExampleException\PendingException();
        }

        $matchers      = new MatcherManager($this->presenter);
        $collaborators = new CollaboratorManager($this->presenter);
<<<<<<< HEAD
        $maintainers   = array_filter($this->maintainers, function ($maintainer) use ($example) {
=======
        $maintainers   = array_filter($this->maintainers, function (Maintainer $maintainer) use ($example) {
>>>>>>> v2-test
            return $maintainer->supports($example);
        });

        // run maintainers prepare
        foreach ($maintainers as $maintainer) {
            $maintainer->prepare($example, $context, $matchers, $collaborators);
        }

        // execute example
        $reflection = $example->getFunctionReflection();

        try {
<<<<<<< HEAD
            $reflection->invokeArgs($context, $collaborators->getArgumentsFor($reflection));
=======
            if ($reflection instanceof \ReflectionMethod) {
                $reflection->invokeArgs($context, $collaborators->getArgumentsFor($reflection));
            }
            else {
                $reflection->invokeArgs($collaborators->getArgumentsFor($reflection));
            }
>>>>>>> v2-test
        } catch (\Exception $e) {
            $this->runMaintainersTeardown(
                $this->searchExceptionMaintainers($maintainers),
                $example,
                $context,
                $matchers,
                $collaborators
            );
            throw $e;
        }

        $this->runMaintainersTeardown($maintainers, $example, $context, $matchers, $collaborators);
    }

    /**
<<<<<<< HEAD
     * @param Maintainer\MaintainerInterface[] $maintainers
     * @param ExampleNode                      $example
     * @param SpecificationInterface           $context
=======
     * @param Maintainer[] $maintainers
     * @param ExampleNode                      $example
     * @param Specification           $context
>>>>>>> v2-test
     * @param MatcherManager                   $matchers
     * @param CollaboratorManager              $collaborators
     */
    private function runMaintainersTeardown(
        array $maintainers,
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
        foreach (array_reverse($maintainers) as $maintainer) {
            $maintainer->teardown($example, $context, $matchers, $collaborators);
        }
    }

    /**
<<<<<<< HEAD
     * @param Maintainer\MaintainerInterface[] $maintainers
     *
     * @return Maintainer\MaintainerInterface[]
=======
     * @param Maintainer[] $maintainers
     *
     * @return Maintainer[]
>>>>>>> v2-test
     */
    private function searchExceptionMaintainers(array $maintainers)
    {
        return array_filter(
            $maintainers,
            function ($maintainer) {
                return $maintainer instanceof LetAndLetgoMaintainer;
            }
        );
    }
}
