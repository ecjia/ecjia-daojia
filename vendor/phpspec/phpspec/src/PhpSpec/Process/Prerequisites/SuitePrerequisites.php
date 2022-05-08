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

namespace PhpSpec\Process\Prerequisites;

<<<<<<< HEAD
use PhpSpec\Process\Context\ExecutionContextInterface;

final class SuitePrerequisites implements SuitePrerequisitesInterface
{
    /**
     * @var ExecutionContextInterface
=======
use PhpSpec\Process\Context\ExecutionContext;

final class SuitePrerequisites implements PrerequisiteTester
{
    /**
     * @var ExecutionContext
>>>>>>> v2-test
     */
    private $executionContext;

    /**
<<<<<<< HEAD
     * @param ExecutionContextInterface $executionContext
     */
    public function __construct(ExecutionContextInterface $executionContext)
=======
     * @param ExecutionContext $executionContext
     */
    public function __construct(ExecutionContext $executionContext)
>>>>>>> v2-test
    {
        $this->executionContext = $executionContext;
    }

    /**
     * @throws PrerequisiteFailedException
     */
<<<<<<< HEAD
    public function guardPrerequisites()
=======
    public function guardPrerequisites(): void
>>>>>>> v2-test
    {
        $undefinedTypes = array();

        foreach ($this->executionContext->getGeneratedTypes() as $type) {
            if (!class_exists($type) && !interface_exists($type)) {
                $undefinedTypes[] = $type;
            }
        }

        if ($undefinedTypes) {
            throw new PrerequisiteFailedException(sprintf(
                "The type%s %s %s generated but could not be loaded. Do you need to configure an autoloader?\n",
<<<<<<< HEAD
                count($undefinedTypes) > 1 ? 's' : '',
                join(', ', $undefinedTypes),
                count($undefinedTypes) > 1 ? 'were' : 'was'
=======
                \count($undefinedTypes) > 1 ? 's' : '',
                join(', ', $undefinedTypes),
                \count($undefinedTypes) > 1 ? 'were' : 'was'
>>>>>>> v2-test
            ));
        }
    }
}
