<?php

namespace Royalcms\Component\DirectoryHasher\Result;

/**
 * Representation of a single File-Resulst
 */
class File
{
    /**
     * @var string
     */
    protected $filename;

    /**
     * @var array
     */
    protected $hashes;

    /**
     * @param string $filename
     * @param array $hashes
     */
    public function __construct($filename, array $hashes = array())
    {
        $this->filename = $filename;
        $this->hashes = $hashes;
    }

    /**
     * Returns filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Adds a hash
     *
     * @param string $name
     * @param string $value
     * @return \Royalcms\Component\DirectoryHasher\Result\File *Provides fluent interface*
     */
    public function addHash($name, $value)
    {
        $this->hashes[$name] = $value;

        return $this;
    }

    /**
     * Returns hashs
     *
     * @return array
     */
    public function getHashes()
    {
        return $this->hashes;
    }

}
