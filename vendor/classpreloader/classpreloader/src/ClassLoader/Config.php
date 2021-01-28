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
 * This is the loader config class.
 */
final class Config
{
    /**
     * The array of file names.
     *
     * @var string[]
     */
    protected $filenames = [];

    /**
     * The array of exclusive filters.
     *
     * @var string[]
     */
    protected $exclusiveFilters = [];

    /**
     * The array of inclusive filters.
     *
     * @var string[]
     */
    protected $inclusiveFilters = [];

    /**
     * Get an array of file names that satisfy any added filters.
     *
     * @return string[]
     */
    public function getFilenames()
    {
        $filenames = [];
        foreach ($this->filenames as $f) {
            foreach ($this->inclusiveFilters as $filter) {
                if ((int) @preg_match($filter, $f) === 0) {
                    continue 2;
                }
            }
            foreach ($this->exclusiveFilters as $filter) {
                if ((int) @preg_match($filter, $f) > 0) {
                    continue 2;
                }
            }
            $filenames[] = $f;
        }

        return $filenames;
    }

    /**
     * Add the filename owned by the config.
     *
     * @param string $filename
     *
     * @return $this
     */
    public function addFile(string $filename)
    {
        $this->filenames[] = $filename;

        return $this;
    }

    /**
     * Add a filter used to filter out file names matching the pattern.
     *
     * We're filtering the classes using a regular expression.
     *
     * @param string $pattern
     *
     * @return $this
     */
    public function addExclusiveFilter(string $pattern)
    {
        $this->exclusiveFilters[] = $pattern;

        return $this;
    }

    /**
     * Add a filter used to grab only file names matching the pattern.
     *
     * We're filtering the classes using a regular expression.
     *
     * @param string $pattern Regular expression pattern
     *
     * @return $this
     */
    public function addInclusiveFilter(string $pattern)
    {
        $this->inclusiveFilters[] = $pattern;

        return $this;
    }
}
