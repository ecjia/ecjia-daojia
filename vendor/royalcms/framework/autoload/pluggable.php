<?php
/**
 * These functions can be replaced via plugins. If plugins do not redefine these
 * functions, then these will be used instead.
 *
 * @package Royalcms
 */

if ( !function_exists('rc_validate_redirect') ) :
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
endif;

// end