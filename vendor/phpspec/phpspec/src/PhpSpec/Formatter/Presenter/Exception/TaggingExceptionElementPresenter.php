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

use PhpSpec\Formatter\Presenter\Value\ExceptionTypePresenter;
use PhpSpec\Formatter\Presenter\Value\ValuePresenter;

final class TaggingExceptionElementPresenter implements ExceptionElementPresenter
{
    /**
     * @var ExceptionTypePresenter
     */
    private $exceptionTypePresenter;

    /**
     * @var ValuePresenter
     */
    private $valuePresenter;

    /**
     * @param ExceptionTypePresenter $exceptionTypePresenter
     * @param ValuePresenter $valuePresenter
     */
    public function __construct(ExceptionTypePresenter $exceptionTypePresenter, ValuePresenter $valuePresenter)
    {
        $this->exceptionTypePresenter = $exceptionTypePresenter;
        $this->valuePresenter = $valuePresenter;
    }

    /**
     * @param \Exception $exception
     * @return string
     */
<<<<<<< HEAD
    public function presentExceptionThrownMessage(\Exception $exception)
=======
    public function presentExceptionThrownMessage(\Exception $exception): string
>>>>>>> v2-test
    {
        return sprintf(
            'Exception <label>%s</label> has been thrown.',
            $this->exceptionTypePresenter->present($exception)
        );
    }

    /**
     * @param string $number
     * @param string $line
     * @return string
     */
<<<<<<< HEAD
    public function presentCodeLine($number, $line)
=======
    public function presentCodeLine(string $number, string $line): string
>>>>>>> v2-test
    {
        return sprintf('<lineno>%s</lineno> <code>%s</code>', $number, $line);
    }

    /**
     * @param string $line
     * @return string
     */
<<<<<<< HEAD
    public function presentHighlight($line)
=======
    public function presentHighlight(string $line): string
>>>>>>> v2-test
    {
        return sprintf('<hl>%s</hl>', $line);
    }

    /**
     * @param string $header
     * @return string
     */
<<<<<<< HEAD
    public function presentExceptionTraceHeader($header)
=======
    public function presentExceptionTraceHeader(string $header): string
>>>>>>> v2-test
    {
        return sprintf('<trace>%s</trace>', $header);
    }

    /**
     * @param string $class
     * @param string $type
     * @param string $method
     * @param array $args
     * @return string
     */
<<<<<<< HEAD
    public function presentExceptionTraceMethod($class, $type, $method, array $args)
=======
    public function presentExceptionTraceMethod(string $class, string $type, string $method, array $args): string
>>>>>>> v2-test
    {
        $template = '   <trace><trace-class>%s</trace-class><trace-type>%s</trace-type>'.
            '<trace-func>%s</trace-func>(<trace-args>%s</trace-args>)</trace>';

        return sprintf($template, $class, $type, $method, $this->presentExceptionTraceArguments($args));
    }

    /**
     * @param string $function
     * @param array $args
     * @return string
     */
<<<<<<< HEAD
    public function presentExceptionTraceFunction($function, array $args)
=======
    public function presentExceptionTraceFunction(string $function, array $args): string
>>>>>>> v2-test
    {
        $template = '   <trace><trace-func>%s</trace-func>(<trace-args>%s</trace-args>)</trace>';

        return sprintf($template, $function, $this->presentExceptionTraceArguments($args));
    }

    /**
     * @param array $args
<<<<<<< HEAD
     * @return array
     */
    private function presentExceptionTraceArguments(array $args)
=======
     * @return string
     */
    private function presentExceptionTraceArguments(array $args): string
>>>>>>> v2-test
    {
        $valuePresenter = $this->valuePresenter;

        $taggedArgs = array_map(function ($arg) use ($valuePresenter) {
            return sprintf('<value>%s</value>', $valuePresenter->presentValue($arg));
        }, $args);

        return implode(', ', $taggedArgs);
    }
}
