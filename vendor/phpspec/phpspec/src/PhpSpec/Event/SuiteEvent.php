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

namespace PhpSpec\Event;

use PhpSpec\Loader\Suite;
<<<<<<< HEAD
use Symfony\Component\EventDispatcher\Event;
=======
>>>>>>> v2-test

/**
 * Class SuiteEvent holds information about the suite event
 */
<<<<<<< HEAD
class SuiteEvent extends Event implements EventInterface
=======
class SuiteEvent extends BaseEvent implements PhpSpecEvent
>>>>>>> v2-test
{
    /**
     * @var Suite
     */
    private $suite;

    /**
     * @var float
     */
    private $time;

    /**
     * @var integer
     */
    private $result;

    /**
     * @var boolean
     */
    private $worthRerunning = false;

    /**
     * @param Suite   $suite
     * @param float   $time
     * @param integer $result
     */
<<<<<<< HEAD
    public function __construct(Suite $suite, $time = null, $result = null)
=======
    public function __construct(Suite $suite, float $time = 0.0, int $result = 0)
>>>>>>> v2-test
    {
        $this->suite  = $suite;
        $this->time   = $time;
        $this->result = $result;
    }

    /**
     * @return Suite
     */
<<<<<<< HEAD
    public function getSuite()
=======
    public function getSuite(): Suite
>>>>>>> v2-test
    {
        return $this->suite;
    }

    /**
     * @return float
     */
<<<<<<< HEAD
    public function getTime()
=======
    public function getTime(): float
>>>>>>> v2-test
    {
        return $this->time;
    }

    /**
     * @return integer
     */
<<<<<<< HEAD
    public function getResult()
=======
    public function getResult(): int
>>>>>>> v2-test
    {
        return $this->result;
    }

    /**
     * @return bool
     */
<<<<<<< HEAD
    public function isWorthRerunning()
=======
    public function isWorthRerunning(): bool
>>>>>>> v2-test
    {
        return $this->worthRerunning;
    }

<<<<<<< HEAD
    public function markAsWorthRerunning()
=======
    public function markAsWorthRerunning(): void
>>>>>>> v2-test
    {
        $this->worthRerunning = true;
    }

<<<<<<< HEAD
    public function markAsNotWorthRerunning()
=======
    public function markAsNotWorthRerunning(): void
>>>>>>> v2-test
    {
        $this->worthRerunning = false;
    }
}
