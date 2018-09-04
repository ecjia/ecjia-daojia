<?php 

namespace Royalcms\Component\HttpRequest;

use RC_Error;
use RC_Hook;
use Royalcms\Component\Foundation\Kses as RC_Kses;
use Royalcms\Component\Foundation\Uri as RC_Uri;

/**
 * Core HTTP Request API
 *
 * Standardizes the HTTP requests for WordPress. Handles cookies, gzip encoding and decoding, chunk
 * decoding, if HTTP 1.1 and various other difficult HTTP protocol implementations.
 *
 * @package RC
 * @subpackage HTTP
 * @since 3.2.0
 */


class HttpRequest {
    /**
     * Returns the initialized Component_Http_Http Object
     *
     * @since 3.2.0
     * @access private
     *
     * @return Component_Http_Http HTTP Transport object.
     */
    private static function _http_get_object() {
        static $http = null;
    
        if ( is_null($http) )
            $http = new Http();
    
        return $http;
    } 
    
    /**
     * Retrieve the raw response from a safe HTTP request.
     *
     * This function is ideal when the HTTP request is being made to an arbitrary
     * URL. The URL is validated to avoid redirection and request forgery attacks.
     *
     * @since 3.2.0
     *
     * @see remote_request() For more information on the response array format.
     * @see Component_Http_Http::request() For default arguments information.
     *
     * @param string $url  Site URL to retrieve.
     * @param array  $args Optional. Request arguments. Default empty array.
     * @return RC_Error|array The response or RC_Error on failure.
     */
    public static function safe_remote_request( $url, $args = array() ) {
        $args['reject_unsafe_urls'] = true;
        $http = self::_http_get_object();
        return $http->request( $url, $args );
    }
    
    
    
    /**
     * Retrieve the raw response from a safe HTTP request using the GET method.
     *
     * This function is ideal when the HTTP request is being made to an arbitrary
     * URL. The URL is validated to avoid redirection and request forgery attacks.
     *
     * @since 3.2.0
     *
     * @see remote_request() For more information on the response array format.
     * @see Component_Http_Http::request() For default arguments information.
     *
     * @param string $url  Site URL to retrieve.
     * @param array  $args Optional. Request arguments. Default empty array.
     * @return RC_Error|array The response or RC_Error on failure.
     */
    public static function safe_remote_get( $url, $args = array() ) {
        $args['reject_unsafe_urls'] = true;
        $http = self::_http_get_object();
        return $http->get( $url, $args );
    }
    
    
    /**
     * Retrieve the raw response from a safe HTTP request using the POST method.
     *
     * This function is ideal when the HTTP request is being made to an arbitrary
     * URL. The URL is validated to avoid redirection and request forgery attacks.
     *
     * @since 3.2.0
     *
     * @see remote_request() For more information on the response array format.
     * @see Component_Http_Http::request() For default arguments information.
     *
     * @param string $url  Site URL to retrieve.
     * @param array  $args Optional. Request arguments. Default empty array.
     * @return RC_Error|array The response or RC_Error on failure.
     */
    public static function safe_remote_post( $url, $args = array() ) {
        $args['reject_unsafe_urls'] = true;
        $http = self::_http_get_object();
        return $http->post( $url, $args );
    }
    
    
    /**
     * Retrieve the raw response from a safe HTTP request using the HEAD method.
     *
     * This function is ideal when the HTTP request is being made to an arbitrary
     * URL. The URL is validated to avoid redirection and request forgery attacks.
     *
     * @since 3.2.0
     *
     * @see remote_request() For more information on the response array format.
     * @see Component_Http_Http::request() For default arguments information.
     *
     * @param string $url Site URL to retrieve.
     * @param array $args Optional. Request arguments. Default empty array.
     * @return RC_Error|array The response or RC_Error on failure.
     */
    public static function safe_remote_head( $url, $args = array() ) {
        $args['reject_unsafe_urls'] = true;
        $http = self::_http_get_object();
        return $http->head( $url, $args );
    }
    
    
    
