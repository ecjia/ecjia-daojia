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

<<<<<<< HEAD
final class TaggingPresenter implements PresenterInterface
=======
final class TaggingPresenter implements Presenter
>>>>>>> v2-test
{
    /**
     * @var Presenter
     */
    private $presenter;

    /**
     * @param Presenter $presenter
     */
    public function __construct(Presenter $presenter)
    {
        $this->presenter = $presenter;
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
        return $this->presenter->presentException($exception, $verbose);
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
        return sprintf('<value>%s</value>', $string);
    }

    /**
     * @param mixed $value
     * @return string
     */
<<<<<<< HEAD
    public function presentValue($value)
=======
    public function presentValue($value): string
>>>>>>> v2-test
    {
        return $this->presentString($this->presenter->presentValue($value));
    }
}
