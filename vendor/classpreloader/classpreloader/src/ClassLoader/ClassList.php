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
 * This is the class list class.
 *
 * This maintains a list of classes using a sort of doubly-linked list.
 *
 * @internal
 */
final class ClassList
{
    /**
     * The head node of the list.
     *
     * @var \ClassPreloader\ClassLoader\ClassNode
     */
    private $head;

    /**
     * The current node of the list.
     *
     * @var \ClassPreloader\ClassLoader\ClassNode
     */
    private $current;

    /**
     * Create a new class list instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->clear();
    }

    /**
     * Clear the contents of the list and reset the head node and current node.
     *
     * @return void
     */
    public function clear()
    {
        $this->head = new ClassNode();
        $this->current = $this->head;
    }

    /**
     * Traverse to the next node in the list.
     *
     * @return void
     */
    public function next()
    {
        if (isset($this->current->next)) {
            $this->current = $this->current->next;
        } else {
            $this->current->next = new ClassNode(null, $this->current);
            $this->current = $this->current->next;
        }
    }

    /**
     * Insert a value at the current position in the list.
     *
     * Any currently set value at this position will be pushed back in the list
     * after the new value.
     *
     * @param string $value
     *
     * @return void
     */
    public function push(string $value)
    {
        if ($this->current->value === null) {
            $this->current->value = $value;
        } else {
            $temp = $this->current;
            $this->current = new ClassNode($value, $temp->prev);
            $this->current->next = $temp;
            $temp->prev = $this->current;
            if ($temp === $this->head) {
                $this->head = $this->current;
            } else {
                assert($this->current->prev !== null);
                $this->current->prev->next = $this->current;
            }
        }
    }

    /**
     * Traverse the ClassList and return a list of classes.
     *
     * @return string[]
     */
    public function getClasses()
    {
        $classes = [];
        $current = $this->head;
        while ($current !== null && $current->value !== null) {
            $classes[] = $current->value;
            $current = $current->next;
        }

        return array_filter($classes);
    }
}
