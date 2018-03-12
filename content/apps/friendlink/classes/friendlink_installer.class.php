<?php
defined('IN_ECJIA') or exit('No permission resources.');

class friendlink_installer extends ecjia_installer
{
    protected $dependent = array(
        'ecjia.system' => '1.0',
    );

    public function __construct()
    {
        $id = 'ecjia.friendlink';
        parent::__construct($id);
    }

    public function install()
    {
    	return true;
    }

    public function uninstall()
    {
    	return true;
    }

}

// end
