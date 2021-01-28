<?php

namespace Royalcms\Component\DirectoryHasher\Hasher;

/**
 * Hasher which provides file size and mtime
 */
class FileData extends HasherAbstract
{

    /**
     * {@inheritdoc}
     */
    public function getHashsForFile($file) {
        return array(
            'size' => filesize($file),
            'mtime' => filemtime($file)
        );
    }

}
