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
=======
use PhpSpec\Specification;
>>>>>>> v2-test
use PhpSpec\Runner\MatcherManager;
use PhpSpec\Runner\CollaboratorManager;
use PhpSpec\Exception\Example as ExampleException;

<<<<<<< HEAD
class ErrorMaintainer implements MaintainerInterface
=======
final class ErrorMaintainer implements Maintainer
>>>>>>> v2-test
{
    /**
     * @var integer
     */
    private $errorLevel;
    /**
     * @var callable|null
     */
    private $errorHandler;

    /**
     * @param integer $errorLevel
     */
<<<<<<< HEAD
    public function __construct($errorLevel)
=======
    public function __construct(int $errorLevel)
>>>>>>> v2-test
    {
        $this->errorLevel = $errorLevel;
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
=======
        Specification $context,
        MatcherManager $matchers,
        CollaboratorManager $collaborators
    ): void {
>>>>>>> v2-test
        $this->errorHandler = set_error_handler(array($this, 'errorHandler'), $this->errorLevel);
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
        if (null !== $this->errorHandler) {
            set_error_handler($this->errorHandler);
        }
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
        return 999;
    }

    /**
     * Custom error handler.
     *
     * This method used as custom error handler when step is running.
     *
     * @see set_error_handler()
     *
     * @param integer $level
     * @param string  $message
     * @param string  $file
     * @param integer $line
     *
<<<<<<< HEAD
     * @return Boolean
     *
     * @throws ExampleException\ErrorException
     */
    final public function errorHandler($level, $message, $file, $line)
=======
     * @return bool
     *
     * @throws ExampleException\ErrorException
     */
    final public function errorHandler(int $level, string $message, string $file, int $line): bool
>>>>>>> v2-test
    {
        $regex = '/^Argument (\d)+ passed to (?:(?P<class>[\w\\\]+)::)?(\w+)\(\)' .
                 ' must (?:be an instance of|implement interface) ([\w\\\]+),(?: instance of)? ([\w\\\]+) given/';

        if (E_RECOVERABLE_ERROR === $level && preg_match($regex, $message, $matches)) {
            $class = $matches['class'];

<<<<<<< HEAD
            if (in_array('PhpSpec\SpecificationInterface', class_implements($class))) {
=======
            if (\in_array('PhpSpec\Specification', class_implements($class))) {
>>>>>>> v2-test
                return true;
            }
        }

        if (0 !== error_reporting()) {
            throw new ExampleException\ErrorException($level, $message, $file, $line);
        }

        // error reporting turned off or more likely suppressed with @
        return false;
    }
}
