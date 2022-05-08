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
use PhpSpec\Event\SuiteEvent;
use PhpSpec\Exception\Fracture\NamedConstructorNotFoundException;
use PhpSpec\Locator\ResourceManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

<<<<<<< HEAD
class NamedConstructorNotFoundListener implements EventSubscriberInterface
=======
final class NamedConstructorNotFoundListener implements EventSubscriberInterface
>>>>>>> v2-test
{
    private $io;
    private $resources;
    private $generator;
    private $methods = array();

<<<<<<< HEAD
    public function __construct(IO $io, ResourceManager $resources, GeneratorManager $generator)
=======
    public function __construct(ConsoleIO $io, ResourceManager $resources, GeneratorManager $generator)
>>>>>>> v2-test
    {
        $this->io        = $io;
        $this->resources = $resources;
        $this->generator = $generator;
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

        if (!$exception instanceof NamedConstructorNotFoundException) {
            return;
        }

<<<<<<< HEAD
        $className = get_class($exception->getSubject());
        $this->methods[$className .'::'.$exception->getMethodName()] = $exception->getArguments();
    }

    public function afterSuite(SuiteEvent $event)
=======
        $className = \get_class($exception->getSubject());
        $this->methods[$className .'::'.$exception->getMethodName()] = $exception->getArguments();
    }

    public function afterSuite(SuiteEvent $event): void
>>>>>>> v2-test
    {
        if (!$this->io->isCodeGenerationEnabled()) {
            return;
        }

        foreach ($this->methods as $call => $arguments) {
            list($classname, $method) = explode('::', $call);
            $message = sprintf('Do you want me to create `%s()` for you?', $call);

            try {
                $resource = $this->resources->createResource($classname);
            } catch (\RuntimeException $e) {
                continue;
            }

            if ($this->io->askConfirmation($message)) {
                $this->generator->generate($resource, 'named_constructor', array(
                    'name'      => $method,
                    'arguments' => $arguments
                ));
                $event->markAsWorthRerunning();

                if (!method_exists($classname, '__construct')) {
<<<<<<< HEAD
                    $message = sprintf('Do you want me to make the constructor of %s private for you?', $classname);

                    if ($this->io->askConfirmation($message)) {
                        $this->generator->generate($resource, 'private-constructor', array(
                            'name' => $method,
                            'arguments' => $arguments
                        ));
                    }
=======
                    $this->generator->generate($resource, 'private-constructor', array(
                        'name' => $method,
                        'arguments' => $arguments
                    ));
>>>>>>> v2-test
                }
            }
        }
    }
}
