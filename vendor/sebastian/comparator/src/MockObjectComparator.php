<<<<<<< HEAD
<?php
/*
 * This file is part of the Comparator package.
=======
<?php declare(strict_types=1);
/*
 * This file is part of sebastian/comparator.
>>>>>>> v2-test
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
<<<<<<< HEAD

namespace SebastianBergmann\Comparator;

/**
 * Compares PHPUnit_Framework_MockObject_MockObject instances for equality.
=======
namespace SebastianBergmann\Comparator;

use PHPUnit\Framework\MockObject\MockObject;

/**
 * Compares PHPUnit\Framework\MockObject\MockObject instances for equality.
>>>>>>> v2-test
 */
class MockObjectComparator extends ObjectComparator
{
    /**
     * Returns whether the comparator can compare two values.
     *
<<<<<<< HEAD
     * @param  mixed $expected The first value to compare
     * @param  mixed $actual   The second value to compare
=======
     * @param mixed $expected The first value to compare
     * @param mixed $actual   The second value to compare
     *
>>>>>>> v2-test
     * @return bool
     */
    public function accepts($expected, $actual)
    {
<<<<<<< HEAD
        return $expected instanceof \PHPUnit_Framework_MockObject_MockObject && $actual instanceof \PHPUnit_Framework_MockObject_MockObject;
=======
        return $expected instanceof MockObject && $actual instanceof MockObject;
>>>>>>> v2-test
    }

    /**
     * Converts an object to an array containing all of its private, protected
     * and public properties.
     *
<<<<<<< HEAD
     * @param  object $object
=======
     * @param object $object
     *
>>>>>>> v2-test
     * @return array
     */
    protected function toArray($object)
    {
        $array = parent::toArray($object);

        unset($array['__phpunit_invocationMocker']);

        return $array;
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> v2-test
