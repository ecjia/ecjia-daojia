<?php

namespace Royalcms\Component\DirectoryHasher\Comparator\Difference;

/**
 * Interface for Differences
 */
interface DifferenceInterface
{

    /**
     * Returns the file path
     *
     * @return string
     */
    public function getFile();

    /**
     * Returns the message
     *
     * @return string
     */
    public function toString();
}
