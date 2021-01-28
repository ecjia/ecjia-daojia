<?php

namespace Royalcms\Component\DirectoryHasher\Hasher;

/**
 * Hasher which generates SHA1-Hashes of the files
 */
class SHA1 extends HasherAbstract
{
    /**
     * {@inheritdoc}
     */
    public function getHashsForFile($file) {
        return array('sha1' => sha1_file($file));
    }
}
