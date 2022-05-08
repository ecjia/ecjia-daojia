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

<<<<<<< HEAD
use PhpSpec\Util\ReservedWordsMethodNameChecker;
use PhpSpec\Util\NameCheckerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use PhpSpec\Console\IO;
use PhpSpec\Locator\ResourceManagerInterface;
=======
use PhpSpec\Util\NameChecker;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use PhpSpec\Console\ConsoleIO;
use PhpSpec\Locator\ResourceManager;
>>>>>>> v2-test
use PhpSpec\CodeGenerator\GeneratorManager;
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Event\SuiteEvent;
use PhpSpec\Exception\Fracture\MethodNotFoundException;

<<<<<<< HEAD
class MethodNotFoundListener implements EventSubscriberInterface
=======
final class MethodNotFoundListener implements EventSubscriberInterface
>>>>>>> v2-test
{
    private $io;
    private $resources;
    private $generator;
    private $methods = array();
    private $wrongMethodNames = array();
    /**
<<<<<<< HEAD
     * @var NameCheckerInterface
=======
     * @var NameChecker
>>>>>>> v2-test
     */
    private $nameChecker;

    /**
<<<<<<< HEAD
     * @param IO $io
     * @param ResourceManagerInterface $resources
     * @param GeneratorManager $generator
     * @param NameCheckerInterface $nameChecker
     */
    public function __construct(
        IO $io,
        ResourceManagerInterface $resources,
        GeneratorManager $generator,
        NameCheckerInterface $nameChecker = null
=======
     * @param ConsoleIO $io
     * @param ResourceManager $resources
     * @param GeneratorManager $generator
     * @param NameChecker $nameChecker
     */
    public function __construct(
        ConsoleIO $io,
        ResourceManager $resources,
        GeneratorManager $generator,
        NameChecker $nameChecker
>>>>>>> v2-test
    ) {
        $this->io        = $io;
        $this->resources = $resources;
        $this->generator = $generator;
<<<<<<< HEAD
        $this->nameChecker = $nameChecker ?: new ReservedWordsMethodNameChecker();
=======
        $this->nameChecker = $nameChecker;
>>>>>>> v2-test
    }

    public static function getSubscribedEvents()
    {
        return array(
            'afterExample' => array('afterExample', 10),
            'afterSuite'   => array('afterSuite', -10),
        );
    }

<<<<<<< HEAD
    public function afterExample(ExampleEvent $event)
=======
    public function afterExample(ExampleEvent $event): void
>>>>>>> v2-test
    {
        if (null === $exception = $event->getException()) {
            return;
        }

        if (!$exception instanceof MethodNotFoundException) {
            return;
        }

<<<<<<< HEAD
        $classname = get_class($exception->getSubject());
=======
        $classname = \get_class($exception->getSubject());
>>>>>>> v2-test
        $methodName = $exception->getMethodName();
        $this->methods[$classname .'::'.$methodName] = $exception->getArguments();
        $this->checkIfMethodNameAllowed($methodName);
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

        foreach ($this->methods as $call => $arguments) {
            list($classname, $method) = explode('::', $call);

<<<<<<< HEAD
            if (in_array($method, $this->wrongMethodNames)) {
=======
            if (\in_array($method, $this->wrongMethodNames)) {
>>>>>>> v2-test
                continue;
            }

            $message = sprintf('Do you want me to create `%s()` for you?', $call);

            try {
                $resource = $this->resources->createResource($classname);
            } catch (\RuntimeException $e) {
                continue;
            }

            if ($this->io->askConfirmation($message)) {
                $this->generator->generate($resource, 'method', array(
                    'name'      => $method,
                    'arguments' => $arguments
                ));
                $event->markAsWorthRerunning();
            }
        }

        if ($this->wrongMethodNames) {
            $this->writeWrongMethodNameMessage();
            $event->markAsNotWorthRerunning();
        }
    }

<<<<<<< HEAD
    private function checkIfMethodNameAllowed($methodName)
=======
    private function checkIfMethodNameAllowed($methodName): void
>>>>>>> v2-test
    {
        if (!$this->nameChecker->isNameValid($methodName)) {
            $this->wrongMethodNames[] = $methodName;
        }
    }

<<<<<<< HEAD
    private function writeWrongMethodNameMessage()
=======
    private function writeWrongMethodNameMessage(): void
>>>>>>> v2-test
    {
        foreach ($this->wrongMethodNames as $methodName) {
            $message = sprintf("I cannot generate the method '%s' for you because it is a reserved keyword", $methodName);
            $this->io->writeBrokenCodeBlock($message, 2);
        }
    }
}
