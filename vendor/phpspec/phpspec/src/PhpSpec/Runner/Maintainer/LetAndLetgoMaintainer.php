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
use PhpSpec\SpecificationInterface;
use PhpSpec\Runner\MatcherManager;
use PhpSpec\Runner\CollaboratorManager;

class LetAndLetgoMaintainer implements MaintainerInterface
=======
use PhpSpec\Specification;
use PhpSpec\Runner\MatcherManager;
use PhpSpec\Runner\CollaboratorManager;

class LetAndLetgoMaintainer implements Maintainer
>>>>>>> v2-test
{
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
        return $example->getSpecification()->getClassReflection()->hasMethod('let')
            || $example->getSpecification()->getClassReflection()->hasMethod('letgo')
        ;
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
=======
        Specification $context,
        MatcherManager $matchers,
        CollaboratorManager $collaborators
    ): void {
>>>>>>> v2-test
        if (!$example->getSpecification()->getClassReflection()->hasMethod('let')) {
            return;
        }

        $reflection = $example->getSpecification()->getClassReflection()->getMethod('let');
        $reflection->invokeArgs($context, $collaborators->getArgumentsFor($reflection));
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
        if (!$example->getSpecification()->getClassReflection()->hasMethod('letgo')) {
            return;
        }

        $reflection = $example->getSpecification()->getClassReflection()->getMethod('letgo');
        $reflection->invokeArgs($context, $collaborators->getArgumentsFor($reflection));
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
        return 10;
    }
}
