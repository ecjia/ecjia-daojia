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
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Event\SuiteEvent;
use PhpSpec\Exception\Locator\ResourceCreationException;
use PhpSpec\Locator\ResourceManagerInterface;
use PhpSpec\Util\NameCheckerInterface;
use PhpSpec\Util\ReservedWordsMethodNameChecker;
use Prophecy\Argument\ArgumentsWildcard;
use Prophecy\Exception\Doubler\MethodNotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CollaboratorMethodNotFoundListener implements EventSubscriberInterface
=======
use PhpSpec\Console\ConsoleIO;
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Event\SuiteEvent;
use PhpSpec\Exception\Locator\ResourceCreationException;
use PhpSpec\Locator\ResourceManager;
use PhpSpec\Util\NameChecker;
use Prophecy\Argument\ArgumentsWildcard;
use Prophecy\Exception\Doubler\MethodNotFoundException;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class CollaboratorMethodNotFoundListener implements EventSubscriberInterface
>>>>>>> v2-test
{
    const PROMPT = 'Would you like me to generate a method signature `%s::%s()` for you?';

    /**
<<<<<<< HEAD
     * @var IO
=======
     * @var ConsoleIO
>>>>>>> v2-test
     */
    private $io;

    /**
     * @var array
     */
    private $interfaces = array();

    /**
<<<<<<< HEAD
     * @var ResourceManagerInterface
=======
     * @var ResourceManager
>>>>>>> v2-test
     */
    private $resources;

    /**
     * @var GeneratorManager
     */
    private $generator;

    /**
<<<<<<< HEAD
     * @var NameCheckerInterface
=======
     * @var NameChecker
>>>>>>> v2-test
     */
    private $nameChecker;

    /**
     * @var array
     */
    private $wrongMethodNames = array();

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
        $this->io = $io;
        $this->resources = $resources;
        $this->generator = $generator;
<<<<<<< HEAD
        $this->nameChecker = $nameChecker ?: new ReservedWordsMethodNameChecker();
=======
        $this->nameChecker = $nameChecker;
>>>>>>> v2-test
    }

    /**
     * @return array
     */
<<<<<<< HEAD
    public static function getSubscribedEvents()
=======
    public static function getSubscribedEvents(): array
>>>>>>> v2-test
    {
        return array(
            'afterExample' => array('afterExample', 10),
            'afterSuite' => array('afterSuite', -10)
        );
    }

    /**
     * @param ExampleEvent $event
     */
<<<<<<< HEAD
    public function afterExample(ExampleEvent $event)
=======
    public function afterExample(ExampleEvent $event): void
>>>>>>> v2-test
    {
        if (!$exception = $this->getMethodNotFoundException($event)) {
            return;
        }

<<<<<<< HEAD
        if (!$interface = $this->getDoubledInterface($exception->getClassName())) {
=======
        $className = $exception->getClassName();

        // Prophecy sometimes throws the exception with the Prophecy rather than the FCQN - in these cases we need to parse the error
        if ($className instanceof ObjectProphecy) {

            $classPattern = '[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*'; //from https://www.php.net/manual/en/language.oop5.basic.php
            $fcqnPattern = "(?:$classPattern)(?:\\\\$classPattern)*)";
            $method = preg_quote($exception->getMethodName());

            if(preg_match("/(?<fcqn>$fcqnPattern::$method\(/", $exception->getMessage(), $matches)) {
                $className = $matches['fcqn'];
            }
        }

        if (!$interface = $this->getDoubledInterface($className)) {
>>>>>>> v2-test
            return;
        }

        if (!array_key_exists($interface, $this->interfaces)) {
            $this->interfaces[$interface] = array();
        }

        $methodName = $exception->getMethodName();
        $this->interfaces[$interface][$methodName] = $exception->getArguments();
        $this->checkIfMethodNameAllowed($methodName);
    }

    /**
<<<<<<< HEAD
     * @param string $classname
     * @return mixed
     */
    private function getDoubledInterface($classname)
    {
        if (class_parents($classname) !== array('stdClass'=>'stdClass')) {
            return;
        }

        $interfaces = array_filter(class_implements($classname),
=======
     * @param string|object $classname
     * @return mixed
     */
    private function getDoubledInterface($class)
    {
        if (class_parents($class) !== array('stdClass'=>'stdClass')) {
            return;
        }

        $interfaces = array_filter(class_implements($class),
>>>>>>> v2-test
            function ($interface) {
                return !preg_match('/^Prophecy/', $interface);
            }
        );

<<<<<<< HEAD
        if (count($interfaces) !== 1) {
=======
        if (\count($interfaces) !== 1) {
>>>>>>> v2-test
            return;
        }

        return current($interfaces);
    }

    /**
     * @param SuiteEvent $event
     */
<<<<<<< HEAD
    public function afterSuite(SuiteEvent $event)
=======
    public function afterSuite(SuiteEvent $event): void
>>>>>>> v2-test
    {
        foreach ($this->interfaces as $interface => $methods) {
            try {
                $resource = $this->resources->createResource($interface);
            } catch (ResourceCreationException $e) {
                continue;
            }

            foreach ($methods as $method => $arguments) {
<<<<<<< HEAD
                if (in_array($method, $this->wrongMethodNames)) {
=======
                if (\in_array($method, $this->wrongMethodNames)) {
>>>>>>> v2-test
                    continue;
                }

                if ($this->io->askConfirmation(sprintf(self::PROMPT, $interface, $method))) {
                    $this->generator->generate(
                        $resource,
                        'method-signature',
                        array(
                            'name' => $method,
                            'arguments' => $this->getRealArguments($arguments)
                        )
                    );
                    $event->markAsWorthRerunning();
                }
            }
        }

        if ($this->wrongMethodNames) {
            $this->writeErrorMessage();
            $event->markAsNotWorthRerunning();
        }
    }

    /**
     * @param mixed $prophecyArguments
     * @return array
     */
<<<<<<< HEAD
    private function getRealArguments($prophecyArguments)
=======
    private function getRealArguments($prophecyArguments): array
>>>>>>> v2-test
    {
        if ($prophecyArguments instanceof ArgumentsWildcard) {
            return $prophecyArguments->getTokens();
        }

        return array();
    }

    /**
     * @param ExampleEvent $event
<<<<<<< HEAD
     * @return bool
=======
     * @return void|MethodNotFoundException
>>>>>>> v2-test
     */
    private function getMethodNotFoundException(ExampleEvent $event)
    {
        if ($this->io->isCodeGenerationEnabled()
            && ($exception = $event->getException())
            && $exception instanceof MethodNotFoundException) {
            return $exception;
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
    private function writeErrorMessage()
=======
    private function writeErrorMessage(): void
>>>>>>> v2-test
    {
        foreach ($this->wrongMethodNames as $methodName) {
            $message = sprintf("I cannot generate the method '%s' for you because it is a reserved keyword", $methodName);
            $this->io->writeBrokenCodeBlock($message, 2);
        }
    }
}
