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
 */
class Chunk
=======
namespace SebastianBergmann\Diff;

final class Chunk
>>>>>>> v2-test
{
    /**
     * @var int
     */
    private $start;

    /**
     * @var int
     */
    private $startRange;

    /**
     * @var int
     */
    private $end;
<<<<<<< HEAD
=======

>>>>>>> v2-test
    /**
     * @var int
     */
    private $endRange;

    /**
<<<<<<< HEAD
     * @var array
     */
    private $lines;

    /**
     * @param int   $start
     * @param int   $startRange
     * @param int   $end
     * @param int   $endRange
     * @param array $lines
     */
    public function __construct($start = 0, $startRange = 1, $end = 0, $endRange = 1, array $lines = array())
    {
        $this->start      = (int) $start;
        $this->startRange = (int) $startRange;
        $this->end        = (int) $end;
        $this->endRange   = (int) $endRange;
        $this->lines      = $lines;
    }

    /**
     * @return int
     */
    public function getStart()
=======
     * @var Line[]
     */
    private $lines;

    public function __construct(int $start = 0, int $startRange = 1, int $end = 0, int $endRange = 1, array $lines = [])
    {
        $this->start      = $start;
        $this->startRange = $startRange;
        $this->end        = $end;
        $this->endRange   = $endRange;
        $this->lines      = $lines;
    }

    public function getStart(): int
>>>>>>> v2-test
    {
        return $this->start;
    }

<<<<<<< HEAD
    /**
     * @return int
     */
    public function getStartRange()
=======
    public function getStartRange(): int
>>>>>>> v2-test
    {
        return $this->startRange;
    }

<<<<<<< HEAD
    /**
     * @return int
     */
    public function getEnd()
=======
    public function getEnd(): int
>>>>>>> v2-test
    {
        return $this->end;
    }

<<<<<<< HEAD
    /**
     * @return int
     */
    public function getEndRange()
=======
    public function getEndRange(): int
>>>>>>> v2-test
    {
        return $this->endRange;
    }

    /**
<<<<<<< HEAD
     * @return array
     */
    public function getLines()
=======
     * @return Line[]
     */
    public function getLines(): array
>>>>>>> v2-test
    {
        return $this->lines;
    }

    /**
<<<<<<< HEAD
     * @param array $lines
     */
    public function setLines(array $lines)
    {
=======
     * @param Line[] $lines
     */
    public function setLines(array $lines): void
    {
        foreach ($lines as $line) {
            if (!$line instanceof Line) {
                throw new InvalidArgumentException;
            }
        }

>>>>>>> v2-test
        $this->lines = $lines;
    }
}
