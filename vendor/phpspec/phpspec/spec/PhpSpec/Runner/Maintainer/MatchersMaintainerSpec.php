<?php

namespace spec\PhpSpec\Runner\Maintainer;

<<<<<<< HEAD
use PhpSpec\Formatter\Presenter\PresenterInterface;
use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\Matcher\MatcherInterface;
use PhpSpec\ObjectBehavior;
use PhpSpec\Runner\CollaboratorManager;
use PhpSpec\Runner\MatcherManager;
use PhpSpec\SpecificationInterface;
use Prophecy\Argument;
=======
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\Matcher\Matcher;
use PhpSpec\ObjectBehavior;
use PhpSpec\Runner\CollaboratorManager;
use PhpSpec\Runner\MatcherManager;
use PhpSpec\Specification;
>>>>>>> v2-test

class MatchersMaintainerSpec extends ObjectBehavior
{
    function it_should_add_default_matchers_to_the_matcher_manager(
<<<<<<< HEAD
        PresenterInterface $presenter, ExampleNode $example, SpecificationInterface $context,
        MatcherManager $matchers, CollaboratorManager $collaborators, MatcherInterface $matcher)
=======
        Presenter $presenter, ExampleNode $example, Specification $context,
        MatcherManager $matchers, CollaboratorManager $collaborators, Matcher $matcher)
>>>>>>> v2-test
    {
        $this->beConstructedWith($presenter, array($matcher));
        $this->prepare($example, $context, $matchers, $collaborators);

        $matchers->replace(array($matcher))->shouldHaveBeenCalled();
    }
}
