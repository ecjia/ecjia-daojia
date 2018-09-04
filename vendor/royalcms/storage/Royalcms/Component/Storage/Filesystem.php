<?php

namespace Royalcms\Component\Storage;

use Closure;
use BadMethodCallException;
use RC_Hook;
use Royalcms\Component\Support\Format;
use Royalcms\Component\Error\Error;

class Filesystem {
    
    protected $driver;
    
    /**
     * Initialises and connects the WordPress Filesystem Abstraction classes.
     * This function will include the chosen transport and attempt connecting.
     *
     * Plugins may add extra transports, And force WordPress to use them by returning the filename via the 'filesystem_method_file' filter.
     *
     * @since 2.5.0
     *
     * @param array $args (optional) Connection args, These are passed directly to the WP_Filesystem_*() classes.
     * @param string $context (optional) Context for get_filesystem_method(), See function declaration for more information.
     * @return boolean false on failure, true on success
     */
    public function __construct( $args = false, $context = false ) {
        $method = self::get_filesystem_method($args, $context);
    
        if ( ! $method )
            return false;

        $method = "\\Royalcms\\Component\\Storage\\" . ucfirst($method);
        $this->driver = new $method($args);

        //Define the timeouts for the connections. Only available after the construct is called to allow for per-transport overriding of the default.
        if ( ! defined('FS_CONNECT_TIMEOUT') )
            define('FS_CONNECT_TIMEOUT', 30);
        if ( ! defined('FS_TIMEOUT') )
            define('FS_TIMEOUT', 30);
    
        if ( Error::is_error($rc_filesystem->errors) && $this->driver->errors->get_error_code() )
            return false;
    
        if ( !$this->driver->connect() )
            return false; //There was an error connecting to the server.
    
        // Set the permission constants if not already set.
        if ( ! defined('FS_CHMOD_DIR') )
            define('FS_CHMOD_DIR', ( fileperms( SITE_ROOT ) & 0777 | 0755 ) );
        if ( ! defined('FS_CHMOD_FILE') )
            define('FS_CHMOD_FILE', ( fileperms( SITE_ROOT . 'index.php' ) & 0777 | 0644 ) );
    
        return true;
    }
    
    public function getDriver() {
        return $this->driver;
    }
    
    /**
     * The registered string macros.
     *
     * @var array
     */
    protected static $macros = array();
    
    /**
     * Register a custom macro.
     *
     * @param  string    $name
     * @param  callable  $macro
     * @return void
    */
    public static function macro($name, callable $macro)
    {
        static::$macros[$name] = $macro;
    }
    
    /**
     * Checks if macro is registered.
     *
     * @param  string  $name
     * @return bool
     */
    public static function hasMacro($name)
    {
        return isset(static::$macros[$name]);
    }
    