    /**
     * Retrieve the raw response from the HTTP request.
     *
     * The array structure is a little complex:
     *
     *     $res = array(
     *         'headers'  => array(),
     *         'response' => array(
     *             'code'    => int,
     *             'message' => string
     *         )
     *     );
     *
     * All of the headers in $res['headers'] are with the name as the key and the
     * value as the value. So to get the User-Agent, you would do the following.
     *
     *     $user_agent = $res['headers']['user-agent'];
     *
     * The body is the raw response content and can be retrieved from $res['body'].
     *
     * This function is called first to make the request and there are other API
     * functions to abstract out the above convoluted setup.
     *
     * Request method defaults for helper functions:
     *  - Default 'GET'  for remote_get()
     *  - Default 'POST' for remote_post()
     *  - Default 'HEAD' for remote_head()
     *
     * @since 3.2.0
     *
     * @see Component_Http_Http::request() For additional information on default arguments.
     *
     * @param string $url  Site URL to retrieve.
     * @param array  $args Optional. Request arguments. Default empty array.
     * @return RC_Error|array The response or RC_Error on failure.
     */
    public static function remote_request($url, $args = array()) {
        $http = self::_http_get_object();
        return $http->request($url, $args);
    }
    
    
    /**
     * Retrieve the raw response from the HTTP request using the GET method.
     *
     * @since 3.2.0
     *
     * @see remote_request() For more information on the response array format.
     * @see Component_Http_Http::request() For default arguments information.
     *
     * @param string $url  Site URL to retrieve.
     * @param array  $args Optional. Request arguments. Default empty array.
     * @return RC_Error|array The response or RC_Error on failure.
     */
    public static function remote_get($url, $args = array()) {
        $http = self::_http_get_object();
        return $http->get($url, $args);
    }
    
    
    
    /**
     * Retrieve the raw response from the HTTP request using the POST method.
     *
     * @since 3.2.0
     *
     * @see remote_request() For more information on the response array format.
     * @see Component_Http_Http::request() For default arguments information.
     *
     * @param string $url  Site URL to retrieve.
     * @param array  $args Optional. Request arguments. Default empty array.
     * @return RC_Error|array The response or RC_Error on failure.
     */
    public static function remote_post($url, $args = array()) {
        $http = self::_http_get_object();
        return $http->post($url, $args);
    }
    
    
    
    /**
     * Retrieve the raw response from the HTTP request using the HEAD method.
     *
     * @since 3.2.0
     *
     * @see remote_request() For more information on the response array format.
     * @see Component_Http_Http::request() For default arguments information.
     *
     * @param string $url  Site URL to retrieve.
     * @param array  $args Optional. Request arguments. Default empty array.
     * @return RC_Error|array The response or RC_Error on failure.
     */
    public static function remote_head($url, $args = array()) {
        $http = self::_http_get_object();
        return $http->head($url, $args);
    }
    
    
    /**
     * Retrieve only the headers from the raw response.
     *
     * @since 3.2.0
     *
     * @param array $response HTTP response.
     * @return array The headers of the response. Empty array if incorrect parameter given.
     */
    public static function remote_retrieve_headers( $response ) {
        if ( RC_Error::is_error($response) || ! isset($response['headers']) || ! is_array($response['headers']))
            return array();
    
        return $response['headers'];
    }
    
    
    /**
     * Retrieve a single header by name from the raw response.
     *
     * @since 3.2.0
     *
     * @param array $response
     * @param string $header Header name to retrieve value from.
     * @return string The header value. Empty string on if incorrect parameter given, or if the header doesn't exist.
     */
    public static function remote_retrieve_header( $response, $header ) {
        if ( RC_Error::is_error($response) || ! isset($response['headers']) || ! is_array($response['headers']))
            return '';
    
        if ( array_key_exists($header, $response['headers']) )
            return $response['headers'][$header];
    
        return '';
    }
    
    
    /**
     * Retrieve only the response code from the raw response.
     *
     * Will return an empty array if incorrect parameter value is given.
     *
     * @since 3.2.0
     *
     * @param array $response HTTP response.
     * @return string the response code. Empty string on incorrect parameter given.
     */
    public static function remote_retrieve_response_code( $response ) {
        if ( RC_Error::is_error($response) || ! isset($response['response']) || ! is_array($response['response']))
            return '';
    
        return $response['response']['code'];
    }
    
    
    /**
     * Retrieve only the response message from the raw response.
     *
     * Will return an empty array if incorrect parameter value is given.
     *
     * @since 3.2.0
     *
     * @param array $response HTTP response.
     * @return string The response message. Empty string on incorrect parameter given.
     */
    public static function remote_retrieve_response_message( $response ) {
        if ( RC_Error::is_error($response) || ! isset($response['response']) || ! is_array($response['response']))
            return '';
    
        return $response['response']['message'];
    }
    
    
    
    /**
     * Retrieve only the body from the raw response.
     *
     * @since 3.2.0
     *
     * @param array $response HTTP response.
     * @return string The body of the response. Empty string if no body or incorrect parameter given.
     */
    public static function remote_retrieve_body( $response ) {
        if ( RC_Error::is_error($response) || ! isset($response['body']) )
            return '';
    
        return $response['body'];
    }
    
