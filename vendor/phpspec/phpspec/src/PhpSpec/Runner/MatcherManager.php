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

namespace PhpSpec\Runner;

<<<<<<< HEAD
use PhpSpec\Matcher\MatcherInterface;
use PhpSpec\Exception\Wrapper\MatcherNotFoundException;
use PhpSpec\Formatter\Presenter\PresenterInterface;
=======
use PhpSpec\Matcher\Matcher;
use PhpSpec\Exception\Wrapper\MatcherNotFoundException;
use PhpSpec\Formatter\Presenter\Presenter;
>>>>>>> v2-test

class MatcherManager
{
    /**
<<<<<<< HEAD
     * @var PresenterInterface
     */
    private $presenter;
    /**
     * @var MatcherInterface[]
=======
     * @var Presenter
     */
    private $presenter;
    /**
     * @var Matcher[]
>>>>>>> v2-test
     */
    private $matchers = array();

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
<<<<<<< HEAD
     * @param MatcherInterface $matcher
     */
    public function add(MatcherInterface $matcher)
    {
        $this->matchers[] = $matcher;
        @usort($this->matchers, function ($matcher1, $matcher2) {
=======
     * @param Matcher $matcher
     */
    public function add(Matcher $matcher): void
    {
        $this->matchers[] = $matcher;
        @usort($this->matchers, function (Matcher $matcher1, Matcher $matcher2) {
>>>>>>> v2-test
            return $matcher2->getPriority() - $matcher1->getPriority();
        });
    }

    /**
     * Replaces matchers with an already-sorted list
     *
<<<<<<< HEAD
     * @param MatcherInterface[] $matchers
     */
    public function replace(array $matchers)
=======
     * @param Matcher[] $matchers
     */
    public function replace(array $matchers): void
>>>>>>> v2-test
    {
        $this->matchers = $matchers;
    }

    /**
     * @param string $keyword
     * @param mixed  $subject
     * @param array  $arguments
     *
<<<<<<< HEAD
     * @return MatcherInterface
     *
     * @throws \PhpSpec\Exception\Wrapper\MatcherNotFoundException
     */
    public function find($keyword, $subject, array $arguments)
=======
     * @return Matcher
     *
     * @throws \PhpSpec\Exception\Wrapper\MatcherNotFoundException
     */
    public function find(string $keyword, $subject, array $arguments): Matcher
>>>>>>> v2-test
    {
        foreach ($this->matchers as $matcher) {
            if (true === $matcher->supports($keyword, $subject, $arguments)) {
                return $matcher;
            }
        }

        throw new MatcherNotFoundException(
            sprintf(
                'No %s(%s) matcher found for %s.',
                $this->presenter->presentString($keyword),
                $this->presenter->presentValue($arguments),
                $this->presenter->presentValue($subject)
            ),
            $keyword,
            $subject,
            $arguments
        );
    }
}
