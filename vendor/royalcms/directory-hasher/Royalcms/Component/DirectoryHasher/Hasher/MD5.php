<?php

namespace Royalcms\Component\DirectoryHasher\Hasher;

/**
 * Hasher which generates MD5-Hashes of the files
 */
class MD5 extends HasherAbstract
{
    /**
     * {@inheritdoc}
     */
    public function getHashsForFile($file) {
        return array('md5' => md5_file($file));
    }
}
