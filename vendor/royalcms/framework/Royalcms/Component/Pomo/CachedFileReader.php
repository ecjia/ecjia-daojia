<?php
defined('IN_ROYALCMS') or exit('No permission resources.');
/**
 * Reads the contents of the file in the beginning.
 */
class Component_Pomo_CachedFileReader extends Component_Pomo_StringReader
{

    public function __construct($filename)
    {
        parent::__construct();
        $this->_str = file_get_contents($filename);
        if (false === $this->_str)
            return false;
        $this->_pos = 0;
    }
}

// end