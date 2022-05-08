<?php


namespace Ecjia\Component\Menu\MenuGroup;

/**
 * 系统菜单
 * Class SystemMenuGroup
 * @package Ecjia\Component\Menu\MenuGroup
 */
class SystemMenuGroup extends AbstractMenuGroup
{

    protected $group = 'system';

    protected $label = '';

    protected $service_name = 'system_menu';

    public function __construct(array $apps)
    {
        parent::__construct($apps);
        
        $this->label = __('控制面板', 'ecjia');
    }

}