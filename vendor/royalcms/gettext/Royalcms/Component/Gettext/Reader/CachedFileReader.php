<?php

namespace Royalcms\Component\Gettext\Reader;

/**
 * Reads the contents of the file in the beginning.
 */
class CachedFileReader extends StringReader
{

    public function __construct($filename)
    {
        parent::__construct();

        $this->_str = file_get_contents($filename);

        if (false === $this->_str)
        {
            return false;
        }

        $this->_pos = 0;
    }
}

// end