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

use PhpSpec\Exception\Exception;

abstract class AbstractPhpSpecExceptionPresenter
{
    /**
     * @param Exception $exception
     * @return string
     */
<<<<<<< HEAD
    public function presentException(Exception $exception)
=======
    public function presentException(Exception $exception): string
>>>>>>> v2-test
    {
        list($file, $line) = $this->getExceptionExamplePosition($exception);

        return $this->presentFileCode($file, $line);
    }

    /**
     * @param Exception $exception
     * @return array
     */
<<<<<<< HEAD
    private function getExceptionExamplePosition(Exception $exception)
=======
    private function getExceptionExamplePosition(Exception $exception): array
>>>>>>> v2-test
    {
        $cause = $exception->getCause();

        foreach ($exception->getTrace() as $call) {
            if (!isset($call['file'])) {
                continue;
            }

<<<<<<< HEAD
            if (!empty($cause) && $cause->getFilename() === $call['file']) {
=======
            if (!empty($cause) && $cause->getFileName() === $call['file']) {
>>>>>>> v2-test
                return array($call['file'], $call['line']);
            }
        }

        return array($exception->getFile(), $exception->getLine());
    }

    /**
     * @param string  $file
     * @param integer $lineno
     * @param integer $context
     *
     * @return string
     */
<<<<<<< HEAD
    abstract protected function presentFileCode($file, $lineno, $context = 6);
=======
    abstract protected function presentFileCode(string $file, int $lineno, int $context = 6): string;
>>>>>>> v2-test
}
