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

use PhpSpec\Event\SuiteEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Event\SpecificationEvent;

class StatisticsCollector implements EventSubscriberInterface
{
    private $globalResult    = 0;
    private $totalSpecs      = 0;
    private $totalSpecsCount = 0;

    private $passedEvents  = array();
    private $pendingEvents = array();
    private $skippedEvents = array();
    private $failedEvents  = array();
    private $brokenEvents  = array();

    public static function getSubscribedEvents()
    {
        return array(
            'afterSpecification' => array('afterSpecification', 10),
            'afterExample'       => array('afterExample', 10),
            'beforeSuite'       => array('beforeSuite', 10),

        );
    }

<<<<<<< HEAD
    public function afterSpecification(SpecificationEvent $event)
=======
    public function afterSpecification(SpecificationEvent $event): void
>>>>>>> v2-test
    {
        $this->totalSpecs++;
    }

<<<<<<< HEAD
    public function afterExample(ExampleEvent $event)
=======
    public function afterExample(ExampleEvent $event): void
>>>>>>> v2-test
    {
        $this->globalResult = max($this->globalResult, $event->getResult());

        switch ($event->getResult()) {
            case ExampleEvent::PASSED:
                $this->passedEvents[] = $event;
                break;
            case ExampleEvent::PENDING:
                $this->pendingEvents[] = $event;
                break;
            case ExampleEvent::SKIPPED:
                $this->skippedEvents[] = $event;
                break;
            case ExampleEvent::FAILED:
                $this->failedEvents[] = $event;
                break;
            case ExampleEvent::BROKEN:
                $this->brokenEvents[] = $event;
                break;
        }
    }

<<<<<<< HEAD
    public function beforeSuite(SuiteEvent $suiteEvent)
    {
        $this->totalSpecsCount = count($suiteEvent->getSuite()->getSpecifications());
    }

    public function getGlobalResult()
=======
    public function beforeSuite(SuiteEvent $suiteEvent): void
    {
        $this->totalSpecsCount = \count($suiteEvent->getSuite()->getSpecifications());
    }

    public function getGlobalResult() : int
>>>>>>> v2-test
    {
        return $this->globalResult;
    }

<<<<<<< HEAD
    public function getAllEvents()
=======
    public function getAllEvents() : array
>>>>>>> v2-test
    {
        return array_merge(
            $this->passedEvents,
            $this->pendingEvents,
            $this->skippedEvents,
            $this->failedEvents,
            $this->brokenEvents
        );
    }

<<<<<<< HEAD
    public function getPassedEvents()
=======
    public function getPassedEvents() : array
>>>>>>> v2-test
    {
        return $this->passedEvents;
    }

<<<<<<< HEAD
    public function getPendingEvents()
=======
    public function getPendingEvents() : array
>>>>>>> v2-test
    {
        return $this->pendingEvents;
    }

<<<<<<< HEAD
    public function getSkippedEvents()
=======
    public function getSkippedEvents() : array
>>>>>>> v2-test
    {
        return $this->skippedEvents;
    }

<<<<<<< HEAD
    public function getFailedEvents()
=======
    public function getFailedEvents() : array
>>>>>>> v2-test
    {
        return $this->failedEvents;
    }

<<<<<<< HEAD
    public function getBrokenEvents()
=======
    public function getBrokenEvents() : array
>>>>>>> v2-test
    {
        return $this->brokenEvents;
    }

<<<<<<< HEAD
    public function getCountsHash()
    {
        return array(
            'passed'  => count($this->getPassedEvents()),
            'pending' => count($this->getPendingEvents()),
            'skipped' => count($this->getSkippedEvents()),
            'failed'  => count($this->getFailedEvents()),
            'broken'  => count($this->getBrokenEvents()),
        );
    }

    public function getTotalSpecs()
=======
    public function getCountsHash() : array
    {
        return array(
            'passed'  => \count($this->getPassedEvents()),
            'pending' => \count($this->getPendingEvents()),
            'skipped' => \count($this->getSkippedEvents()),
            'failed'  => \count($this->getFailedEvents()),
            'broken'  => \count($this->getBrokenEvents()),
        );
    }

    public function getTotalSpecs() : int
>>>>>>> v2-test
    {
        return $this->totalSpecs;
    }

<<<<<<< HEAD
    public function getEventsCount()
    {
        return count($this->getAllEvents());
    }

    public function getTotalSpecsCount()
=======
    public function getEventsCount() : int
    {
        return array_sum($this->getCountsHash());
    }

    public function getTotalSpecsCount() : int
>>>>>>> v2-test
    {
        return $this->totalSpecsCount;
    }
}
