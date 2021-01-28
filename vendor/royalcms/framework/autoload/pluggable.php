<?php
/**
 * These functions can be replaced via plugins. If plugins do not redefine these
 * functions, then these will be used instead.
 *
 * @package Royalcms
 */

if ( !function_exists('rc_redirect') )
{
    /**
     * Redirects to another page.
     *
     * Note: rc_redirect() does not exit automatically, and should almost always be
     * followed by a call to `exit;`:
     *
     *     rc_redirect( $url );
     *     exit;
     *
     * Exiting can also be selectively manipulated by using rc_redirect() as a conditional
     * in conjunction with the {@see 'rc_redirect'} and {@see 'rc_redirect_location'} hooks:
     *
     *     if ( rc_redirect( $url ) ) {
     *         exit;
     *     }
     *
     * @since 1.5.1
     *
     * @global bool $is_IIS
     *
     * @param string $location The path to redirect to.
     * @param int    $status   Status code to use.
     * @return bool False if $location is not provided, true otherwise.
     */
    function rc_redirect($location, $status = 302) {
        global $is_IIS;

        /**
         * Filters the redirect location.
         *
         * @since 2.1.0
         *
         * @param string $location The path to redirect to.
         * @param int    $status   Status code to use.
         */
        $location = RC_Hook::apply_filters( 'rc_redirect', $location, $status );

        /**
         * Filters the redirect status code.
         *
         * @since 2.3.0
         *
         * @param int    $status   Status code to use.
         * @param string $location The path to redirect to.
        */
        $status = RC_Hook::apply_filters( 'rc_redirect_status', $status, $location );

        if ( ! $location )
            return false;

        $location = rc_sanitize_redirect($location);

        if ( !$is_IIS && PHP_SAPI != 'cgi-fcgi' )
            rc_status_header($status); // This causes problems on IIS and some FastCGI setups

        //header("Location: $location", true, $status);
        //return true;

        $response = redirect($location, $status);
        $cookies = royalcms('response')->headers->getCookies();
        foreach ($cookies as $cookie)
        {
            $response->withCookie($cookie);
        }
        royalcms()->instance('response', $response);
        $response->send();
        exit(0);
    }
}

if ( !function_exists('rc_sanitize_redirect') )
{
    /**
     * Sanitizes a URL for use in a redirect.
     *
     * @since 2.3.0
     *
     * @param string $location The path to redirect to.
     * @return string Redirect-sanitized URL.
     **/
    function rc_sanitize_redirect($location) {
        $regex = '/
    		(
    			(?: [\xC2-\xDF][\x80-\xBF]        # double-byte sequences   110xxxxx 10xxxxxx
    			|   \xE0[\xA0-\xBF][\x80-\xBF]    # triple-byte sequences   1110xxxx 10xxxxxx * 2
    			|   [\xE1-\xEC][\x80-\xBF]{2}
    			|   \xED[\x80-\x9F][\x80-\xBF]
    			|   [\xEE-\xEF][\x80-\xBF]{2}
    			|   \xF0[\x90-\xBF][\x80-\xBF]{2} # four-byte sequences   11110xxx 10xxxxxx * 3
    			|   [\xF1-\xF3][\x80-\xBF]{3}
    			|   \xF4[\x80-\x8F][\x80-\xBF]{2}
    		){1,40}                              # ...one or more times
    		)/x';
        $location = preg_replace_callback( $regex, '_rc_sanitize_utf8_in_redirect', $location );
        $location = preg_replace('|[^a-z0-9-~+_.?#=&;,/:%!*\[\]()@]|i', '', $location);
        $location = RC_Kses::no_null($location);

        // remove %0d and %0a from location
        $strip = array('%0d', '%0a', '%0D', '%0A');
        return RC_Format::_deep_replace( $strip, $location );
    }

    /**
     * URL encode UTF-8 characters in a URL.
     *
     * @ignore
     * @since 4.2.0
     * @access private
     *
     * @see rc_sanitize_redirect()
     *
     * @param array $matches RegEx matches against the redirect location.
     * @return string URL-encoded version of the first RegEx match.
     */
    function _rc_sanitize_utf8_in_redirect( $matches ) {
        return urlencode( $matches[0] );
    }
}

