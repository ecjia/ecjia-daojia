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
/**
 * Plugin Upgrader Skin for ECJia Plugin Upgrades.
 *
 * @package ECJia
 * @subpackage Upgrader
 * @since 1.4.0
 */
class ecjia_bulk_upgrader_skin extends ecjia_upgrader_skin {
    public $in_loop = false;
    public $error = false;
    
    function __construct($args = array()) {
        $defaults = array( 'url' => '', 'nonce' => '' );
        $args = rc_parse_args($args, $defaults);
    
        parent::__construct($args);
    }
    
    function add_strings() {
        $this->upgrader->strings['skin_upgrade_start'] = __('The update process is starting. This process may take a while on some hosts, so please be patient.');
        $this->upgrader->strings['skin_update_failed_error'] = __('An error occurred while updating %1$s: <strong>%2$s</strong>');
        $this->upgrader->strings['skin_update_failed'] = __('The update of %1$s failed.');
        $this->upgrader->strings['skin_update_successful'] = __('%1$s updated successfully.').' <a onclick="%2$s" href="#" class="hide-if-no-js"><span>'.__('Show Details').'</span><span class="hidden">'.__('Hide Details').'</span>.</a>';
        $this->upgrader->strings['skin_upgrade_end'] = __('All updates have been completed.');
    }
    
    function feedback($string) {
        if ( isset( $this->upgrader->strings[$string] ) )
            $string = $this->upgrader->strings[$string];
    
        if ( strpos($string, '%') !== false ) {
            $args = func_get_args();
            $args = array_splice($args, 1);
            if ( $args ) {
                $args = array_map( 'strip_tags', $args );
                $args = array_map( 'esc_html', $args );
                $string = vsprintf($string, $args);
            }
        }
        if ( empty($string) )
            return;
        if ( $this->in_loop )
            echo "$string<br />\n";
        else
            echo "<p>$string</p>\n";
    }
    
    function header() {
        // Nothing, This will be displayed within a iframe.
    }
    
    function footer() {
        // Nothing, This will be displayed within a iframe.
    }
    
    function error($error) {
        if ( is_string($error) && isset( $this->upgrader->strings[$error] ) )
            $this->error = $this->upgrader->strings[$error];
    
        if ( is_ecjia_error($error) ) {
            foreach ( $error->get_error_messages() as $emessage ) {
                if ( $error->get_error_data() && is_string( $error->get_error_data() ) )
                    $messages[] = $emessage . ' ' . RC_Format::esc_html( strip_tags( $error->get_error_data() ) );
                else
                    $messages[] = $emessage;
            }
            $this->error = implode(', ', $messages);
        }
        echo '<script type="text/javascript">jQuery(\'.waiting-' . RC_Format::esc_js($this->upgrader->update_current) . '\').hide();</script>';
    }
    
    function bulk_header() {
        $this->feedback('skin_upgrade_start');
    }
    
    function bulk_footer() {
        $this->feedback('skin_upgrade_end');
    }
    
    function before($title = '') {
        $this->in_loop = true;
        printf( '<h4>' . $this->upgrader->strings['skin_before_update_header'] . ' <span class="spinner waiting-' . $this->upgrader->update_current . '"></span></h4>',  $title, $this->upgrader->update_current, $this->upgrader->update_count);
        echo '<script type="text/javascript">jQuery(\'.waiting-' . RC_Format::esc_js($this->upgrader->update_current) . '\').css("display", "inline-block");</script>';
        echo '<div class="update-messages hide-if-js" id="progress-' . RC_Format::esc_attr($this->upgrader->update_current) . '"><p>';
        $this->flush_output();
    }
    
    function after($title = '') {
        echo '</p></div>';
        if ( $this->error || ! $this->result ) {
            if ( $this->error )
                echo '<div class="error"><p>' . sprintf($this->upgrader->strings['skin_update_failed_error'], $title, $this->error) . '</p></div>';
            else
                echo '<div class="error"><p>' . sprintf($this->upgrader->strings['skin_update_failed'], $title) . '</p></div>';
    
            echo '<script type="text/javascript">jQuery(\'#progress-' . RC_Format::esc_js($this->upgrader->update_current) . '\').show();</script>';
        }
        if ( $this->result && ! is_ecjia_error( $this->result ) ) {
            if ( ! $this->error )
                echo '<div class="updated"><p>' . sprintf($this->upgrader->strings['skin_update_successful'], $title, 'jQuery(\'#progress-' . RC_Format::esc_js($this->upgrader->update_current) . '\').toggle();jQuery(\'span\', this).toggle(); return false;') . '</p></div>';
            echo '<script type="text/javascript">jQuery(\'.waiting-' . RC_Format::esc_js($this->upgrader->update_current) . '\').hide();</script>';
        }
    
        $this->reset();
        $this->flush_output();
    }
    
    function reset() {
        $this->in_loop = false;
        $this->error = false;
    }
    
    function flush_output() {
        wp_ob_end_flush_all();
        flush();
    }
    
    /**
     * Output JavaScript that sends message to parent window to decrement the update counts.
     *
     * @since 3.9.0
     *
     * @param string $type Type of update count to decrement. Likely values include 'plugin',
     *                     'theme', 'translation', etc.
     */
    protected function decrement_update_count( $type ) {
        if ( ! $this->result || is_ecjia_error( $this->result ) || 'up_to_date' === $this->result ) {
            return;
        }
        echo '<script type="text/javascript">
				if ( window.postMessage && JSON ) {
					window.parent.postMessage( JSON.stringify( { action: "decrementUpdateCount", upgradeType: "' . $type . '" } ), window.location.protocol + "//" + window.location.hostname );
				}
			</script>';
    }
    
}

// end