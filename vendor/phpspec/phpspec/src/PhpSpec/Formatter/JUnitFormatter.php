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
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Event\SuiteEvent;
use PhpSpec\Event\SpecificationEvent;

/**
 * The JUnit Formatter
 *
 * @author Gildas Quemener <gildas.quemener@gmail.com>
 */
<<<<<<< HEAD
class JUnitFormatter extends BasicFormatter
=======
final class JUnitFormatter extends BasicFormatter
>>>>>>> v2-test
{
    /** @var array */
    protected $testCaseNodes = array();

    /** @var array */
    protected $testSuiteNodes = array();

    /** @var array */
    protected $exampleStatusCounts = array();

    /** @var array */
    protected $jUnitStatuses = array(
        ExampleEvent::PASSED  => 'passed',
        ExampleEvent::PENDING => 'pending',
        ExampleEvent::SKIPPED => 'skipped',
        ExampleEvent::FAILED  => 'failed',
        ExampleEvent::BROKEN  => 'broken',
    );

    /** @var array */
    protected $resultTags = array(
        ExampleEvent::FAILED  => 'failure',
        ExampleEvent::BROKEN  => 'error',
        ExampleEvent::SKIPPED => 'skipped',
    );

<<<<<<< HEAD
    public function __construct(PresenterInterface $presenter, IO $io, StatisticsCollector $stats)
=======
    public function __construct(Presenter $presenter, IO $io, StatisticsCollector $stats)
>>>>>>> v2-test
    {
        parent::__construct($presenter, $io, $stats);

        $this->initTestCaseNodes();
    }

    /**
     * Set testcase nodes
     *
     * @param array $testCaseNodes
     */
<<<<<<< HEAD
    public function setTestCaseNodes(array $testCaseNodes)
=======
    public function setTestCaseNodes(array $testCaseNodes): void
>>>>>>> v2-test
    {
        $this->testCaseNodes = $testCaseNodes;
    }

    /**
     * Get testcase nodes
     *
     * @return array
     */
<<<<<<< HEAD
    public function getTestCaseNodes()
=======
    public function getTestCaseNodes(): array
>>>>>>> v2-test
    {
        return $this->testCaseNodes;
    }

    /**
     * Set testsuite nodes
     *
     * @param array $testSuiteNodes
     */
    public function setTestSuiteNodes(array $testSuiteNodes)
    {
        $this->testSuiteNodes = $testSuiteNodes;
    }

    /**
     * Get testsuite nodes
     *
     * @return array
     */
<<<<<<< HEAD
    public function getTestSuiteNodes()
=======
    public function getTestSuiteNodes(): array
>>>>>>> v2-test
    {
        return $this->testSuiteNodes;
    }

    /**
     * Set example status counts
     *
     * @param array $exampleStatusCounts
     */
    public function setExampleStatusCounts(array $exampleStatusCounts)
    {
        $this->exampleStatusCounts = $exampleStatusCounts;
    }

    /**
     * Get example status counts
     *
     * @return array
     */
<<<<<<< HEAD
    public function getExampleStatusCounts()
=======
    public function getExampleStatusCounts(): array
>>>>>>> v2-test
    {
        return $this->exampleStatusCounts;
    }

    /**
     * {@inheritdoc}
     */
    public function afterExample(ExampleEvent $event)
    {
        $testCaseNode = sprintf(
            '<testcase name="%s" time="%F" classname="%s" status="%s"',
            $event->getTitle(),
            $event->getTime(),
            $event->getSpecification()->getClassReflection()->getName(),
            $this->jUnitStatuses[$event->getResult()]
        );

        $this->exampleStatusCounts[$event->getResult()]++;

<<<<<<< HEAD
        if (in_array($event->getResult(), array(ExampleEvent::BROKEN, ExampleEvent::FAILED))) {
=======
        if (\in_array($event->getResult(), array(ExampleEvent::BROKEN, ExampleEvent::FAILED))) {
>>>>>>> v2-test
            $exception = $event->getException();
            $testCaseNode .= sprintf(
                '>'."\n".
                '<%s type="%s" message="%s" />'."\n".
                '<system-err>'."\n".
                '<![CDATA['."\n".
                '%s'."\n".
                ']]>'."\n".
                '</system-err>'."\n".
                '</testcase>',
                $this->resultTags[$event->getResult()],
<<<<<<< HEAD
                get_class($exception),
=======
                \get_class($exception),
>>>>>>> v2-test
                htmlspecialchars($exception->getMessage()),
                $exception->getTraceAsString()
            );
        } elseif (ExampleEvent::SKIPPED === $event->getResult()) {
            $testCaseNode .= sprintf(
                '>'."\n".
                '\<skipped><![CDATA[ %s ]]>\</skipped>'."\n".
                '</testcase>',
                htmlspecialchars($event->getException()->getMessage())
            );
        } else {
            $testCaseNode .= ' />';
        }

        $this->testCaseNodes[] = $testCaseNode;
    }

    /**
     * {@inheritdoc}
     */
    public function afterSpecification(SpecificationEvent $event)
    {
        $this->testSuiteNodes[] = sprintf(
            '<testsuite name="%s" time="%F" tests="%s" failures="%s" errors="%s" skipped="%s">'."\n".
            '%s'."\n".
            '</testsuite>',
            $event->getTitle(),
            $event->getTime(),
<<<<<<< HEAD
            count($this->testCaseNodes),
=======
            \count($this->testCaseNodes),
>>>>>>> v2-test
            $this->exampleStatusCounts[ExampleEvent::FAILED],
            $this->exampleStatusCounts[ExampleEvent::BROKEN],
            $this->exampleStatusCounts[ExampleEvent::PENDING] + $this->exampleStatusCounts[ExampleEvent::SKIPPED],
            implode("\n", $this->testCaseNodes)
        );

        $this->initTestCaseNodes();
    }

    /**
     * {@inheritdoc}
     */
    public function afterSuite(SuiteEvent $event)
    {
        $stats = $this->getStatisticsCollector();

        $output = sprintf(
            '<?xml version="1.0" encoding="UTF-8" ?>' . "\n" .
            '<testsuites time="%F" tests="%s" failures="%s" errors="%s">' . "\n" .
            '%s' . "\n" .
            '</testsuites>',
            $event->getTime(),
            $stats->getEventsCount(),
<<<<<<< HEAD
            count($stats->getFailedEvents()),
            count($stats->getBrokenEvents()),
            implode("\n", $this->testSuiteNodes)
        );

        $this->getIo()->write($output);
=======
            \count($stats->getFailedEvents()),
            \count($stats->getBrokenEvents()),
            implode("\n", $this->testSuiteNodes)
        );

        $this->getIO()->write($output);
>>>>>>> v2-test
    }

    /**
     * Initialize test case nodes and example status counts
     */
<<<<<<< HEAD
    protected function initTestCaseNodes()
=======
    protected function initTestCaseNodes(): void
>>>>>>> v2-test
    {
        $this->testCaseNodes       = array();
        $this->exampleStatusCounts = array(
            ExampleEvent::PASSED  => 0,
            ExampleEvent::PENDING => 0,
            ExampleEvent::SKIPPED => 0,
            ExampleEvent::FAILED  => 0,
            ExampleEvent::BROKEN  => 0,
        );
    }
}
