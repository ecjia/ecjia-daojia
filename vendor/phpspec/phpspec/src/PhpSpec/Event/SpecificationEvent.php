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

namespace PhpSpec\Event;

<<<<<<< HEAD
use Symfony\Component\EventDispatcher\Event;
=======
use PhpSpec\Loader\Suite;
>>>>>>> v2-test
use PhpSpec\Loader\Node\SpecificationNode;

/**
 * Class SpecificationEvent holds information about the specification event
 */
<<<<<<< HEAD
class SpecificationEvent extends Event implements EventInterface
=======
class SpecificationEvent extends BaseEvent implements PhpSpecEvent
>>>>>>> v2-test
{
    /**
     * @var SpecificationNode
     */
    private $specification;

    /**
     * @var float
     */
    private $time;

    /**
     * @var integer
     */
    private $result;

    /**
     * @param SpecificationNode $specification
     * @param float             $time
     * @param integer           $result
     */
<<<<<<< HEAD
    public function __construct(SpecificationNode $specification, $time = null, $result = null)
=======
    public function __construct(SpecificationNode $specification, float $time = 0.0, int $result = 0)
>>>>>>> v2-test
    {
        $this->specification = $specification;
        $this->time          = $time;
        $this->result        = $result;
    }

    /**
     * @return SpecificationNode
     */
<<<<<<< HEAD
    public function getSpecification()
=======
    public function getSpecification(): SpecificationNode
>>>>>>> v2-test
    {
        return $this->specification;
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    public function getTitle()
=======
    public function getTitle(): string
>>>>>>> v2-test
    {
        return $this->specification->getTitle();
    }

    /**
<<<<<<< HEAD
     * @return \PhpSpec\Loader\Suite
     */
    public function getSuite()
=======
     * @return Suite
     */
    public function getSuite(): Suite
>>>>>>> v2-test
    {
        return $this->specification->getSuite();
    }

    /**
     * @return float
     */
<<<<<<< HEAD
    public function getTime()
=======
    public function getTime(): float
>>>>>>> v2-test
    {
        return $this->time;
    }

    /**
     * @return integer
     */
<<<<<<< HEAD
    public function getResult()
=======
    public function getResult(): int
>>>>>>> v2-test
    {
        return $this->result;
    }
}
