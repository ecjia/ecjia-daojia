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

use PhpSpec\Event\SuiteEvent;
use PhpSpec\Event\ExampleEvent;

<<<<<<< HEAD
class DotFormatter extends ConsoleFormatter
=======
final class DotFormatter extends ConsoleFormatter
>>>>>>> v2-test
{
    /**
     * @var int
     */
    private $examplesCount = 0;

    /**
     * @param SuiteEvent $event
     */
    public function beforeSuite(SuiteEvent $event)
    {
<<<<<<< HEAD
        $this->examplesCount = count($event->getSuite());
=======
        $this->examplesCount = \count($event->getSuite());
>>>>>>> v2-test
    }

    /**
     * @param ExampleEvent $event
     */
    public function afterExample(ExampleEvent $event)
    {
        $io = $this->getIO();

        $eventsCount = $this->getStatisticsCollector()->getEventsCount();
        if ($eventsCount === 1) {
            $io->writeln();
        }

        switch ($event->getResult()) {
            case ExampleEvent::PASSED:
                $io->write('<passed>.</passed>');
                break;
            case ExampleEvent::PENDING:
                $io->write('<pending>P</pending>');
                break;
            case ExampleEvent::SKIPPED:
                $io->write('<skipped>S</skipped>');
                break;
            case ExampleEvent::FAILED:
                $io->write('<failed>F</failed>');
                break;
            case ExampleEvent::BROKEN:
                $io->write('<broken>B</broken>');
                break;
        }

        $remainder = $eventsCount % 50;
        $endOfRow = 0 === $remainder;
        $lastRow = $eventsCount === $this->examplesCount;

        if ($lastRow && !$endOfRow) {
            $io->write(str_repeat(' ', 50 - $remainder));
        }

        if ($lastRow || $endOfRow) {
<<<<<<< HEAD
            $length = strlen((string) $this->examplesCount);
=======
            $length = \strlen((string) $this->examplesCount);
>>>>>>> v2-test
            $format = sprintf(' %%%dd / %%%dd', $length, $length);

            $io->write(sprintf($format, $eventsCount, $this->examplesCount));

            if ($eventsCount !== $this->examplesCount) {
                $io->writeln();
            }
        }
    }

    /**
     * @param SuiteEvent $event
     */
    public function afterSuite(SuiteEvent $event)
    {
        $this->getIO()->writeln("\n");

        $this->outputExceptions();
        $this->outputSuiteSummary($event);
    }

<<<<<<< HEAD
    private function outputExceptions()
=======
    private function outputExceptions(): void
>>>>>>> v2-test
    {
        $stats = $this->getStatisticsCollector();
        $notPassed = array_filter(array(
            'failed' => $stats->getFailedEvents(),
            'broken' => $stats->getBrokenEvents(),
            'pending' => $stats->getPendingEvents(),
            'skipped' => $stats->getSkippedEvents(),
        ));

        foreach ($notPassed as $events) {
            array_map(array($this, 'printException'), $events);
        }
    }

<<<<<<< HEAD
    private function outputSuiteSummary(SuiteEvent $event)
=======
    private function outputSuiteSummary(SuiteEvent $event): void
>>>>>>> v2-test
    {
        $this->outputTotalSpecCount();
        $this->outputTotalExamplesCount();
        $this->outputSpecificExamplesCount();

        $this->getIO()->writeln(sprintf("\n%sms", round($event->getTime() * 1000)));
    }

    private function plural($count)
    {
        return $count !== 1 ? 's' : '';
    }

<<<<<<< HEAD
    private function outputTotalSpecCount()
=======
    private function outputTotalSpecCount(): void
>>>>>>> v2-test
    {
        $count = $this->getStatisticsCollector()->getTotalSpecs();
        $this->getIO()->writeln(sprintf("%d spec%s", $count, $this->plural($count)));
    }

<<<<<<< HEAD
    private function outputTotalExamplesCount()
=======
    private function outputTotalExamplesCount(): void
>>>>>>> v2-test
    {
        $count = $this->getStatisticsCollector()->getEventsCount();
        $this->getIO()->write(sprintf("%d example%s ", $count, $this->plural($count)));
    }

<<<<<<< HEAD
    private function outputSpecificExamplesCount()
=======
    private function outputSpecificExamplesCount(): void
>>>>>>> v2-test
    {
        $typesWithEvents = array_filter($this->getStatisticsCollector()->getCountsHash());

        $counts = array();
        foreach ($typesWithEvents as $type => $count) {
            $counts[] = sprintf('<%s>%d %s</%s>', $type, $count, $type, $type);
        }

<<<<<<< HEAD
        if (count($counts)) {
=======
        if (\count($counts)) {
>>>>>>> v2-test
            $this->getIO()->write(sprintf("(%s)", implode(', ', $counts)));
        }
    }
}
