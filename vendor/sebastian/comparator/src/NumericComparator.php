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

use function abs;
use function is_float;
use function is_infinite;
use function is_nan;
use function is_numeric;
use function is_string;
use function sprintf;

>>>>>>> v2-test
/**
 * Compares numerical values for equality.
 */
class NumericComparator extends ScalarComparator
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
        // all numerical values, but not if one of them is a double
        // or both of them are strings
        return is_numeric($expected) && is_numeric($actual) &&
<<<<<<< HEAD
               !(is_double($expected) || is_double($actual)) &&
=======
               !(is_float($expected) || is_float($actual)) &&
>>>>>>> v2-test
               !(is_string($expected) && is_string($actual));
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
    {
        if (is_infinite($actual) && is_infinite($expected)) {
            return;
        }

        if ((is_infinite($actual) xor is_infinite($expected)) ||
            (is_nan($actual) or is_nan($expected)) ||
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
    {
        if ($this->isInfinite($actual) && $this->isInfinite($expected)) {
            return;
        }

        if (($this->isInfinite($actual) xor $this->isInfinite($expected)) ||
            ($this->isNan($actual) || $this->isNan($expected)) ||
>>>>>>> v2-test
            abs($actual - $expected) > $delta) {
            throw new ComparisonFailure(
                $expected,
                $actual,
                '',
                '',
                false,
                sprintf(
                    'Failed asserting that %s matches expected %s.',
                    $this->exporter->export($actual),
                    $this->exporter->export($expected)
                )
            );
        }
    }
<<<<<<< HEAD
=======

    private function isInfinite($value): bool
    {
        return is_float($value) && is_infinite($value);
    }

    private function isNan($value): bool
    {
        return is_float($value) && is_nan($value);
    }
>>>>>>> v2-test
}
