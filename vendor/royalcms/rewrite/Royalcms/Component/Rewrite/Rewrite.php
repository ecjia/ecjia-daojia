<<<<<<< HEAD
<?php namespace Royalcms\Component\Rewrite;
=======
<?php

namespace Royalcms\Component\Rewrite;
>>>>>>> v2-test
/**
 * Rewrite API: RC_Rewrite class
 *
 * @package Royalcms
 * @subpackage Rewrite
 * @since 3.10.0
 */

/**
<<<<<<< HEAD
 * Endpoint Mask for default, which is nothing.
 *
 * @since 3.10.0
 */
define('EP_NONE', 0);

/**
 * Endpoint Mask for Permalink.
 *
 * @since 3.10.0
*/
define('EP_PERMALINK', 1);

/**
 * Endpoint Mask for root.
 *
 * @since 3.10.0
 */
define('EP_ROOT', 64);

/**
=======
>>>>>>> v2-test
 * Core class used to implement a rewrite component API.
 *
 * The Royalcms Rewrite class writes the rewrite module rules to the .htaccess
 * file. It also handles parsing the request to get the correct setup for the
 * Royalcms Query class.
 *
 * The Rewrite along with WP class function as a front controller for Royalcms.
 * You can add rules to trigger your page view and processing using this
 * component. The full functionality of a front controller does not exist,
 * meaning you can't define how the template files load based on the rewrite
 * rules.
 *
 * @since 3.10.0
 */
class Rewrite {
    
    /**
     * Permalink structure for posts.
     *
     * @since 3.10.0
     * @var string
     */
    public $permalink_structure;
    
    /**
     * Whether to add trailing slashes.
     *
     * @since 3.10.0
     * @var bool
     */
    public $use_trailing_slashes;
    
    /**
     * The static portion of the post permalink structure.
     *
     * If the permalink structure is "/archive/%post_id%" then the front
     * is "/archive/". If the permalink structure is "/%year%/%postname%/"
     * then the front is "/".
     *
     * @since 3.10.0
     * @access public
     * @var string
     *
     * @see RC_Rewrite::init()
     */
    public $front;

	/**
	 * The prefix for all permalink structures.
	 *
	 * If PATHINFO/index permalinks are in use then the root is the value of
	 * `RC_Rewrite::$index` with a trailing slash appended. Otherwise the root
	 * will be empty.
	 *
	 * @since 3.10.0
	 * @access public
	 * @var string
	 *
	 * @see RC_Rewrite::init()
	 * @see RC_Rewrite::using_index_permalinks()
	 */
	public $root = '';

	/**
	 * The name of the index file which is the entry point to all requests.
	 *
	 * @since 3.10.0
	 * @access public
	 * @var string
	 */
	public $index = 'index.php';

	/**
	 * Variable name to use for regex matches in the rewritten query.
	 *
	 * @since 3.10.0
	 * @access private
	 * @var string
	 */
	var $matches = '';

	/**
	 * Rewrite rules to match against the request to find the redirect or query.
	 *
	 * @since 3.10.0
	 * @access private
	 * @var array
	 */
	var $rules;

	/**
	 * Additional rules added external to the rewrite class.
	 *
	 * Those not generated by the class, see add_rewrite_rule().
	 *
	 * @since 3.10.0
	 * @access private
	 * @var array
	 */
	var $extra_rules = array();

	/**
	 * Additional rules that belong at the beginning to match first.
	 *
	 * Those not generated by the class, see add_rewrite_rule().
	 *
	 * @since 3.10.0
	 * @access private
	 * @var array
	 */
	var $extra_rules_top = array();

	/**
	 * Rules that don't redirect to Royalcms' index.php.
	 *
	 * These rules are written to the mod_rewrite portion of the .htaccess,
	 * and are added by add_external_rule().
	 *
	 * @since 3.10.0
	 * @access private
	 * @var array
	 */
	var $non_rc_rules = array();

	/**
	 * Extra permalink structures, e.g. categories, added by add_permastruct().
	 *
	 * @since 3.10.0
	 * @access private
	 * @var array
	 */
	var $extra_permastructs = array();

	/**
	 * Endpoints (like /trackback/) added by add_rewrite_endpoint().
	 *
	 * @since 3.10.0
	 * @access private
	 * @var array
	 */
	var $endpoints;

