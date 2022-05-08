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

namespace PhpSpec\Process\ReRunner;

<<<<<<< HEAD
use PhpSpec\Console\IO;
use PhpSpec\Process\ReRunner;

class OptionalReRunner implements ReRunner
{
    /**
     * @var IO
=======
use PhpSpec\Console\ConsoleIO;
use PhpSpec\Process\ReRunner;

final class OptionalReRunner implements ReRunner
{
    /**
     * @var ConsoleIO
>>>>>>> v2-test
     */
    private $io;
    /**
     * @var ReRunner
     */
    private $decoratedRerunner;

    /**
<<<<<<< HEAD
     * @param IO $io
     */
    public function __construct(ReRunner $decoratedRerunner, IO $io)
=======
     * @param ConsoleIO $io
     */
    public function __construct(ReRunner $decoratedRerunner, ConsoleIO $io)
>>>>>>> v2-test
    {
        $this->io = $io;
        $this->decoratedRerunner = $decoratedRerunner;
    }

<<<<<<< HEAD
    public function reRunSuite()
=======
    public function reRunSuite(): void
>>>>>>> v2-test
    {
        if ($this->io->isRerunEnabled()) {
            $this->decoratedRerunner->reRunSuite();
        }
    }
}
