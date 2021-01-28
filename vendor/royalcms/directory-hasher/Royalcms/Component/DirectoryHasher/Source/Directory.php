<?php

namespace Royalcms\Component\DirectoryHasher\Source;

use Exception;
use SplFileInfo;
use RecursiveDirectoryIterator;
use Royalcms\Component\DirectoryHasher\Result\File;

class Directory implements SourceInterface
{

    /**
     * Directory
     *
     * @var string
     */
    protected $directory;

    /**
     * Ignored directories
     *
     * @var array
     */
    protected $ignoredDirectories;

    /**
     * Ignored files
     *
     * @var array
     */
    protected $ignoredFiles = array();

    /**
     * Check extensions
     *
     * @var array
     */
    protected $checkExtensions = array();

    /**
     * Array of SplFileInfo Objects
     *
     * @var array|\Royalcms\Component\DirectoryHasher\Result\File[]
     */
    protected $results = array();

    /**
     * If the files are already loaded
     *
     * @var boolean
     */
    protected $loaded = false;

    /**
     * @param string $directory
     * @param array $ignoredDirectories
     */
    public function __construct($directory, array $ignoredDirectories = array())
    {
        $this->directory = realpath($directory);
        if (false === $directory) {
            $message = sprintf('Path "%s" does not exist', $directory);
            throw new Exception($message);
        }

        foreach ($ignoredDirectories as $key => $ignoredDirectory)
        {
            $ignoredDirectories[$key] = realpath($ignoredDirectory);
            if (false === $directory) {
                $message = sprintf(
                    'Ignored Path "%s" does not exist', $ignoredDirectory
                );
                throw new Exception($message);
            }
        }
        $this->ignoredDirectories = $ignoredDirectories;
    }

    /**
     * Returns directory
     *
     * @return string
     */
    public function getDirectory() {
        return $this->directory;
    }

    /**
     * Ignored directories
     *
     * @return array
     */
    public function getIgnoredDirectories() {
        return $this->ignoredDirectories;
    }

    /**
     * Check extensions
     *
     * @var array
     */
    public function getCheckExtensions() {
        return $this->checkExtensions;
    }

    /**
     * Ignored files
     *
     * @return array
     */
    public function setCheckExtensions(array $checkExtensions) {
        $this->checkExtensions = $checkExtensions;
    }

    /**
     * Check extensions
     * extension name not is dot
     *
     * @return array
     */
    public function addCheckExtension($checkExtension) {
        $this->checkExtensions[] = $checkExtension;
    }

    /**
     * Check extensions
     *
     * @return array
     */
    public function getIgnoredFiles() {
        return $this->ignoredFiles;
    }

    /**
     * Ignored files
     *
     * @return array
     */
    public function setIgnoredFiles(array $ignoredFiles) {
        $this->ignoredFiles = $ignoredFiles;
    }

    /**
     * Ignored files
     *
     * @return array
     */
    public function addIgnoredFile($ignoredFile) {
        $this->ignoredFiles[] = $ignoredFile;
    }

    /**
     * Uses iterator to create array of Result_File
     */
    protected function loadFiles() {
        if ($this->loaded === true) {
            return;
        }
        $iter = new RecursiveDirectoryIterator($this->directory);
        $this->iterateFiles($iter);
        $this->loaded = true;
    }

    /**
     * Not using recursiveDirectoryIterator to savely ignore unreadable directories
     * 
     * @param RecursiveDirectoryIterator $iter
     */
    protected function iterateFiles(RecursiveDirectoryIterator $iter)
    {
        foreach ($iter as $file) {
            if (!is_readable($file)) {
                continue;
            } else if(!$iter->isDot()) {
                if (is_file((string) $file)) {
                    if (!$this->isIgnored($file) && !$this->isIgnoredDirectory($file)) {
                        if ($this->isCheckExtensioned($file)) {
                            $this->results[] = new File($file->getRealPath());
                        }
                    }
                } else if (is_dir(($file))) {
                    $this->iterateFiles(new RecursiveDirectoryIterator((string) $file));
                }
            }
        }
    }

    /**
     * is check extension File
     *
     * @param SplFileInfo $file
     * @return boolean
     */
    protected function isCheckExtensioned(SplFileInfo $file) {
        if (empty($this->checkExtensions)) {
            return true;
        }

        return in_array($file->getExtension(), $this->checkExtensions);
    }

    /**
     * is dot File
     *
     * @param SplFileInfo $file
     * @return boolean
     */
    protected function isIgnored(SplFileInfo $file) {
        return ($file->getFilename() === '.' ||
            $file->getFilename() === '..' ||
            in_array($file->getFilename(), $this->ignoredFiles)
        );
    }

    /**
     * @param string $file
     */
    protected function isIgnoredDirectory(SplFileInfo $file) {
        foreach ($this->ignoredDirectories as $directory) {
            if (0 === strpos((string)$file, $directory)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getFileResults() {
        $this->loadFiles();

        return $this->results;
    }

}
