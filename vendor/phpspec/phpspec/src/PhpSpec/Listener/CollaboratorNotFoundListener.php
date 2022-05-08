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
use PhpSpec\Exception\Fracture\CollaboratorNotFoundException;
use PhpSpec\Locator\ResourceInterface;
use PhpSpec\Locator\ResourceManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CollaboratorNotFoundListener implements EventSubscriberInterface
{
    /**
     * @var IO
=======
use PhpSpec\Console\ConsoleIO;
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Event\SuiteEvent;
use PhpSpec\Exception\Fracture\CollaboratorNotFoundException;
use PhpSpec\Locator\Resource;
use PhpSpec\Locator\ResourceManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class CollaboratorNotFoundListener implements EventSubscriberInterface
{
    /**
     * @var ConsoleIO
>>>>>>> v2-test
     */
    private $io;

    /**
     * @var CollaboratorNotFoundException[]
     */
    private $exceptions = array();

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
     * @param IO $io
     * @param ResourceManagerInterface $resources
     * @param GeneratorManager $generator
     */
    public function __construct(IO $io, ResourceManagerInterface $resources, GeneratorManager $generator)
=======
     * @param ConsoleIO $io
     * @param ResourceManager $resources
     * @param GeneratorManager $generator
     */
    public function __construct(ConsoleIO $io, ResourceManager $resources, GeneratorManager $generator)
>>>>>>> v2-test
    {
        $this->io = $io;
        $this->resources = $resources;
        $this->generator = $generator;
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
            'afterSuite'   => array('afterSuite', -10)
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
        if (($exception = $event->getException()) &&
            ($exception instanceof CollaboratorNotFoundException)) {
            $this->exceptions[$exception->getCollaboratorName()] = $exception;
        }
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
        if (!$this->io->isCodeGenerationEnabled()) {
            return;
        }

        foreach ($this->exceptions as $exception) {
            $resource = $this->resources->createResource($exception->getCollaboratorName());

            if ($this->resourceIsInSpecNamespace($exception, $resource)) {
                continue;
            }

            if ($this->io->askConfirmation(
                sprintf('Would you like me to generate an interface `%s` for you?', $exception->getCollaboratorName())
            )) {
                $this->generator->generate($resource, 'interface');
                $event->markAsWorthRerunning();
            }
        }
    }

    /**
     * @param CollaboratorNotFoundException $exception
<<<<<<< HEAD
     * @param ResourceInterface $resource
     * @return bool
     */
    private function resourceIsInSpecNamespace($exception, $resource)
=======
     * @param Resource $resource
     * @return bool
     */
    private function resourceIsInSpecNamespace(CollaboratorNotFoundException $exception, Resource $resource): bool
>>>>>>> v2-test
    {
        return strpos($exception->getCollaboratorName(), $resource->getSpecNamespace()) === 0;
    }
}
