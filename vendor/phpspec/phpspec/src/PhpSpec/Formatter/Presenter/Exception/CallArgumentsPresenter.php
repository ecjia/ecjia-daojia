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

namespace PhpSpec\Formatter\Presenter\Exception;

use PhpSpec\Formatter\Presenter\Differ\Differ;
use Prophecy\Argument\Token\ExactValueToken;
use Prophecy\Exception\Call\UnexpectedCallException;
use Prophecy\Prophecy\MethodProphecy;

class CallArgumentsPresenter
{
    /**
     * @var Differ
     */
    private $differ;

    /**
     * @param Differ $differ
     */
    public function __construct(Differ $differ)
    {
        $this->differ = $differ;
    }

    /**
     * @param UnexpectedCallException $exception
     * @return string
     */
<<<<<<< HEAD
    public function presentDifference(UnexpectedCallException $exception)
=======
    public function presentDifference(UnexpectedCallException $exception): string
>>>>>>> v2-test
    {
        $actualArguments = $exception->getArguments();
        $methodProphecies = $exception->getObjectProphecy()->getMethodProphecies($exception->getMethodName());

        if ($this->noMethodPropheciesForUnexpectedCall($methodProphecies)) {
            return '';
        }

        $presentedMethodProphecy = $this->findFirstUnexpectedArgumentsCallProphecy($methodProphecies, $exception);
<<<<<<< HEAD
        if (is_null($presentedMethodProphecy)) {
=======
        if (\is_null($presentedMethodProphecy)) {
>>>>>>> v2-test
            return '';
        }

        $expectedTokens = $presentedMethodProphecy->getArgumentsWildcard()->getTokens();
        if ($this->parametersCountMismatch($expectedTokens, $actualArguments)) {
            return '';
        }

        $expectedArguments = $this->convertArgumentTokensToDiffableValues($expectedTokens);
        $text = $this->generateArgumentsDifferenceText($actualArguments, $expectedArguments);

        return $text;
    }

    /**
     * @param MethodProphecy[] $methodProphecies
     * @return bool
     */
<<<<<<< HEAD
    private function noMethodPropheciesForUnexpectedCall(array $methodProphecies)
    {
        return count($methodProphecies) === 0;
=======
    private function noMethodPropheciesForUnexpectedCall(array $methodProphecies): bool
    {
        return \count($methodProphecies) === 0;
>>>>>>> v2-test
    }

    /**
     * @param MethodProphecy[] $methodProphecies
     * @param UnexpectedCallException $exception
     *
<<<<<<< HEAD
     * @return MethodProphecy
=======
     * @return MethodProphecy|null
>>>>>>> v2-test
     */
    private function findFirstUnexpectedArgumentsCallProphecy(
        array $methodProphecies,
        UnexpectedCallException $exception
<<<<<<< HEAD
    ) {
=======
    ){
>>>>>>> v2-test
        $objectProphecy = $exception->getObjectProphecy();

        foreach ($methodProphecies as $methodProphecy) {
            $calls = $objectProphecy->findProphecyMethodCalls(
                $exception->getMethodName(),
                $methodProphecy->getArgumentsWildcard()
            );

<<<<<<< HEAD
            if (count($calls)) {
=======
            if (\count($calls)) {
>>>>>>> v2-test
                continue;
            }

            return $methodProphecy;
        }
<<<<<<< HEAD
=======

        return null;
>>>>>>> v2-test
    }

    /**
     * @param array $expectedTokens
     * @param array $actualArguments
     *
     * @return bool
     */
<<<<<<< HEAD
    private function parametersCountMismatch(array $expectedTokens, array $actualArguments)
    {
        return count($expectedTokens) !== count($actualArguments);
=======
    private function parametersCountMismatch(array $expectedTokens, array $actualArguments): bool
    {
        return \count($expectedTokens) !== \count($actualArguments);
>>>>>>> v2-test
    }

    /**
     * @param array $tokens
     *
     * @return array
     */
<<<<<<< HEAD
    private function convertArgumentTokensToDiffableValues(array $tokens)
=======
    private function convertArgumentTokensToDiffableValues(array $tokens): array
>>>>>>> v2-test
    {
        $values = array();
        foreach ($tokens as $token) {
            if ($token instanceof ExactValueToken) {
                $values[] = $token->getValue();
            } else {
                $values[] = (string)$token;
            }
        }

        return $values;
    }

    /**
     * @param array $actualArguments
     * @param array $expectedArguments
     *
     * @return string
     */
<<<<<<< HEAD
    private function generateArgumentsDifferenceText(array $actualArguments, array $expectedArguments)
=======
    private function generateArgumentsDifferenceText(array $actualArguments, array $expectedArguments): string
>>>>>>> v2-test
    {
        $text = '';
        foreach($actualArguments as $i => $actualArgument) {
            $expectedArgument = $expectedArguments[$i];
<<<<<<< HEAD
            $actualArgument = is_null($actualArgument) ? 'null' : $actualArgument;
            $expectedArgument = is_null($expectedArgument) ? 'null' : $expectedArgument;
=======
            $actualArgument = \is_null($actualArgument) ? 'null' : $actualArgument;
            $expectedArgument = \is_null($expectedArgument) ? 'null' : $expectedArgument;
>>>>>>> v2-test

            $text .= $this->differ->compare($expectedArgument, $actualArgument);
        }

        return $text;
    }
}
