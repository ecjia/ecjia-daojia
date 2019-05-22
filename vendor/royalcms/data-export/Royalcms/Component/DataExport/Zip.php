<?php

namespace Royalcms\Component\DataExport;

use ZipArchive;
use Royalcms\Component\Support\Str;
use Royalcms\Component\TemporaryDirectory\TemporaryDirectory;

class Zip
{
    /** @var \ZipArchive */
    protected $zipFile;

    /** @var int */
    protected $fileCount = 0;

    /** @var string */
    protected $pathToZip;

    public static function createForCustomizeData(
        CustomizeDataSelection $customizeDataSelection,
        TemporaryDirectory $temporaryDirectory)
    {
        $zipFilenameParts = [
            $customizeDataSelection->data->getKey(),
            now()->timestamp,
            Str::random(64),
        ];

        $zipFilename = implode('-', $zipFilenameParts).'.zip';

        $pathToZip = $temporaryDirectory->path($zipFilename);

        return (new static($pathToZip))
            ->add($customizeDataSelection->files(), $temporaryDirectory->path())
            ->close();
    }

    public function __construct($pathToZip)
    {
        $this->zipFile = new ZipArchive();

        $this->pathToZip = $pathToZip;

        $this->open();
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->pathToZip;
    }

    /**
     * @return int
     */
    public function size()
    {
        if ($this->fileCount === 0) {
            return 0;
        }

        return filesize($this->pathToZip);
    }

    /**
     * @return \Royalcms\Component\DataExport\Zip
     */
    public function open()
    {
        $this->zipFile->open($this->pathToZip, ZipArchive::CREATE);

        return $this;
    }

    /**
     * @param string|array $files
     * @param string $rootPath
     *
     * @return \Royalcms\Component\DataExport\Zip
     */
    public function add($files, $rootPath)
    {
        foreach ($files as $file) {
            if (file_exists($file)) {
                $nameInZip = Str::after($file, $rootPath.'/');

                $this->zipFile->addFile($file, ltrim($nameInZip, DIRECTORY_SEPARATOR));
            }
            $this->fileCount++;
        }

        return $this;
    }

    /**
     * @return \Royalcms\Component\DataExport\Zip
     */
    public function close()
    {
        $this->zipFile->close();

        return $this;
    }
}
