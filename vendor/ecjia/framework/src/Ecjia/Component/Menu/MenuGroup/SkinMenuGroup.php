<?php


namespace Ecjia\Component\Menu\MenuGroup;

/**
 * 外观菜单
 * Class SkinMenuGroup
 * @package Ecjia\Component\Menu\MenuGroup
 */
class SkinMenuGroup extends AbstractMenuGroup
{

    protected $group = 'skin';

    protected $label = '';

    protected $service_name = 'skin_menu';

    public function __construct(array $apps)
    {
        parent::__construct($apps);
        
        $this->label = __('外观', 'ecjia');
    }

}