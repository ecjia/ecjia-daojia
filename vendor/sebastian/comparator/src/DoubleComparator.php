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

=======
namespace SebastianBergmann\Comparator;

use function is_float;
use function is_numeric;

>>>>>>> v2-test
/**
 * Compares doubles for equality.
 */
class DoubleComparator extends NumericComparator
{
    /**
     * Smallest value available in PHP.
     *
     * @var float
     */
<<<<<<< HEAD
    const EPSILON = 0.0000000001;
=======
    public const EPSILON = 0.0000000001;
>>>>>>> v2-test

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
        return (is_double($expected) || is_double($actual)) && is_numeric($expected) && is_numeric($actual);
=======
        return (is_float($expected) || is_float($actual)) && is_numeric($expected) && is_numeric($actual);
>>>>>>> v2-test
    }

    /**
     * Asserts that two values are equal.
     *
<<<<<<< HEAD
     * @param  mixed             $expected     The first value to compare
     * @param  mixed             $actual       The second value to compare
     * @param  float             $delta        The allowed numerical distance between two values to
     *                                         consider them equal
     * @param  bool              $canonicalize If set to TRUE, arrays are sorted before
     *                                         comparison
     * @param  bool              $ignoreCase   If set to TRUE, upper- and lowercasing is
     *                                         ignored when comparing string values
     * @throws ComparisonFailure Thrown when the comparison
     *                                        fails. Contains information about the
     *                                        specific errors that lead to the failure.
     */
    public function assertEquals($expected, $actual, $delta = 0.0, $canonicalize = false, $ignoreCase = false)
=======
     * @param mixed $expected     First value to compare
     * @param mixed $actual       Second value to compare
     * @param float $delta        Allowed numerical distance between two values to consider them equal
     * @param bool  $canonicalize Arrays are sorted before comparison when set to true
     * @param bool  $ignoreCase   Case is ignored when set to true
     *
     * @throws ComparisonFailure
     */
    public function assertEquals($expected, $actual, $delta = 0.0, $canonicalize = false, $ignoreCase = false)/*: void*/
>>>>>>> v2-test
    {
        if ($delta == 0) {
            $delta = self::EPSILON;
        }

        parent::assertEquals($expected, $actual, $delta, $canonicalize, $ignoreCase);
    }
}
