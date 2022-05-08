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

use PhpSpec\Wrapper\Unwrapper;

<<<<<<< HEAD
class UnwrapDecorator extends Decorator implements ExpectationInterface
=======
final class UnwrapDecorator extends Decorator implements Expectation
>>>>>>> v2-test
{
    /**
     * @var Unwrapper
     */
    private $unwrapper;

    /**
<<<<<<< HEAD
     * @param ExpectationInterface $expectation
     * @param Unwrapper            $unwrapper
     */
    public function __construct(ExpectationInterface $expectation, Unwrapper $unwrapper)
    {
        $this->setExpectation($expectation);
=======
     * @param Expectation $expectation
     * @param Unwrapper            $unwrapper
     */
    public function __construct(Expectation $expectation, Unwrapper $unwrapper)
    {
        parent::__construct($expectation);
>>>>>>> v2-test
        $this->unwrapper = $unwrapper;
    }

    /**
     * @param string $alias
     * @param mixed  $subject
     * @param array  $arguments
     *
     * @return mixed
     */
<<<<<<< HEAD
    public function match($alias, $subject, array $arguments = array())
=======
    public function match(string $alias, $subject, array $arguments = array())
>>>>>>> v2-test
    {
        $arguments = $this->unwrapper->unwrapAll($arguments);

        return $this->getExpectation()->match($alias, $subject, $arguments);
    }
}
