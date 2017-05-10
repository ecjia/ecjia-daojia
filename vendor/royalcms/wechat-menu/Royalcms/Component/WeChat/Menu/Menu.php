<?php namespace Royalcms\Component\WeChat\Menu;

use Royalcms\Component\WeChat\Core\AbstractAPI;

/**
 * Class Menu.
 */
class Menu extends AbstractAPI
{
    const API_CREATE = 'https://api.weixin.qq.com/cgi-bin/menu/create';
    const API_GET = 'https://api.weixin.qq.com/cgi-bin/menu/get';
    const API_DELETE = 'https://api.weixin.qq.com/cgi-bin/menu/delete';
    const API_QUERY = 'https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info';
    const API_CONDITIONAL_CREATE = 'https://api.weixin.qq.com/cgi-bin/menu/addconditional';
    const API_CONDITIONAL_DELETE = 'https://api.weixin.qq.com/cgi-bin/menu/delconditional';
    const API_CONDITIONAL_TEST = 'https://api.weixin.qq.com/cgi-bin/menu/trymatch';

    /**
     * Get all menus.
     *
     * @return \Royalcms\Component\Support\Collection
     */
    public function all()
    {
        return $this->parseJSON('get', array(self::API_GET));
    }

    /**
     * Get current menus.
     *
     * @return \Royalcms\Component\Support\Collection
     */
    public function current()
    {
        return $this->parseJSON('get', array(self::API_QUERY));
    }

    /**
     * Add menu.
     *
     * @param array $buttons
     * @param array $matchRule
     *
     * @return bool
     */
    public function add(array $buttons, array $matchRule = array())
    {
        if (!empty($matchRule)) {
            return $this->parseJSON('json', array(self::API_CONDITIONAL_CREATE, array(
                'button' => $buttons,
                'matchrule' => $matchRule,
            )));
        }

        return $this->parseJSON('json', array(self::API_CREATE, array('button' => $buttons)));
    }

    /**
     * Destroy menu.
     *
     * @param int $menuId
     *
     * @return bool
     */
    public function destroy($menuId = null)
    {
        if ($menuId !== null) {
            return $this->parseJSON('json', array(self::API_CONDITIONAL_DELETE, array('menuid' => $menuId)));
        }

        return  $this->parseJSON('get', array(self::API_DELETE));
    }

    /**
     * Test conditional menu.
     *
     * @param string $userId
     *
     * @return bool
     */
    public function test($userId)
    {
        return $this->parseJSON('json', array(self::API_CONDITIONAL_TEST, array('user_id' => $userId)));
    }
}
