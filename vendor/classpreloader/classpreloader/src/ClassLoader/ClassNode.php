<?php

declare(strict_types=1);

/*
 * This file is part of Class Preloader.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 * (c) Michael Dowling <mtdowling@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ClassPreloader\ClassLoader;

/**
 * This is the class node class.
 *
 * This class contains a value, and the previous/next pointers.
 *
 * @internal
 */
final class ClassNode
{
    /**
     * The next node pointer.
     *
     * @var self|null
     */
    public $next;

    /**
     * The previous node pointer.
     *
     * @var self|null
     */
    public $prev;

    /**
     * The value of the class node.
     *
     * @var string|null
     */
    public $value;

    /**
     * Create a new class node instance.
     *
     * @param string|null $value
     * @param self|null   $prev
     *
     * @return void
     */
    public function __construct(string $value = null, self $prev = null)
    {
        $this->value = $value;
        $this->prev = $prev;
    }
}
