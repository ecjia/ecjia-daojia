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
abstract class Decorator implements ExpectationInterface
{
    /**
     * @var ExpectationInterface
=======
abstract class Decorator implements Expectation
{
    /**
     * @var Expectation
>>>>>>> v2-test
     */
    private $expectation;

    /**
<<<<<<< HEAD
     * @param ExpectationInterface $expectation
     */
    public function __construct(ExpectationInterface $expectation)
=======
     * @param Expectation $expectation
     */
    public function __construct(Expectation $expectation)
>>>>>>> v2-test
    {
        $this->expectation = $expectation;
    }

    /**
<<<<<<< HEAD
     * @return ExpectationInterface
     */
    public function getExpectation()
=======
     * @return Expectation
     */
    public function getExpectation(): Expectation
>>>>>>> v2-test
    {
        return $this->expectation;
    }

    /**
<<<<<<< HEAD
     * @param ExpectationInterface $expectation
     */
    protected function setExpectation(ExpectationInterface $expectation)
=======
     * @param Expectation $expectation
     */
    protected function setExpectation(Expectation $expectation): void
>>>>>>> v2-test
    {
        $this->expectation = $expectation;
    }

    /**
<<<<<<< HEAD
     * @return ExpectationInterface
     */
    public function getNestedExpectation()
=======
     * @return Expectation
     */
    public function getNestedExpectation(): Expectation
>>>>>>> v2-test
    {
        $expectation = $this->getExpectation();
        while ($expectation instanceof Decorator) {
            $expectation = $expectation->getExpectation();
        }

        return $expectation;
    }
}
