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

namespace PhpSpec\Wrapper\Subject\Expectation;

<<<<<<< HEAD
interface ThrowExpectation
=======
interface ThrowExpectation extends Expectation
>>>>>>> v2-test
{
    /**
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
<<<<<<< HEAD
    public function during($method, array $arguments = array());
=======
    public function during(string $method, array $arguments = array());
>>>>>>> v2-test
}
