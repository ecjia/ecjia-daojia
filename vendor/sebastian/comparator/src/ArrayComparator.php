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
 * Compares arrays for equality.
=======
namespace SebastianBergmann\Comparator;

use function array_key_exists;
use function is_array;
use function sort;
use function sprintf;
use function str_replace;
use function trim;

/**
 * Compares arrays for equality.
 *
 * Arrays are equal if they contain the same key-value pairs.
 * The order of the keys does not matter.
 * The types of key-value pairs do not matter.
>>>>>>> v2-test
 */
class ArrayComparator extends Comparator
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
        return is_array($expected) && is_array($actual);
    }

    /**
<<<<<<< HEAD
     * Asserts that two values are equal.
     *
     * @param  mixed             $expected     The first value to compare
     * @param  mixed             $actual       The second value to compare
     * @param  float             $delta        The allowed numerical distance between two values to
     *                                         consider them equal
     * @param  bool              $canonicalize If set to TRUE, arrays are sorted before
     *                                         comparison
     * @param  bool              $ignoreCase   If set to TRUE, upper- and lowercasing is
     *                                         ignored when comparing string values
     * @param  array             $processed
     * @throws ComparisonFailure Thrown when the comparison
     *                                        fails. Contains information about the
     *                                        specific errors that lead to the failure.
     */
    public function assertEquals($expected, $actual, $delta = 0.0, $canonicalize = false, $ignoreCase = false, array &$processed = array())
=======
     * Asserts that two arrays are equal.
     *
     * @param mixed $expected     First value to compare
     * @param mixed $actual       Second value to compare
     * @param float $delta        Allowed numerical distance between two values to consider them equal
     * @param bool  $canonicalize Arrays are sorted before comparison when set to true
     * @param bool  $ignoreCase   Case is ignored when set to true
     * @param array $processed    List of already processed elements (used to prevent infinite recursion)
     *
     * @throws ComparisonFailure
     */
    public function assertEquals($expected, $actual, $delta = 0.0, $canonicalize = false, $ignoreCase = false, array &$processed = [])/*: void*/
>>>>>>> v2-test
    {
        if ($canonicalize) {
            sort($expected);
            sort($actual);
        }

<<<<<<< HEAD
        $remaining = $actual;
        $expString = $actString = "Array (\n";
        $equal     = true;
=======
        $remaining        = $actual;
        $actualAsString   = "Array (\n";
        $expectedAsString = "Array (\n";
        $equal            = true;
>>>>>>> v2-test

        foreach ($expected as $key => $value) {
            unset($remaining[$key]);

            if (!array_key_exists($key, $actual)) {
<<<<<<< HEAD
                $expString .= sprintf(
=======
                $expectedAsString .= sprintf(
>>>>>>> v2-test
                    "    %s => %s\n",
                    $this->exporter->export($key),
                    $this->exporter->shortenedExport($value)
                );

                $equal = false;

                continue;
            }

            try {
                $comparator = $this->factory->getComparatorFor($value, $actual[$key]);
                $comparator->assertEquals($value, $actual[$key], $delta, $canonicalize, $ignoreCase, $processed);

<<<<<<< HEAD
                $expString .= sprintf(
=======
                $expectedAsString .= sprintf(
>>>>>>> v2-test
                    "    %s => %s\n",
                    $this->exporter->export($key),
                    $this->exporter->shortenedExport($value)
                );
<<<<<<< HEAD
                $actString .= sprintf(
=======

                $actualAsString .= sprintf(
>>>>>>> v2-test
                    "    %s => %s\n",
                    $this->exporter->export($key),
                    $this->exporter->shortenedExport($actual[$key])
                );
            } catch (ComparisonFailure $e) {
<<<<<<< HEAD
                $expString .= sprintf(
                    "    %s => %s\n",
                    $this->exporter->export($key),
                    $e->getExpectedAsString()
                    ? $this->indent($e->getExpectedAsString())
                    : $this->exporter->shortenedExport($e->getExpected())
                );

                $actString .= sprintf(
                    "    %s => %s\n",
                    $this->exporter->export($key),
                    $e->getActualAsString()
                    ? $this->indent($e->getActualAsString())
                    : $this->exporter->shortenedExport($e->getActual())
=======
                $expectedAsString .= sprintf(
                    "    %s => %s\n",
                    $this->exporter->export($key),
                    $e->getExpectedAsString() ? $this->indent($e->getExpectedAsString()) : $this->exporter->shortenedExport($e->getExpected())
                );

                $actualAsString .= sprintf(
                    "    %s => %s\n",
                    $this->exporter->export($key),
                    $e->getActualAsString() ? $this->indent($e->getActualAsString()) : $this->exporter->shortenedExport($e->getActual())
>>>>>>> v2-test
                );

                $equal = false;
            }
        }

        foreach ($remaining as $key => $value) {
<<<<<<< HEAD
            $actString .= sprintf(
=======
            $actualAsString .= sprintf(
>>>>>>> v2-test
                "    %s => %s\n",
                $this->exporter->export($key),
                $this->exporter->shortenedExport($value)
            );

            $equal = false;
        }

<<<<<<< HEAD
        $expString .= ')';
        $actString .= ')';
=======
        $expectedAsString .= ')';
        $actualAsString .= ')';
>>>>>>> v2-test

        if (!$equal) {
            throw new ComparisonFailure(
                $expected,
                $actual,
<<<<<<< HEAD
                $expString,
                $actString,
=======
                $expectedAsString,
                $actualAsString,
>>>>>>> v2-test
                false,
                'Failed asserting that two arrays are equal.'
            );
        }
    }

    protected function indent($lines)
    {
        return trim(str_replace("\n", "\n    ", $lines));
    }
}
