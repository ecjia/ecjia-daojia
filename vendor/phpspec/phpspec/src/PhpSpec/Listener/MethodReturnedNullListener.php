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

namespace PhpSpec\Listener;

use PhpSpec\CodeGenerator\GeneratorManager;
<<<<<<< HEAD
use PhpSpec\Console\IO;
=======
use PhpSpec\Console\ConsoleIO;
>>>>>>> v2-test
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Event\MethodCallEvent;
use PhpSpec\Event\SuiteEvent;
use PhpSpec\Exception\Example\NotEqualException;
use PhpSpec\Locator\ResourceManager;
use PhpSpec\Util\MethodAnalyser;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

<<<<<<< HEAD
class MethodReturnedNullListener implements EventSubscriberInterface
{
    /**
     * @var IO
=======
final class MethodReturnedNullListener implements EventSubscriberInterface
{
    /**
     * @var ConsoleIO
>>>>>>> v2-test
     */
    private $io;

    /**
     * @var MethodCallEvent[]
     */
    private $nullMethods = array();

    /**
     * @var MethodCallEvent|null
     */
    private $lastMethodCallEvent = null;
    /**
     * @var ResourceManager
     */
    private $resources;
    /**
     * @var GeneratorManager
     */
    private $generator;
    /**
     * @var MethodAnalyser
     */
    private $methodAnalyser;

    /**
<<<<<<< HEAD
     * @param IO               $io
     * @param ResourceManager  $resources
     * @param GeneratorManager $generator
     */
    public function __construct(
        IO $io,
=======
     * @param ConsoleIO $io
     * @param ResourceManager $resources
     * @param GeneratorManager $generator
     * @param MethodAnalyser $methodAnalyser
     */
    public function __construct(
        ConsoleIO $io,
>>>>>>> v2-test
        ResourceManager $resources,
        GeneratorManager $generator,
        MethodAnalyser $methodAnalyser
    ) {
        $this->io = $io;
        $this->resources = $resources;
        $this->generator = $generator;
        $this->methodAnalyser = $methodAnalyser;
    }

    /**
     * @{inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            'afterExample' => array('afterExample', 10),
            'afterSuite'   => array('afterSuite', -20),
            'afterMethodCall' => array('afterMethodCall')
        );
    }

<<<<<<< HEAD
    public function afterMethodCall(MethodCallEvent $methodCallEvent)
=======
    public function afterMethodCall(MethodCallEvent $methodCallEvent): void
>>>>>>> v2-test
    {
        $this->lastMethodCallEvent = $methodCallEvent;
    }

<<<<<<< HEAD
    public function afterExample(ExampleEvent $exampleEvent)
=======
    public function afterExample(ExampleEvent $exampleEvent): void
>>>>>>> v2-test
    {
        $exception = $exampleEvent->getException();

        if (!$exception instanceof NotEqualException) {
            return;
        }

        if ($exception->getActual() !== null) {
            return;
        }

<<<<<<< HEAD
        if (is_object($exception->getExpected())
         || is_array($exception->getExpected())
         || is_resource($exception->getExpected())
=======
        if (\is_object($exception->getExpected())
         || \is_array($exception->getExpected())
         || \is_resource($exception->getExpected())
>>>>>>> v2-test
        ) {
            return;
        }

        if (!$this->lastMethodCallEvent) {
<<<<<<< HEAD
            return;
        }

        $class = get_class($this->lastMethodCallEvent->getSubject());
        $method = $this->lastMethodCallEvent->getMethod();

=======
            $subject = $exception->getSubject();
            $method = $exception->getMethod();
            if (is_null($subject) || is_null($method)) {
                return;
            }
            $class = \get_class($subject);
        } else {
            $class = \get_class($this->lastMethodCallEvent->getSubject());
            $method = $this->lastMethodCallEvent->getMethod();
        }

>>>>>>> v2-test
        if (!$this->methodAnalyser->methodIsEmpty($class, $method)) {
            return;
        }

        $key = $class.'::'.$method;

        if (!array_key_exists($key, $this->nullMethods)) {
            $this->nullMethods[$key] = array(
                'class' => $this->methodAnalyser->getMethodOwnerName($class, $method),
                'method' => $method,
                'expected' => array()
            );
        }

        $this->nullMethods[$key]['expected'][] = $exception->getExpected();
    }

<<<<<<< HEAD
    public function afterSuite(SuiteEvent $event)
=======
    public function afterSuite(SuiteEvent $event): void
>>>>>>> v2-test
    {
        if (!$this->io->isCodeGenerationEnabled()) {
            return;
        }

        if (!$this->io->isFakingEnabled()) {
            return;
        }

        foreach ($this->nullMethods as $methodString => $failedCall) {
            $failedCall['expected'] = array_unique($failedCall['expected']);

<<<<<<< HEAD
            if (count($failedCall['expected'])>1) {
=======
            if (\count($failedCall['expected'])>1) {
>>>>>>> v2-test
                continue;
            }

            $expected = current($failedCall['expected']);
            $class = $failedCall['class'];

            $message = sprintf(
                'Do you want me to make `%s()` always return %s for you?',
                $methodString,
                var_export($expected, true)
            );

            try {
                $resource = $this->resources->createResource($class);
            } catch (\RuntimeException $exception) {
                continue;
            }

            if ($this->io->askConfirmation($message)) {
                $this->generator->generate(
                    $resource,
                    'returnConstant',
                    array('method' => $failedCall['method'], 'expected' => $expected)
                );
                $event->markAsWorthRerunning();
            }
        }
    }
}
