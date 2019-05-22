<?php

namespace Royalcms\Component\DataExport\Events;

use Royalcms\Component\DataExport\Contracts\ExportsCustomizeData;
use Royalcms\Component\DataExport\CustomizeDataSelection;

class CustomizeDataSelected
{
    /** @var \Royalcms\Component\DataExport\CustomizeDataSelection */
    public $selectionData;

    /** @var \Royalcms\Component\DataExport\Contracts\ExportsCustomizeData */
    public $data;

    /**
     * PersonalDataSelected constructor.
     * @param \Royalcms\Component\DataExport\CustomizeDataSelection $selectionData
     * @param \Royalcms\Component\DataExport\Contracts\ExportsCustomizeData   $data
     */
    public function __construct(CustomizeDataSelection $selectionData, ExportsCustomizeData $data)
    {
        $this->selectionData = $selectionData;

        $this->data = $data;
    }
}
