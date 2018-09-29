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

use Royalcms\Component\Widget\Widget;

class ecjia_widget
{

    
    /**
     * Register all of the default WordPress widgets on startup.
     *
     * Calls 'widgets_init' action after all of the WordPress widgets have been
     * registered.
     *
     * @since 1.0.0
     */
    public static function widgets_init() {

        RC_Loader::load_sys_class('widgets.widget_nav_menu', false);
        RC_Loader::load_sys_class('widgets.widget_cat_articles', false);
        RC_Loader::load_sys_class('widgets.widget_cat_goods', false);
        RC_Loader::load_sys_class('widgets.widget_brand_goods', false);
        RC_Loader::load_sys_class('widgets.widget_ad_position', false);
        
        RC_Widget::registerWidget('widget_nav_menu');
        RC_Widget::registerWidget('widget_cat_articles');
        RC_Widget::registerWidget('widget_cat_goods');
        RC_Widget::registerWidget('widget_brand_goods');
        RC_Widget::registerWidget('widget_ad_position');


        /**
         * Fires after all default ECJia widgets have been registered.
         *
         * @since 1.0.0
        */
        RC_Hook::do_action( 'widgets_init' );

    }



    
    
    /**
     * Display list of the available widgets.
     *
     * @since 1.0.0
     */
    public static function get_list_widgets() {
        $sort = RC_Widget::getRegisteredWidgets();
        usort( $sort, array(__CLASS__, '_sort_name_callback') );

        $registered_widget_controls = RC_Widget::getRegisteredWidgetControls();
        
        $done = array();
    
        foreach ( $sort as $widget ) {
            if ( in_array( $widget['callback'], $done, true ) ) // We already showed this multi-widget
                continue;
    
            $sidebar = RC_Widget::is_active_widget( $widget['callback'], $widget['id'], false, false );
            $done[] = $widget['callback'];
    
            if ( ! isset( $widget['params'][0] ) )
                $widget['params'][0] = array();
    
            $args = array( 'widget_id' => $widget['id'], 'widget_name' => $widget['name'], '_display' => 'template' );

            if ( isset($registered_widget_controls[$widget['id']]['id_base']) && isset($widget['params'][0]['number']) ) {
                $id_base = $registered_widget_controls[$widget['id']]['id_base'];
                $args['_temp_id'] = "$id_base-__i__";
                $args['_multi_num'] = self::next_widget_id_number($id_base);
                $args['_add'] = 'multi';
            } else {
                $args['_add'] = 'single';
                if ( $sidebar )
                    $args['_hide'] = '1';
            }
    
            $args = self::list_widget_controls_dynamic_sidebar( array( 0 => $args, 1 => $widget['params'][0] ) );
            call_user_func_array( array(__CLASS__, 'widget_control'), $args );
        }
    }
    
    /**
     * Callback to sort array by a 'name' key.
     *
     * @since 1.0.0
     * @access private
     */
    public static function _sort_name_callback( $a, $b ) {
        return strnatcasecmp( $a['name'], $b['name'] );
    }
    
    /**
     * Show the widgets and their settings for a sidebar.
     * Used in the admin widget config screen.
     *
     * @since 1.0.0
     *
     * @param string $sidebar id slug of the sidebar
     * @param string optional $sidebar_name Include the HTML for the sidebar name
     */
    public static function list_widget_controls( $sidebar, $sidebar_name = '' ) {
        RC_Hook::add_filter( 'dynamic_sidebar_params', array(__CLASS__, 'list_widget_controls_dynamic_sidebar') );
    
        $description = RC_Widget::sidebarDescription( $sidebar );
    
        echo '<div id="' . RC_Format::esc_attr( $sidebar ) . '" class="widgets-sortables">';
    
        if ( $sidebar_name ) {
            ?>
    		<div class="sidebar-name">
    			<div class="sidebar-name-arrow"><br /></div>
    			<h3><?php echo RC_Format::esc_html( $sidebar_name ); ?> <span class="spinner"></span></h3>
    		</div>
    		<?php
    	}
    
    	echo '<div class="sidebar-description">';
    
    	if ( ! empty( $description ) ) {
    		echo '<p class="description">' . $description . '</p>';
    	}
    
    	echo '</div>';

        RC_Widget::dynamicSidebar( $sidebar );
    
    	echo '</div>';
    }
    
