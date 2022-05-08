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
use function floor;
use function sprintf;
use DateInterval;
use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Exception;

>>>>>>> v2-test
/**
 * Compares DateTimeInterface instances for equality.
 */
class DateTimeComparator extends ObjectComparator
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
        return ($expected instanceof \DateTime || $expected instanceof \DateTimeInterface) &&
            ($actual instanceof \DateTime || $actual instanceof \DateTimeInterface);
=======
        return ($expected instanceof DateTime || $expected instanceof DateTimeInterface) &&
               ($actual instanceof DateTime || $actual instanceof DateTimeInterface);
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
    {
        $delta = new \DateInterval(sprintf('PT%sS', abs($delta)));

        $expectedLower = clone $expected;
        $expectedUpper = clone $expected;

        if ($actual < $expectedLower->sub($delta) ||
            $actual > $expectedUpper->add($delta)) {
=======
     * @param mixed $expected     First value to compare
     * @param mixed $actual       Second value to compare
     * @param float $delta        Allowed numerical distance between two values to consider them equal
     * @param bool  $canonicalize Arrays are sorted before comparison when set to true
     * @param bool  $ignoreCase   Case is ignored when set to true
     * @param array $processed    List of already processed elements (used to prevent infinite recursion)
     *
     * @throws Exception
     * @throws ComparisonFailure
     */
    public function assertEquals($expected, $actual, $delta = 0.0, $canonicalize = false, $ignoreCase = false, array &$processed = [])/*: void*/
    {
        /** @var DateTimeInterface $expected */
        /** @var DateTimeInterface $actual */
        $absDelta = abs($delta);
        $delta    = new DateInterval(sprintf('PT%dS', $absDelta));
        $delta->f = $absDelta - floor($absDelta);

        $actualClone = (clone $actual)
            ->setTimezone(new DateTimeZone('UTC'));

        $expectedLower = (clone $expected)
            ->setTimezone(new DateTimeZone('UTC'))
            ->sub($delta);

        $expectedUpper = (clone $expected)
            ->setTimezone(new DateTimeZone('UTC'))
            ->add($delta);

        if ($actualClone < $expectedLower || $actualClone > $expectedUpper) {
>>>>>>> v2-test
            throw new ComparisonFailure(
                $expected,
                $actual,
                $this->dateTimeToString($expected),
                $this->dateTimeToString($actual),
                false,
                'Failed asserting that two DateTime objects are equal.'
            );
        }
    }

    /**
     * Returns an ISO 8601 formatted string representation of a datetime or
     * 'Invalid DateTimeInterface object' if the provided DateTimeInterface was not properly
     * initialized.
<<<<<<< HEAD
     *
     * @param  \DateTimeInterface $datetime
     * @return string
     */
    protected function dateTimeToString($datetime)
    {
        $string = $datetime->format(\DateTime::ISO8601);

        return $string ? $string : 'Invalid DateTimeInterface object';
=======
     */
    private function dateTimeToString(DateTimeInterface $datetime): string
    {
        $string = $datetime->format('Y-m-d\TH:i:s.uO');

        return $string ?: 'Invalid DateTimeInterface object';
>>>>>>> v2-test
    }
}
