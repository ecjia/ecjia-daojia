<?php namespace Royalcms\Component\Rewrite;

use RC_Hook;
use Royalcms\Component\Foundation\Uri;

class RewriteQuery
{
    protected $rc_rewrite;
    
    /**
     * Public query variables.
     *
     * Long list of public query variables.
     *
     * @since 2.0.0
     * @access public
     * @var array
     */
    public $public_query_vars = array('m', 'c', 'a', 'data', 'lang', 'page');
    
    /**
     * Private query variables.
     *
     * Long list of private query variables.
     *
     * @since 2.0.0
     * @var array
    */
    public $private_query_vars = array();
    
    /**
     * Extra query variables set by the user.
     *
     * @since 2.1.0
     * @var array
    */
    public $extra_query_vars = array();
    
    /**
     * Query variables for setting up the WordPress Query Loop.
     *
     * @since 2.0.0
     * @var array
    */
    public $query_vars;
    
    /**
     * String parsed to set the query variables.
     *
     * @since 2.0.0
     * @var string
     */
    public $query_string;
    
    /**
     * Permalink or requested URI.
     *
     * @since 2.0.0
     * @var string
     */
    public $request;
    
    /**
     * Rewrite rule the request matched.
     *
     * @since 2.0.0
     * @var string
     */
    public $matched_rule;
    
    /**
     * Rewrite query the request matched.
     *
     * @since 2.0.0
     * @var string
     */
    public $matched_query;
    
    /**
     * Whether already did the permalink.
     *
     * @since 2.0.0
     * @var bool
     */
    public $did_permalink = false;
    
    public function __construct()
    {
        $this->rc_rewrite = new Rewrite();
    }
    
    /**
     * 返回当前终级类对象的实例
     *
     * @param $cache_config 缓存配置
     * @return object
     */
    public function instance()
    {
        return $this->rc_rewrite;
    }
    
    /**
     * Adds a rewrite rule that transforms a URL structure to a set of query vars.
     *
     * Any value in the $after parameter that isn't 'bottom' will result in the rule
     * being placed at the top of the rewrite rules.
     *
     * @since 2.1.0
     * @since 4.4.0 Array support was added to the `$query` parameter.
     *
     * @global RC_Rewrite $rc_rewrite WordPress Rewrite Component.
     *
     * @param string       $regex Regular expression to match request against.
     * @param string|array $query The corresponding query vars for this rewrite rule.
     * @param string       $after Optional. Priority of the new rule. Accepts 'top'
     *                            or 'bottom'. Default 'bottom'.
     */
    public function add_rewrite_rule( $regex, $query, $after = 'bottom' ) {
        $this->rc_rewrite->add_rule( $regex, $query, $after );
    }
    
    
    /**
     * Add a new rewrite tag (like %postname%).
     *
     * The $query parameter is optional. If it is omitted you must ensure that
     * you call this on, or before, the 'init' hook. This is because $query defaults
     * to "$tag=", and for this to work a new query var has to be added.
     *
     * @since 2.1.0
     *
     * @global RC_Rewrite $rc_rewrite
     * @global WP         $wp
     *
     * @param string $tag   Name of the new rewrite tag.
     * @param string $regex Regular expression to substitute the tag for in rewrite rules.
     * @param string $query Optional. String to append to the rewritten query. Must end in '='. Default empty.
     */
    public function add_rewrite_tag( $tag, $regex, $query = '' ) {
        // validate the tag's name
        if ( strlen( $tag ) < 3 || $tag[0] != '%' || $tag[ strlen($tag) - 1 ] != '%' )
            return;

        if ( empty( $query ) ) {
            $qv = trim( $tag, '%' );
            $this->add_query_var( $qv );
            $query = $qv . '=';
        }
    
        $this->rc_rewrite->add_rewrite_tag( $tag, $regex, $query );
    }
    
    
    /**
     * Add permalink structure.
     *
     * @since 3.0.0
     *
     * @see RC_Rewrite::add_permastruct()
     * @global RC_Rewrite $rc_rewrite
     *
     * @param string $name   Name for permalink structure.
     * @param string $struct Permalink structure.
     * @param array  $args   Optional. Arguments for building the rules from the permalink structure,
     *                       see RC_Rewrite::add_permastruct() for full details. Default empty array.
     */
    public function add_permastruct( $name, $struct, $args = array() ) {
        // backwards compatibility for the old parameters: $with_front and $ep_mask
        if ( ! is_array( $args ) )
            $args = array( 'with_front' => $args );
        if ( func_num_args() == 4 )
            $args['ep_mask'] = func_get_arg( 3 );
    
        $this->rc_rewrite->add_permastruct( $name, $struct, $args );
    }
    
