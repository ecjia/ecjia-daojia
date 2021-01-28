<?php

if ( ! function_exists('rc_allowed_protocols'))
{
    /**
     * Retrieve a list of protocols to allow in HTML attributes.
     *
     * @since 3.3.0
     * @see rc_kses()
     * @see esc_url()
     *
     * @return array Array of allowed protocols
     */
    function rc_allowed_protocols()
    {
        static $protocols;

        if (empty($protocols)) {
            $protocols = array(
                'http',
                'https',
                'ftp',
                'ftps',
                'mailto',
                'news',
                'irc',
                'gopher',
                'nntp',
                'feed',
                'telnet',
                'mms',
                'rtsp',
                'svn',
                'tel',
                'fax',
                'xmpp'
            );

            /**
             * Filter the list of protocols allowed in HTML attributes.
             *
             * @since 3.0.0
             *
             * @param array $protocols
             *            Array of allowed protocols e.g. 'http', 'ftp', 'tel', and more.
             */
            $protocols = RC_Hook::apply_filters('kses_allowed_protocols', $protocols);
        }

        return $protocols;
    }
}

if ( ! function_exists('rc_parse_str'))
{
    /**
     * Parses a string into variables to be stored in an array.
     *
     * Uses {@link http://www.php.net/parse_str parse_str()}.
     *
     * @since 2.2.1
     *
     * @param string $string
     *            The string to be parsed.
     * @param array $array
     *            Variables will be stored in this array.
     */
    function rc_parse_str($string, &$array)
    {
        parse_str($string, $array);

        /**
         * Filter the array of variables derived from a parsed string.
         *
         * @since 2.3.0
         *
         * @param array $array
         *            The array populated with variables.
         */
        $array = RC_Hook::apply_filters('rc_parse_str', $array);
    }
}

if ( ! function_exists('rc_parse_args'))
{
    /**
     * Merge user defined arguments into defaults array.
     *
     * This function is used throughout WordPress to allow for both string or array
     * to be merged into another array.
     *
     * @since 2.2.0
     *
     * @param string|array $args
     *            Value to merge with $defaults
     * @param array $defaults
     *            Array that serves as the defaults.
     * @return array Merged user defined values with defaults.
     */
    function rc_parse_args($args, $defaults = '')
    {
        if (is_object($args))
        {
            $r = get_object_vars($args);
        }
        elseif (is_array($args))
        {
            $r = & $args;
        }
        else
        {
            rc_parse_str($args, $r);
        }

        if (is_array($defaults))
        {
            return array_merge($defaults, $r);
        }

        return $r;
    }
}


if ( ! function_exists('rc_throw_exception'))
{
    /**
     * 抛出异常
     *
     * @param string $msg
     *            错误信息
     * @param int $code
     *            编码
     * @throws
     *
     *
     */
    function rc_throw_exception($msg, $code = 0)
    {
        /**
         * 加载异常类
         * 默认异常类 Component_Error_Exception
         */
        $class = RC_Hook::apply_filters('load_exception_class', 'Exception');

        if (class_exists($class, false)) {
            throw new $class($msg, $code, true);
        } else {
            rc_die($msg);
        }
    }
}

if ( ! function_exists('_doing_it_wrong'))
{
    /**
     * Marks something as being incorrectly called.
     *
     * There is a hook doing_it_wrong_run that will be called that can be used
     * to get the backtrace up to what file and function called the deprecated
     * function.
     *
     * The current behavior is to trigger a user error if WP_DEBUG is true.
     *
     * @since 3.1.0
     * @access private
     *
     * @param string $function The function that was called.
     * @param string $message A message explaining what has been done incorrectly.
     * @param string $version The version of WordPress where the message was added.
     */
    function _doing_it_wrong( $function, $message, $version ) {

        /**
         * Fires when the given function is being used incorrectly.
         *
         * @since 3.1.0
         *
         * @param string $function The function that was called.
         * @param string $message  A message explaining what has been done incorrectly.
         * @param string $version  The version of WordPress where the message was added.
         */
        RC_Hook::do_action( 'doing_it_wrong_run', $function, $message, $version );

        /**
         * Filter whether to trigger an error for _doing_it_wrong() calls.
         *
         * @since 3.1.0
         *
         * @param bool $trigger Whether to trigger the error for _doing_it_wrong() calls. Default true.
         */
        if ( RC_DEBUG && RC_Hook::apply_filters( 'doing_it_wrong_trigger_error', true ) ) {
            if ( function_exists( '__' ) ) {
                $version = is_null( $version ) ? '' : sprintf( __( '(This message was added in version %s.)' ), $version );
                $message .= ' ' . __( 'Please see for more information.' );
                trigger_error( sprintf( __( '%1$s was called <strong>incorrectly</strong>. %2$s %3$s' ), $function, $message, $version ) );
            } else {
                $version = is_null( $version ) ? '' : sprintf( '(This message was added in version %s.)', $version );
                $message .= ' Please see for more information.';
                trigger_error( sprintf( '%1$s was called <strong>incorrectly</strong>. %2$s %3$s', $function, $message, $version ) );
            }
        }
    }
}

