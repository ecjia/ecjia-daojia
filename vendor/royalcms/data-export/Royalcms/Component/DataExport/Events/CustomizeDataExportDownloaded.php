<?php

namespace Royalcms\Component\DataExport\Events;

use Royalcms\Component\DataExport\Contracts\ExportsCustomizeData;

class CustomizeDataExportDownloaded
{
    /** @var string */
    public $zipFilename;

    /** @var \Royalcms\Component\DataExport\Contracts\ExportsCustomizeData|null */
    public $data;

    /**
     * PersonalDataExportDownloaded constructor.
     * @param                                                         $zipFilename
     * @param \Royalcms\Component\DataExport\Contracts\ExportsCustomizeData $data
     */
    public function __construct($zipFilename, ExportsCustomizeData $data)
    {
        $this->zipFilename = $zipFilename;

        $this->data = $data;
    }
}