    /**
     * Remove rewrite rules and then recreate rewrite rules.
     *
     * @since 3.0.0
     *
     * @global RC_Rewrite $rc_rewrite
     *
     * @param bool $hard Whether to update .htaccess (hard flush) or just update
     * 	                 rewrite_rules transient (soft flush). Default is true (hard).
     */
    public function flush_rewrite_rules( $hard = true ) {
        $this->rc_rewrite->flush_rules( $hard );
    }
    
    /**
     * Add an endpoint, like /trackback/.
     *
     * Adding an endpoint creates extra rewrite rules for each of the matching
     * places specified by the provided bitmask. For example:
     *
     *     add_rewrite_endpoint( 'json', EP_PERMALINK | EP_PAGES );
     *
     * will add a new rewrite rule ending with "json(/(.*))?/?$" for every permastruct
     * that describes a permalink (post) or page. This is rewritten to "json=$match"
     * where $match is the part of the URL matched by the endpoint regex (e.g. "foo" in
     * "[permalink]/json/foo/").
     *
     * A new query var with the same name as the endpoint will also be created.
     *
     * When specifying $places ensure that you are using the EP_* constants (or a
     * combination of them using the bitwise OR operator) as their values are not
     * guaranteed to remain static (especially `EP_ALL`).
     *
     * Be sure to flush the rewrite rules - see flush_rewrite_rules() - when your plugin gets
     * activated and deactivated.
     *
     * @since 2.1.0
     * @since 4.3.0 Added support for skipping query var registration by passing `false` to `$query_var`.
     *
     * @global RC_Rewrite $rc_rewrite
     *
     * @param string      $name      Name of the endpoint.
     * @param int         $places    Endpoint mask describing the places the endpoint should be added.
     * @param string|bool $query_var Name of the corresponding query variable. Pass `false` to skip registering a query_var
     *                               for this endpoint. Defaults to the value of `$name`.
     */
    public function add_rewrite_endpoint( $name, $places, $query_var = true ) {
        $this->rc_rewrite->add_endpoint( $name, $places, $query_var );
    }
    
