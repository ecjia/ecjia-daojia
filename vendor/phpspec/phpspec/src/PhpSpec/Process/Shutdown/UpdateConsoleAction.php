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

namespace PhpSpec\Process\Shutdown;

use PhpSpec\Formatter\FatalPresenter;
use PhpSpec\Message\CurrentExampleTracker;

<<<<<<< HEAD
final class UpdateConsoleAction implements ShutdownActionInterface
=======
final class UpdateConsoleAction implements ShutdownAction
>>>>>>> v2-test
{
    /**
     * @var CurrentExampleTracker
     */
    private $currentExample;

    /**
<<<<<<< HEAD
     * @var CurrentExampleWriter
=======
     * @var FatalPresenter
>>>>>>> v2-test
     */
    private $currentExampleWriter;

    public function __construct(CurrentExampleTracker $currentExample, FatalPresenter $currentExampleWriter)
    {
        $this->currentExample = $currentExample;
        $this->currentExampleWriter = $currentExampleWriter;
    }

<<<<<<< HEAD
    public function runAction($error)
=======
    public function runAction($error): void
>>>>>>> v2-test
    {
        $this->currentExampleWriter->displayFatal($this->currentExample, $error);
    }
}
