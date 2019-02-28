<?php
defined('IN_ECJIA') or exit('No permission resources.');

class topic_installer extends ecjia_installer
{

    protected $dependent = array(
        'ecjia.system'    => '1.0',
        'ecjia.promotion' => '1.0',
    );

    public function __construct()
    {
        $id = 'ecjia.topic';
        parent::__construct($id);
    }

    public function install()
    {

    }

    public function uninstall()
    {

    }

}

// end