    /**
     * Parse request to find correct WordPress query.
     *
     * Sets up the query variables based on the request. There are also many
     * filters and actions that can be used to further manipulate the result.
     *
     * @since 2.0.0
     *
     * @global RC_Rewrite $rc_rewrite
     *
     * @param array|string $extra_query_vars Set the extra query variables.
     */
    public function parse_request($extra_query_vars = '') {

        /**
         * Filter whether to parse the request.
         *
         * @since 3.5.0
         *
         * @param bool         $bool             Whether or not to parse the request. Default true.
         * @param WP           $this             Current WordPress environment instance.
         * @param array|string $extra_query_vars Extra passed query variables.
         */
        if ( ! RC_Hook::apply_filters( 'do_parse_request', true, $this, $extra_query_vars ) )
            return;
    
        $this->query_vars = array();
    
        if ( is_array( $extra_query_vars ) ) {
            $this->extra_query_vars = & $extra_query_vars;
        } elseif ( ! empty( $extra_query_vars ) ) {
            parse_str( $extra_query_vars, $this->extra_query_vars );
        }
        // Process PATH_INFO, REQUEST_URI, and 404 for permalinks.
    
        // Fetch the rewrite rules.
        $rewrite = $this->rc_rewrite->rc_rewrite_rules();
        
        if ( ! empty($rewrite) ) {
            // If we match a rewrite rule, this will be cleared.
            $error = '404';
            $this->did_permalink = true;
    
            $pathinfo = isset( $_SERVER['PATH_INFO'] ) ? $_SERVER['PATH_INFO'] : '';
            list( $pathinfo ) = explode( '?', $pathinfo );
            $pathinfo = str_replace( "%", "%25", $pathinfo );
            
            if (strpos($_SERVER['REQUEST_URI'], '?')) {
                list( $req_uri, $req_str ) = explode( '?', $_SERVER['REQUEST_URI'] );
            } else {
                list( $req_uri ) = explode( '?', $_SERVER['REQUEST_URI'] );
                $req_str = '';
            }
            
            $self = $_SERVER['PHP_SELF'];
            $home_path = trim( parse_url( Uri::home_url(), PHP_URL_PATH ), '/' );
            $home_path_regex = sprintf( '|^%s|i', preg_quote( $home_path, '|' ) );
    
            // Trim path info from the end and the leading home path from the
            // front. For path info requests, this leaves us with the requesting
            // filename, if any. For 404 requests, this leaves us with the
            // requested permalink.
            $req_uri = str_replace($pathinfo, '', $req_uri);
            $req_uri = trim($req_uri, '/');
            $req_uri = preg_replace( $home_path_regex, '', $req_uri );
            $req_uri = trim($req_uri, '/');
            $pathinfo = trim($pathinfo, '/');
            $pathinfo = preg_replace( $home_path_regex, '', $pathinfo );
            $pathinfo = trim($pathinfo, '/');
            $self = trim($self, '/');
            $self = preg_replace( $home_path_regex, '', $self );
            $self = trim($self, '/');
    
            // The requested permalink is in $pathinfo for path info requests and
            //  $req_uri for other requests.
            if ( ! empty($pathinfo) && !preg_match('|^.*' . $this->rc_rewrite->index . '$|', $pathinfo) ) {
                $request = $pathinfo;
            } else {
                // If the request uri is the index, blank it out so that we don't try to match it against a rule.
                if ( $req_uri == $this->rc_rewrite->index )
                    $req_uri = '';
                $request = $req_uri;
            }

            $this->request = $request;
            
            $req_str = RC_Hook::apply_filters('rewrite_parse_query_string', $req_str);
            // Look for matches.
            $request_match = $request . '?' . $req_str;
            if ( empty( $request_match ) ) {
                // An empty request could only match against ^$ regex
                if ( isset( $rewrite['$'] ) ) {
                    $this->matched_rule = '$';
                    $query = $rewrite['$'];
                    $matches = array('');
                }
            } else {
                foreach ( (array) $rewrite as $match => $query ) {
                    // If the requesting file is the anchor of the match, prepend it to the path info.
                    if ( ! empty($req_uri) && strpos($match, $req_uri) === 0 && $req_uri != $request )
                        $request_match = $req_uri . '/' . $request;

                    if ( preg_match("#^$match#", $request_match, $matches) ||
                        preg_match("#^$match#", urldecode($request_match), $matches) ) {
                            // Got a match.
                            $this->matched_rule = $match;
                            break;
                        }
                }
            }
            
            if ( isset( $this->matched_rule ) ) {
                // Trim the query of everything up to the '?'.
                $query = preg_replace('!^.+\?!', '', $query);
                
                // Substitute the substring matches into the query.
                $query = addslashes(MatchesMapRegex::apply($query, $matches));

                $this->matched_query = $query;
    
                // Parse the query.
                parse_str($query, $perma_query_vars);

                // If we're processing a 404 request, clear the error var since we found something.
                if ( '404' == $error )
                    unset( $error, $_GET['error'] );
            }

            // If req_uri is empty or if it is a request for ourself, unset error.
            if ( empty($request) || $req_uri == $self ) {
                unset( $error, $_GET['error'] );
                $this->did_permalink = false;
            }
        }
    
        /**
         * Filter the query variables whitelist before processing.
         *
         * Allows (publicly allowed) query vars to be added, removed, or changed prior
         * to executing the query. Needed to allow custom rewrite rules using your own arguments
         * to work, or any other custom query variables you want to be publicly available.
         *
         * @since 1.5.0
         *
         * @param array $public_query_vars The array of whitelisted query variables.
         */
        $this->public_query_vars = RC_Hook::apply_filters( 'query_vars', $this->public_query_vars );
    
        foreach ( $this->public_query_vars as $rcvar ) {
            if ( isset( $this->extra_query_vars[$rcvar] ) )
                $this->query_vars[$rcvar] = $this->extra_query_vars[$rcvar];
            elseif ( isset( $_POST[$rcvar] ) )
                $this->query_vars[$rcvar] = $_POST[$rcvar];
            elseif ( isset( $_GET[$rcvar] ) )
                $this->query_vars[$rcvar] = $_GET[$rcvar];
            elseif ( isset( $perma_query_vars[$rcvar] ) )
                $this->query_vars[$rcvar] = $perma_query_vars[$rcvar];
    
            if ( !empty( $this->query_vars[$rcvar] ) ) {
                if ( ! is_array( $this->query_vars[$rcvar] ) ) {
                    $this->query_vars[$rcvar] = (string) $this->query_vars[$rcvar];
                } else {
                    foreach ( $this->query_vars[$rcvar] as $vkey => $v ) {
                        if ( !is_object( $v ) ) {
                            $this->query_vars[$rcvar][$vkey] = (string) $v;
                        }
                    }
                }
            }
        }

        foreach ( (array) $this->private_query_vars as $var) {
            if ( isset($this->extra_query_vars[$var]) )
                $this->query_vars[$var] = $this->extra_query_vars[$var];
        }

        if ( isset($error) )
            $this->query_vars['error'] = $error;

        /**
         * Filter the array of parsed query variables.
         *
         * @since 2.1.0
         *
         * @param array $query_vars The array of requested query variables.
         */
        $this->query_vars = RC_Hook::apply_filters( 'request', $this->query_vars );

        /**
         * Fires once all query variables for the current request have been parsed.
         *
         * @since 2.1.0
         *
         * @param WP &$this Current WordPress environment instance (passed by reference).
        */
        RC_Hook::do_action_ref_array( 'parse_request', array( &$this ) );
    }
    
