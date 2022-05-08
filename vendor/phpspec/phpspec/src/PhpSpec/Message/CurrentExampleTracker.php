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

namespace PhpSpec\Message;

final class CurrentExampleTracker
{
    private $currentExample;

<<<<<<< HEAD
    public function setCurrentExample($currentExample)
=======
    public function setCurrentExample(string $currentExample = null)
>>>>>>> v2-test
    {
        $this->currentExample = $currentExample;
    }

<<<<<<< HEAD
    public function getCurrentExample()
=======
    public function getCurrentExample() : ?string
>>>>>>> v2-test
    {
        return $this->currentExample;
    }
}
