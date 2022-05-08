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
use PhpSpec\IO\IOInterface as IO;
use PhpSpec\Formatter\Presenter\PresenterInterface;
=======
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\IO\IO;
>>>>>>> v2-test
use PhpSpec\Listener\StatisticsCollector;
use PhpSpec\Event\SuiteEvent;
use PhpSpec\Event\SpecificationEvent;
use PhpSpec\Event\ExampleEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

abstract class BasicFormatter implements EventSubscriberInterface
{
    /**
     * @var IO
     */
    private $io;

    /**
<<<<<<< HEAD
     * @var PresenterInterface
=======
     * @var Presenter
>>>>>>> v2-test
     */
    private $presenter;

    /**
     * @var StatisticsCollector
     */
    private $stats;

<<<<<<< HEAD
    public function __construct(PresenterInterface $presenter, IO $io, StatisticsCollector $stats)
=======
    public function __construct(Presenter $presenter, IO $io, StatisticsCollector $stats)
>>>>>>> v2-test
    {
        $this->presenter = $presenter;
        $this->io = $io;
        $this->stats = $stats;
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
        $events = array(
            'beforeSuite', 'afterSuite',
            'beforeExample', 'afterExample',
            'beforeSpecification', 'afterSpecification'
        );

        return array_combine($events, $events);
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
<<<<<<< HEAD
     * @return PresenterInterface
     */
    protected function getPresenter()
=======
     * @return Presenter
     */
    protected function getPresenter(): Presenter
>>>>>>> v2-test
    {
        return $this->presenter;
    }

    /**
     * @return StatisticsCollector
     */
<<<<<<< HEAD
    protected function getStatisticsCollector()
=======
    protected function getStatisticsCollector(): StatisticsCollector
>>>>>>> v2-test
    {
        return $this->stats;
    }

    /**
     * @param SuiteEvent $event
     */
    public function beforeSuite(SuiteEvent $event)
    {
    }

    /**
     * @param SuiteEvent $event
     */
    public function afterSuite(SuiteEvent $event)
    {
    }

    /**
     * @param ExampleEvent $event
     */
    public function beforeExample(ExampleEvent $event)
    {
    }

    /**
     * @param ExampleEvent $event
     */
    public function afterExample(ExampleEvent $event)
    {
    }

    /**
     * @param SpecificationEvent $event
     */
    public function beforeSpecification(SpecificationEvent $event)
    {
    }

    /**
     * @param SpecificationEvent $event
     */
    public function afterSpecification(SpecificationEvent $event)
    {
    }
}
