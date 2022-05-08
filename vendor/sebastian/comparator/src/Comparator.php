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

=======
>>>>>>> v2-test
namespace SebastianBergmann\Comparator;

use SebastianBergmann\Exporter\Exporter;

/**
 * Abstract base class for comparators which compare values for equality.
 */
abstract class Comparator
{
    /**
     * @var Factory
     */
    protected $factory;

    /**
     * @var Exporter
     */
    protected $exporter;

    public function __construct()
    {
        $this->exporter = new Exporter;
    }

<<<<<<< HEAD
    /**
     * @param Factory $factory
     */
    public function setFactory(Factory $factory)
=======
    public function setFactory(Factory $factory)/*: void*/
>>>>>>> v2-test
    {
        $this->factory = $factory;
    }

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
    abstract public function accepts($expected, $actual);

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
=======
     * @param mixed $expected     First value to compare
     * @param mixed $actual       Second value to compare
     * @param float $delta        Allowed numerical distance between two values to consider them equal
     * @param bool  $canonicalize Arrays are sorted before comparison when set to true
     * @param bool  $ignoreCase   Case is ignored when set to true
     *
     * @throws ComparisonFailure
>>>>>>> v2-test
     */
    abstract public function assertEquals($expected, $actual, $delta = 0.0, $canonicalize = false, $ignoreCase = false);
}
