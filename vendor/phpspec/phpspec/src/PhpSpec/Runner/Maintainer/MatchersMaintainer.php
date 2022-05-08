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

namespace PhpSpec\Runner\Maintainer;

use PhpSpec\Loader\Node\ExampleNode;
<<<<<<< HEAD
use PhpSpec\Matcher\MatcherInterface;
use PhpSpec\SpecificationInterface;
use PhpSpec\Runner\MatcherManager;
use PhpSpec\Runner\CollaboratorManager;
use PhpSpec\Formatter\Presenter\PresenterInterface;
use PhpSpec\Matcher;

class MatchersMaintainer implements MaintainerInterface
{
    /**
     * @var PresenterInterface
=======
use PhpSpec\Matcher\CallbackMatcher;
use PhpSpec\Matcher\Matcher;
use PhpSpec\Matcher\MatchersProvider;
use PhpSpec\Specification;
use PhpSpec\Runner\MatcherManager;
use PhpSpec\Runner\CollaboratorManager;
use PhpSpec\Formatter\Presenter\Presenter;

final class MatchersMaintainer implements Maintainer
{
    /**
     * @var Presenter
>>>>>>> v2-test
     */
    private $presenter;

    /**
<<<<<<< HEAD
     * @var MatcherInterface[]
=======
     * @var Matcher[]
>>>>>>> v2-test
     */
    private $defaultMatchers = array();

    /**
<<<<<<< HEAD
     * @param PresenterInterface $presenter
     * @param MatcherInterface[] $matchers
     */
    public function __construct(PresenterInterface $presenter, array $matchers)
    {
        $this->presenter = $presenter;
        $this->defaultMatchers = $matchers;
        @usort($this->defaultMatchers, function ($matcher1, $matcher2) {
=======
     * @param Presenter $presenter
     * @param Matcher[] $matchers
     */
    public function __construct(Presenter $presenter, array $matchers)
    {
        $this->presenter = $presenter;
        $this->defaultMatchers = $matchers;
        @usort($this->defaultMatchers, function (Matcher $matcher1, Matcher $matcher2) {
>>>>>>> v2-test
            return $matcher2->getPriority() - $matcher1->getPriority();
        });
    }

    /**
     * @param ExampleNode $example
     *
     * @return bool
     */
<<<<<<< HEAD
    public function supports(ExampleNode $example)
=======
    public function supports(ExampleNode $example): bool
>>>>>>> v2-test
    {
        return true;
    }

    /**
     * @param ExampleNode            $example
<<<<<<< HEAD
     * @param SpecificationInterface $context
=======
     * @param Specification $context
>>>>>>> v2-test
     * @param MatcherManager         $matchers
     * @param CollaboratorManager    $collaborators
     */
    public function prepare(
        ExampleNode $example,
<<<<<<< HEAD
        SpecificationInterface $context,
        MatcherManager $matchers,
        CollaboratorManager $collaborators
    ) {

        $matchers->replace($this->defaultMatchers);

        if (!$context instanceof Matcher\MatchersProviderInterface) {
=======
        Specification $context,
        MatcherManager $matchers,
        CollaboratorManager $collaborators
    ): void {

        $matchers->replace($this->defaultMatchers);

        if (!$context instanceof MatchersProvider) {
>>>>>>> v2-test
            return;
        }

        foreach ($context->getMatchers() as $name => $matcher) {
<<<<<<< HEAD
            if ($matcher instanceof Matcher\MatcherInterface) {
                $matchers->add($matcher);
            } else {
                $matchers->add(new Matcher\CallbackMatcher(
=======
            if ($matcher instanceof Matcher) {
                $matchers->add($matcher);
            } else {
                $matchers->add(new CallbackMatcher(
>>>>>>> v2-test
                    $name,
                    $matcher,
                    $this->presenter
                ));
            }
        }
    }

    /**
     * @param ExampleNode            $example
<<<<<<< HEAD
     * @param SpecificationInterface $context
=======
     * @param Specification $context
>>>>>>> v2-test
     * @param MatcherManager         $matchers
     * @param CollaboratorManager    $collaborators
     */
    public function teardown(
        ExampleNode $example,
<<<<<<< HEAD
        SpecificationInterface $context,
        MatcherManager $matchers,
        CollaboratorManager $collaborators
    ) {
=======
        Specification $context,
        MatcherManager $matchers,
        CollaboratorManager $collaborators
    ): void {
>>>>>>> v2-test
    }

    /**
     * @return int
     */
<<<<<<< HEAD
    public function getPriority()
=======
    public function getPriority(): int
>>>>>>> v2-test
    {
        return 50;
    }
}
