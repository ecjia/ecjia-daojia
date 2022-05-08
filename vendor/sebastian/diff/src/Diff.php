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
class Diff
=======
namespace SebastianBergmann\Diff;

final class Diff
>>>>>>> v2-test
{
    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $to;

    /**
     * @var Chunk[]
     */
    private $chunks;

    /**
<<<<<<< HEAD
     * @param string  $from
     * @param string  $to
     * @param Chunk[] $chunks
     */
    public function __construct($from, $to, array $chunks = array())
=======
     * @param Chunk[] $chunks
     */
    public function __construct(string $from, string $to, array $chunks = [])
>>>>>>> v2-test
    {
        $this->from   = $from;
        $this->to     = $to;
        $this->chunks = $chunks;
    }

<<<<<<< HEAD
    /**
     * @return string
     */
    public function getFrom()
=======
    public function getFrom(): string
>>>>>>> v2-test
    {
        return $this->from;
    }

<<<<<<< HEAD
    /**
     * @return string
     */
    public function getTo()
=======
    public function getTo(): string
>>>>>>> v2-test
    {
        return $this->to;
    }

    /**
     * @return Chunk[]
     */
<<<<<<< HEAD
    public function getChunks()
=======
    public function getChunks(): array
>>>>>>> v2-test
    {
        return $this->chunks;
    }

    /**
     * @param Chunk[] $chunks
     */
<<<<<<< HEAD
    public function setChunks(array $chunks)
=======
    public function setChunks(array $chunks): void
>>>>>>> v2-test
    {
        $this->chunks = $chunks;
    }
}
