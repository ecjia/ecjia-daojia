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

final class ObjectTypePresenter implements TypePresenter
{
    /**
     * @param mixed $value
     * @return bool
     */
<<<<<<< HEAD
    public function supports($value)
    {
        return 'object' === strtolower(gettype($value));
=======
    public function supports($value): bool
    {
        return 'object' === strtolower(\gettype($value));
>>>>>>> v2-test
    }

    /**
     * @param mixed $value
     * @return string
     */
<<<<<<< HEAD
    public function present($value)
    {
        return sprintf('[obj:%s]', get_class($value));
=======
    public function present($value): string
    {
        return sprintf('[obj:%s]', \get_class($value));
>>>>>>> v2-test
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
        return 30;
    }
}
