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

namespace PhpSpec\Formatter\Html;

use PhpSpec\Event\ExampleEvent;
<<<<<<< HEAD
use PhpSpec\Formatter\Presenter\PresenterInterface;
=======
use PhpSpec\Formatter\Presenter\Presenter;
>>>>>>> v2-test
use PhpSpec\Formatter\Template as TemplateInterface;

class ReportItemFactory
{
    /**
     * @var TemplateInterface
     */
    private $template;

    /**
     * @param TemplateInterface $template
     */
    public function __construct(TemplateInterface $template)
    {
        $this->template = $template;
    }

    /**
<<<<<<< HEAD
     * @param ExampleEvent       $event
     * @param PresenterInterface $presenter
     *
     * @return ReportFailedItem|ReportPassedItem|ReportPendingItem
     */
    public function create(ExampleEvent $event, PresenterInterface $presenter)
=======
     * @param ExampleEvent $event
     * @param Presenter    $presenter
     *
     * @return ReportFailedItem|ReportPassedItem|ReportPendingItem|ReportSkippedItem
     */
    public function create(ExampleEvent $event, Presenter $presenter)
>>>>>>> v2-test
    {
        switch ($event->getResult()) {
            case ExampleEvent::PASSED:
                return new ReportPassedItem($this->template, $event);
            case ExampleEvent::PENDING:
                return new ReportPendingItem($this->template, $event);
            case ExampleEvent::SKIPPED:
                return new ReportSkippedItem($this->template, $event);
            case ExampleEvent::FAILED:
            case ExampleEvent::BROKEN:
                return new ReportFailedItem($this->template, $event, $presenter);
            default:
                $this->invalidResultException($event->getResult());
        }
    }

    /**
     * @param integer $result
     *
     * @throws InvalidExampleResultException
     */
<<<<<<< HEAD
    private function invalidResultException($result)
=======
    private function invalidResultException(int $result): void
>>>>>>> v2-test
    {
        throw new InvalidExampleResultException(
            "Unrecognised example result $result"
        );
    }
}
