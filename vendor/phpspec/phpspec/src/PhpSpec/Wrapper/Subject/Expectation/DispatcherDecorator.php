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

namespace PhpSpec\Wrapper\Subject\Expectation;

use PhpSpec\Event\ExpectationEvent;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Loader\Node\ExampleNode;
<<<<<<< HEAD
use PhpSpec\Matcher\MatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Exception;

class DispatcherDecorator extends Decorator implements ExpectationInterface
{
=======
use PhpSpec\Matcher\Matcher;
use PhpSpec\Util\DispatchTrait;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Exception;

final class DispatcherDecorator extends Decorator implements Expectation
{
    use DispatchTrait;

>>>>>>> v2-test
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;
    /**
<<<<<<< HEAD
     * @var MatcherInterface
=======
     * @var Matcher
>>>>>>> v2-test
     */
    private $matcher;
    /**
     * @var ExampleNode
     */
    private $example;

    /**
<<<<<<< HEAD
     * @param ExpectationInterface     $expectation
     * @param EventDispatcherInterface $dispatcher
     * @param MatcherInterface         $matcher
     * @param ExampleNode              $example
     */
    public function __construct(
        ExpectationInterface $expectation,
        EventDispatcherInterface $dispatcher,
        MatcherInterface $matcher,
=======
     * @param Expectation     $expectation
     * @param EventDispatcherInterface $dispatcher
     * @param Matcher         $matcher
     * @param ExampleNode              $example
     */
    public function __construct(
        Expectation $expectation,
        EventDispatcherInterface $dispatcher,
        Matcher $matcher,
>>>>>>> v2-test
        ExampleNode $example
    ) {
        $this->setExpectation($expectation);
        $this->dispatcher = $dispatcher;
        $this->matcher = $matcher;
        $this->example = $example;
    }

    /**
     * @param  string  $alias
     * @param  mixed   $subject
     * @param  array   $arguments
<<<<<<< HEAD
     * @return boolean
=======
     * @return mixed
>>>>>>> v2-test
     *
     * @throws \Exception
     * @throws \PhpSpec\Exception\Example\FailureException
     * @throws \Exception
     */
<<<<<<< HEAD
    public function match($alias, $subject, array $arguments = array())
    {
        $this->dispatcher->dispatch(
            'beforeExpectation',
            new ExpectationEvent($this->example, $this->matcher, $subject, $alias, $arguments)
=======
    public function match(string $alias, $subject, array $arguments = array())
    {
        $this->dispatch(
            $this->dispatcher,
            new ExpectationEvent($this->example, $this->matcher, $subject, $alias, $arguments),
            'beforeExpectation'
>>>>>>> v2-test
        );

        try {
            $result = $this->getExpectation()->match($alias, $subject, $arguments);
<<<<<<< HEAD
            $this->dispatcher->dispatch(
                'afterExpectation',
=======
            $this->dispatch(
                $this->dispatcher,
>>>>>>> v2-test
                new ExpectationEvent(
                    $this->example,
                    $this->matcher,
                    $subject,
                    $alias,
                    $arguments,
                    ExpectationEvent::PASSED
<<<<<<< HEAD
                )
            );
        } catch (FailureException $e) {
            $this->dispatcher->dispatch(
                'afterExpectation',
=======
                ),
                'afterExpectation'
            );
        } catch (FailureException $e) {
            $this->dispatch(
                $this->dispatcher,
>>>>>>> v2-test
                new ExpectationEvent(
                    $this->example,
                    $this->matcher,
                    $subject,
                    $alias,
                    $arguments,
                    ExpectationEvent::FAILED,
                    $e
<<<<<<< HEAD
                )
=======
                ),
                'afterExpectation'
>>>>>>> v2-test
            );

            throw $e;
        } catch (Exception $e) {
<<<<<<< HEAD
            $this->dispatcher->dispatch(
                'afterExpectation',
=======
            $this->dispatch(
                $this->dispatcher,
>>>>>>> v2-test
                new ExpectationEvent(
                    $this->example,
                    $this->matcher,
                    $subject,
                    $alias,
                    $arguments,
                    ExpectationEvent::BROKEN,
                    $e
<<<<<<< HEAD
                )
=======
                ),
                'afterExpectation'
>>>>>>> v2-test
            );

            throw $e;
        }

        return $result;
    }
}
