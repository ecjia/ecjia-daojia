<?php namespace Royalcms\Component\HttpRequest;

use RC_Hook;

class HeaderUtility {
    
    /**
     * Retrieve the description for the HTTP status.
     *
     * @since 2.3.0
     *
     * @param int $code HTTP status code.
     * @return string Empty string if not found, or description if found.
     */
    public static function get_status_header_desc( $code ) {
        global $rc_header_to_desc;
    
        $code = rc_absint( $code );
    
        if ( !isset( $rc_header_to_desc ) ) {
            $rc_header_to_desc = array(
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
                422 => 'Unprocessable Entity',
                423 => 'Locked',
                424 => 'Failed Dependency',
                426 => 'Upgrade Required',
                428 => 'Precondition Required',
                429 => 'Too Many Requests',
                431 => 'Request Header Fields Too Large',
    
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
    
    /**
     * Set HTTP status header.
     *
     * @since 3.2.0
     *
     * @see get_status_header_desc()
     *
     * @param int $code HTTP status code.
     */
    public static function status_header( $code ) {
        $description = self::get_status_header_desc( $code );
    
        if ( empty( $description ) ) {
    		return;
    	}
    
        $protocol = rc_server_protocol();
        $status_header = "$protocol $code $description";
  
        /**
         * Filter an HTTP status header.
         *
         * @since 3.2.0
         *
         * @param string $status_header HTTP status header.
         * @param int    $code          HTTP status code.
         * @param string $description   Description for the status code.
         * @param string $protocol      Server protocol.
         */
        $status_header = RC_Hook::apply_filters( 'status_header', $status_header, $code, $description, $protocol );
    
        @header( $status_header, true, $code );
    }
    
    /**
     * Get the header information to prevent caching.
     *
     * The several different headers cover the different ways cache prevention
     * is handled by different browsers
     *
     * @since 2.8.0
     *
     * @return array The associative array of header names and field values.
     */
    public static function get_nocache_headers() {
        $headers = array(
            'Expires' => 'Wed, 11 Jan 1984 05:00:00 GMT',
            'Cache-Control' => 'no-cache, must-revalidate, max-age=0',
        );
    
        if ( function_exists('apply_filters') ) {
            /**
             * Filters the cache-controlling headers.
             *
             * @since 2.8.0
             *
             * @see get_nocache_headers()
             *
             * @param array $headers {
             *     Header names and field values.
             *
             *     @type string $Expires       Expires header.
             *     @type string $Cache-Control Cache-Control header.
             * }
             */
            $headers = (array) RC_Hook::apply_filters( 'nocache_headers', $headers );
        }
        $headers['Last-Modified'] = false;
        return $headers;
    }
    
    /**
     * Set the headers to prevent caching for the different browsers.
     *
     * Different browsers support different nocache headers, so several
     * headers must be sent so that all of them get the point that no
     * caching should occur.
     *
     * @since 2.0.0
     *
     * @see wp_get_nocache_headers()
     */
    public static function nocache_headers() {
        $headers = self::get_nocache_headers();
    
        unset( $headers['Last-Modified'] );
    
        // In PHP 5.3+, make sure we are not sending a Last-Modified header.
        if ( function_exists( 'header_remove' ) ) {
            @header_remove( 'Last-Modified' );
        } else {
            // In PHP 5.2, send an empty Last-Modified header, but only as a
            // last resort to override a header already sent. #WP23021
            foreach ( headers_list() as $header ) {
                if ( 0 === stripos( $header, 'Last-Modified' ) ) {
                    $headers['Last-Modified'] = '';
                    break;
                }
            }
        }
    
        foreach ( $headers as $name => $field_value )
            @header("{$name}: {$field_value}");
    }
    
    
    /**
     * Set the headers for caching for 10 days with JavaScript content type.
     *
     * @since 2.1.0
     */
    public static function cache_javascript_headers() {
        $expiresOffset = 10 * DAY_IN_SECONDS;
    
        header( "Content-Type: text/javascript; charset=" . RC_CHARSET );
        header( "Vary: Accept-Encoding" ); // Handle proxies
        header( "Expires: " . gmdate( "D, d M Y H:i:s", time() + $expiresOffset ) . " GMT" );
    }
}


// end