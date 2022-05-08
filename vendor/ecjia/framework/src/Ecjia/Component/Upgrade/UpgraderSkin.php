<?php
namespace Ecjia\Component\Upgrade;

/**
 * The User Interface "Skins" for the ECJia File Upgrader
 *
 * @package ECJia
 * @subpackage Upgrader
 * @since 1.4.0
 */

/**
 * Generic Skin for the ECJia Upgrader classes. This skin is designed to be extended for specific purposes.
 *
 * @package ECJia
 * @subpackage Upgrader
 * @since 1.4.0
 */
class UpgraderSkin
{
    /**
     * @var Upgrader
     */
    public $upgrader;
    public $done_header = false;
    public $result = false;
    
    public function __construct($args = array())
    {
        $defaults = array(
            'url' => '',
            'nonce' => '',
            'title' => '',
            'context' => false
        );
        $this->options = rc_parse_args($args, $defaults);
    }

    /**
     * @param Upgrader $upgrader
     */
    public function set_upgrader(Upgrader & $upgrader)
    {
        if ( $upgrader instanceof Upgrader) {
            $this->upgrader = & $upgrader;
        }

        $this->add_strings();
    }
    
    public function add_strings()
    {
    }
    
    public function set_result($result)
    {
        $this->result = $result;
    }
    
    public function request_filesystem_credentials($error = false)
    {
        $url = $this->options['url'];
        $context = $this->options['context'];
        if ( !empty($this->options['nonce']) )
            $url = wp_nonce_url($url, $this->options['nonce']);
        return request_filesystem_credentials($url, '', $error, $context); //Possible to bring inline, Leaving as is for now.
    }
    
    public function header()
    {
        if ( $this->done_header )
            return;
        $this->done_header = true;
        echo '<div class="wrap">';
        echo '<h2>' . $this->options['title'] . '</h2>';
    }
    
    public function footer()
    {
        echo '</div>';
    }
    
    public function error($errors)
    {
        if ( ! $this->done_header )
            $this->header();
        if ( is_string($errors) ) {
            $this->feedback($errors);
        } elseif ( is_ecjia_error($errors) && $errors->get_error_code() ) {
            foreach ( $errors->get_error_messages() as $message ) {
                if ( $errors->get_error_data() && is_string( $errors->get_error_data() ) ) {
                    $this->feedback($message . ' ' . RC_Format::esc_html( strip_tags( $errors->get_error_data() ) ) );
                } else {
                    $this->feedback($message);
                }
            }
        }
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
        show_message($string);
    }
    
    public function before() {

    }
    
    public function after() {

    }
    
    /**
     * Output JavaScript that calls function to decrement the update counts.
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
				(function( ecjia ) {
					if ( ecjia && ecjia.updates.decrementCount ) {
						ecjia.updates.decrementCount( "' . $type . '" );
					}
				})( window.ecjia );
			</script>';
    }
    
}

// end