    /**
     * Add name to list of public query variables.
     *
     * @since 2.1.0
     *
     * @param string $qv Query variable name.
     */
    public function add_query_var($qv) {
        if ( !in_array($qv, $this->public_query_vars) )
            $this->public_query_vars[] = $qv;
    }
    
    /**
     * Add name to list of public query variables.
     *
     * @since 2.1.0
     *
     * @param string $qv Query variable name.
     */
    public function add_query_vars($qvs) {
        foreach ($qvs as $key) 
            $this->add_query_var($key);
    }
    
    /**
     * Set the value of a query variable.
     *
     * @since 2.3.0
     *
     * @param string $key Query variable name.
     * @param mixed $value Query variable value.
     */
    public function set_query_var($key, $value) {
        $this->query_vars[$key] = $value;
    }
    
    /**
     * Get the value of a query variable.
     *
     * @since 2.3.0
     *
     */
    public function get_query_var() {
        return $this->query_vars;
    }
    
    /**
     * Sets the query string property based off of the query variable property.
     *
     * The 'query_string' filter is deprecated, but still works. Plugins should
     * use the 'request' filter instead.
     *
     * @since 2.0.0
     */
    public function build_query_string() {
        $this->query_string = '';
        foreach ( (array) array_keys($this->query_vars) as $wpvar) {
            if ( '' != $this->query_vars[$wpvar] ) {
                $this->query_string .= (strlen($this->query_string) < 1) ? '' : '&';
                if ( !is_scalar($this->query_vars[$wpvar]) ) // Discard non-scalars.
                    continue;
                $this->query_string .= $wpvar . '=' . rawurlencode($this->query_vars[$wpvar]);
            }
        }
    
        if ( RC_Hook::has_filter( 'query_string' ) ) {  // Don't bother filtering and parsing if no plugins are hooked in.
            /**
            * Filter the query string before parsing.
            *
            * @since 1.5.0
            * @deprecated 2.1.0 Use 'query_vars' or 'request' filters instead.
            *
            * @param string $query_string The query string to modify.
            */
            $this->query_string = RC_Hook::apply_filters( 'query_string', $this->query_string );
			parse_str($this->query_string, $this->query_vars);
		}
	}
    
}

// end