	/**
	 * Whether to write every mod_rewrite rule for Royalcms into the .htaccess file.
	 *
	 * This is off by default, turning it on might print a lot of rewrite rules
	 * to the .htaccess file.
	 *
	 * @since 3.10.0
	 * @access public
	 * @var bool
	 *
	 * @see RC_Rewrite::mod_rewrite_rules()
	 */
	public $use_verbose_rules = false;

	/**
	 * Query variables that rewrite tags map to, see RC_Rewrite::$rewritecode.
	 *
	 * @since 3.10.0
	 * @access private
	 * @var array
	 */
	var $queryreplace = array();
	
	/**
	 * Rewrite tags that can be used in permalink structures.
	 *
	 * These are translated into the regular expressions stored in
	 * `RC_Rewrite::$rewritereplace` and are rewritten to the query
	 * variables listed in RC_Rewrite::$queryreplace.
	 *
	 * Additional tags can be added with add_rewrite_tag().
	 *
	 * @since 3.10.0
	 * @access private
	 * @var array
	*/
	var $rewritecode = array();
	
	/**
	 * Regular expressions to be substituted into rewrite rules in place
	 * of rewrite tags, see RC_Rewrite::$rewritecode.
	 *
	 * @since 3.10.0
	 * @access private
	 * @var array
	*/
	var $rewritereplace = array();

	/**
	 * Constructor - Calls init(), which runs setup.
	 *
	 * @since 3.10.0
	 * @access public
	 *
	 */
	public function __construct() {
	    $this->init();
	}
	
	/**
	 * Sets up the object's properties.
	 *
	 * @since 3.10.0
	 * @access public
	 */
	public function init() {
	    $this->extra_rules = $this->non_wp_rules = $this->endpoints = array();
	    $this->front = substr($this->permalink_structure, 0, strpos($this->permalink_structure, '%'));
	    $this->root = '';
	    
	    if ( $this->using_index_permalinks() )
	        $this->root = $this->index . '/';
	    
	    $this->use_trailing_slashes = ( '/' == substr($this->permalink_structure, -1, 1) );
	}
	
	/**
	 * Sets the main permalink structure for the site.
	 *
	 * Will update the 'permalink_structure' option, if there is a difference
	 * between the current permalink structure and the parameter value. Calls
	 * RC_Rewrite::init() after the option is updated.
	 *
	 * Fires the 'permalink_structure_changed' action once the init call has
	 * processed passing the old and new values
	 *
	 * @since 3.10.0
	 * @access public
	 *
	 * @param string $permalink_structure Permalink structure.
	 */
	public function set_permalink_structure($permalink_structure) {
	    if ( $permalink_structure != $this->permalink_structure ) {
	        $old_permalink_structure = $this->permalink_structure;
	        $this->permalink_structure = $permalink_structure;
	        $this->init();
	
	        /**
	         * Fires after the permalink structure is updated.
	         *
	         * @since 3.10.0
	         *
	         * @param string $old_permalink_structure The previous permalink structure.
	         * @param string $permalink_structure     The new permalink structure.
	        */
	        \RC_Hook::do_action( 'permalink_structure_changed', $old_permalink_structure, $permalink_structure );
	    }
	}
	
	/**
	 * Determines whether permalinks are being used.
	 *
	 * This can be either rewrite module or permalink in the HTTP query string.
	 *
	 * @since 3.10.0
	 * @access public
	 *
	 * @return bool True, if permalinks are enabled.
	 */
	public function using_permalinks() {
	    return ! empty($this->permalink_structure);
	}
	
	/**
	 * Determines whether permalinks are being used and rewrite module is not enabled.
	 *
	 * Means that permalink links are enabled and index.php is in the URL.
	 *
	 * @since 3.10.0
	 * @access public
	 *
	 * @return bool Whether permalink links are enabled and index.php is in the URL.
	 */
	public function using_index_permalinks() {
	    if ( empty( $this->permalink_structure ) ) {
	        return false;
	    }
	
	    // If the index is not in the permalink, we're using mod_rewrite.
	    return preg_match( '#^/*' . $this->index . '#', $this->permalink_structure );
	}
	
	/**
	 * Determines whether permalinks are being used and rewrite module is enabled.
	 *
	 * Using permalinks and index.php is not in the URL.
	 *
	 * @since 3.10.0
	 * @access public
	 *
	 * @return bool Whether permalink links are enabled and index.php is NOT in the URL.
	 */
	public function using_mod_rewrite_permalinks() {
	    return $this->using_permalinks() && ! $this->using_index_permalinks();
	}


