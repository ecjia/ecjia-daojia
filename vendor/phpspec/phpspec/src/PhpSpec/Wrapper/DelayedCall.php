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

namespace PhpSpec\Wrapper;

class DelayedCall
{
    /**
     * @var callable
     */
    private $callable;

    /**
     * @param callable $callable
     */
<<<<<<< HEAD
    public function __construct($callable)
=======
    public function __construct(callable $callable)
>>>>>>> v2-test
    {
        $this->callable = $callable;
    }

    /**
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
<<<<<<< HEAD
    public function __call($method, array $arguments)
    {
        return call_user_func($this->callable, $method, $arguments);
=======
    public function __call(string $method, array $arguments)
    {
        return \call_user_func($this->callable, $method, $arguments);
>>>>>>> v2-test
    }
}
