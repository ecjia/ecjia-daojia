<?php

namespace Royalcms\Component\DataExport\Exceptions;

use Exception;

class CouldNotAddToCustomizeDataSelection extends Exception
{
    /**
     * @param string $path
     * @return \Royalcms\Component\DataExport\Exceptions\CouldNotAddToCustomizeDataSelection
     */
    public static function fileAlreadyAddedToPersonalDataSelection($path)
    {
        return new static("Could not add `{$path}` because it already exists.");
    }
}
