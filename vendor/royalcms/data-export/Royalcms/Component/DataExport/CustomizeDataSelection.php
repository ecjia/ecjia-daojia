<?php

namespace Royalcms\Component\DataExport;

use Royalcms\Component\DataExport\Contracts\ExportsCustomizeData;
use Royalcms\Component\Filesystem\Filesystem;
use Royalcms\Component\Support\Facades\Storage;
use Royalcms\Component\TemporaryDirectory\TemporaryDirectory;
use Royalcms\Component\DataExport\Exceptions\CouldNotAddToCustomizeDataSelection;

class CustomizeDataSelection
{
    /** @var \Royalcms\Component\TemporaryDirectory\TemporaryDirectory */
    protected $temporaryDirectory;

    /** @var array */
    protected $files = [];

    /** @var \Royalcms\Component\Database\Eloquent\Model */
    public $data;

    public function __construct(TemporaryDirectory $temporaryDirectory)
    {
        $this->temporaryDirectory = $temporaryDirectory;
    }

    /**
     * @return array
     */
    public function files()
    {
        return $this->files;
    }

    /**
     * @param \Royalcms\Component\DataExport\Contracts\ExportsCustomizeData $data
     * @return $this
     */
    public function forData(ExportsCustomizeData $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param $nameInDownload
     * @param $content
     * @return \Royalcms\Component\DataExport\CustomizeDataSelection
     * @throws \Royalcms\Component\DataExport\Exceptions\CouldNotAddToCustomizeDataSelection
     */
    public function add($nameInDownload, $content)
    {
        if (! is_string($content)) {
            $content = json_encode($content);
        }

        $path = $this->temporaryDirectory->path($nameInDownload);

        $this->ensureDoesNotOverwriteExistingFile($path);

        $this->files[] = $path;

        file_put_contents($path, $content);

        return $this;
    }

    /**
     * @param      $pathToFile
     * @param      $pathToSave
     * @param null $diskName
     * @return \Royalcms\Component\DataExport\CustomizeDataSelection
     * @throws \Royalcms\Component\DataExport\Exceptions\CouldNotAddToCustomizeDataSelection
     */
    public function addFile($pathToFile, $pathToSave = null, $diskName = null)
    {
        return is_null($diskName)
            ? $this->copyLocalFile($pathToFile, $pathToSave)
            : $this->copyFileFromDisk($pathToFile, $pathToSave, $diskName);
    }

    /**
     * @param $pathToFile
     * @param $pathToSave
     * @return $this
     * @throws \Royalcms\Component\DataExport\Exceptions\CouldNotAddToCustomizeDataSelection
     */
    protected function copyLocalFile($pathToFile, $pathToSave = null)
    {
        if (is_null($pathToSave)) {
            $fileName = pathinfo($pathToFile, PATHINFO_BASENAME);
        }
        else {
            $fileName = $pathToSave;
        }

        $destination = $this->temporaryDirectory->path($fileName);

        $this->ensureDoesNotOverwriteExistingFile($destination);

        (new Filesystem())->copy($pathToFile, $destination);

        $this->files[] = $destination;

        return $this;
    }

    /**
     * @param $pathOnDisk
     * @param $pathToSave
     * @param $diskName
     * @return $this
     * @throws \Royalcms\Component\DataExport\Exceptions\CouldNotAddToCustomizeDataSelection
     */
    protected function copyFileFromDisk($pathOnDisk, $pathToSave = null, $diskName)
    {
        $stream = Storage::disk($diskName)->readStream($pathOnDisk);

        if (is_null($pathToSave)) {
            $fileName = $pathOnDisk;
        }
        else {
            $fileName = $pathToSave;
        }

        $pathInTemporaryDirectory = $this->temporaryDirectory->path($fileName);

        $this->ensureDoesNotOverwriteExistingFile($pathInTemporaryDirectory);

        file_put_contents($pathInTemporaryDirectory, stream_get_contents($stream), FILE_APPEND);

        return $this;
    }

    /**
     * @param string $path
     * @throws \Royalcms\Component\DataExport\Exceptions\CouldNotAddToCustomizeDataSelection
     */
    protected function ensureDoesNotOverwriteExistingFile($path)
    {
        if (file_exists($path)) {
            throw CouldNotAddToCustomizeDataSelection::fileAlreadyAddedToPersonalDataSelection($path);
        }
    }
}
