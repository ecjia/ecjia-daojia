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

namespace PhpSpec\CodeAnalysis;

final class StaticRejectingNamespaceResolver implements NamespaceResolver
{
    /**
     * @var NamespaceResolver
     */
    private $namespaceResolver;

    public function __construct(NamespaceResolver $namespaceResolver)
    {
        $this->namespaceResolver = $namespaceResolver;
    }

<<<<<<< HEAD
    public function analyse($code)
=======
    public function analyse(string $code): void
>>>>>>> v2-test
    {
        $this->namespaceResolver->analyse($code);
    }

<<<<<<< HEAD
    public function resolve($typeAlias)
    {
        $this->guardScalarTypeHints($typeAlias);
=======
    public function resolve(string $typeAlias): string
    {
        $this->guardNonObjectTypeHints($typeAlias);
>>>>>>> v2-test

        return $this->namespaceResolver->resolve($typeAlias);
    }

    /**
<<<<<<< HEAD
     * @param $typeAlias
     * @throws \Exception
     */
    private function guardScalarTypeHints($typeAlias)
    {
        if (in_array($typeAlias, array('int', 'float', 'string', 'bool'))) {
            throw new DisallowedScalarTypehintException("Scalar type $typeAlias cannot be resolved within a namespace");
=======
     * @throws \Exception
     */
    private function guardNonObjectTypeHints(string $typeAlias)
    {
        $nonObjectTypes = [
            'int',
            'float',
            'string',
            'bool',
            'iterable',
        ];

        if (\in_array($typeAlias, $nonObjectTypes, true)) {
            throw new DisallowedNonObjectTypehintException("Non-object type $typeAlias cannot be resolved within a namespace");
>>>>>>> v2-test
        }
    }
}
