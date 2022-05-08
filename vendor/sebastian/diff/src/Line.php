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
class Line
{
    const ADDED     = 1;
    const REMOVED   = 2;
    const UNCHANGED = 3;
=======
namespace SebastianBergmann\Diff;

final class Line
{
    public const ADDED     = 1;

    public const REMOVED   = 2;

    public const UNCHANGED = 3;
>>>>>>> v2-test

    /**
     * @var int
     */
    private $type;

    /**
     * @var string
     */
    private $content;

<<<<<<< HEAD
    /**
     * @param int    $type
     * @param string $content
     */
    public function __construct($type = self::UNCHANGED, $content = '')
=======
    public function __construct(int $type = self::UNCHANGED, string $content = '')
>>>>>>> v2-test
    {
        $this->type    = $type;
        $this->content = $content;
    }

<<<<<<< HEAD
    /**
     * @return string
     */
    public function getContent()
=======
    public function getContent(): string
>>>>>>> v2-test
    {
        return $this->content;
    }

<<<<<<< HEAD
    /**
     * @return int
     */
    public function getType()
=======
    public function getType(): int
>>>>>>> v2-test
    {
        return $this->type;
    }
}