    /**
     * {@internal Missing Short Description}}
     *
     * @since 1.0.0
     *
     * @param array $params
     * @return array
     */
    public static function list_widget_controls_dynamic_sidebar( $params ) {
    	global $wp_registered_widgets;
    	static $i = 0;
    	$i++;
    
    	$widget_id = $params[0]['widget_id'];
    	$id = isset($params[0]['_temp_id']) ? $params[0]['_temp_id'] : $widget_id;
    	$hidden = isset($params[0]['_hide']) ? ' style="display:none;"' : '';
    
    	$params[0]['before_widget'] = "<div id='widget-{$i}_{$id}' class='widget'$hidden>";
    	$params[0]['after_widget'] = "</div>";
    	$params[0]['before_title'] = "%BEG_OF_TITLE%"; // deprecated
    	$params[0]['after_title'] = "%END_OF_TITLE%"; // deprecated
    	if ( is_callable( RC_Widget::$registered_widgets[$widget_id]['callback'] ) ) {
    		RC_Widget::$registered_widgets[$widget_id]['_callback'] = RC_Widget::$registered_widgets[$widget_id]['callback'];
    		RC_Widget::$registered_widgets[$widget_id]['callback'] = 'wp_widget_control';
    	}
    
    	return $params;
    }
    
    public static function next_widget_id_number($id_base) {
//     	global $wp_registered_widgets;
    	$number = 1;
    
    	foreach ( RC_Widget::$registered_widgets as $widget_id => $widget ) {
    		if ( preg_match( '/' . $id_base . '-([0-9]+)$/', $widget_id, $matches ) )
    			$number = max($number, $matches[1]);
    	}
    	$number++;
    
    	return $number;
    }
    
