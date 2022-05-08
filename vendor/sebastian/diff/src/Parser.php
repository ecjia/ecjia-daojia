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

/**
 * Unified diff parser.
 */
class Parser
{
    /**
     * @param string $string
     *
     * @return Diff[]
     */
    public function parse($string)
    {
        $lines     = preg_split('(\r\n|\r|\n)', $string);
        $lineCount = count($lines);
        $diffs     = array();
        $diff      = null;
        $collected = array();

        for ($i = 0; $i < $lineCount; ++$i) {
            if (preg_match('(^---\\s+(?P<file>\\S+))', $lines[$i], $fromMatch) &&
                preg_match('(^\\+\\+\\+\\s+(?P<file>\\S+))', $lines[$i + 1], $toMatch)) {
                if ($diff !== null) {
                    $this->parseFileDiff($diff, $collected);
                    $diffs[]   = $diff;
                    $collected = array();
                }

                $diff = new Diff($fromMatch['file'], $toMatch['file']);
=======
namespace SebastianBergmann\Diff;

use function array_pop;
use function count;
use function max;
use function preg_match;
use function preg_split;

/**
 * Unified diff parser.
 */
final class Parser
{
    /**
     * @return Diff[]
     */
    public function parse(string $string): array
    {
        $lines = preg_split('(\r\n|\r|\n)', $string);

        if (!empty($lines) && $lines[count($lines) - 1] === '') {
            array_pop($lines);
        }

        $lineCount = count($lines);
        $diffs     = [];
        $diff      = null;
        $collected = [];

        for ($i = 0; $i < $lineCount; ++$i) {
            if (preg_match('#^---\h+"?(?P<file>[^\\v\\t"]+)#', $lines[$i], $fromMatch) &&
                preg_match('#^\\+\\+\\+\\h+"?(?P<file>[^\\v\\t"]+)#', $lines[$i + 1], $toMatch)) {
                if ($diff !== null) {
                    $this->parseFileDiff($diff, $collected);

                    $diffs[]   = $diff;
                    $collected = [];
                }

                $diff = new Diff($fromMatch['file'], $toMatch['file']);

>>>>>>> v2-test
                ++$i;
            } else {
                if (preg_match('/^(?:diff --git |index [\da-f\.]+|[+-]{3} [ab])/', $lines[$i])) {
                    continue;
                }
<<<<<<< HEAD
=======

>>>>>>> v2-test
                $collected[] = $lines[$i];
            }
        }

<<<<<<< HEAD
        if (count($collected) && ($diff !== null)) {
            $this->parseFileDiff($diff, $collected);
=======
        if ($diff !== null && count($collected)) {
            $this->parseFileDiff($diff, $collected);

>>>>>>> v2-test
            $diffs[] = $diff;
        }

        return $diffs;
    }

<<<<<<< HEAD
    /**
     * @param Diff  $diff
     * @param array $lines
     */
    private function parseFileDiff(Diff $diff, array $lines)
    {
        $chunks = array();
=======
    private function parseFileDiff(Diff $diff, array $lines): void
    {
        $chunks    = [];
        $chunk     = null;
        $diffLines = [];
>>>>>>> v2-test

        foreach ($lines as $line) {
            if (preg_match('/^@@\s+-(?P<start>\d+)(?:,\s*(?P<startrange>\d+))?\s+\+(?P<end>\d+)(?:,\s*(?P<endrange>\d+))?\s+@@/', $line, $match)) {
                $chunk = new Chunk(
<<<<<<< HEAD
                    $match['start'],
                    isset($match['startrange']) ? max(1, $match['startrange']) : 1,
                    $match['end'],
                    isset($match['endrange']) ? max(1, $match['endrange']) : 1
                );

                $chunks[]  = $chunk;
                $diffLines = array();
=======
                    (int) $match['start'],
                    isset($match['startrange']) ? max(1, (int) $match['startrange']) : 1,
                    (int) $match['end'],
                    isset($match['endrange']) ? max(1, (int) $match['endrange']) : 1
                );

                $chunks[]  = $chunk;
                $diffLines = [];

>>>>>>> v2-test
                continue;
            }

            if (preg_match('/^(?P<type>[+ -])?(?P<line>.*)/', $line, $match)) {
                $type = Line::UNCHANGED;

<<<<<<< HEAD
                if ($match['type'] == '+') {
                    $type = Line::ADDED;
                } elseif ($match['type'] == '-') {
=======
                if ($match['type'] === '+') {
                    $type = Line::ADDED;
                } elseif ($match['type'] === '-') {
>>>>>>> v2-test
                    $type = Line::REMOVED;
                }

                $diffLines[] = new Line($type, $match['line']);

<<<<<<< HEAD
                if (isset($chunk)) {
=======
                if (null !== $chunk) {
>>>>>>> v2-test
                    $chunk->setLines($diffLines);
                }
            }
        }

        $diff->setChunks($chunks);
    }
}
