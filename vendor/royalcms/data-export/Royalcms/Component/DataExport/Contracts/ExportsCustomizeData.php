<?php

namespace Royalcms\Component\DataExport\Contracts;

use Royalcms\Component\DataExport\CustomizeDataSelection;

interface ExportsCustomizeData
{
    /**
     * @param \Royalcms\Component\DataExport\CustomizeDataSelection $customizeDataSelection
     * @return void
     */
    public function selectCustomizeData(CustomizeDataSelection $customizeDataSelection);

    /**
     * @return string
     */
    public function customizeDataExportName();

    public function getKey();
}