if ( ! function_exists('_deprecated_function'))
{
    /**
     * Mark a function as deprecated and inform when it has been used.
     *
     * There is a hook deprecated_function_run that will be called that can be used
     * to get the backtrace up to what file and function called the deprecated
     * function.
     *
     * The current behavior is to trigger a user error if RC_DEBUG is true.
     *
     * This function is to be used in every function that is deprecated.
     *
     * @since 2.5.0
     * @access private
     *
     * @param string $function    The function that was called.
     * @param string $version     The version of WordPress that deprecated the function.
     * @param string $replacement Optional. The function that should have been called. Default null.
     */
    function _deprecated_function( $function, $version, $replacement = null ) {

        /**
         * Fires when a deprecated function is called.
         *
         * @since 2.5.0
         *
         * @param string $function    The function that was called.
         * @param string $replacement The function that should have been called.
         * @param string $version     The version of WordPress that deprecated the function.
         */
        RC_Hook::do_action( 'deprecated_function_run', $function, $replacement, $version );

        /**
         * Filter whether to trigger an error for deprecated functions.
         *
         * @since 2.5.0
         *
         * @param bool $trigger Whether to trigger the error for deprecated functions. Default true.
         */
        if ( config('system.debug') && RC_Hook::apply_filters( 'deprecated_function_trigger_error', true ) ) {
            if ( function_exists( '__' ) ) {
                if ( ! is_null( $replacement ) ) {
                    trigger_error( sprintf( __('%1$s is <strong>deprecated</strong> since version %2$s! Use %3$s instead.'), $function, $version, $replacement ) );
                } else {
                    trigger_error( sprintf( __('%1$s is <strong>deprecated</strong> since version %2$s with no alternative available.'), $function, $version ) );
                }
            } else {
                if ( ! is_null( $replacement ) ) {
                    trigger_error( sprintf( '%1$s is <strong>deprecated</strong> since version %2$s! Use %3$s instead.', $function, $version, $replacement ) );
                } else {
                    trigger_error( sprintf( '%1$s is <strong>deprecated</strong> since version %2$s with no alternative available.', $function, $version ) );
                }
            }
        }
    }
}

if ( ! function_exists('_deprecated_file'))
{
    /**
     * Mark a file as deprecated and inform when it has been used.
     *
     * There is a hook deprecated_file_included that will be called that can be used
     * to get the backtrace up to what file and function included the deprecated
     * file.
     *
     * The current behavior is to trigger a user error if WP_DEBUG is true.
     *
     * This function is to be used in every file that is deprecated.
     *
     * @since 2.5.0
     * @access private
     *
     * @param string $file        The file that was included.
     * @param string $version     The version of WordPress that deprecated the file.
     * @param string $replacement Optional. The file that should have been included based on ABSPATH.
     *                            Default null.
     * @param string $message     Optional. A message regarding the change. Default empty.
     */
    function _deprecated_file( $file, $version, $replacement = null, $message = '' ) {

        /**
         * Fires when a deprecated file is called.
         *
         * @since 2.5.0
         *
         * @param string $file        The file that was called.
         * @param string $replacement The file that should have been included based on ABSPATH.
         * @param string $version     The version of WordPress that deprecated the file.
         * @param string $message     A message regarding the change.
         */
        RC_Hook::do_action( 'deprecated_file_included', $file, $replacement, $version, $message );

        /**
         * Filter whether to trigger an error for deprecated files.
         *
         * @since 2.5.0
         *
         * @param bool $trigger Whether to trigger the error for deprecated files. Default true.
         */
        if ( RC_DEBUG && RC_Hook::apply_filters( 'deprecated_file_trigger_error', true ) ) {
            $message = empty( $message ) ? '' : ' ' . $message;
            if ( function_exists( '__' ) ) {
                if ( ! is_null( $replacement ) ) {
                    trigger_error( sprintf( __('%1$s is <strong>deprecated</strong> since version %2$s! Use %3$s instead.'), $file, $version, $replacement ) . $message );
                } else {
                    trigger_error( sprintf( __('%1$s is <strong>deprecated</strong> since version %2$s with no alternative available.'), $file, $version ) . $message );
                }
            } else {
                if ( ! is_null( $replacement ) ) {
                    trigger_error( sprintf( '%1$s is <strong>deprecated</strong> since version %2$s! Use %3$s instead.', $file, $version, $replacement ) . $message );
                } else {
                    trigger_error( sprintf( '%1$s is <strong>deprecated</strong> since version %2$s with no alternative available.', $file, $version ) . $message );
                }
            }
        }
    }
}

