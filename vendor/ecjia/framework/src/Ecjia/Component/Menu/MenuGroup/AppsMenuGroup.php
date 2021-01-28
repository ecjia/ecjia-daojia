<?php


namespace Ecjia\Component\Menu\MenuGroup;

/**
 * 应用菜单
 * Class AppsMenuGroup
 * @package Ecjia\Component\Menu\MenuGroup
 */
class AppsMenuGroup extends AbstractMenuGroup
{

    protected $group = 'apps';

    protected $label = '';

    protected $service_name = 'admin_menu';

    public function __construct(array $apps)
    {
        parent::__construct($apps);

        $this->label = __('应用', 'ecjia');
    }

}