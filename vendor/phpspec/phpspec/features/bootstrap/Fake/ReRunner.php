<?php

namespace Fake;

use PhpSpec\Process\ReRunner as BaseReRunner;

class ReRunner implements BaseReRunner
{
    private $hasBeenReRun = false;

    /**
     * @return boolean
     */
    public function isSupported()
    {
        return true;
    }

<<<<<<< HEAD
    public function reRunSuite()
=======
    public function reRunSuite() : void
>>>>>>> v2-test
    {
        $this->hasBeenReRun = true;
    }

    public function hasBeenReRun()
    {
        return $this->hasBeenReRun;
    }
}