if ( ! function_exists('_deprecated_argument'))
{
    /**
     * Mark a function argument as deprecated and inform when it has been used.
     *
     * This function is to be used whenever a deprecated function argument is used.
     * Before this function is called, the argument must be checked for whether it was
     * used by comparing it to its default value or evaluating whether it is empty.
     * For example:
     * <code>
     * if ( ! empty( $deprecated ) ) {
     * 	_deprecated_argument( __FUNCTION__, '3.0' );
     * }
     * </code>
     *
     * There is a hook deprecated_argument_run that will be called that can be used
     * to get the backtrace up to what file and function used the deprecated
     * argument.
     *
     * The current behavior is to trigger a user error if WP_DEBUG is true.
     *
     * @since 3.0.0
     * @access private
     *
     * @param string $function The function that was called.
     * @param string $version  The version of WordPress that deprecated the argument used.
     * @param string $message  Optional. A message regarding the change. Default null.
     */
    function _deprecated_argument( $function, $version, $message = null ) {

        /**
         * Fires when a deprecated argument is called.
         *
         * @since 3.0.0
         *
         * @param string $function The function that was called.
         * @param string $message  A message regarding the change.
         * @param string $version  The version of WordPress that deprecated the argument used.
         */
        RC_Hook::do_action( 'deprecated_argument_run', $function, $message, $version );

        /**
         * Filter whether to trigger an error for deprecated arguments.
         *
         * @since 3.0.0
         *
         * @param bool $trigger Whether to trigger the error for deprecated arguments. Default true.
         */
        if ( RC_DEBUG && RC_Hook::apply_filters( 'deprecated_argument_trigger_error', true ) ) {
            if ( function_exists( '__' ) ) {
                if ( ! is_null( $message ) ) {
                    trigger_error( sprintf( __('%1$s was called with an argument that is <strong>deprecated</strong> since version %2$s! %3$s'), $function, $version, $message ) );
                } else {
                    trigger_error( sprintf( __('%1$s was called with an argument that is <strong>deprecated</strong> since version %2$s with no alternative available.'), $function, $version ) );
                }
            } else {
                if ( ! is_null( $message ) ) {
                    trigger_error( sprintf( '%1$s was called with an argument that is <strong>deprecated</strong> since version %2$s! %3$s', $function, $version, $message ) );
                } else {
                    trigger_error( sprintf( '%1$s was called with an argument that is <strong>deprecated</strong> since version %2$s with no alternative available.', $function, $version ) );
                }
            }
        }
    }
}

