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

namespace PhpSpec\CodeGenerator;

<<<<<<< HEAD
use PhpSpec\Locator\ResourceInterface;
use InvalidArgumentException;
=======
use PhpSpec\Locator\Resource;
use InvalidArgumentException;
use PhpSpec\CodeGenerator\Generator\Generator;
>>>>>>> v2-test

/**
 * Uses registered generators to generate code honoring priority order
 */
class GeneratorManager
{
    /**
<<<<<<< HEAD
     * @var array
=======
     * @var Generator[]
>>>>>>> v2-test
     */
    private $generators = array();

    /**
<<<<<<< HEAD
     * @param Generator\GeneratorInterface $generator
     */
    public function registerGenerator(Generator\GeneratorInterface $generator)
    {
        $this->generators[] = $generator;
        @usort($this->generators, function ($generator1, $generator2) {
=======
     * @param Generator $generator
     */
    public function registerGenerator(Generator $generator): void
    {
        $this->generators[] = $generator;
        @usort($this->generators, function (Generator $generator1, Generator $generator2) {
>>>>>>> v2-test
            return $generator2->getPriority() - $generator1->getPriority();
        });
    }

    /**
<<<<<<< HEAD
     * @param ResourceInterface $resource
     * @param string            $name
     * @param array             $data
     *
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function generate(ResourceInterface $resource, $name, array $data = array())
    {
        foreach ($this->generators as $generator) {
            if ($generator->supports($resource, $name, $data)) {
                return $generator->generate($resource, $data);
=======
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function generate(Resource $resource, string $name, array $data = array()): void
    {
        foreach ($this->generators as $generator) {
            if ($generator->supports($resource, $name, $data)) {
                $generator->generate($resource, $data);

                return;
>>>>>>> v2-test
            }
        }

        throw new InvalidArgumentException(sprintf(
            '"%s" code generator is not registered.',
            $name
        ));
    }
}
