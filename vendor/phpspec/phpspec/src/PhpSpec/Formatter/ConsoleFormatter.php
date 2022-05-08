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

namespace PhpSpec\Formatter;

<<<<<<< HEAD
use PhpSpec\Console\IO;
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Exception\Example\PendingException;
use PhpSpec\Exception\Example\SkippingException;
use PhpSpec\Formatter\Presenter\PresenterInterface;
use PhpSpec\Listener\StatisticsCollector;
use PhpSpec\Message\CurrentExampleTracker;

class ConsoleFormatter extends BasicFormatter implements FatalPresenter
{
    /**
     * @var IO
=======
use PhpSpec\Console\ConsoleIO;
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Exception\Example\PendingException;
use PhpSpec\Exception\Example\SkippingException;
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\IO\IO;
use PhpSpec\Listener\StatisticsCollector;
use PhpSpec\Message\CurrentExampleTracker;

abstract class ConsoleFormatter extends BasicFormatter implements FatalPresenter
{
    /**
     * @var ConsoleIO
>>>>>>> v2-test
     */
    private $io;

    /**
<<<<<<< HEAD
     * @param PresenterInterface  $presenter
     * @param IO                  $io
     * @param StatisticsCollector $stats
     */
    public function __construct(PresenterInterface $presenter, IO $io, StatisticsCollector $stats)
=======
     * @param Presenter           $presenter
     * @param ConsoleIO           $io
     * @param StatisticsCollector $stats
     */
    public function __construct(Presenter $presenter, ConsoleIO $io, StatisticsCollector $stats)
>>>>>>> v2-test
    {
        parent::__construct($presenter, $io, $stats);
        $this->io = $io;
    }

    /**
     * @return IO
     */
<<<<<<< HEAD
    protected function getIO()
=======
    protected function getIO(): IO
>>>>>>> v2-test
    {
        return $this->io;
    }

    /**
     * @param ExampleEvent $event
     */
<<<<<<< HEAD
    protected function printException(ExampleEvent $event)
=======
    protected function printException(ExampleEvent $event): void
>>>>>>> v2-test
    {
        if (null === $exception = $event->getException()) {
            return;
        }

        if ($exception instanceof PendingException) {
            $this->printSpecificException($event, 'pending');
        } elseif ($exception instanceof SkippingException) {
            if ($this->io->isVerbose()) {
<<<<<<< HEAD
                $this->printSpecificException($event, 'skipped ');
=======
                $this->printSpecificException($event, 'skipped');
>>>>>>> v2-test
            }
        } elseif (ExampleEvent::FAILED === $event->getResult()) {
            $this->printSpecificException($event, 'failed');
        } else {
            $this->printSpecificException($event, 'broken');
        }
    }

    /**
     * @param ExampleEvent $event
     * @param string $type
     */
<<<<<<< HEAD
    protected function printSpecificException(ExampleEvent $event, $type)
=======
    protected function printSpecificException(ExampleEvent $event, string $type): void
>>>>>>> v2-test
    {
        $title = str_replace('\\', DIRECTORY_SEPARATOR, $event->getSpecification()->getTitle());
        $message = $this->getPresenter()->presentException($event->getException(), $this->io->isVerbose());

        foreach (explode("\n", wordwrap($title, $this->io->getBlockWidth(), "\n", true)) as $line) {
            $this->io->writeln(sprintf('<%s-bg>%s</%s-bg>', $type, str_pad($line, $this->io->getBlockWidth()), $type));
        }

        $this->io->writeln(sprintf(
            '<lineno>%4d</lineno>  <%s>- %s</%s>',
<<<<<<< HEAD
            $event->getExample()->getFunctionReflection()->getStartLine(),
=======
            $event->getExample()->getLineNumber(),
>>>>>>> v2-test
            $type,
            $event->getExample()->getTitle(),
            $type
        ));
        $this->io->writeln(sprintf('<%s>%s</%s>', $type, lcfirst($message), $type), 6);
        $this->io->writeln();
    }

<<<<<<< HEAD
    public function displayFatal(CurrentExampleTracker $currentExample, $error)
    {
        if (
            (null !== $error && ($currentExample->getCurrentExample() || $error['type'] == E_ERROR)) ||
            (is_null($currentExample->getCurrentExample()) && defined('HHVM_VERSION'))
=======
    public function displayFatal(CurrentExampleTracker $currentExample, $error): void
    {
        if (
            (null !== $error && ($currentExample->getCurrentExample() || $error['type'] == E_ERROR)) ||
            (\is_null($currentExample->getCurrentExample()) && \defined('HHVM_VERSION'))
>>>>>>> v2-test
        ) {
            ini_set('display_errors', "stderr");
            $failedOpen = ($this->io->isDecorated()) ? '<failed>' : '';
            $failedClosed = ($this->io->isDecorated()) ? '</failed>' : '';
            $failedCross = ($this->io->isDecorated()) ? '✘' : '';

            $this->io->writeln("$failedOpen$failedCross Fatal error happened while executing the following $failedClosed");
            $this->io->writeln("$failedOpen    {$currentExample->getCurrentExample()} $failedClosed");
            $this->io->writeln("$failedOpen    {$error['message']} in {$error['file']} on line {$error['line']} $failedClosed");
        }
    }
}
