<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 获取友情链接列表
 * @author royalwang
 *
 */
class friendlink_friendlink_list_api extends Component_Event_Api
{
    /**
     * type: 获取列表类型
     *      logo：只获取带有LOGO的数据
     *      nologo: 只获取不带LOGO的数据
     *      all: 获取所有数据
     * 
     * @see Component_Event_Api::call()
     */
    public function call(&$options)
    {
        /*检测友情链接应用是否安装，未安装返回空数据
        if (!ecjia_app::is_active('ecjia.friendlink')) {
            return new ecjia_error('app_not_installed', '检测到友情链接应用未安装');
        }
        */
        $type = array_get($options, 'type', 'all');
        
        $link_list = RC_DB::table('friend_link')->where('status', 0)->orderBy('show_order', 'asc')->get();
        $has_logo_arr = $no_logo_arr = array();
        if (!empty($link_list)) {
            foreach ($link_list as $k => $v) {
                if (empty($v['link_logo'])) {
                    $no_logo_arr[] = $v;
                } else {
                    $v['link_logo'] = RC_Upload::upload_url($v['link_logo']);
                    $has_logo_arr[] = $v;
                }
            }
        }
        
        if ($type == 'logo')
        {
            return $has_logo_arr;
        }
        else if ($type == 'nologo')
        {
            return $no_logo_arr;
        }
        else 
        {
            return [$has_logo_arr, $no_logo_arr];
        }
    }
    
}

// end
