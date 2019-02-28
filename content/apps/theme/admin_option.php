<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/22
 * Time: 15:03
 */

defined('IN_ECJIA') or exit('No permission resources.');


class admin_option extends ecjia_admin
{

    public function __construct()
    {
        parent::__construct();

        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jquery-uniform');

        RC_Script::enqueue_script('admin_option', RC_App::apps_url('statics/js/admin_option.js', __FILE__));
    }


    public function init()
    {
        $this->admin_priv('theme_option_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('主题选项', 'theme')));

        if (RC_Hook::has_action('admin_theme_option_nav')) {

            $section = $this->request->input('section');

            if (empty($section)) {
                $section = RC_Hook::apply_filters('template_option_default_section', $section);
            }


            $this->assign('current_code', $section);

            $this->display('template_option.dwt');
        } else {
            $this->display('template_option_default.dwt');
        }

    }


    /**
     * we are saving settings sent from a settings page
     */
    public function update()
    {
        $this->admin_priv('theme_option_update', ecjia::MSGTYPE_JSON);

        $section = $this->request->input('section');

        $whitelist_options = array();

        /**
         * Filters the options white list.
         *
         * @since 2.7.0
         *
         * @param array $whitelist_options White list options.
         */
        $whitelist_options = RC_Hook::apply_filters('whitelist_options', $whitelist_options);

        $options = $this->request->input(Ecjia\App\Theme\ThemeFramework\ThemeConstant::CS_OPTION);

        if ($options) {

            foreach ($options as $option => $value) {
                $option = trim($option);

                if (!is_array($value)) {
                    $value = trim($value);
                }

                $value = rc_unslash($value);

                ecjia_theme_option::update_option($option, $value);
            }

        }

        /**
         * Handle settings errors and return to options page
         */
        // If no settings errors were registered add a general 'updated' message.
        if (!count(ecjia_theme_setting::get_settings_errors())) {
            ecjia_theme_setting::add_settings_error('general', 'settings_updated', __('设置保存成功。', 'theme'), 'updated');
        }

        ecjia_theme_transient::set_transient('settings_errors', ecjia_theme_setting::get_settings_errors(), 30);

        RC_Hook::do_action('admin_theme_option_save');

        $this->showmessage(__('设置保存成功', 'theme'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('theme/admin_option/init', array('section' => $section))));
    }

}