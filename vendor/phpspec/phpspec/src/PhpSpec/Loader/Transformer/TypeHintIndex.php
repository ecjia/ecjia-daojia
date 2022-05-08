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

namespace PhpSpec\Loader\Transformer;

interface TypeHintIndex
{
    /**
     * @param string $class
     * @param string $method
     * @param string $argument
     * @param string $typehint
     */
<<<<<<< HEAD
    public function add($class, $method, $argument, $typehint);
=======
    public function add(string $class, string $method, string $argument, string $typehint): void;
>>>>>>> v2-test

    /**
     * @param string $class
     * @param string $method
     * @param string $argument
<<<<<<< HEAD
     * @param Exception $exception
     */
    public function addInvalid($class, $method, $argument, \Exception $exception);
=======
     * @param \Exception $exception
     */
    public function addInvalid(string $class, string $method, string $argument, \Exception $exception): void;
>>>>>>> v2-test

    /**
     * @param string $class
     * @param string $method
     * @param string $argument
<<<<<<< HEAD
     * @return string
     */
    public function lookup($class, $method, $argument);
=======
     *
     * @return string|null
     */
    public function lookup(string $class, string $method, string $argument);
>>>>>>> v2-test
}