    /**
     * Retrieve only the cookies from the raw response.
     *
     * @since 4.4.0
     *
     * @param array $response HTTP response.
     * @return array An array of `Royalcms_Http_Cookie` objects from the response. Empty array if there are none, or the response is a WP_Error.
     */
    public static function remote_retrieve_cookies( $response ) {
        if ( RC_Error::is_error( $response ) || empty( $response['cookies'] ) ) {
            return array();
        }
    
        return $response['cookies'];
    }
    
    /**
     * Retrieve a single cookie by name from the raw response.
     *
     * @since 4.4.0
     *
     * @param array  $response HTTP response.
     * @param string $name     The name of the cookie to retrieve.
     * @return Royalcms_Http_Cookie|string The `WP_Http_Cookie` object. Empty string if the cookie isn't present in the response.
     */
    public static function remote_retrieve_cookie( $response, $name ) {
        $cookies = self::remote_retrieve_cookies( $response );
    
        if ( empty( $cookies ) ) {
            return '';
        }
    
        foreach ( $cookies as $cookie ) {
            if ( $cookie->name === $name ) {
                return $cookie;
            }
        }
    
        return '';
    }
    
    /**
     * Retrieve a single cookie's value by name from the raw response.
     *
     * @since 4.4.0
     *
     * @param array  $response HTTP response.
     * @param string $name     The name of the cookie to retrieve.
     * @return string The value of the cookie. Empty string if the cookie isn't present in the response.
     */
    public static function remote_retrieve_cookie_value( $response, $name ) {
        $cookie = self::remote_retrieve_cookie( $response, $name );
    
        if ( ! is_a( $cookie, 'Royalcms\Component\HttpRequest\Cookie' ) ) {
            return '';
        }
    
        return $cookie->value;
    }
    
    /**
     * Determines if there is an HTTP Transport that can process this request.
     *
     * @since 3.2.0
     *
     * @param array  $capabilities Array of capabilities to test or a wp_remote_request() $args array.
     * @param string $url Optional. If given, will check if the URL requires SSL and adds that requirement to the capabilities array.
     *
     * @return bool
     */
    public static function http_supports( $capabilities = array(), $url = null ) {
        $http = self::_http_get_object();
    
        $capabilities = rc_parse_args( $capabilities );
    
        $count = count( $capabilities );
    
        // If we have a numeric $capabilities array, spoof a wp_remote_request() associative $args array
        if ( $count && count( array_filter( array_keys( $capabilities ), 'is_numeric' ) ) == $count ) {
            $capabilities = array_combine( array_values( $capabilities ), array_fill( 0, $count, true ) );
        }
    
        if ( $url && !isset( $capabilities['ssl'] ) ) {
            $scheme = parse_url( $url, PHP_URL_SCHEME );
            if ( 'https' == $scheme || 'ssl' == $scheme ) {
                $capabilities['ssl'] = true;
            }
        }
    
        return (bool) $http->_get_first_available_transport( $capabilities );
    }
    
    
    
