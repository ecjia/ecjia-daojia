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

namespace PhpSpec\Formatter\Presenter\Value;

use PhpSpec\Formatter\Presenter\Presenter;

final class CallableTypePresenter implements TypePresenter
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
     * @param mixed $value
     * @return bool
     */
<<<<<<< HEAD
    public function supports($value)
=======
    public function supports($value): bool
>>>>>>> v2-test
    {
        return is_callable($value);
    }

    /**
     * @param mixed $value
     * @return string
     */
<<<<<<< HEAD
    public function present($value)
    {
        if (is_array($value)) {
            $type = is_object($value[0]) ? $this->presenter->presentValue($value[0]) : $value[0];
=======
    public function present($value): string
    {
        if (\is_array($value)) {
            $type = \is_object($value[0]) ? $this->presenter->presentValue($value[0]) : $value[0];
>>>>>>> v2-test
            return sprintf('%s::%s()', $type, $value[1]);
        }

        if ($value instanceof \Closure) {
            return '[closure]';
        }

<<<<<<< HEAD
        if (is_object($value)) {
            return sprintf('[obj:%s]', get_class($value));
=======
        if (\is_object($value)) {
            return sprintf('[obj:%s]', \get_class($value));
>>>>>>> v2-test
        }

        return sprintf('[%s()]', $value);
    }

    /**
     * @return int
     */
<<<<<<< HEAD
    public function getPriority()
=======
    public function getPriority(): int
>>>>>>> v2-test
    {
        return 70;
    }
}
