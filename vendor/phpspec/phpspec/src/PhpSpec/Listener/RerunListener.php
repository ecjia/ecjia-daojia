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
<<<<<<< HEAD
use PhpSpec\Process\Prerequisites\SuitePrerequisitesInterface;
use PhpSpec\Process\ReRunner;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RerunListener implements EventSubscriberInterface
=======
use PhpSpec\Process\Prerequisites\PrerequisiteTester;
use PhpSpec\Process\ReRunner;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class RerunListener implements EventSubscriberInterface
>>>>>>> v2-test
{
    /**
     * @var ReRunner
     */
    private $reRunner;

    /**
<<<<<<< HEAD
     * @var SuitePrerequisitesInterface
=======
     * @var PrerequisiteTester
>>>>>>> v2-test
     */
    private $suitePrerequisites;

    /**
     * @param ReRunner $reRunner
<<<<<<< HEAD
     * @param SuitePrerequisitesInterface $suitePrerequisites
     */
    public function __construct(ReRunner $reRunner, SuitePrerequisitesInterface $suitePrerequisites)
=======
     * @param PrerequisiteTester $suitePrerequisites
     */
    public function __construct(ReRunner $reRunner, PrerequisiteTester $suitePrerequisites)
>>>>>>> v2-test
    {
        $this->reRunner = $reRunner;
        $this->suitePrerequisites = $suitePrerequisites;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            'beforeSuite' => array('beforeSuite', 1000),
            'afterSuite' => array('afterSuite', -1000)
        );
    }

    /**
     * @param SuiteEvent $suiteEvent
     */
<<<<<<< HEAD
    public function beforeSuite(SuiteEvent $suiteEvent)
=======
    public function beforeSuite(SuiteEvent $suiteEvent): void
>>>>>>> v2-test
    {
        $this->suitePrerequisites->guardPrerequisites();
    }

    /**
     * @param SuiteEvent $suiteEvent
     */
<<<<<<< HEAD
    public function afterSuite(SuiteEvent $suiteEvent)
=======
    public function afterSuite(SuiteEvent $suiteEvent): void
>>>>>>> v2-test
    {
        if ($suiteEvent->isWorthRerunning()) {
            $this->reRunner->reRunSuite();
        }
    }
}
