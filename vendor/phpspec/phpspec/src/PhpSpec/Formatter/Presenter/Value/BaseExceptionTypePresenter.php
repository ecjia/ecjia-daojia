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

<<<<<<< HEAD
=======
use PhpSpec\Exception\ErrorException;

>>>>>>> v2-test
final class BaseExceptionTypePresenter implements ExceptionTypePresenter
{
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
        return $value instanceof \Exception;
    }

    /**
     * @param mixed $value
     * @return string
     */
<<<<<<< HEAD
    public function present($value)
    {
        return sprintf(
            '[exc:%s("%s")]',
            get_class($value),
            $value->getMessage()
=======
    public function present($value): string
    {
        $label = 'exc';
        $message = $value->getMessage();

        if ($value instanceof ErrorException) {
            $value = $value->getPrevious();
            $label = 'err';
        }

        if ($value instanceof \ParseError) {
            $message = sprintf(
                '%s in "%s" on line %d',
                $value->getMessage(),
                $value->getFile(),
                $value->getLine()
            );
        }

        return sprintf(
            '[%s:%s("%s")]',
            $label,
            \get_class($value),
            $message
>>>>>>> v2-test
        );
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
        return 60;
    }
}