if ( !function_exists('rc_safe_redirect') )
{
    /**
     * Performs a safe (local) redirect, using wp_redirect().
     *
     * Checks whether the $location is using an allowed host, if it has an absolute
     * path. A plugin can therefore set or remove allowed host(s) to or from the
     * list.
     *
     * If the host is not allowed, then the redirect defaults to admin on the siteurl
     * instead. This prevents malicious redirects which redirect to another host,
     * but only used in a few places.
     *
     * @since 2.3.0
     *
     * @param string $location The path to redirect to.
     * @param int    $status   Status code to use.
     */
    function rc_safe_redirect($location, $status = 302) {

        // Need to look at the URL the way it will end up in wp_redirect()
        $location = rc_sanitize_redirect($location);

        /**
         * Filters the redirect fallback URL for when the provided redirect is not safe (local).
         *
         * @since 4.3.0
         *
         * @param string $fallback_url The fallback URL to use by default.
         * @param int    $status       The redirect status.
        */
        $location = rc_validate_redirect( $location, RC_Hook::apply_filters( 'rc_safe_redirect_fallback', RC_Uri::home_url(), $status ) );

        rc_redirect($location, $status);
    }
}

if ( !function_exists('rc_validate_redirect') ) 
{
    /**
     * Validates a URL for use in a redirect.
     *
     * Checks whether the $location is using an allowed host, if it has an absolute
     * path. A plugin can therefore set or remove allowed host(s) to or from the
     * list.
     *
     * If the host is not allowed, then the redirect is to $default supplied
     *
     * @since 3.2.0
     *
     * @param string $location The redirect to validate
     * @param string $default The value to return if $location is not allowed
     * @return string redirect-sanitized URL
     **/
    function rc_validate_redirect($location, $default = '') {
        $location = trim( $location );
        // browsers will assume 'http' is your protocol, and will obey a redirect to a URL starting with '//'
        if ( substr($location, 0, 2) == '//' )
            $location = 'http:' . $location;
    
        // In php 5 parse_url may fail if the URL query part contains http://, bug #38143
        $test = ( $cut = strpos($location, '?') ) ? substr( $location, 0, $cut ) : $location;
    
        $lp  = parse_url($test);
    
        // Give up if malformed URL
        if ( false === $lp )
            return $default;
    
        // Allow only http and https schemes. No data:, etc.
        if ( isset($lp['scheme']) && !('http' == $lp['scheme'] || 'https' == $lp['scheme']) )
            return $default;
    
        // Reject if scheme is set but host is not. This catches urls like https:host.com for which parse_url does not set the host field.
        if ( isset($lp['scheme'])  && !isset($lp['host']) )
            return $default;
    
        $wpp = parse_url(RC_Uri::home_url());
    
        /**
         * Filter the whitelist of hosts to redirect to.
         *
         * @since 2.3.0
         *
         * @param array       $hosts An array of allowed hosts.
         * @param bool|string $host  The parsed host; empty if not isset.
        */
        $allowed_hosts = (array) RC_Hook::apply_filters( 'allowed_redirect_hosts', array($wpp['host']), isset($lp['host']) ? $lp['host'] : '' );
    
        if ( isset($lp['host']) && ( !in_array($lp['host'], $allowed_hosts) && $lp['host'] != strtolower($wpp['host'])) )
            $location = $default;
    
        return $location;
    }
}

