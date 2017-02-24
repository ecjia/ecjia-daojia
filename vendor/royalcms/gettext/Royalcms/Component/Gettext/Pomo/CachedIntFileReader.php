<?php
defined('IN_ROYALCMS') or exit('No permission resources.');
/**
 * Reads the contents of the file in the beginning.
 */
class Component_Pomo_CachedIntFileReader extends Component_Pomo_CachedFileReader
{

    public function __construct($filename)
    {
        parent::__construct($filename);
    }
}

// end