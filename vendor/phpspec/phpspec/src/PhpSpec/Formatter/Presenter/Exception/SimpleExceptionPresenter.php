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

namespace PhpSpec\Formatter\Presenter\Exception;

use PhpSpec\Exception\Example\ErrorException;
use PhpSpec\Exception\Example\NotEqualException;
use PhpSpec\Exception\Example\PendingException;
use PhpSpec\Exception\Exception as PhpSpecException;
use PhpSpec\Formatter\Presenter\Differ\Differ;
use Prophecy\Exception\Call\UnexpectedCallException;
use Prophecy\Exception\Exception as ProphecyException;

final class SimpleExceptionPresenter implements ExceptionPresenter
{
    /**
     * @var Differ
     */
    private $differ;

    /**
     * @var string
     */
    private $phpspecPath;

    /**
     * @var string
     */
    private $runnerPath;

    /**
     * @var ExceptionElementPresenter
     */
    private $exceptionElementPresenter;

    /**
     * @var CallArgumentsPresenter
     */
    private $callArgumentsPresenter;

    /**
     * @var PhpSpecExceptionPresenter
     */
    private $phpspecExceptionPresenter;

    /**
     * @param Differ $differ
     * @param ExceptionElementPresenter $exceptionElementPresenter
     * @param CallArgumentsPresenter $callArgumentsPresenter
     * @param PhpSpecExceptionPresenter $phpspecExceptionPresenter
     */
    public function __construct(
        Differ $differ,
        ExceptionElementPresenter $exceptionElementPresenter,
        CallArgumentsPresenter $callArgumentsPresenter,
        PhpSpecExceptionPresenter $phpspecExceptionPresenter
    ) {
        $this->differ = $differ;
        $this->exceptionElementPresenter = $exceptionElementPresenter;
        $this->callArgumentsPresenter = $callArgumentsPresenter;
        $this->phpspecExceptionPresenter = $phpspecExceptionPresenter;

        $this->phpspecPath = dirname(dirname(__DIR__));
        $this->runnerPath  = $this->phpspecPath.DIRECTORY_SEPARATOR.'Runner';
    }

    /**
     * @param \Exception $exception
     * @param bool $verbose
     * @return string
     */
<<<<<<< HEAD
    public function presentException(\Exception $exception, $verbose = false)
=======
    public function presentException(\Exception $exception, bool $verbose = false): string
>>>>>>> v2-test
    {
        if ($exception instanceof PhpSpecException) {
            $presentation = wordwrap($exception->getMessage(), 120);
        } elseif ($exception instanceof ProphecyException) {
            $presentation = $exception->getMessage();
        } else {
            $presentation = $this->exceptionElementPresenter->presentExceptionThrownMessage($exception);
        }

        if (!$verbose || $exception instanceof PendingException) {
            return $presentation;
        }

        return $this->getVerbosePresentation($exception, $presentation);
    }

    /**
     * @param \Exception $exception
     * @param string $presentation
     * @return string
     */
<<<<<<< HEAD
    private function getVerbosePresentation(\Exception $exception, $presentation)
=======
    private function getVerbosePresentation(\Exception $exception, string $presentation): string
>>>>>>> v2-test
    {
        if ($exception instanceof NotEqualException) {
            if ($diff = $this->presentExceptionDifference($exception)) {
                $presentation .= PHP_EOL . $diff;
            }
        }

        if ($exception instanceof PhpSpecException && !$exception instanceof ErrorException) {
            $presentation .= PHP_EOL . $this->phpspecExceptionPresenter->presentException($exception);
        }

        if ($exception instanceof UnexpectedCallException) {
            $presentation .= $this->callArgumentsPresenter->presentDifference($exception);
        }

        return $presentation . $this->presentExceptionStackTrace($exception);
    }