	/**
	 * Indexes for matches for usage in preg_*() functions.
	 *
	 * The format of the string is, with empty matches property value, '$NUM'.
	 * The 'NUM' will be replaced with the value in the $number parameter. With
	 * the matches property not empty, the value of the returned string will
	 * contain that value of the matches property. The format then will be
	 * '$MATCHES[NUM]', with MATCHES as the value in the property and NUM the
	 * value of the $number parameter.
	 *
	 * @since 3.10.0
	 * @access public
	 *
	 * @param int $number Index number.
	 * @return string
	 */
	public function preg_index($number) {
		$match_prefix = '$';
		$match_suffix = '';

		if ( ! empty($this->matches) ) {
			$match_prefix = '$' . $this->matches . '[';
			$match_suffix = ']';
		}

		return "$match_prefix$number$match_suffix";
	}
	

	/**
	 * Adds or updates existing rewrite tags (e.g. %postname%).
	 *
	 * If the tag already exists, replace the existing pattern and query for
	 * that tag, otherwise add the new tag.
	 *
	 * @since 3.10.0
	 * @access public
	 *
	 * @see RC_Rewrite::$rewritecode
	 * @see RC_Rewrite::$rewritereplace
	 * @see RC_Rewrite::$queryreplace
	 *
	 * @param string $tag   Name of the rewrite tag to add or update.
	 * @param string $regex Regular expression to substitute the tag for in rewrite rules.
	 * @param string $query String to append to the rewritten query. Must end in '='.
	 */
	public function add_rewrite_tag( $tag, $regex, $query ) {
		$position = array_search( $tag, $this->rewritecode );
		if ( false !== $position && null !== $position ) {
			$this->rewritereplace[ $position ] = $regex;
			$this->queryreplace[ $position ] = $query;
		} else {
			$this->rewritecode[] = $tag;
			$this->rewritereplace[] = $regex;
			$this->queryreplace[] = $query;
		}
	}

