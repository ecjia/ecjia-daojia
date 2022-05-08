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

use PhpSpec\Exception\Example\FailureException;
<<<<<<< HEAD
use PhpSpec\Formatter\Presenter\PresenterInterface;
=======
use PhpSpec\Formatter\Presenter\Presenter;
>>>>>>> v2-test

final class StringContainMatcher extends BasicMatcher
{
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
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function supports($name, $subject, array $arguments)
    {
        return 'contain' === $name
            && is_string($subject)
            && 1 === count($arguments)
            && is_string($arguments[0]);
=======
    public function supports(string $name, $subject, array $arguments): bool
    {
        return 'contain' === $name
            && \is_string($subject)
            && 1 === \count($arguments)
            && \is_string($arguments[0]);
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    protected function matches($subject, array $arguments)
=======
    protected function matches($subject, array $arguments): bool
>>>>>>> v2-test
    {
        return false !== strpos($subject, $arguments[0]);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    protected function getFailureException($name, $subject, array $arguments)
=======
    protected function getFailureException(string $name, $subject, array $arguments): FailureException
>>>>>>> v2-test
    {
        return new FailureException(sprintf(
            'Expected %s to contain %s, but it does not.',
            $this->presenter->presentString($subject),
            $this->presenter->presentString($arguments[0])
        ));
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    protected function getNegativeFailureException($name, $subject, array $arguments)
=======
    protected function getNegativeFailureException(string $name, $subject, array $arguments): FailureException
>>>>>>> v2-test
    {
        return new FailureException(sprintf(
            'Expected %s not to contain %s, but it does.',
            $this->presenter->presentString($subject),
            $this->presenter->presentString($arguments[0])
        ));
    }
}
