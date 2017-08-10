<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
defined('IN_ECJIA') or exit('No permission resources.');

class ecjia_admin_setting extends RC_Object {
    
    public function __construct(){
        
    }
    
    
    public function load_groups() {
        $menus = array(
            ecjia_admin::make_admin_menu('shop_info', $this->cfg_name_langs('shop_info'), RC_Uri::url('setting/shop_config/init', array('code' => 'shop_info')), 2)->add_purview('shop_config')->add_icon('fontello-icon-wrench'),
            ecjia_admin::make_admin_menu('basic', $this->cfg_name_langs('basic'), RC_Uri::url('setting/shop_config/init', array('code' => 'basic')), 1)->add_purview('shop_config')->add_icon('fontello-icon-info'),
            ecjia_admin::make_admin_menu('display', $this->cfg_name_langs('display'), RC_Uri::url('setting/shop_config/init', array('code' => 'display')), 3)->add_purview('shop_config')->add_icon('fontello-icon-desktop'),
            ecjia_admin::make_admin_menu('shopping_flow', $this->cfg_name_langs('shopping_flow'), RC_Uri::url('setting/shop_config/init', array('code' => 'shopping_flow')), 4)->add_purview('shop_config')->add_icon('fontello-icon-truck'),
            ecjia_admin::make_admin_menu('goods', $this->cfg_name_langs('goods'), RC_Uri::url('setting/shop_config/init', array('code' => 'goods')), 5)->add_purview('shop_config')->add_icon('fontello-icon-gift'),
        );
        
        $menus = RC_Hook::apply_filters('append_admin_setting_group', $menus);
        return $menus;
    }
    
    
    public function load_items($group) {
        $parent_id = $this->get_parent_id($group);
        
        $item_list = RC_DB::table('shop_config')
                    ->where('parent_id', $parent_id)
                    ->where('type', '<>', 'hidden')
                    ->orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();

        foreach ($item_list AS $key => & $item) {
            $item['name'] = $this->cfg_name_langs($item['code'], $item['code']);
            $item['desc'] = $this->cfg_desc_langs($item['code'], '');
            
            if ($item['type']=='file' && !empty($item['value'])) {
                if ($item['code'] == 'icp_file') {
                	$value = explode('/', $item['value']);
                    $item['file_name'] = array_pop($value);
                }
                $item['value'] = RC_Upload::upload_url() .'/'. $item['value'];
            }
            
            if ($item['code'] == 'sms_shop_mobile') {
                $item['url'] = 1;
            }
            
            if ($item['store_range']) {
                $item['store_options'] = explode(',', $item['store_range']);
            
                foreach ($item['store_options'] AS $k => $v) {
                    $item['display_options'][$k] = $this->cfg_range_langs($item['code'].'.'.$v, $v);
                }
            }
        }
        
        return $item_list;
    }

    
    public function get_lang_list() {
        return array(
        	'zh_CN'
        );
    }
    
    protected function get_parent_id($code) {
        $id = RC_DB::table('shop_config')->where('parent_id', 0)->where('type', 'group')->where('code', $code)->pluck('id');
        return $id;
    }
    
    public function cfg_name_langs($key, $default = null) {
        $cfg_name_lang  = RC_Lang::get('setting::shop_config.cfg_name');
        
        return array_get($cfg_name_lang, $key, $default);
    }
    
    public function cfg_desc_langs($key, $default = null) {
        $cfg_desc_lang  = RC_Lang::get('setting::shop_config.cfg_desc');
        
        return array_get($cfg_desc_lang, $key, $default);
    }
    
    public function cfg_range_langs($key, $default = null) {
        $cfg_range_lang = RC_Lang::get('setting::shop_config.cfg_range');
        
        return array_get($cfg_range_lang, $key, $default);
    }
    
    /**
     * 是否覆盖文件
     * @param string $code
     * @return boolean
     */
    public function is_replace_file($code) {
        //定义需要替换的文件
        $files = array('shop_logo', 'watermark', 'wap_logo', 'no_picture', 'wap_app_download_img');
         
        return in_array($code, $files);
    }
    
    /**
     * 删除需要覆盖的文件
     *
     * @param string $code
     * @param string $value
     */
    public function replace_file($code, $value) {
        //删除原有文件
        if ($this->is_replace_file($code)) {
        	$disk = RC_Filesystem::disk();
            if ($disk->exists(RC_Upload::upload_path() . $value)) {
                $disk->delete(RC_Upload::upload_path() . $value);
            }
        }
    }
    
}

// end