    /**
     * Dynamically handle calls to the class.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public static function __callStatic($method, $parameters)
    {
        if (static::hasMacro($method))
        {
            if (static::$macros[$method] instanceof Closure)
            {
                return call_user_func_array(Closure::bind(static::$macros[$method], null, get_called_class()), $parameters);
            }
            else
            {
                return call_user_func_array(static::$macros[$method], $parameters);
            }
        }
    
        throw new BadMethodCallException("Method {$method} does not exist.");
    }
    
    public function __call($method, $parameters) {
        if (static::hasMacro($method))
        {
            if (static::$macros[$method] instanceof Closure)
            {
                return call_user_func_array(static::$macros[$method]->bindTo($this, get_class($this)), $parameters);
            }
            else
            {
                return call_user_func_array(static::$macros[$method], $parameters);
            }
        }
        elseif (method_exists($this->driver, $method))
        {
            return call_user_func_array(array($this->driver, $method), $parameters);
        }
        
        throw new BadMethodCallException("Method {$method} does not exist.");
    }
    
    /**
     * Determines which Filesystem Method to use.
     * The priority of the Transports are: Direct, SSH2, FTP PHP Extension, FTP Sockets (Via Sockets class, or fsockopen())
     *
     * Note that the return value of this function can be overridden in 2 ways
     *  - By defining FS_METHOD in your <code>wp-config.php</code> file
     *  - By using the filesystem_method filter
     * Valid values for these are: 'direct', 'ssh2', 'ftpext' or 'ftpsockets'
     * Plugins may also define a custom transport handler, See the WP_Filesystem function for more information.
     *
     * @since 2.5.0
     *
     * @param array $args Connection details.
     * @param string $context Full path to the directory that is tested for being writable.
     * @return string The transport to use, see description for valid return values.
     */
    public static function get_filesystem_method($args = array(), $context = false) {
        $method = defined('FS_METHOD') ? FS_METHOD : false; // Please ensure that this is either 'direct', 'ssh2', 'ftpext' or 'ftpsockets'
    
        if ( ! $method && function_exists('getmyuid') && function_exists('fileowner') ){
            if ( !$context )
                $context = RC_CONTENT_PATH;
            //@TODO
            // If the directory doesn't exist (wp-content/languages) then use the parent directory as we'll create it.
            if ( WP_LANG_DIR == $context && ! is_dir( $context ) )
                $context = dirname( $context );

            $context = Format::trailingslashit($context);
            $temp_file_name = $context . 'temp-write-test-' . time();
            $temp_handle = @fopen($temp_file_name, 'w');
            if ( $temp_handle ) {
                if ( getmyuid() == @fileowner($temp_file_name) ) {
                    $method = 'direct';
                }
                @fclose($temp_handle);
                @unlink($temp_file_name);
            }
        }

        if ( ! $method && isset($args['connection_type']) && 'ssh' == $args['connection_type'] && extension_loaded('ssh2') && function_exists('stream_get_contents') ) $method = 'ssh2';
        if ( ! $method && extension_loaded('ftp') ) $method = 'ftpext';
        if ( ! $method && ( extension_loaded('sockets') || function_exists('fsockopen') ) ) $method = 'ftpsockets'; //Sockets: Socket extension; PHP Mode: FSockopen / fwrite / fread

        /**
         * Filter the filesystem method to use.
         *
         * @since 2.6.0
         *
         * @param string $method Filesystem method to return.
         * @param array  $args   An array of connection details for the method.
         */
        return RC_Hook::apply_filters( 'filesystem_method', $method, $args );
    }
    
    
    /**
     * Displays a form to the user to request for their FTP/SSH details in order to connect to the filesystem.
     * All chosen/entered details are saved, Excluding the Password.
     *
     * Hostnames may be in the form of hostname:portnumber (eg: wordpress.org:2467) to specify an alternate FTP/SSH port.
     *
     * Plugins may override this form by returning true|false via the <code>request_filesystem_credentials</code> filter.
     *
     * @since 2.5.0
     *
     * @param string $form_post the URL to post the form to
     * @param string $type the chosen Filesystem method in use
     * @param boolean $error if the current request has failed to connect
     * @param string $context The directory which is needed access to, The write-test will be performed on this directory by get_filesystem_method()
     * @param string $extra_fields Extra POST fields which should be checked for to be included in the post.
     * @return boolean False on failure. True on success.
     */
    public static function request_filesystem_credentials($form_post, $type = '', $error = false, $context = false, $extra_fields = null) {
    
        /**
         * Filter the filesystem credentials form output.
         *
         * Returning anything other than an empty string will effectively short-circuit
         * output of the filesystem credentials form, returning that value instead.
         *
         * @since 2.5.0
         *
         * @param mixed  $output       Form output to return instead. Default empty.
         * @param string $form_post    URL to POST the form to.
         * @param string $type         Chosen type of filesystem.
         * @param bool   $error        Whether the current request has failed to connect.
         *                             Default false.
         * @param string $context      Full path to the directory that is tested for
         *                             being writable.
         * @param array  $extra_fields Extra POST fields.
         */
        $req_cred = RC_Hook::apply_filters( 'request_filesystem_credentials', '', $form_post, $type, $error, $context, $extra_fields );
        if ( '' !== $req_cred )
            return $req_cred;
    
        if ( empty($type) )
            $type = self::get_filesystem_method(array(), $context);
    
        if ( 'direct' == $type )
            return true;
    
        if ( is_null( $extra_fields ) )
            $extra_fields = array( 'version', 'locale' );
    
        //         $credentials = get_option('ftp_credentials', array( 'hostname' => '', 'username' => ''));
        $credentials = array( 'hostname' => '', 'username' => '');
    
        // If defined, set it to that, Else, If POST'd, set it to that, If not, Set it to whatever it previously was(saved details in option)
        $credentials['hostname'] = defined('FTP_HOST') ? FTP_HOST : (!empty($_POST['hostname']) ? rc_unslash( $_POST['hostname'] ) : $credentials['hostname']);
        $credentials['username'] = defined('FTP_USER') ? FTP_USER : (!empty($_POST['username']) ? rc_unslash( $_POST['username'] ) : $credentials['username']);
        $credentials['password'] = defined('FTP_PASS') ? FTP_PASS : (!empty($_POST['password']) ? rc_unslash( $_POST['password'] ) : '');
    
        // Check to see if we are setting the public/private keys for ssh
        $credentials['public_key'] = defined('FTP_PUBKEY') ? FTP_PUBKEY : (!empty($_POST['public_key']) ? rc_unslash( $_POST['public_key'] ) : '');
        $credentials['private_key'] = defined('FTP_PRIKEY') ? FTP_PRIKEY : (!empty($_POST['private_key']) ? rc_unslash( $_POST['private_key'] ) : '');
    
        // Sanitize the hostname, Some people might pass in odd-data:
        $credentials['hostname'] = preg_replace('|\w+://|', '', $credentials['hostname']); //Strip any schemes off
    
        if ( strpos($credentials['hostname'], ':') ) {
            list( $credentials['hostname'], $credentials['port'] ) = explode(':', $credentials['hostname'], 2);
            if ( ! is_numeric($credentials['port']) )
                unset($credentials['port']);
        } else {
            unset($credentials['port']);
        }
    
        if ( ( defined('FTP_SSH') && FTP_SSH ) || ( defined('FS_METHOD') && 'ssh2' == FS_METHOD ) )
            $credentials['connection_type'] = 'ssh';
        else if ( (defined('FTP_SSL') && FTP_SSL) && 'ftpext' == $type ) //Only the FTP Extension understands SSL
            $credentials['connection_type'] = 'ftps';
        else if ( !empty($_POST['connection_type']) )
            $credentials['connection_type'] = rc_unslash( $_POST['connection_type'] );
        else if ( !isset($credentials['connection_type']) ) //All else fails (And it's not defaulted to something else saved), Default to FTP
            $credentials['connection_type'] = 'ftp';
    
        if ( ! $error &&
            (
                ( !empty($credentials['password']) && !empty($credentials['username']) && !empty($credentials['hostname']) ) ||
                ( 'ssh' == $credentials['connection_type'] && !empty($credentials['public_key']) && !empty($credentials['private_key']) )
            ) ) {
                $stored_credentials = $credentials;
                if ( !empty($stored_credentials['port']) ) //save port as part of hostname to simplify above code.
                    $stored_credentials['hostname'] .= ':' . $stored_credentials['port'];
    
                unset($stored_credentials['password'], $stored_credentials['port'], $stored_credentials['private_key'], $stored_credentials['public_key']);
                update_option('ftp_credentials', $stored_credentials);
                return $credentials;
            }
            $hostname = isset( $credentials['hostname'] ) ? $credentials['hostname'] : '';
            $username = isset( $credentials['username'] ) ? $credentials['username'] : '';
            $public_key = isset( $credentials['public_key'] ) ? $credentials['public_key'] : '';
            $private_key = isset( $credentials['private_key'] ) ? $credentials['private_key'] : '';
            $port = isset( $credentials['port'] ) ? $credentials['port'] : '';
            $connection_type = isset( $credentials['connection_type'] ) ? $credentials['connection_type'] : '';
    
            if ( $error ) {
                $error_string = __('<strong>ERROR:</strong> There was an error connecting to the server, Please verify the settings are correct.');
                if ( Error::is_error($error) )
                    $error_string = Format::esc_html( $error->get_error_message() );
                echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
            }
    
            $types = array();
            if ( extension_loaded('ftp') || extension_loaded('sockets') || function_exists('fsockopen') )
                $types[ 'ftp' ] = __('FTP');
            if ( extension_loaded('ftp') ) //Only this supports FTPS
                $types[ 'ftps' ] = __('FTPS (SSL)');
            if ( extension_loaded('ssh2') && function_exists('stream_get_contents') )
                $types[ 'ssh' ] = __('SSH2');
    
            /**
             * Filter the connection types to output to the filesystem credentials form.
             *
             * @since 2.9.0
             *
             * @param array  $types       Types of connections.
             * @param array  $credentials Credentials to connect with.
             * @param string $type        Chosen filesystem method.
             * @param object $error       Error object.
             * @param string $context     Full path to the directory that is tested
             *                            for being writable.
            */
            $types = RC_Hook::apply_filters( 'fs_ftp_connection_types', $types, $credentials, $type, $error, $context );
    
            ?>
        <script type="text/javascript">
        <!--
        jQuery(function($){
        	jQuery("#ssh").click(function () {
        		jQuery("#ssh_keys").show();
        	});
        	jQuery("#ftp, #ftps").click(function () {
        		jQuery("#ssh_keys").hide();
        	});
        	jQuery('form input[value=""]:first').focus();
        });
        -->
        </script>
        <form action="<?php echo Format::esc_url( $form_post ) ?>" method="post">
        <div>
        <h3><?php _e('Connection Information') ?></h3>
        <p><?php
        	$label_user = __('Username');
        	$label_pass = __('Password');
        	_e('To perform the requested action, WordPress needs to access your web server.');
        	echo ' ';
        	if ( ( isset( $types['ftp'] ) || isset( $types['ftps'] ) ) ) {
        		if ( isset( $types['ssh'] ) ) {
        			_e('Please enter your FTP or SSH credentials to proceed.');
        			$label_user = __('FTP/SSH Username');
        			$label_pass = __('FTP/SSH Password');
        		} else {
        			_e('Please enter your FTP credentials to proceed.');
        			$label_user = __('FTP Username');
        			$label_pass = __('FTP Password');
        		}
        		echo ' ';
        	}
        	_e('If you do not remember your credentials, you should contact your web host.');
        ?></p>
        <table class="form-table">
        <tr>
        <th scope="row"><label for="hostname"><?php _e('Hostname') ?></label></th>
        <td><input name="hostname" type="text" id="hostname" value="<?php echo Format::esc_attr($hostname); if ( !empty($port) ) echo ":$port"; ?>"<?php disabled( defined('FTP_HOST') ); ?> size="40" /></td>
        </tr>
        
        <tr>
        <th scope="row"><label for="username"><?php echo $label_user; ?></label></th>
        <td><input name="username" type="text" id="username" value="<?php echo Format::esc_attr($username) ?>"<?php disabled( defined('FTP_USER') ); ?> size="40" /></td>
        </tr>
        
        <tr>
        <th scope="row"><label for="password"><?php echo $label_pass; ?></label></th>
        <td><div><input name="password" type="password" id="password" value="<?php if ( defined('FTP_PASS') ) echo '*****'; ?>"<?php disabled( defined('FTP_PASS') ); ?> size="40" /></div>
        <div><em><?php if ( ! defined('FTP_PASS') ) _e( 'This password will not be stored on the server.' ); ?></em></div></td>
        </tr>
        
        <?php if ( isset($types['ssh']) ) : ?>
        <tr id="ssh_keys" style="<?php if ( 'ssh' != $connection_type ) echo 'display:none' ?>">
        <th scope="row"><?php _e('Authentication Keys') ?>
        <div class="key-labels textright">
        <label for="public_key"><?php _e('Public Key:') ?></label ><br />
        <label for="private_key"><?php _e('Private Key:') ?></label>
        </div></th>
        <td><br /><input name="public_key" type="text" id="public_key" value="<?php echo Format::esc_attr($public_key) ?>"<?php disabled( defined('FTP_PUBKEY') ); ?> size="40" />
        	<br /><input name="private_key" type="text" id="private_key" value="<?php echo Format::esc_attr($private_key) ?>"<?php disabled( defined('FTP_PRIKEY') ); ?> size="40" />
        <div><?php _e('Enter the location on the server where the keys are located. If a passphrase is needed, enter that in the password field above.') ?></div></td>
        </tr>
        <?php endif; ?>
        
        <tr>
        <th scope="row"><?php _e('Connection Type') ?></th>
        <td>
        <fieldset><legend class="screen-reader-text"><span><?php _e('Connection Type') ?></span></legend>
        <?php
        	$disabled = disabled( (defined('FTP_SSL') && FTP_SSL) || (defined('FTP_SSH') && FTP_SSH), true, false );
        	foreach ( $types as $name => $text ) : ?>
        	<label for="<?php echo Format::esc_attr($name) ?>">
        		<input type="radio" name="connection_type" id="<?php echo Format::esc_attr($name) ?>" value="<?php echo Format::esc_attr($name) ?>"<?php checked($name, $connection_type); echo $disabled; ?> />
        		<?php echo $text ?>
        	</label>
        	<?php endforeach; ?>
        </fieldset>
        </td>
        </tr>
        </table>
        
        <?php
        foreach ( (array) $extra_fields as $field ) {
        	if ( isset( $_POST[ $field ] ) )
        		echo '<input type="hidden" name="' . Format::esc_attr( $field ) . '" value="' . Format::esc_attr( rc_unslash( $_POST[ $field ] ) ) . '" />';
        }
        \ecjia_form::submit_button( __( 'Proceed' ), 'button', 'upgrade' );
        ?>
        </div>
        </form>
        <?php
        	return false;
        }
}