    /**
     * @param NotEqualException $exception
     *
     * @return string
     */
<<<<<<< HEAD
    private function presentExceptionDifference(NotEqualException $exception)
    {
        return $this->differ->compare($exception->getExpected(), $exception->getActual());
=======
    private function presentExceptionDifference(NotEqualException $exception): string
    {
        $diff = $this->differ->compare($exception->getExpected(), $exception->getActual());

        return $diff === null ? '' : $diff;
>>>>>>> v2-test
    }

    /**
     * @param \Exception $exception
     *
     * @return string
     */
<<<<<<< HEAD
    private function presentExceptionStackTrace(\Exception $exception)
=======
    private function presentExceptionStackTrace(\Exception $exception): string
>>>>>>> v2-test
    {
        $offset = 0;
        $text = '';

        $text .= $this->presentExceptionTraceLocation($offset++, $exception->getFile(), $exception->getLine());
        $text .= $this->presentExceptionTraceFunction(
<<<<<<< HEAD
            'throw new '.get_class($exception),
=======
            'throw new '.\get_class($exception),
>>>>>>> v2-test
            array($exception->getMessage())
        );

        foreach ($exception->getTrace() as $call) {
            // skip internal framework calls
            if ($this->shouldStopTracePresentation($call)) {
                break;
            }
            if ($this->shouldSkipTracePresentation($call)) {
                continue;
            }

            $text .= $this->presentExceptionTraceDetails($call, $offset++);
        }

        return empty($text) ? $text : PHP_EOL . $text;
    }

    /**
     * @param string $header
     *
     * @return string
     */
<<<<<<< HEAD
    private function presentExceptionTraceHeader($header)
=======
    private function presentExceptionTraceHeader(string $header): string
>>>>>>> v2-test
    {
        return $this->exceptionElementPresenter->presentExceptionTraceHeader($header) . PHP_EOL;
    }

    /**
     * @param string $class
     * @param string $type
     * @param string $method
     * @param array  $args
     *
     * @return string
     */
<<<<<<< HEAD
    private function presentExceptionTraceMethod($class, $type, $method, array $args)
=======
    private function presentExceptionTraceMethod(string $class, string $type, string $method, array $args): string
>>>>>>> v2-test
    {
        return $this->exceptionElementPresenter->presentExceptionTraceMethod($class, $type, $method, $args) . PHP_EOL;
    }

    /**
     * @param string $function
     * @param array  $args
     *
     * @return string
     */
<<<<<<< HEAD
    private function presentExceptionTraceFunction($function, array $args)
=======
    private function presentExceptionTraceFunction(string $function, array $args): string
>>>>>>> v2-test
    {
        return $this->exceptionElementPresenter->presentExceptionTraceFunction($function, $args) . PHP_EOL;
    }

    /**
     * @param int    $offset
     * @param string $file
     * @param int    $line
     *
     * @return string
     */
<<<<<<< HEAD
    private function presentExceptionTraceLocation($offset, $file, $line)
=======
    private function presentExceptionTraceLocation(int $offset, string $file, int $line): string
>>>>>>> v2-test
    {
        return $this->presentExceptionTraceHeader(sprintf(
            "%2d %s:%d",
            $offset,
            str_replace(getcwd().DIRECTORY_SEPARATOR, '', $file),
            $line
        ));
    }

    /**
     * @param array $call
     * @return bool
     */
<<<<<<< HEAD
    private function shouldStopTracePresentation(array $call)
=======
    private function shouldStopTracePresentation(array $call): bool
>>>>>>> v2-test
    {
        return isset($call['file']) && false !== strpos($call['file'], $this->runnerPath);
    }

    /**
     * @param array $call
     * @return bool
     */
<<<<<<< HEAD
    private function shouldSkipTracePresentation(array $call)
=======
    private function shouldSkipTracePresentation(array $call): bool
>>>>>>> v2-test
    {
        if (isset($call['file']) && 0 === strpos($call['file'], $this->phpspecPath)) {
            return true;
        }

        return isset($call['class']) && 0 === strpos($call['class'], "PhpSpec\\");
    }

    /**
     * @param array $call
     * @param int $offset
     * @return string
     */
<<<<<<< HEAD
    private function presentExceptionTraceDetails(array $call, $offset)
=======
    private function presentExceptionTraceDetails(array $call, int $offset): string
>>>>>>> v2-test
    {
        $text = '';

        if (isset($call['file'])) {
            $text .= $this->presentExceptionTraceLocation($offset, $call['file'], $call['line']);
        } else {
            $text .= $this->presentExceptionTraceHeader(sprintf("%2d [internal]", $offset));
        }

        if (!isset($call['args'])) {
            $call['args'] = array();
        }

        if (isset($call['class'])) {
            $text .= $this->presentExceptionTraceMethod(
                $call['class'],
                $call['type'],
                $call['function'],
                $call['args']
            );
        } elseif (isset($call['function'])) {
            $text .= $this->presentExceptionTraceFunction(
                $call['function'],
                $call['args']
            );
        }

        return $text;
    }

}
