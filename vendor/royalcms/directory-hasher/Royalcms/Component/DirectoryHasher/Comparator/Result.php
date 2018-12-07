<?php

namespace Royalcms\Component\DirectoryHasher\Comparator;

use Royalcms\Component\DirectoryHasher\Comparator\Difference\DifferenceInterface;

/**
 * Comparator Result
 */
class Result
{
    /**
     * @var array|\Royalcms\Component\DirectoryHasher\Comparator\Difference\DifferenceInterface[]
     */
    protected $differences = array();

    /**
     * Adds a difference
     *
     * @param \Royalcms\Component\DirectoryHasher\Comparator\Difference\DifferenceInterface $difference
     * @return \Royalcms\Component\DirectoryHasher\Comparator\Result *Provides fluent interface*
     */
    public function addDifference(DifferenceInterface $difference)
    {
        $this->differences[] = $difference;

        return $this;
    }

    /**
     * Add multiple differences
     *
     * @param array|\Royalcms\Component\DirectoryHasher\Comparator\Difference\DifferenceInterface[] $differences
     * @return \Royalcms\Component\DirectoryHasher\Comparator\Result *Provides fluent interface*
     */
    public function addDifferences(array $differences)
    {
        foreach($differences as $difference)
        {
            $this->addDifference($difference);
        }

        return $this;
    }

    /**
     * Returns the collected differences
     *
     * @return array|\Royalcms\Component\DirectoryHasher\Comparator\Difference\DifferenceInterface[]
     */
    public function getDifferences()
    {
        return $this->differences;
    }
}
