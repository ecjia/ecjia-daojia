<?php

namespace Royalcms\Component\DirectoryHasher;

use Royalcms\Component\DirectoryHasher\Comparator\Difference\MissingFile;
use Royalcms\Component\DirectoryHasher\Comparator\Difference\NewFile;
use Royalcms\Component\DirectoryHasher\Comparator\Difference\MissingHash;
use Royalcms\Component\DirectoryHasher\Comparator\Difference\WrongHash;
use Royalcms\Component\DirectoryHasher\Result;
use Royalcms\Component\DirectoryHasher\Comparator\Result as ComparatorResult;
use Royalcms\Component\DirectoryHasher\Result\File;

class Comparator
{

    /**
     * Compares two Results
     *
     * @param \Royalcms\Component\DirectoryHasher\Result $old
     * @param \Royalcms\Component\DirectoryHasher\Result $new
     * @return \Royalcms\Component\DirectoryHasher\Comparator\Result
     */
    public function compare(Result $old, Result $new) {
        $result = new ComparatorResult();

        foreach ($old->getIterator() as $fileResult) {
            /* @var $fileResult \Royalcms\Component\DirectoryHasher\Result\File */
            if (!$new->hasFileResultFor($fileResult->getFilename())) {
                $result->addDifference(
                        new MissingFile(
                                $fileResult->getFilename()
                        )
                );
            } else {
                $result->addDifferences(
                        $this->getHashDifferences(
                                $fileResult, $new->getFileResultFor($fileResult->getFilename()
                                )
                        )
                );
            }
        }

        foreach ($new->getIterator() as $fileResult) {
            /* @var $fileResult \Royalcms\Component\DirectoryHasher\Result\File */
            if (!$old->hasFileResultFor($fileResult->getFilename())) {
                $result->addDifference(
                        new NewFile(
                                $fileResult->getFilename()
                        )
                );
            }
        }

        return $result;
    }

    /**
     * Returns differences of hashes
     *
     * @param \Royalcms\Component\DirectoryHasher\Result\File $oldFileResult
     * @param \Royalcms\Component\DirectoryHasher\Result\File $newFileResult
     * @return array|\Royalcms\Component\DirectoryHasher\Comparator\Difference\WrongHash[]
     */
    public function getHashDifferences(File $oldFileResult, File $newFileResult) {
        $differences = array();

        $oldHashes = $oldFileResult->getHashes();
        $newHashes = $newFileResult->getHashes();

        foreach ($oldHashes as $hashname => $value) {
            if (!isset($newHashes[$hashname])) {
                $differences[] = new MissingHash(
                                $oldFileResult->getFilename(), $hashname
                );
            } elseif (strval($oldHashes[$hashname]) !== strval($newHashes[$hashname])) {
                $differences[] = new WrongHash(
                                $oldFileResult->getFilename(), $hashname, $newHashes[$hashname], $oldHashes[$hashname]
                );
            }
        }

        return $differences;
    }

}
