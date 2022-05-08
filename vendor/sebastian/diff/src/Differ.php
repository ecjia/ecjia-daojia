<<<<<<< HEAD
<?php
/*
 * This file is part of the Diff package.
=======
<?php declare(strict_types=1);
/*
 * This file is part of sebastian/diff.
>>>>>>> v2-test
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
<<<<<<< HEAD

namespace SebastianBergmann\Diff;

use SebastianBergmann\Diff\LCS\LongestCommonSubsequence;
use SebastianBergmann\Diff\LCS\TimeEfficientImplementation;
use SebastianBergmann\Diff\LCS\MemoryEfficientImplementation;

/**
 * Diff implementation.
 */
class Differ
{
    /**
     * @var string
     */
    private $header;

    /**
     * @var bool
     */
    private $showNonDiffLines;

    /**
     * @param string $header
     */
    public function __construct($header = "--- Original\n+++ New\n", $showNonDiffLines = true)
    {
        $this->header           = $header;
        $this->showNonDiffLines = $showNonDiffLines;
=======
namespace SebastianBergmann\Diff;

use const PHP_INT_SIZE;
use const PREG_SPLIT_DELIM_CAPTURE;
use const PREG_SPLIT_NO_EMPTY;
use function array_shift;
use function array_unshift;
use function array_values;
use function count;
use function current;
use function end;
use function get_class;
use function gettype;
use function is_array;
use function is_object;
use function is_string;
use function key;
use function min;
use function preg_split;
use function prev;
use function reset;
use function sprintf;
use function substr;
use SebastianBergmann\Diff\Output\DiffOutputBuilderInterface;
use SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;

final class Differ
{
    public const OLD                     = 0;

    public const ADDED                   = 1;

    public const REMOVED                 = 2;

    public const DIFF_LINE_END_WARNING   = 3;

    public const NO_LINE_END_EOF_WARNING = 4;

    /**
     * @var DiffOutputBuilderInterface
     */
    private $outputBuilder;

    /**
     * @param DiffOutputBuilderInterface $outputBuilder
     *
     * @throws InvalidArgumentException
     */
    public function __construct($outputBuilder = null)
    {
        if ($outputBuilder instanceof DiffOutputBuilderInterface) {
            $this->outputBuilder = $outputBuilder;
        } elseif (null === $outputBuilder) {
            $this->outputBuilder = new UnifiedDiffOutputBuilder;
        } elseif (is_string($outputBuilder)) {
            // PHPUnit 6.1.4, 6.2.0, 6.2.1, 6.2.2, and 6.2.3 support
            // @see https://github.com/sebastianbergmann/phpunit/issues/2734#issuecomment-314514056
            // @deprecated
            $this->outputBuilder = new UnifiedDiffOutputBuilder($outputBuilder);
        } else {
            throw new InvalidArgumentException(
                sprintf(
                    'Expected builder to be an instance of DiffOutputBuilderInterface, <null> or a string, got %s.',
                    is_object($outputBuilder) ? 'instance of "' . get_class($outputBuilder) . '"' : gettype($outputBuilder) . ' "' . $outputBuilder . '"'
                )
            );
        }
>>>>>>> v2-test
    }

    /**
     * Returns the diff between two arrays or strings as string.
     *
<<<<<<< HEAD
     * @param array|string             $from
     * @param array|string             $to
     * @param LongestCommonSubsequence $lcs
     *
     * @return string
     */
    public function diff($from, $to, LongestCommonSubsequence $lcs = null)
    {
        if (!is_array($from) && !is_string($from)) {
            $from = (string) $from;
        }

        if (!is_array($to) && !is_string($to)) {
            $to = (string) $to;
        }

        $buffer = $this->header;
        $diff   = $this->diffToArray($from, $to, $lcs);

        $inOld = false;
        $i     = 0;
        $old   = array();

        foreach ($diff as $line) {
            if ($line[1] ===  0 /* OLD */) {
                if ($inOld === false) {
                    $inOld = $i;
                }
            } elseif ($inOld !== false) {
                if (($i - $inOld) > 5) {
                    $old[$inOld] = $i - 1;
                }

                $inOld = false;
            }

            ++$i;
        }

        $start = isset($old[0]) ? $old[0] : 0;
        $end   = count($diff);

        if ($tmp = array_search($end, $old)) {
            $end = $tmp;
        }

        $newChunk = true;

        for ($i = $start; $i < $end; $i++) {
            if (isset($old[$i])) {
                $buffer  .= "\n";
                $newChunk = true;
                $i        = $old[$i];
            }

            if ($newChunk) {
                if ($this->showNonDiffLines === true) {
                    $buffer .= "@@ @@\n";
                }
                $newChunk = false;
            }

            if ($diff[$i][1] === 1 /* ADDED */) {
                $buffer .= '+' . $diff[$i][0] . "\n";
            } elseif ($diff[$i][1] === 2 /* REMOVED */) {
                $buffer .= '-' . $diff[$i][0] . "\n";
            } elseif ($this->showNonDiffLines === true) {
                $buffer .= ' ' . $diff[$i][0] . "\n";
            }
        }

        return $buffer;
=======
     * @param array|string $from
     * @param array|string $to
     */
    public function diff($from, $to, LongestCommonSubsequenceCalculator $lcs = null): string
    {
        $diff = $this->diffToArray(
            $this->normalizeDiffInput($from),
            $this->normalizeDiffInput($to),
            $lcs
        );

        return $this->outputBuilder->getDiff($diff);
>>>>>>> v2-test
    }

    /**
     * Returns the diff between two arrays or strings as array.
     *
     * Each array element contains two elements:
<<<<<<< HEAD
     *   - [0] => string $token
=======
     *   - [0] => mixed $token
>>>>>>> v2-test
     *   - [1] => 2|1|0
     *
     * - 2: REMOVED: $token was removed from $from
     * - 1: ADDED: $token was added to $from
     * - 0: OLD: $token is not changed in $to
     *
<<<<<<< HEAD
     * @param array|string             $from
     * @param array|string             $to
     * @param LongestCommonSubsequence $lcs
     *
     * @return array
     */
    public function diffToArray($from, $to, LongestCommonSubsequence $lcs = null)
    {
        preg_match_all('(\r\n|\r|\n)', $from, $fromMatches);
        preg_match_all('(\r\n|\r|\n)', $to, $toMatches);

        if (is_string($from)) {
            $from = preg_split('(\r\n|\r|\n)', $from);
        }

        if (is_string($to)) {
            $to = preg_split('(\r\n|\r|\n)', $to);
        }

        $start      = array();
        $end        = array();
        $fromLength = count($from);
        $toLength   = count($to);
        $length     = min($fromLength, $toLength);

        for ($i = 0; $i < $length; ++$i) {
            if ($from[$i] === $to[$i]) {
                $start[] = $from[$i];
                unset($from[$i], $to[$i]);
            } else {
                break;
            }
        }

        $length -= $i;

        for ($i = 1; $i < $length; ++$i) {
            if ($from[$fromLength - $i] === $to[$toLength - $i]) {
                array_unshift($end, $from[$fromLength - $i]);
                unset($from[$fromLength - $i], $to[$toLength - $i]);
            } else {
                break;
            }
        }
=======
     * @param array|string                       $from
     * @param array|string                       $to
     * @param LongestCommonSubsequenceCalculator $lcs
     */
    public function diffToArray($from, $to, LongestCommonSubsequenceCalculator $lcs = null): array
    {
        if (is_string($from)) {
            $from = $this->splitStringByLines($from);
        } elseif (!is_array($from)) {
            throw new InvalidArgumentException('"from" must be an array or string.');
        }

        if (is_string($to)) {
            $to = $this->splitStringByLines($to);
        } elseif (!is_array($to)) {
            throw new InvalidArgumentException('"to" must be an array or string.');
        }

        [$from, $to, $start, $end] = self::getArrayDiffParted($from, $to);
>>>>>>> v2-test

        if ($lcs === null) {
            $lcs = $this->selectLcsImplementation($from, $to);
        }

        $common = $lcs->calculate(array_values($from), array_values($to));
<<<<<<< HEAD
        $diff   = array();

        if (isset($fromMatches[0]) && $toMatches[0] &&
            count($fromMatches[0]) === count($toMatches[0]) &&
            $fromMatches[0] !== $toMatches[0]) {
            $diff[] = array(
              '#Warning: Strings contain different line endings!', 0
            );
        }

        foreach ($start as $token) {
            $diff[] = array($token, 0 /* OLD */);
=======
        $diff   = [];

        foreach ($start as $token) {
            $diff[] = [$token, self::OLD];
>>>>>>> v2-test
        }

        reset($from);
        reset($to);

        foreach ($common as $token) {
<<<<<<< HEAD
            while ((($fromToken = reset($from)) !== $token)) {
                $diff[] = array(array_shift($from), 2 /* REMOVED */);
            }

            while ((($toToken = reset($to)) !== $token)) {
                $diff[] = array(array_shift($to), 1 /* ADDED */);
            }

            $diff[] = array($token, 0 /* OLD */);
=======
            while (($fromToken = reset($from)) !== $token) {
                $diff[] = [array_shift($from), self::REMOVED];
            }

            while (($toToken = reset($to)) !== $token) {
                $diff[] = [array_shift($to), self::ADDED];
            }

            $diff[] = [$token, self::OLD];
>>>>>>> v2-test

            array_shift($from);
            array_shift($to);
        }

        while (($token = array_shift($from)) !== null) {
<<<<<<< HEAD
            $diff[] = array($token, 2 /* REMOVED */);
        }

        while (($token = array_shift($to)) !== null) {
            $diff[] = array($token, 1 /* ADDED */);
        }

        foreach ($end as $token) {
            $diff[] = array($token, 0 /* OLD */);
=======
            $diff[] = [$token, self::REMOVED];
        }

        while (($token = array_shift($to)) !== null) {
            $diff[] = [$token, self::ADDED];
        }

        foreach ($end as $token) {
            $diff[] = [$token, self::OLD];
        }

        if ($this->detectUnmatchedLineEndings($diff)) {
            array_unshift($diff, ["#Warning: Strings contain different line endings!\n", self::DIFF_LINE_END_WARNING]);
>>>>>>> v2-test
        }

        return $diff;
    }

    /**
<<<<<<< HEAD
     * @param array $from
     * @param array $to
     *
     * @return LongestCommonSubsequence
     */
    private function selectLcsImplementation(array $from, array $to)
=======
     * Casts variable to string if it is not a string or array.
     *
     * @return array|string
     */
    private function normalizeDiffInput($input)
    {
        if (!is_array($input) && !is_string($input)) {
            return (string) $input;
        }

        return $input;
    }

    /**
     * Checks if input is string, if so it will split it line-by-line.
     */
    private function splitStringByLines(string $input): array
    {
        return preg_split('/(.*\R)/', $input, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    }

    private function selectLcsImplementation(array $from, array $to): LongestCommonSubsequenceCalculator
>>>>>>> v2-test
    {
        // We do not want to use the time-efficient implementation if its memory
        // footprint will probably exceed this value. Note that the footprint
        // calculation is only an estimation for the matrix and the LCS method
        // will typically allocate a bit more memory than this.
        $memoryLimit = 100 * 1024 * 1024;

        if ($this->calculateEstimatedFootprint($from, $to) > $memoryLimit) {
<<<<<<< HEAD
            return new MemoryEfficientImplementation;
        }

        return new TimeEfficientImplementation;
=======
            return new MemoryEfficientLongestCommonSubsequenceCalculator;
        }

        return new TimeEfficientLongestCommonSubsequenceCalculator;
>>>>>>> v2-test
    }

    /**
     * Calculates the estimated memory footprint for the DP-based method.
     *
<<<<<<< HEAD
     * @param array $from
     * @param array $to
     *
     * @return int
     */
    private function calculateEstimatedFootprint(array $from, array $to)
    {
        $itemSize = PHP_INT_SIZE == 4 ? 76 : 144;

        return $itemSize * pow(min(count($from), count($to)), 2);
=======
     * @return float|int
     */
    private function calculateEstimatedFootprint(array $from, array $to)
    {
        $itemSize = PHP_INT_SIZE === 4 ? 76 : 144;

        return $itemSize * min(count($from), count($to)) ** 2;
    }

    /**
     * Returns true if line ends don't match in a diff.
     */
    private function detectUnmatchedLineEndings(array $diff): bool
    {
        $newLineBreaks = ['' => true];
        $oldLineBreaks = ['' => true];

        foreach ($diff as $entry) {
            if (self::OLD === $entry[1]) {
                $ln                 = $this->getLinebreak($entry[0]);
                $oldLineBreaks[$ln] = true;
                $newLineBreaks[$ln] = true;
            } elseif (self::ADDED === $entry[1]) {
                $newLineBreaks[$this->getLinebreak($entry[0])] = true;
            } elseif (self::REMOVED === $entry[1]) {
                $oldLineBreaks[$this->getLinebreak($entry[0])] = true;
            }
        }

        // if either input or output is a single line without breaks than no warning should be raised
        if (['' => true] === $newLineBreaks || ['' => true] === $oldLineBreaks) {
            return false;
        }

        // two way compare
        foreach ($newLineBreaks as $break => $set) {
            if (!isset($oldLineBreaks[$break])) {
                return true;
            }
        }

        foreach ($oldLineBreaks as $break => $set) {
            if (!isset($newLineBreaks[$break])) {
                return true;
            }
        }

        return false;
    }

    private function getLinebreak($line): string
    {
        if (!is_string($line)) {
            return '';
        }

        $lc = substr($line, -1);

        if ("\r" === $lc) {
            return "\r";
        }

        if ("\n" !== $lc) {
            return '';
        }

        if ("\r\n" === substr($line, -2)) {
            return "\r\n";
        }

        return "\n";
    }

    private static function getArrayDiffParted(array &$from, array &$to): array
    {
        $start = [];
        $end   = [];

        reset($to);

        foreach ($from as $k => $v) {
            $toK = key($to);

            if ($toK === $k && $v === $to[$k]) {
                $start[$k] = $v;

                unset($from[$k], $to[$k]);
            } else {
                break;
            }
        }

        end($from);
        end($to);

        do {
            $fromK = key($from);
            $toK   = key($to);

            if (null === $fromK || null === $toK || current($from) !== current($to)) {
                break;
            }

            prev($from);
            prev($to);

            $end = [$fromK => $from[$fromK]] + $end;
            unset($from[$fromK], $to[$toK]);
        } while (true);

        return [$from, $to, $start, $end];
>>>>>>> v2-test
    }
}