if (! function_exists('_deprecated_hook'))
{
    /**
     * Marks a deprecated action or filter hook as deprecated and throws a notice.
     *
     * Use the {@see 'deprecated_hook_run'} action to get the backtrace describing where
     * the deprecated hook was called.
     *
     * Default behavior is to trigger a user error if `WP_DEBUG` is true.
     *
     * This function is called by the do_action_deprecated() and apply_filters_deprecated()
     * functions, and so generally does not need to be called directly.
     *
     * @since 4.6.0
     * @access private
     *
     * @param string $hook        The hook that was used.
     * @param string $version     The version of Royalcms that deprecated the hook.
     * @param string $replacement Optional. The hook that should have been used.
     * @param string $message     Optional. A message regarding the change.
     */
    function _deprecated_hook( $hook, $version, $replacement = null, $message = null ) {
        /**
         * Fires when a deprecated hook is called.
         *
         * @since 4.6.0
         *
         * @param string $hook        The hook that was called.
         * @param string $replacement The hook that should be used as a replacement.
         * @param string $version     The version of WordPress that deprecated the argument used.
         * @param string $message     A message regarding the change.
         */
        RC_Hook::do_action( 'deprecated_hook_run', $hook, $replacement, $version, $message );

        /**
         * Filters whether to trigger deprecated hook errors.
         *
         * @since 4.6.0
         *
         * @param bool $trigger Whether to trigger deprecated hook errors. Requires
         *                      `RC_DEBUG` to be defined true.
         */
        if ( RC_DEBUG && RC_Hook::apply_filters( 'deprecated_hook_trigger_error', true ) ) {
            $message = empty( $message ) ? '' : ' ' . $message;
            if ( ! is_null( $replacement ) ) {
                /* translators: 1: ECJia hook name, 2: version number, 3: alternative hook name */
                trigger_error( sprintf( __( '%1$s is <strong>deprecated</strong> since version %2$s! Use %3$s instead.' ), $hook, $version, $replacement ) . $message );
            } else {
                /* translators: 1: ECJia hook name, 2: version number */
                trigger_error( sprintf( __( '%1$s is <strong>deprecated</strong> since version %2$s with no alternative available.' ), $hook, $version ) . $message );
            }
        }
    }
}

if ( ! function_exists('_halt'))
{
    /**
     * 错误中断
     *
     * @param
     *            string | array $error 错误内容
     */
    function _halt($error)
    {
        rc_die($error);
    }
}

if ( ! function_exists('rc_die'))
{
    /**
     * Kill Royalcms execution and display HTML message with error message.
     *
     * This function complements the die() PHP function. The difference is that
     * HTML will be displayed to the user. It is recommended to use this function
     * only, when the execution should not continue any further. It is not
     * recommended to call this function very often and try to handle as many errors
     * as possible silently.
     *
     * @since 2.0.4
     *
     * @param string $message Error message.
     * @param string $title Error title.
     * @param string|array $args Optional arguments to control behavior.
     */
    function rc_die( $message = '', $title = '', $args = array() ) {
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            /**
             * Filter callback for killing WordPress execution for AJAX requests.
             *
             * @since 3.4.0
             *
             * @param callback $function Callback function name.
             */
            $function = RC_Hook::apply_filters( 'rc_die_ajax_handler', '_ajax_rc_die_handler' );
        } elseif ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) {
            /**
             * Filter callback for killing WordPress execution for XML-RPC requests.
             *
             * @since 3.4.0
             *
             * @param callback $function Callback function name.
             */
            $function = RC_Hook::apply_filters( 'rc_die_xmlrpc_handler', '_xmlrpc_rc_die_handler' );
        } else {
            /**
             * Filter callback for killing WordPress execution for all non-AJAX, non-XML-RPC requests.
             *
             * @since 3.0.0
             *
             * @param callback $function Callback function name.
             */
            $function = RC_Hook::apply_filters( 'rc_die_handler', '_default_rc_die_handler' );
        }

        call_user_func( $function, $message, $title, $args );
    }
}

