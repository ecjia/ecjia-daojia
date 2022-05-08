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

namespace PhpSpec\Matcher;

<<<<<<< HEAD
use PhpSpec\Formatter\Presenter\PresenterInterface;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Exception\Example\NotEqualException;

class IdentityMatcher extends BasicMatcher
=======
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Exception\Example\NotEqualException;

final class IdentityMatcher extends BasicMatcher
>>>>>>> v2-test
{
    /**
     * @var array
     */
    private static $keywords = array(
        'return',
        'be',
        'equal',
        'beEqualTo'
    );
    /**
<<<<<<< HEAD
     * @var PresenterInterface
=======
     * @var Presenter
>>>>>>> v2-test
     */
    private $presenter;

    /**
<<<<<<< HEAD
     * @param PresenterInterface $presenter
     */
    public function __construct(PresenterInterface $presenter)
=======
     * @param Presenter $presenter
     */
    public function __construct(Presenter $presenter)
>>>>>>> v2-test
    {
        $this->presenter = $presenter;
    }

    /**
     * @param string $name
     * @param mixed  $subject
     * @param array  $arguments
     *
     * @return bool
     */
<<<<<<< HEAD
    public function supports($name, $subject, array $arguments)
    {
        return in_array($name, self::$keywords)
            && 1 == count($arguments)
=======
    public function supports(string $name, $subject, array $arguments): bool
    {
        return \in_array($name, self::$keywords)
            && 1 == \count($arguments)
>>>>>>> v2-test
        ;
    }

    /**
     * @param mixed $subject
     * @param array $arguments
     *
     * @return bool
     */
<<<<<<< HEAD
    protected function matches($subject, array $arguments)
=======
    protected function matches($subject, array $arguments): bool
>>>>>>> v2-test
    {
        return $subject === $arguments[0];
    }

    /**
     * @param string $name
     * @param mixed  $subject
     * @param array  $arguments
     *
<<<<<<< HEAD
     * @return NotEqualException
     */
    protected function getFailureException($name, $subject, array $arguments)
=======
     * @return FailureException
     */
    protected function getFailureException(string $name, $subject, array $arguments): FailureException
>>>>>>> v2-test
    {
        return new NotEqualException(sprintf(
            'Expected %s, but got %s.',
            $this->presenter->presentValue($arguments[0]),
            $this->presenter->presentValue($subject)
        ), $arguments[0], $subject);
    }

    /**
     * @param string $name
     * @param mixed  $subject
     * @param array  $arguments
     *
     * @return FailureException
     */
<<<<<<< HEAD
    protected function getNegativeFailureException($name, $subject, array $arguments)
=======
    protected function getNegativeFailureException(string $name, $subject, array $arguments): FailureException
>>>>>>> v2-test
    {
        return new FailureException(sprintf(
            'Did not expect %s, but got one.',
            $this->presenter->presentValue($subject)
        ));
    }
}
