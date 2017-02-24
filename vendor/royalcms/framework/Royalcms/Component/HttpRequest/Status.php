<?php namespace Royalcms\Component\HttpRequest;

use Royalcms\Component\Support\Facades\Hook;

class Status {
    
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
    
        $code = abs(intval($code));
    
        if ( !isset( $wp_header_to_desc ) ) {
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
    
        if ( empty( $description ) )
            return;
    
        $protocol = $_SERVER['SERVER_PROTOCOL'];
        if ( 'HTTP/1.1' != $protocol && 'HTTP/1.0' != $protocol )
            $protocol = 'HTTP/1.0';
        $status_header = "$protocol $code $description";
        if ( method_exists('RC_Hook', 'apply_filters') )
    
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
            $status_header = Hook::apply_filters( 'status_header', $status_header, $code, $description, $protocol );
    
        @header( $status_header, true, $code );
    }
    
}


// end