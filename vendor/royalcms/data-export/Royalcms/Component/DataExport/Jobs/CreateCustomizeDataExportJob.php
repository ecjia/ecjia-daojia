<?php

namespace Royalcms\Component\DataExport\Jobs;

use Royalcms\Component\Contracts\Bus\SelfHandling;
use Royalcms\Component\DataExport\Zip;
use Royalcms\Component\Support\Facades\Storage;
use Royalcms\Component\Contracts\Queue\ShouldQueue;
use Royalcms\Component\Contracts\Filesystem\Filesystem;
use Royalcms\Component\TemporaryDirectory\TemporaryDirectory;
use Royalcms\Component\DataExport\Contracts\ExportsCustomizeData;
use Royalcms\Component\DataExport\CustomizeDataSelection;
use Royalcms\Component\DataExport\Events\CustomizeDataSelected;
use Royalcms\Component\DataExport\Events\CustomizeDataExportCreated;

class CreateCustomizeDataExportJob implements ShouldQueue, SelfHandling
{
    /** @var \Royalcms\Component\DataExport\Contracts\ExportsCustomizeData */
    protected $data;

    public function __construct(ExportsCustomizeData $data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        $temporaryDirectory = (new TemporaryDirectory())->create();

        $customizeDataSelection = (new CustomizeDataSelection($temporaryDirectory))->forData($this->data);

        $this->data->selectCustomizeData($customizeDataSelection);

        event(new CustomizeDataSelected($customizeDataSelection, $this->data));

        $zipFilename = $this->zipCustomizeData($customizeDataSelection, $this->getDisk(), $temporaryDirectory);

        $temporaryDirectory->delete();

        event(new CustomizeDataExportCreated($zipFilename, $this->data));
    }

    /**
     * @param \Royalcms\Component\TemporaryDirectory\TemporaryDirectory $temporaryDirectory
     * @return \Royalcms\Component\DataExport\CustomizeDataSelection
     */
    protected function selectPersonalData(TemporaryDirectory $temporaryDirectory)
    {
        $customizeData = new CustomizeDataSelection($temporaryDirectory);

        $this->data->selectCustomizeData($customizeData);

        return $customizeData;
    }

    /**
     * @param \Royalcms\Component\DataExport\CustomizeDataSelection      $customizeData
     * @param \Royalcms\Component\Contracts\Filesystem\Filesystem       $filesystem
     * @param \Royalcms\Component\TemporaryDirectory\TemporaryDirectory $temporaryDirectory
     * @return string
     */
    protected function zipCustomizeData(
        CustomizeDataSelection $customizeData,
        Filesystem $filesystem,
        TemporaryDirectory $temporaryDirectory
        )
    {
        $zip = Zip::createForCustomizeData($customizeData, $temporaryDirectory);

        $zipFilename = pathinfo($zip->path(), PATHINFO_BASENAME);

        $filesystem->writeStream($zipFilename, fopen($zip->path(), 'r'));

        return $zipFilename;
    }

    /**
     * @return \Royalcms\Component\Contracts\Filesystem\Filesystem
     */
    public function getDisk()
    {
        return Storage::disk('data-export');
    }

}
