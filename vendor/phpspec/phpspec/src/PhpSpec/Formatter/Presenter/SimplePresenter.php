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

namespace PhpSpec\Formatter\Presenter;

use PhpSpec\Formatter\Presenter\Exception\ExceptionPresenter;
use PhpSpec\Formatter\Presenter\Value\ValuePresenter;

<<<<<<< HEAD
final class SimplePresenter implements PresenterInterface
=======
final class SimplePresenter implements Presenter
>>>>>>> v2-test
{
    /**
     * @var ValuePresenter
     */
    private $valuePresenter;

    /**
     * @var ExceptionPresenter
     */
    private $exceptionPresenter;

    /**
     * @param ValuePresenter $valuePresenter
     * @param ExceptionPresenter $exceptionPresenter
     */
    public function __construct(ValuePresenter $valuePresenter, ExceptionPresenter $exceptionPresenter)
    {
        $this->valuePresenter = $valuePresenter;
        $this->exceptionPresenter = $exceptionPresenter;
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
<<<<<<< HEAD
    public function presentValue($value)
=======
    public function presentValue($value): string
>>>>>>> v2-test
    {
        return $this->valuePresenter->presentValue($value);
    }

    /**
     * @param \Exception $exception
     * @param bool $verbose
     *
     * @return string
     */
<<<<<<< HEAD
    public function presentException(\Exception $exception, $verbose = false)
=======
    public function presentException(\Exception $exception, bool $verbose = false): string
>>>>>>> v2-test
    {
        return $this->exceptionPresenter->presentException($exception, $verbose);
    }

    /**
     * @param string $string
     *
     * @return string
     */
<<<<<<< HEAD
    public function presentString($string)
=======
    public function presentString(string $string): string
>>>>>>> v2-test
    {
        return $string;
    }
}
