<?php

namespace Ecjia\Component\Version\Events;

use Ecjia\Component\Version\Version;

class UpgradeBeforeEvent
{

    /**
     * @var Version
     */
    public $version;

    /**
     * UpgradeBeforeEvent constructor.
     * @param Version $version
     */
    public function __construct(Version $version)
    {
        $this->version = $version;
    }


}