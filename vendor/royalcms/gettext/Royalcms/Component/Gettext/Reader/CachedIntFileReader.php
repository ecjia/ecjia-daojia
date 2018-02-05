<?php

namespace Royalcms\Component\Gettext\Reader;

/**
 * Reads the contents of the file in the beginning.
 */
class CachedIntFileReader extends CachedFileReader
{

    public function __construct($filename)
    {
        parent::__construct($filename);
    }
}

// end