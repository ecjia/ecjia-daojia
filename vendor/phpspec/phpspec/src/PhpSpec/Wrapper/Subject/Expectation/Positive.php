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
use PhpSpec\Matcher\MatcherInterface;

class Positive implements ExpectationInterface
{
    /**
     * @var MatcherInterface
=======
use PhpSpec\Matcher\Matcher;

final class Positive implements Expectation
{
    /**
     * @var Matcher
>>>>>>> v2-test
     */
    private $matcher;

    /**
<<<<<<< HEAD
     * @param MatcherInterface $matcher
     */
    public function __construct(MatcherInterface $matcher)
=======
     * @param Matcher $matcher
     */
    public function __construct(Matcher $matcher)
>>>>>>> v2-test
    {
        $this->matcher = $matcher;
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
        return $this->matcher->positiveMatch($alias, $subject, $arguments);
    }
}