	/**
	 * Generates rewrite rules from a permalink structure.
	 *
	 * The main RC_Rewrite function for building the rewrite rule list. The
	 * contents of the function is a mix of black magic and regular expressions,
	 * so best just ignore the contents and move to the parameters.
	 *
	 * @since 3.10.0
	 * @access public
	 *
	 * @param string $permalink_structure The permalink structure.
	 * @param int    $ep_mask             Optional. Endpoint mask defining what endpoints are added to the structure.
	 *                                    Accepts `EP_NONE`, `EP_PERMALINK`, `EP_ATTACHMENT`, `EP_DATE`, `EP_YEAR`,
	 *                                    `EP_MONTH`, `EP_DAY`, `EP_ROOT`, `EP_COMMENTS`, `EP_SEARCH`, `EP_CATEGORIES`,
	 *                                    `EP_TAGS`, `EP_AUTHORS`, `EP_PAGES`, `EP_ALL_ARCHIVES`, and `EP_ALL`.
	 *                                    Default `EP_NONE`.
	 * @param bool   $paged               Optional. Whether archive pagination rules should be added for the structure.
	 *                                    Default true.
	 * @param bool   $feed                Optional Whether feed rewrite rules should be added for the structure.
	 *                                    Default true.
	 * @param bool   $forcomments         Optional. Whether the feed rules should be a query for a comments feed.
	 *                                    Default false.
	 * @param bool   $walk_dirs           Optional. Whether the 'directories' making up the structure should be walked
	 *                                    over and rewrite rules built for each in-turn. Default true.
	 * @param bool   $endpoints           Optional. Whether endpoints should be applied to the generated rewrite rules.
	 *                                    Default true.
	 * @return array Rewrite rule list.
	 */
<<<<<<< HEAD
	public function generate_rewrite_rules($permalink_structure, $ep_mask = EP_NONE, $walk_dirs = true, $endpoints = true) {
=======
	public function generate_rewrite_rules($permalink_structure, $ep_mask = EndpointMaskEnum::EP_NONE, $walk_dirs = true, $endpoints = true) {
>>>>>>> v2-test
		// Build up an array of endpoint regexes to append => queries to append.
		if ( $endpoints ) {
			$ep_query_append = array ();
			foreach ( (array) $this->endpoints as $endpoint) {
				// Match everything after the endpoint name, but allow for nothing to appear there.
				$epmatch = $endpoint[1] . '(/(.*))?/?$';

				// This will be appended on to the rest of the query for each dir.
				$epquery = '&' . $endpoint[2] . '=';
				$ep_query_append[$epmatch] = array ( $endpoint[0], $epquery );
			}
		}

		// Get everything up to the first rewrite tag.
		$front = substr($permalink_structure, 0, strpos($permalink_structure, '%'));

		// Build an array of the tags (note that said array ends up being in $tokens[0]).
		preg_match_all('/%.+?%/', $permalink_structure, $tokens);

		$num_tokens = count($tokens[0]);

		$index = $this->index; //probably 'index.php'

		/*
		 * Build a list from the rewritecode and queryreplace arrays, that will look something
		 * like tagname=$matches[i] where i is the current $i.
		 */
		$queries = array();
		for ( $i = 0; $i < $num_tokens; ++$i ) {
			if ( 0 < $i )
				$queries[$i] = $queries[$i - 1] . '&';
			else
				$queries[$i] = '';

			$query_token = str_replace($this->rewritecode, $this->queryreplace, $tokens[0][$i]) . $this->preg_index($i+1);
			$queries[$i] .= $query_token;
		}

		// Get the structure, minus any cruft (stuff that isn't tags) at the front.
		$structure = $permalink_structure;
		if ( $front != '/' )
			$structure = str_replace($front, '', $structure);

		/*
		 * Create a list of dirs to walk over, making rewrite rules for each level
		 * so for example, a $structure of /%year%/%monthnum%/%postname% would create
		 * rewrite rules for /%year%/, /%year%/%monthnum%/ and /%year%/%monthnum%/%postname%
		 */
		$structure = trim($structure, '/');
		$dirs = $walk_dirs ? explode('/', $structure) : array( $structure );
		$num_dirs = count($dirs);

		// Strip slashes from the front of $front.
		$front = preg_replace('|^/+|', '', $front);

		// The main workhorse loop.
		$struct = $front;
		for ( $j = 0; $j < $num_dirs; ++$j ) {
			// Get the struct for this dir, and trim slashes off the front.
			$struct .= $dirs[$j] . '/'; // Accumulate. see comment near explode('/', $structure) above.
			$struct = ltrim($struct, '/');

			// Replace tags with regexes.
			$match = str_replace($this->rewritecode, $this->rewritereplace, $struct);

			// Make a list of tags, and store how many there are in $num_toks.
			$num_toks = preg_match_all('/%.+?%/', $struct, $toks);

			// Get the 'tagname=$matches[i]'.
			$query = ( ! empty( $num_toks ) && isset( $queries[$num_toks - 1] ) ) ? $queries[$num_toks - 1] : '';

			// Set up $ep_mask_specific which is used to match more specific URL types.
<<<<<<< HEAD
			$ep_mask_specific = EP_NONE;
=======
			$ep_mask_specific = EndpointMaskEnum::EP_NONE;
>>>>>>> v2-test

			// Start creating the array of rewrites for this dir.
			$rewrite = array();

			// Do endpoints.
			if ( $endpoints ) {
				foreach ( (array) $ep_query_append as $regex => $ep) {
					// Add the endpoints on if the mask fits.
					if ( $ep[0] & $ep_mask || $ep[0] & $ep_mask_specific )
						$rewrite[$match . $regex] = $index . '?' . $query . $ep[1] . $this->preg_index($num_toks + 2);
				}
			}

			// If we've got some tags in this dir.
			if ( $num_toks ) {

				// Close the match and finalise the query.
				$match .= '?$';
				$query = $index . '?' . $query;

				/*
				 * Create the final array for this dir by joining the $rewrite array (which currently
				 * only contains rules/queries for trackback, pages etc) to the main regex/query for
				 * this dir
				 */
				$rewrite = array_merge($rewrite, array($match => $query));

			}
		}

		// The finished rules. phew!
		return $rewrite;
	}

	/**
	 * Generates rewrite rules with permalink structure and walking directory only.
	 *
	 * Shorten version of RC_Rewrite::generate_rewrite_rules() that allows for shorter
	 * list of parameters. See the method for longer description of what generating
	 * rewrite rules does.
	 *
	 * @since 3.10.0
	 * @access public
	 *
	 * @see RC_Rewrite::generate_rewrite_rules() See for long description and rest of parameters.
	 *
	 * @param string $permalink_structure The permalink structure to generate rules.
	 * @param bool   $walk_dirs           Optional, default is false. Whether to create list of directories to walk over.
	 * @return array
	 */
	public function generate_rewrite_rule($permalink_structure, $walk_dirs = false) {
<<<<<<< HEAD
		return $this->generate_rewrite_rules($permalink_structure, EP_NONE, false, false, false, $walk_dirs);
=======
		return $this->generate_rewrite_rules($permalink_structure, EndpointMaskEnum::EP_NONE, false, false, false, $walk_dirs);
>>>>>>> v2-test
	}

	/**
	 * Constructs rewrite matches and queries from permalink structure.
	 *
	 * Runs the action 'generate_rewrite_rules' with the parameter that is an
	 * reference to the current RC_Rewrite instance to further manipulate the
	 * permalink structures and rewrite rules. Runs the 'rewrite_rules_array'
	 * filter on the full rewrite rule array.
	 *
	 * There are two ways to manipulate the rewrite rules, one by hooking into
	 * the 'generate_rewrite_rules' action and gaining full control of the
	 * object or just manipulating the rewrite rule array before it is passed
	 * from the function.
	 *
	 * @since 3.10.0
	 * @access public
	 *
	 * @return array An associate array of matches and queries.
	 */
	public function rewrite_rules() {
		$rewrite = array();

		if ( empty($this->permalink_structure) )
			return $rewrite;

		// robots.txt -only if installed at the root
		$home_path = parse_url( \RC_Uri::home_url() );
		$robots_rewrite = ( empty( $home_path['path'] ) || '/' == $home_path['path'] ) ? array( 'robots\.txt$' => $this->index . '?robots=1' ) : array();

		// Old feed and service files.
		$deprecated_files = array(
// 			'.*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\.php$' => $this->index . '?feed=old',
// 			'.*wp-app\.php(/.*)?$' => $this->index . '?error=403',
		);

		// Root-level rewrite rules.
<<<<<<< HEAD
		$root_rewrite = $this->generate_rewrite_rules($this->root . '/', EP_ROOT);
=======
		$root_rewrite = $this->generate_rewrite_rules($this->root . '/', EndpointMaskEnum::EP_ROOT);
>>>>>>> v2-test

		/**
		 * Filter rewrite rules used for root-level archives.
		 *
		 * Likely root-level archives would include pagination rules for the homepage
		 * as well as site-wide post feeds (e.g. /feed/, and /feed/atom/).
		 *
		 * @since 3.10.0
		 *
		 * @param array $root_rewrite The root-level rewrite rules.
		 */
		$root_rewrite = \RC_Hook::apply_filters( 'root_rewrite_rules', $root_rewrite );

		// Extra permastructs.
		foreach ( $this->extra_permastructs as $permastructname => $struct ) {
			if ( is_array( $struct ) ) {
				if ( count( $struct ) == 2 )
					$rules = $this->generate_rewrite_rules( $struct[0], $struct[1] );
				else
					$rules = $this->generate_rewrite_rules( $struct['struct'], $struct['ep_mask'], $struct['paged'], $struct['feed'], $struct['forcomments'], $struct['walk_dirs'], $struct['endpoints'] );
			} else {
				$rules = $this->generate_rewrite_rules( $struct );
			}

			/**
			 * Filter rewrite rules used for individual permastructs.
			 *
			 * The dynamic portion of the hook name, `$permastructname`, refers
			 * to the name of the registered permastruct, e.g. 'post_tag' (tags),
			 * 'category' (categories), etc.
			 *
			 * @since 3.10.0
			 *
			 * @param array $rules The rewrite rules generated for the current permastruct.
			 */
			$rules = \RC_Hook::apply_filters( $permastructname . '_rewrite_rules', $rules );

			$this->extra_rules_top = array_merge($this->extra_rules_top, $rules);
		}
		    
		$this->rules = array_merge($this->extra_rules_top, $robots_rewrite, $deprecated_files, $root_rewrite, $this->extra_rules);
        
		/**
		 * Fires after the rewrite rules are generated.
		 *
		 * @since 3.10.0
		 *
		 * @param RC_Rewrite $this Current RC_Rewrite instance, passed by reference.
		 */
		\RC_Hook::do_action_ref_array( 'generate_rewrite_rules', array( &$this ) );

		/**
		 * Filter the full set of generated rewrite rules.
		 *
		 * @since 3.10.0
		 *
		 * @param array $this->rules The compiled array of rewrite rules.
		 */
		$this->rules = \RC_Hook::apply_filters( 'rewrite_rules_array', $this->rules );

		return $this->rules;
	}

	/**
	 * Retrieves the rewrite rules.
	 *
	 * The difference between this method and RC_Rewrite::rewrite_rules() is that
	 * this method stores the rewrite rules in the 'rewrite_rules' option and retrieves
	 * it. This prevents having to process all of the permalinks to get the rewrite rules
	 * in the form of caching.
	 *
	 * @since 3.10.0
	 * @access public
	 *
	 * @return array Rewrite rules.
	 */
	public function rc_rewrite_rules() {
		$this->rules = \RC_Variable::get('rewrite_rules');
		if ( empty($this->rules) ) {
			$this->matches = 'matches';
			$this->rewrite_rules();
			\RC_Variable::set('rewrite_rules', $this->rules);
		}

		return $this->rules;
	}

	/**
	 * Retrieves mod_rewrite-formatted rewrite rules to write to .htaccess.
	 *
	 * Does not actually write to the .htaccess file, but creates the rules for
	 * the process that will.
	 *
	 * Will add the non_wp_rules property rules to the .htaccess file before
	 * the Royalcms rewrite rules one.
	 *
	 * @since 3.10.0
	 * @access public
	 *
	 * @return string
	 */
	public function mod_rewrite_rules() {
		if ( ! $this->using_permalinks() )
			return '';

		$site_root = parse_url( \RC_Uri::site_url() );
		if ( isset( $site_root['path'] ) )
			$site_root = \RC_Format::trailingslashit($site_root['path']);

		$home_root = parse_url(\RC_Uri::home_url());
		if ( isset( $home_root['path'] ) )
			$home_root = \RC_Format::trailingslashit($home_root['path']);
		else
			$home_root = '/';

		$rules = "<IfModule mod_rewrite.c>\n";
		$rules .= "RewriteEngine On\n";
		$rules .= "RewriteBase $home_root\n";

		// Prevent -f checks on index.php.
		$rules .= "RewriteRule ^index\\.php$ - [L]\n";

		// Add in the rules that don't redirect to WP's index.php (and thus shouldn't be handled by WP at all).
		foreach ( (array) $this->non_rc_rules as $match => $query) {
			// Apache 1.3 does not support the reluctant (non-greedy) modifier.
			$match = str_replace('.+?', '.+', $match);

			$rules .= 'RewriteRule ^' . $match . ' ' . $home_root . $query . " [QSA,L]\n";
		}

		if ( $this->use_verbose_rules ) {
			$this->matches = '';
			$rewrite = $this->rewrite_rules();
			$num_rules = count($rewrite);
			$rules .= "RewriteCond %{REQUEST_FILENAME} -f [OR]\n" .
				"RewriteCond %{REQUEST_FILENAME} -d\n" .
				"RewriteRule ^.*$ - [S=$num_rules]\n";

			foreach ( (array) $rewrite as $match => $query) {
				// Apache 1.3 does not support the reluctant (non-greedy) modifier.
				$match = str_replace('.+?', '.+', $match);

				if ( strpos($query, $this->index) !== false )
					$rules .= 'RewriteRule ^' . $match . ' ' . $home_root . $query . " [QSA,L]\n";
				else
					$rules .= 'RewriteRule ^' . $match . ' ' . $site_root . $query . " [QSA,L]\n";
			}
		} else {
			$rules .= "RewriteCond %{REQUEST_FILENAME} !-f\n" .
				"RewriteCond %{REQUEST_FILENAME} !-d\n" .
				"RewriteRule . {$home_root}{$this->index} [L]\n";
		}

		$rules .= "</IfModule>\n";

		/**
		 * Filter the list of rewrite rules formatted for output to an .htaccess file.
		 *
		 * @since 3.10.0
		 *
		 * @param string $rules mod_rewrite Rewrite rules formatted for .htaccess.
		 */
		$rules = \RC_Hook::apply_filters( 'mod_rewrite_rules', $rules );

		/**
		 * Filter the list of rewrite rules formatted for output to an .htaccess file.
		 *
		 * @since 3.10.0
		 * @deprecated 1.5.0 Use the mod_rewrite_rules filter instead.
		 *
		 * @param string $rules mod_rewrite Rewrite rules formatted for .htaccess.
		 */
		return \RC_Hook::apply_filters( 'rewrite_rules', $rules );
	}

	/**
	 * Retrieves IIS7 URL Rewrite formatted rewrite rules to write to web.config file.
	 *
	 * Does not actually write to the web.config file, but creates the rules for
	 * the process that will.
	 *
	 * @since 3.10.0
	 * @access public
	 *
	 * @return string
	 */
	public function iis7_url_rewrite_rules( $add_parent_tags = false ) {
		if ( ! $this->using_permalinks() )
			return '';
		
		$rules = '';
		if ( $add_parent_tags ) {
			$rules .= '<configuration>
	<system.webServer>
		<rewrite>
			<rules>';
		}

		$rules .= '
			<rule name="Royalcms" patternSyntax="Wildcard">
				<match url="*" />
					<conditions>
						<add input="{REQUEST_FILENAME}" matchType="IsFile" negate="true" />
						<add input="{REQUEST_FILENAME}" matchType="IsDirectory" negate="true" />
					</conditions>
				<action type="Rewrite" url="index.php" />
			</rule>';

		if ( $add_parent_tags ) {
			$rules .= '
			</rules>
		</rewrite>
	</system.webServer>
</configuration>';
		}

		/**
		 * Filter the list of rewrite rules formatted for output to a web.config.
		 *
		 * @since 2.8.0
		 *
		 * @param string $rules Rewrite rules formatted for IIS web.config.
		 */
		return \RC_Hook::apply_filters( 'iis7_url_rewrite_rules', $rules );
	}

	/**
	 * Adds a rewrite rule that transforms a URL structure to a set of query vars.
	 *
	 * Any value in the $after parameter that isn't 'bottom' will result in the rule
	 * being placed at the top of the rewrite rules.
	 *
	 * @since 3.10.0 Array support was added to the `$query` parameter.
	 * @access public
	 *
	 * @param string       $regex Regular expression to match request against.
	 * @param string|array $query The corresponding query vars for this rewrite rule.
	 * @param string       $after Optional. Priority of the new rule. Accepts 'top'
	 *                            or 'bottom'. Default 'bottom'.
	 */
	public function add_rule( $regex, $query, $after = 'bottom' ) {
		if ( is_array( $query ) ) {
			$external = false;
			$query = \RC_Uri::add_query_arg( $query, 'index.php' );
		} else {
			$index = false === strpos( $query, '?' ) ? strlen( $query ) : strpos( $query, '?' );
			$front = substr( $query, 0, $index );

			$external = $front != $this->index;
		}

		// "external" = it doesn't correspond to index.php.
		if ( $external ) {
			$this->add_external_rule( $regex, $query );
		} else {
			if ( 'bottom' == $after ) {
				$this->extra_rules = array_merge( $this->extra_rules, array( $regex => $query ) );
			} else {
				$this->extra_rules_top = array_merge( $this->extra_rules_top, array( $regex => $query ) );
			}
		}
	}

	/**
	 * Adds a rewrite rule that doesn't correspond to index.php.
	 *
	 * @since 3.10.0
	 * @access public
	 *
	 * @param string $regex Regular expression to match request against.
	 * @param string $query The corresponding query vars for this rewrite rule.
	 */
	public function add_external_rule( $regex, $query ) {
		$this->non_rc_rules[ $regex ] = $query;
	}

	/**
	 * Adds an endpoint, like /trackback/.
	 *
	 * @since 3.10.0 $query_var parameter added.
	 * @since 3.10.0 Added support for skipping query var registration by passing `false` to `$query_var`.
	 * @access public
	 *
	 * @see add_rewrite_endpoint() for full documentation.
	 * @global WP $wp
	 *
	 * @param string      $name      Name of the endpoint.
	 * @param int         $places    Endpoint mask describing the places the endpoint should be added.
	 * @param string|bool $query_var Optional. Name of the corresponding query variable. Pass `false` to
	 *                               skip registering a query_var for this endpoint. Defaults to the
	 *                               value of `$name`.
	 */
	public function add_endpoint( $name, $places, $query_var = true ) {
		global $wp;

		// For backward compatibility, if null has explicitly been passed as `$query_var`, assume `true`.
		if ( true === $query_var || null === func_get_arg( 2 ) ) {
			$query_var = $name;
		}
		$this->endpoints[] = array( $places, $name, $query_var );

		if ( $query_var ) {
			$wp->add_query_var( $query_var );
		}
	}

	/**
	 * Adds a new permalink structure.
	 *
	 * A permalink structure (permastruct) is an abstract definition of a set of rewrite rules;
	 * it is an easy way of expressing a set of regular expressions that rewrite to a set of
	 * query strings. The new permastruct is added to the RC_Rewrite::$extra_permastructs array.
	 *
	 * When the rewrite rules are built by RC_Rewrite::rewrite_rules(), all of these extra
	 * permastructs are passed to RC_Rewrite::generate_rewrite_rules() which transforms them
	 * into the regular expressions that many love to hate.
	 *
	 * The `$args` parameter gives you control over how RC_Rewrite::generate_rewrite_rules()
	 * works on the new permastruct.
	 *
	 * @since 3.10.0
	 * @access public
	 *
	 * @param string $name   Name for permalink structure.
	 * @param string $struct Permalink structure (e.g. category/%category%)
	 * @param array  $args   {
	 *     Optional. Arguments for building rewrite rules based on the permalink structure.
	 *     Default empty array.
	 *
	 *     @type bool $with_front  Whether the structure should be prepended with `RC_Rewrite::$front`.
	 *                             Default true.
	 *     @type int  $ep_mask     The endpoint mask defining which endpoints are added to the structure.
	 *                             Accepts `EP_NONE`, `EP_PERMALINK`, `EP_ATTACHMENT`, `EP_DATE`, `EP_YEAR`,
	 *                             `EP_MONTH`, `EP_DAY`, `EP_ROOT`, `EP_COMMENTS`, `EP_SEARCH`, `EP_CATEGORIES`,
	 *                             `EP_TAGS`, `EP_AUTHORS`, `EP_PAGES`, `EP_ALL_ARCHIVES`, and `EP_ALL`.
	 *                             Default `EP_NONE`.
	 *     @type bool $paged       Whether archive pagination rules should be added for the structure.
	 *                             Default true.
	 *     @type bool $feed        Whether feed rewrite rules should be added for the structure. Default true.
	 *     @type bool $forcomments Whether the feed rules should be a query for a comments feed. Default false.
	 *     @type bool $walk_dirs   Whether the 'directories' making up the structure should be walked over
	 *                             and rewrite rules built for each in-turn. Default true.
	 *     @type bool $endpoints   Whether endpoints should be applied to the generated rules. Default true.
	 * }
	 */
	public function add_permastruct( $name, $struct, $args = array() ) {
		// Backwards compatibility for the old parameters: $with_front and $ep_mask.
		if ( ! is_array( $args ) )
			$args = array( 'with_front' => $args );
		if ( func_num_args() == 4 )
			$args['ep_mask'] = func_get_arg( 3 );

		$defaults = array(
			'with_front' => true,
<<<<<<< HEAD
			'ep_mask' => EP_NONE,
=======
			'ep_mask' => EndpointMaskEnum::EP_NONE,
>>>>>>> v2-test
			'paged' => true,
			'feed' => true,
			'forcomments' => false,
			'walk_dirs' => true,
			'endpoints' => true,
		);
		$args = array_intersect_key( $args, $defaults );
		$args = rc_parse_args( $args, $defaults );

		if ( $args['with_front'] )
			$struct = $this->front . $struct;
		else
			$struct = $this->root . $struct;
		$args['struct'] = $struct;

		$this->extra_permastructs[ $name ] = $args;
	}

	/**
	 * Removes rewrite rules and then recreate rewrite rules.
	 *
	 * Calls RC_Rewrite::RC_Rewrite_rules() after removing the 'rewrite_rules' option.
	 * If the function named 'save_mod_rewrite_rules' exists, it will be called.
	 *
	 * @since 3.10.0
	 * @access public
	 *
	 * @staticvar bool $do_hard_later
	 *
	 * @param bool $hard Whether to update .htaccess (hard flush) or just update rewrite_rules option (soft flush). Default is true (hard).
	 */
	public function flush_rules( $hard = true ) {
		static $do_hard_later = null;

		// Prevent this action from running before everyone has registered their rewrites.
		if ( ! \RC_Hook::did_action( 'rc_loaded' ) ) {
			\RC_Hook::add_action( 'rc_loaded', array( $this, 'flush_rules' ) );
			$do_hard_later = ( isset( $do_hard_later ) ) ? $do_hard_later || $hard : $hard;
			return;
		}

		if ( isset( $do_hard_later ) ) {
			$hard = $do_hard_later;
			unset( $do_hard_later );
		}

		\RC_Variable::delete('rewrite_rules');
		$this->rc_rewrite_rules();

		/**
		 * Filter whether a "hard" rewrite rule flush should be performed when requested.
		 *
		 * A "hard" flush updates .htaccess (Apache) or web.config (IIS).
		 *
		 * @since 3.10.0
		 *
		 * @param bool $hard Whether to flush rewrite rules "hard". Default true.
		 */
		if ( ! $hard || ! \RC_Hook::apply_filters( 'flush_rewrite_rules_hard', true ) ) {
			return;
		}
		if ( function_exists( 'save_mod_rewrite_rules' ) )
			save_mod_rewrite_rules();
		if ( function_exists( 'iis7_save_url_rewrite_rules' ) )
			iis7_save_url_rewrite_rules();
	}


	
}