    /**
     * Get the HTTP Origin of the current request.
     *
     * @since 3.2.0
     *
     * @return string URL of the origin. Empty string if no origin.
     */
    public static function get_http_origin() {
        $origin = '';
        if ( ! empty ( $_SERVER[ 'HTTP_ORIGIN' ] ) )
            $origin = $_SERVER[ 'HTTP_ORIGIN' ];
    
        /**
         * Change the origin of an HTTP request.
         *
         * @since 3.2.0
         *
         * @param string $origin The original origin for the request.
         */
        return RC_Hook::apply_filters( 'http_origin', $origin );
    }
    
    
    /**
     * Retrieve list of allowed HTTP origins.
     *
     * @since 3.2.0
     *
     * @return array Array of origin URLs.
     */
    public static function get_allowed_http_origins() {
        $admin_origin = parse_url( RC_Uri::admin_url() );
        $home_origin = parse_url( RC_Uri::home_url() );
    
        // @todo preserve port?
        $allowed_origins = array_unique( array(
            'http://' . $admin_origin[ 'host' ],
            'https://' . $admin_origin[ 'host' ],
            'http://' . $home_origin[ 'host' ],
            'https://' . $home_origin[ 'host' ],
        ) );
    
        /**
         * Change the origin types allowed for HTTP requests.
         *
         * @since 3.2.0
         *
         * @param array $allowed_origins {
         *     Default allowed HTTP origins.
         *     @type string Non-secure URL for admin origin.
         *     @type string Secure URL for admin origin.
         *     @type string Non-secure URL for home origin.
         *     @type string Secure URL for home origin.
         * }
        */
        return RC_Hook::apply_filters( 'allowed_http_origins' , $allowed_origins );
    }
    
    
    /**
     * Determines if the HTTP origin is an authorized one.
     *
     * @since 3.4.0
     *
     * @param string Origin URL. If not provided, the value of get_http_origin() is used.
     * @return bool True if the origin is allowed. False otherwise.
     */
    public static function is_allowed_http_origin( $origin = null ) {
        $origin_arg = $origin;
    
        if ( null === $origin )
            $origin = self::get_http_origin();
    
        if ( $origin && ! in_array( $origin, self::get_allowed_http_origins() ) )
            $origin = '';
    
        /**
         * Change the allowed HTTP origin result.
         *
         * @since 3.2.0
         *
         * @param string $origin Result of check for allowed origin.
         * @param string $origin_arg original origin string passed into is_allowed_http_origin function.
         */
        return RC_Hook::apply_filters( 'allowed_http_origin', $origin, $origin_arg );
    }
    
    
    /**
     * Send Access-Control-Allow-Origin and related headers if the current request
     * is from an allowed origin.
     *
     * If the request is an OPTIONS request, the script exits with either access
     * control headers sent, or a 403 response if the origin is not allowed. For
     * other request methods, you will receive a return value.
     *
     * @since 3.2.0
     *
     * @return bool|string Returns the origin URL if headers are sent. Returns false
     * if headers are not sent.
     */
    public static function send_origin_headers() {
        $origin = self::get_http_origin();
    
        if ( self::is_allowed_http_origin( $origin ) ) {
            @header( 'Access-Control-Allow-Origin: ' .  $origin );
            @header( 'Access-Control-Allow-Credentials: true' );
            if ( 'OPTIONS' === $_SERVER['REQUEST_METHOD'] )
                exit;
            return $origin;
        }
    
        if ( 'OPTIONS' === $_SERVER['REQUEST_METHOD'] ) {
            HeaderUtility::status_header( 403 );
            exit;
        }
    
        return false;
    }
    
    
    /**
     * Validate a URL for safe use in the HTTP API.
     *
     * @since 3.2.0
     *
     * @return mixed URL or false on failure.
     */
    public static function http_validate_url( $url ) {
        $original_url = $url;
        $url = RC_Kses::bad_protocol( $url, array( 'http', 'https' ) );
        if ( ! $url || strtolower( $url ) !== strtolower( $original_url ) )
            return false;
    
        $parsed_url = @parse_url( $url );
        if ( ! $parsed_url || empty( $parsed_url['host'] ) )
            return false;
    
        if ( isset( $parsed_url['user'] ) || isset( $parsed_url['pass'] ) )
            return false;
    
        if ( false !== strpbrk( $parsed_url['host'], ':#?[]' ) )
            return false;
    
        $parsed_home = @parse_url( RC_Uri::home_url() );
    
        $same_host = strtolower( $parsed_home['host'] ) === strtolower( $parsed_url['host'] );
    
        if ( ! $same_host ) {
            $host = trim( $parsed_url['host'], '.' );
            if ( preg_match( '#^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$#', $host ) ) {
                $ip = $host;
            } else {
                $ip = gethostbyname( $host );
                if ( $ip === $host ) // Error condition for gethostbyname()
                    $ip = false;
            }
            if ( $ip ) {
                $parts = array_map( 'intval', explode( '.', $ip ) );
                if ( 127 === $parts[0] || 10 === $parts[0]
                    || ( 172 === $parts[0] && 16 <= $parts[1] && 31 >= $parts[1] )
                    || ( 192 === $parts[0] && 168 === $parts[1] )
                ) {
                    // If host appears local, reject unless specifically allowed.
                    /**
                    * Check if HTTP request is external or not.
                    *
                    * Allows to change and allow external requests for the HTTP request.
                    *
                    * @since 3.2.0
                    *
                    * @param bool false Whether HTTP request is external or not.
                    * @param string $host IP of the requested host.
                    * @param string $url URL of the requested host.
                    */
                    if ( ! RC_Hook::apply_filters( 'http_request_host_is_external', false, $host, $url ) )
                        return false;
                }
            }
        }
    
        if ( empty( $parsed_url['port'] ) )
            return $url;
    
        $port = $parsed_url['port'];
        if ( 80 === $port || 443 === $port || 8080 === $port )
            return $url;
    
        if ( $parsed_home && $same_host && isset( $parsed_home['port'] ) && $parsed_home['port'] === $port )
            return $url;
    
        return false;
    }
    
    /**
     * Whitelists allowed redirect hosts for safe HTTP requests as well.
     *
     * Attached to the http_request_host_is_external filter.
     *
     * @since 3.2.0
     *
     * @param bool $is_external
     * @param string $host
     * @return bool
     */
    public static function allowed_http_request_hosts( $is_external, $host ) {
        if ( ! $is_external && rc_validate_redirect( 'http://' . $host ) )
            $is_external = true;
        return $is_external;
    } 
    
}


// end