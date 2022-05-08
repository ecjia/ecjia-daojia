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

namespace PhpSpec\Locator\PSR0;

<<<<<<< HEAD
use PhpSpec\Locator\ResourceInterface;

class PSR0Resource implements ResourceInterface
=======
use PhpSpec\Locator\Resource;

final class PSR0Resource implements Resource
>>>>>>> v2-test
{
    /**
     * @var array
     */
    private $parts;
    /**
     * @var PSR0Locator
     */
    private $locator;

    /**
     * @param array       $parts
     * @param PSR0Locator $locator
     */
    public function __construct(array $parts, PSR0Locator $locator)
    {
        $this->parts   = $parts;
        $this->locator = $locator;
    }

    /**
<<<<<<< HEAD
     * @return mixed
     */
    public function getName()
=======
     * @return string
     */
    public function getName(): string
>>>>>>> v2-test
    {
        return end($this->parts);
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    public function getSpecName()
=======
    public function getSpecName(): string
>>>>>>> v2-test
    {
        return $this->getName().'Spec';
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    public function getSrcFilename()
=======
    public function getSrcFilename(): string
>>>>>>> v2-test
    {
        if ($this->locator->isPSR4()) {
            return $this->locator->getFullSrcPath().implode(DIRECTORY_SEPARATOR, $this->parts).'.php';
        }

        $nsParts   = $this->parts;
        $classname = array_pop($nsParts);
        $parts     = array_merge($nsParts, explode('_', $classname));

        return $this->locator->getFullSrcPath().implode(DIRECTORY_SEPARATOR, $parts).'.php';
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    public function getSrcNamespace()
=======
    public function getSrcNamespace(): string
>>>>>>> v2-test
    {
        $nsParts = $this->parts;
        array_pop($nsParts);

        return rtrim($this->locator->getSrcNamespace().implode('\\', $nsParts), '\\');
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    public function getSrcClassname()
=======
    public function getSrcClassname(): string
>>>>>>> v2-test
    {
        return $this->locator->getSrcNamespace().implode('\\', $this->parts);
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    public function getSpecFilename()
=======
    public function getSpecFilename(): string
>>>>>>> v2-test
    {
        if ($this->locator->isPSR4()) {
            return $this->locator->getFullSpecPath().
                implode(DIRECTORY_SEPARATOR, $this->parts).'Spec.php';
        }

        $nsParts   = $this->parts;
        $classname = array_pop($nsParts);
        $parts     = array_merge($nsParts, explode('_', $classname));

        return $this->locator->getFullSpecPath().
            implode(DIRECTORY_SEPARATOR, $parts).'Spec.php';
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    public function getSpecNamespace()
=======
    public function getSpecNamespace(): string
>>>>>>> v2-test
    {
        $nsParts = $this->parts;
        array_pop($nsParts);

        return rtrim($this->locator->getSpecNamespace().implode('\\', $nsParts), '\\');
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    public function getSpecClassname()
=======
    public function getSpecClassname(): string
>>>>>>> v2-test
    {
        return $this->locator->getSpecNamespace().implode('\\', $this->parts).'Spec';
    }
}
