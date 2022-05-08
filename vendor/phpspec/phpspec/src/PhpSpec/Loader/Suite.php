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

namespace PhpSpec\Loader;

class Suite implements \Countable
{
    /**
     * @var array
     */
    private $specs = array();

    /**
     * @param Node\SpecificationNode $spec
     */
<<<<<<< HEAD
    public function addSpecification(Node\SpecificationNode $spec)
=======
    public function addSpecification(Node\SpecificationNode $spec): void
>>>>>>> v2-test
    {
        $this->specs[] = $spec;
        $spec->setSuite($this);
    }

    /**
     * @return Node\SpecificationNode[]
     */
<<<<<<< HEAD
    public function getSpecifications()
=======
    public function getSpecifications(): array
>>>>>>> v2-test
    {
        return $this->specs;
    }

    /**
<<<<<<< HEAD
     * @return number
     */
    public function count()
=======
     * @return int
     */
    public function count(): int
>>>>>>> v2-test
    {
        return array_sum(array_map('count', $this->specs));
    }
}
