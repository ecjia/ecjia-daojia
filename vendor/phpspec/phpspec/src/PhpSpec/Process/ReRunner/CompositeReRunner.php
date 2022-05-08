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

use PhpSpec\Process\ReRunner;

<<<<<<< HEAD
class CompositeReRunner implements ReRunner
=======
final class CompositeReRunner implements ReRunner
>>>>>>> v2-test
{
    /**
     * @var ReRunner
     */
    private $reRunner;

    /**
     * @param PlatformSpecificReRunner[] $reRunners
     */
    public function __construct(array $reRunners)
    {
        foreach ($reRunners as $reRunner) {
            if ($reRunner->isSupported()) {
                $this->reRunner = $reRunner;
                break;
            }
        }
    }

<<<<<<< HEAD
    public function reRunSuite()
=======
    public function reRunSuite(): void
>>>>>>> v2-test
    {
        $this->reRunner->reRunSuite();
    }
}
