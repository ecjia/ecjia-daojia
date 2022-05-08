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
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Exception\Example\StopOnFailureException;
<<<<<<< HEAD
use PhpSpec\Console\IO;

class StopOnFailureListener implements EventSubscriberInterface
{
    /**
     * @var IO
=======
use PhpSpec\Console\ConsoleIO;

final class StopOnFailureListener implements EventSubscriberInterface
{
    /**
     * @var ConsoleIO
>>>>>>> v2-test
     */
    private $io;

    /**
<<<<<<< HEAD
     * @param IO $io
     */
    public function __construct(IO $io)
=======
     * @param ConsoleIO $io
     */
    public function __construct(ConsoleIO $io)
>>>>>>> v2-test
    {
        $this->io = $io;
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
            'afterExample' => array('afterExample', -100),
        );
    }

    /**
     * @param ExampleEvent $event
     *
     * @throws \PhpSpec\Exception\Example\StopOnFailureException
     */
<<<<<<< HEAD
    public function afterExample(ExampleEvent $event)
=======
    public function afterExample(ExampleEvent $event): void
>>>>>>> v2-test
    {
        if (!$this->io->isStopOnFailureEnabled()) {
            return;
        }

        if ($event->getResult() === ExampleEvent::FAILED
         || $event->getResult() === ExampleEvent::BROKEN) {
            throw new StopOnFailureException('Example failed', 0, null, $event->getResult());
        }
    }
}
