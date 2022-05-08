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

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
<<<<<<< HEAD
use PhpSpec\Console\IO;
use PhpSpec\Locator\ResourceManagerInterface;
=======
use PhpSpec\Console\ConsoleIO;
use PhpSpec\Locator\ResourceManager;
>>>>>>> v2-test
use PhpSpec\CodeGenerator\GeneratorManager;
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Event\SuiteEvent;
use PhpSpec\Exception\Fracture\ClassNotFoundException as PhpSpecClassException;
use Prophecy\Exception\Doubler\ClassNotFoundException as ProphecyClassException;

<<<<<<< HEAD
class ClassNotFoundListener implements EventSubscriberInterface
=======
final class ClassNotFoundListener implements EventSubscriberInterface
>>>>>>> v2-test
{
    private $io;
    private $resources;
    private $generator;
    private $classes = array();

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
        $this->io        = $io;
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
            'afterSuite'   => array('afterSuite', -10),
        );
    }

    /**
     * @param ExampleEvent $event
     */
    public function afterExample(ExampleEvent $event)
    {
        if (null === $exception = $event->getException()) {
            return;
        }

        if (!($exception instanceof PhpSpecClassException) &&
            !($exception instanceof ProphecyClassException)) {
            return;
        }

        $this->classes[$exception->getClassname()] = true;
    }

    /**
     * @param SuiteEvent $event
     */
    public function afterSuite(SuiteEvent $event)
    {
        if (!$this->io->isCodeGenerationEnabled()) {
            return;
        }

        foreach ($this->classes as $classname => $_) {
            $message = sprintf('Do you want me to create `%s` for you?', $classname);

            try {
                $resource = $this->resources->createResource($classname);
            } catch (\RuntimeException $e) {
                continue;
            }

            if ($this->io->askConfirmation($message)) {
                $this->generator->generate($resource, 'class');
                $event->markAsWorthRerunning();
            }
        }
    }
}