if ( ! function_exists('rc_showmessage'))
{
    function rc_showmessage($message) {
        $version = Royalcms\Component\Foundation\Royalcms::VERSION;
        return <<<RCMSG
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="robots" content="noindex,nofollow" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>Royalcms - Error reporting...</title>
<style>
    html{color:#000;background:#FFF;}body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,code,form,fieldset,legend,input,textarea,p,blockquote,th,td{margin:0;padding:0;}table{border-collapse:collapse;border-spacing:0;}fieldset,img{border:0;}address,caption,cite,code,dfn,em,strong,th,var{font-style:normal;font-weight:normal;}li{list-style:none;}caption,th{text-align:left;}h1,h2,h3,h4,h5,h6{font-size:100%;font-weight:normal;}q:before,q:after{content:'';}abbr,acronym{border:0;font-variant:normal;}sup{vertical-align:text-top;}sub{vertical-align:text-bottom;}input,textarea,select{font-family:inherit;font-size:inherit;font-weight:inherit;}input,textarea,select{*font-size:100%;}legend{color:#000;}
    html { background: #eee; padding: 10px }
    img { border: 0; }
    #sf-resetcontent { width:100%; max-width:970px; margin:0 auto; }
    .sf-reset { font: 11px Verdana, Arial, sans-serif; color: #333 }
    .sf-reset .clear { clear:both; height:0; font-size:0; line-height:0; }
    .sf-reset .clear_fix:after { display:block; height:0; clear:both; visibility:hidden; }
    .sf-reset .clear_fix { display:inline-block; }
    .sf-reset * html .clear_fix { height:1%; }
    .sf-reset .clear_fix { display:block; }
    .sf-reset, .sf-reset .block { margin: auto }
    .sf-reset abbr { border-bottom: 1px dotted #000; cursor: help; }
    .sf-reset p { font-size:14px; line-height:20px; color:#868686; padding-bottom:0; }
    .sf-reset strong { font-weight:bold; }
    .sf-reset a { color:#6c6159; }
    .sf-reset a img { border:none; }
    .sf-reset a:hover { text-decoration:underline; }
    .sf-reset em { font-style:italic; }
    .sf-reset h1, .sf-reset h2 { font: 20px Georgia, "Times New Roman", Times, serif }
    .sf-reset h2 span { background-color: #fff; color: #333; padding: 6px; float: left; margin-right: 10px; }
    .sf-reset .traces li { font-size:12px; padding: 2px 4px; list-style-type:decimal; margin-left:20px; }
    .sf-reset .block { background-color:#FFFFFF; padding:10px 28px; margin-bottom:20px; -webkit-border-bottom-right-radius: 16px; -webkit-border-bottom-left-radius: 16px; -moz-border-radius-bottomright: 16px; -moz-border-radius-bottomleft: 16px; border-bottom-right-radius: 16px; border-bottom-left-radius: 16px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; border-left:1px solid #ccc;}
    .sf-reset .block_exception { background-color:#ddd; color: #333; padding:20px; -webkit-border-top-left-radius: 16px; -webkit-border-top-right-radius: 16px; -moz-border-radius-topleft: 16px; -moz-border-radius-topright: 16px; border-top-left-radius: 16px; border-top-right-radius: 16px; border-top:1px solid #ccc; border-right:1px solid #ccc; border-left:1px solid #ccc; overflow: hidden; word-wrap: break-word;}
    .sf-reset li a { background:none; color:#868686; text-decoration:none; }
    .sf-reset li a:hover { background:none; color:#313131; text-decoration:underline; }
    .sf-reset ol { padding: 10px 0; }
    .sf-reset h1 { background-color:#FFFFFF; padding: 15px 28px; margin-bottom: 20px; -webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px; border: 1px solid #ccc;}
</style>
</head>
<body>
<div id="sf-resetcontent" class="sf-reset">
	<h1>{$message}</h1>
	Current royalcms version: {$version}
</div>
</body>
</html>        
RCMSG;
    }
}

if ( ! function_exists('_default_rc_die_handler'))
{
    /**
     * Kill WordPress execution and display HTML message with error message.
     *
     * This is the default handler for wp_die if you want a custom one for your
     * site then you can overload using the wp_die_handler filter in wp_die
     *
     * @since 3.0.0
     * @access private
     *
     * @param string $message Error message.
     * @param string $title Error title.
     * @param string|array $args Optional arguments to control behavior.
     */
    function _default_rc_die_handler( $message, $title = '', $args = array() ) {
        $defaults = array( 'response' => 500 );
        $r = rc_parse_args($args, $defaults);

        $have_gettext = function_exists('__');

        if ( is_string( $message ) ) {
            $message = "<p>$message</p>";
        }

        if ( isset( $r['back_link'] ) && $r['back_link'] ) {
            $back_text = $have_gettext? __('&laquo; Back') : '&laquo; Back';
            $message .= "\n<p><a href='javascript:history.back()'>$back_text</a></p>";
        }

        echo rc_showmessage($message);

        die();
    }
}

if ( ! function_exists('_ajax_rc_die_handler'))
{
    /**
     * Kill WordPress ajax execution.
     *
     * This is the handler for wp_die when processing Ajax requests.
     *
     * @since 3.4.0
     * @access private
     *
     * @param string $message Optional. Response to print.
     */
    function _ajax_rc_die_handler( $message = '' ) {
        if ( is_scalar( $message ) )
        {
            die( (string) $message );
        }
        die( '0' );
    }
}

if ( ! function_exists('_scalar_rc_die_handler'))
{
    /**
     * Kill WordPress execution.
     *
     * This is the handler for wp_die when processing APP requests.
     *
     * @since 3.4.0
     * @access private
     *
     * @param string $message Optional. Response to print.
     */
    function _scalar_rc_die_handler( $message = '' ) {
        if ( is_scalar( $message ) )
        {
            die( (string) $message );
        }
        die();
    }
}