if ( !function_exists('rc_get_status_header_desc') )
{
    /**
     * Retrieve the description for the HTTP status.
     *
     * @since 2.3.0
     *
     * @global array $wp_header_to_desc
     *
     * @param int $code HTTP status code.
     * @return string Empty string if not found, or description if found.
     */
    function rc_get_status_header_desc( $code ) {
        global $rc_header_to_desc;
    
        $code = rc_absint( $code );
    
        if ( !isset( $rc_header_to_desc ) ) {
            $wp_header_to_desc = array(
                100 => 'Continue',
                101 => 'Switching Protocols',
                102 => 'Processing',
    
                200 => 'OK',
                201 => 'Created',
                202 => 'Accepted',
                203 => 'Non-Authoritative Information',
                204 => 'No Content',
                205 => 'Reset Content',
                206 => 'Partial Content',
                207 => 'Multi-Status',
                226 => 'IM Used',
    
                300 => 'Multiple Choices',
                301 => 'Moved Permanently',
                302 => 'Found',
                303 => 'See Other',
                304 => 'Not Modified',
                305 => 'Use Proxy',
                306 => 'Reserved',
                307 => 'Temporary Redirect',
                308 => 'Permanent Redirect',
    
                400 => 'Bad Request',
                401 => 'Unauthorized',
                402 => 'Payment Required',
                403 => 'Forbidden',
                404 => 'Not Found',
                405 => 'Method Not Allowed',
                406 => 'Not Acceptable',
                407 => 'Proxy Authentication Required',
                408 => 'Request Timeout',
                409 => 'Conflict',
                410 => 'Gone',
                411 => 'Length Required',
                412 => 'Precondition Failed',
                413 => 'Request Entity Too Large',
                414 => 'Request-URI Too Long',
                415 => 'Unsupported Media Type',
                416 => 'Requested Range Not Satisfiable',
                417 => 'Expectation Failed',
                418 => 'I\'m a teapot',
                421 => 'Misdirected Request',
                422 => 'Unprocessable Entity',
                423 => 'Locked',
                424 => 'Failed Dependency',
                426 => 'Upgrade Required',
                428 => 'Precondition Required',
                429 => 'Too Many Requests',
                431 => 'Request Header Fields Too Large',
                451 => 'Unavailable For Legal Reasons',
    
                500 => 'Internal Server Error',
                501 => 'Not Implemented',
                502 => 'Bad Gateway',
                503 => 'Service Unavailable',
                504 => 'Gateway Timeout',
                505 => 'HTTP Version Not Supported',
                506 => 'Variant Also Negotiates',
                507 => 'Insufficient Storage',
                510 => 'Not Extended',
                511 => 'Network Authentication Required',
            );
        }
    
        if ( isset( $rc_header_to_desc[$code] ) )
            return $rc_header_to_desc[$code];
        else
            return '';
    }
}

if ( !function_exists('rc_status_header') )
{
    /**
     * Set HTTP status header.
     *
     * @since 2.0.0
     * @since 4.4.0 Added the `$description` parameter.
     *
     * @see get_status_header_desc()
     *
     * @param int    $code        HTTP status code.
     * @param string $description Optional. A custom description for the HTTP status.
     */
    function rc_status_header( $code, $description = '' ) {
        if ( ! $description ) {
            $description = rc_get_status_header_desc( $code );
        }
    
        if ( empty( $description ) ) {
            return;
        }
    
        $protocol = rc_get_server_protocol();
        $status_header = "$protocol $code $description";
    
        /**
         * Filters an HTTP status header.
         *
         * @since 2.2.0
         *
         * @param string $status_header HTTP status header.
         * @param int    $code          HTTP status code.
         * @param string $description   Description for the status code.
         * @param string $protocol      Server protocol.
         */
        $status_header = RC_Hook::apply_filters( 'status_header', $status_header, $code, $description, $protocol );
    
        @header( $status_header, true, $code );
    }
}

if ( ! function_exists('rc_get_server_protocol'))
{
    /**
     * Return the HTTP protocol sent by the server.
     *
     * @since 4.4.0
     *
     * @return string The HTTP protocol. Default: HTTP/1.0.
     */
    function rc_get_server_protocol() {
        $protocol = $_SERVER['SERVER_PROTOCOL'];
        if ( ! in_array( $protocol, array( 'HTTP/1.1', 'HTTP/2', 'HTTP/2.0' ) ) ) {
            $protocol = 'HTTP/1.0';
        }
        return $protocol;
    }
}
// end