    /**
     * Meta widget used to display the control form for a widget.
     *
     * Called from dynamic_sidebar().
     *
     * @since 1.0.0
     *
     * @param array $sidebar_args
     * @return array
     */
    public static function widget_control( $sidebar_args ) {
    	$widget_id = $sidebar_args['widget_id'];
    	$sidebar_id = isset($sidebar_args['id']) ? $sidebar_args['id'] : false;
    	$key = $sidebar_id ? array_search( $widget_id, self::$sidebars_widgets[$sidebar_id] ) : '-1'; // position of widget in sidebar
    	$control = isset(RC_Widget::$registered_widget_controls[$widget_id]) ? RC_Widget::$registered_widget_controls[$widget_id] : array();
    	$widget = RC_Widget::$registered_widgets[$widget_id];
    
    	$id_format = $widget['id'];
    	$widget_number = isset($control['params'][0]['number']) ? $control['params'][0]['number'] : '';
    	$id_base = isset($control['id_base']) ? $control['id_base'] : $widget_id;
    	$multi_number = isset($sidebar_args['_multi_num']) ? $sidebar_args['_multi_num'] : '';
    	$add_new = isset($sidebar_args['_add']) ? $sidebar_args['_add'] : '';
    
    	$query_arg = array( 'editwidget' => $widget['id'] );
    	if ( $add_new ) {
    		$query_arg['addnew'] = 1;
    		if ( $multi_number ) {
    			$query_arg['num'] = $multi_number;
    			$query_arg['base'] = $id_base;
    		}
    	} else {
    		$query_arg['sidebar'] = $sidebar_id;
    		$query_arg['key'] = $key;
    	}
    
    	// We aren't showing a widget control, we're outputting a template for a multi-widget control
    	if ( isset($sidebar_args['_display']) && 'template' == $sidebar_args['_display'] && $widget_number ) {
    		// number == -1 implies a template where id numbers are replaced by a generic '__i__'
    		$control['params'][0]['number'] = -1;
    		// with id_base widget id's are constructed like {$id_base}-{$id_number}
    		if ( isset($control['id_base']) )
    			$id_format = $control['id_base'] . '-__i__';
    	}
    
    	RC_Widget::$registered_widgets[$widget_id]['callback'] = RC_Widget::$registered_widgets[$widget_id]['_callback'];
    	unset(RC_Widget::$registered_widgets[$widget_id]['_callback']);
    
    	$widget_title = RC_Format::esc_html( strip_tags( $sidebar_args['widget_name'] ) );
    	$has_form = 'noform';
    
    	echo $sidebar_args['before_widget']; ?>
    	<div class="widget-top">
    	<div class="widget-title-action">
    		<a class="widget-action hide-if-no-js" href="#available-widgets"></a>
    		<a class="widget-control-edit hide-if-js" href="<?php echo RC_Format::esc_url( RC_Uri::add_query_arg( $query_arg ) ); ?>">
    			<span class="edit"><?php _ex( 'Edit', 'widget' ); ?></span>
    			<span class="add"><?php _ex( 'Add', 'widget' ); ?></span>
    			<span class="screen-reader-text"><?php echo $widget_title; ?></span>
    		</a>
    	</div>
    	<div class="widget-title"><h4><?php echo $widget_title ?><span class="in-widget-title"></span></h4></div>
    	</div>
    
    	<div class="widget-inside">
    	<form action="" method="post">
    	<div class="widget-content">
    <?php
    	if ( isset($control['callback']) )
    		$has_form = call_user_func_array( $control['callback'], $control['params'] );
    	else
    		echo "\t\t<p>" . __('There are no options for this widget.') . "</p>\n"; ?>
    	</div>
    	<input type="hidden" name="widget-id" class="widget-id" value="<?php echo RC_Format::esc_attr($id_format); ?>" />
    	<input type="hidden" name="id_base" class="id_base" value="<?php echo RC_Format::esc_attr($id_base); ?>" />
    	<input type="hidden" name="widget-width" class="widget-width" value="<?php if (isset( $control['width'] )) echo RC_Format::esc_attr($control['width']); ?>" />
    	<input type="hidden" name="widget-height" class="widget-height" value="<?php if (isset( $control['height'] )) echo RC_Format::esc_attr($control['height']); ?>" />
    	<input type="hidden" name="widget_number" class="widget_number" value="<?php echo RC_Format::esc_attr($widget_number); ?>" />
    	<input type="hidden" name="multi_number" class="multi_number" value="<?php echo RC_Format::esc_attr($multi_number); ?>" />
    	<input type="hidden" name="add_new" class="add_new" value="<?php echo RC_Format::esc_attr($add_new); ?>" />
    
    	<div class="widget-control-actions">
    		<div class="alignleft">
    		<a class="widget-control-remove" href="#remove"><?php _e('Delete'); ?></a> |
    		<a class="widget-control-close" href="#close"><?php _e('Close'); ?></a>
    		</div>
    		<div class="alignright<?php if ( 'noform' === $has_form ) echo ' widget-control-noform'; ?>">
    			<?php ecjia_form::submit_button( __( 'Save' ), 'button-primary widget-control-save right', 'savewidget', false, array( 'id' => 'widget-' . RC_Format::esc_attr( $id_format ) . '-savewidget' ) ); ?>
    			<span class="spinner"></span>
    		</div>
    		<br class="clear" />
    	</div>
    	</form>
    	</div>
    
    	<div class="widget-description">
    <?php echo ( $widget_description = RC_Widget::widget_description($widget_id) ) ? "$widget_description\n" : "$widget_title\n"; ?>
    	</div>
    <?php
    	echo $sidebar_args['after_widget'];
    
    	return $sidebar_args;
    }
     
    
    

    
    public static $sidebars_widgets = array();
    
    /**
     * Retrieve full list of sidebars and their widgets.
     *
     * Will upgrade sidebar widget list, if needed. Will also save updated list, if
     * needed.
     *
     * @since 1.0.0
     * @access private
     *
     * @param bool $deprecated Not used (deprecated).
     * @return array Upgraded list of widgets to version 3 array format when called from the admin.
     */
    public static function get_sidebars_widgets() {
        
        self::$sidebars_widgets = ecjia_config::instance()->get_addon_config('sidebars_widgets', true);
    
        if ( is_array( self::$sidebars_widgets ) && isset(self::$sidebars_widgets['array_version']) )
            unset(self::$sidebars_widgets['array_version']);
    
        /**
         * Filter the list of sidebars and their widgets.
         *
         * @since 1.0.0
         *
         * @param array $sidebars_widgets An associative array of sidebars and their widgets.
        */
        self::$sidebars_widgets = RC_Hook::apply_filters( 'sidebars_widgets', self::$sidebars_widgets );
        return self::$sidebars_widgets;
    }
    
    

}

//end