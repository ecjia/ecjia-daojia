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

final class TruncatingStringTypePresenter implements StringTypePresenter
{
    /**
     * @var StringTypePresenter
     */
    private $stringTypePresenter;

    public function __construct(StringTypePresenter $stringTypePresenter)
    {
        $this->stringTypePresenter = $stringTypePresenter;
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
        return $this->stringTypePresenter->supports($value);
    }

    /**
     * @param mixed $value
     * @return string
     */
<<<<<<< HEAD
    public function present($value)
    {
        if (25 > strlen($value) && false === strpos($value, "\n")) {
=======
    public function present($value): string
    {
        if (25 > \strlen($value) && false === strpos($value, "\n")) {
>>>>>>> v2-test
            return $this->stringTypePresenter->present($value);
        }

        $lines = explode("\n", $value);
        return $this->stringTypePresenter->present(sprintf('%s...', substr($lines[0], 0, 25)));
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
        return $this->stringTypePresenter->getPriority();
    }
}
