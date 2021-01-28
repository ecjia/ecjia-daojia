<?php

namespace Royalcms\Component\DirectoryHasher\Source;

interface SourceInterface
{
    /**
     * Returns an array with an Robo47_DirectoryHasher_Result_File for each file
     *
     * @return array|\Royalcms\Component\DirectoryHasher\Result\File[]
     */
    public function getFileResults();
}
