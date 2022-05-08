<?php
namespace Ecjia\Component\Upgrade\Skin;

use Ecjia\Component\Upgrade\UpgraderSkin;
use RC_Format;

/**
 * Plugin Upgrader Skin for ECJia Plugin Upgrades.
 *
 * @package ECJia
 * @subpackage Upgrader
 * @since 1.4.0
 */
class BulkUpgraderSkin extends UpgraderSkin
{
    protected $in_loop = false;
    protected $error = false;
    
    public function __construct($args = array())
    {
        $defaults = array( 'url' => '', 'nonce' => '' );
        $args = rc_parse_args($args, $defaults);
    
        parent::__construct($args);
    }
    
    public function add_strings()
    {
        $this->upgrader->strings['skin_upgrade_start'] = __('The update process is starting. This process may take a while on some hosts, so please be patient.', 'ecjia');
        $this->upgrader->strings['skin_update_failed_error'] = __('An error occurred while updating %1$s: <strong>%2$s</strong>', 'ecjia');
        $this->upgrader->strings['skin_update_failed'] = __('The update of %1$s failed.', 'ecjia');
        $this->upgrader->strings['skin_update_successful'] = __('%1$s updated successfully.', 'ecjia').' <a onclick="%2$s" href="#" class="hide-if-no-js"><span>'.__('Show Details', 'ecjia').'</span><span class="hidden">'.__('Hide Details', 'ecjia').'</span>.</a>';
        $this->upgrader->strings['skin_upgrade_end'] = __('All updates have been completed.', 'ecjia');
    }
    
    public function feedback($string)
    {
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
    
    public function header()
    {
        // Nothing, This will be displayed within a iframe.
    }
    
    public function footer()
    {
        // Nothing, This will be displayed within a iframe.
    }
    
    public function error($error)
    {
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
    
    public function bulk_header()
    {
        $this->feedback('skin_upgrade_start');
    }
    
    public function bulk_footer()
    {
        $this->feedback('skin_upgrade_end');
    }
    
    public function before($title = '')
    {
        $this->in_loop = true;
        printf( '<h4>' . $this->upgrader->strings['skin_before_update_header'] . ' <span class="spinner waiting-' . $this->upgrader->update_current . '"></span></h4>',  $title, $this->upgrader->update_current, $this->upgrader->update_count);
        echo '<script type="text/javascript">jQuery(\'.waiting-' . RC_Format::esc_js($this->upgrader->update_current) . '\').css("display", "inline-block");</script>';
        echo '<div class="update-messages hide-if-js" id="progress-' . RC_Format::esc_attr($this->upgrader->update_current) . '"><p>';
        $this->flush_output();
    }
    
    public function after($title = '')
    {
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
    
    public function reset()
    {
        $this->in_loop = false;
        $this->error = false;
    }
    
    public function flush_output()
    {
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