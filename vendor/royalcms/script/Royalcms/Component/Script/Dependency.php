<?php namespace Royalcms\Component\Script;
/**
 * Class Dependency
 *
 * Helper class to register a handle and associated data.
 *
 * @access private
 * @since 2.6.0
 */
class Dependency
{

    /**
     * The handle name.
     *
     * @access public
     * @since 2.6.0
     * @var null
     */
    var $handle;

    /**
     * The handle source.
     *
     * @access public
     * @since 2.6.0
     * @var null
     */
    var $src;

    /**
     * An array of handle dependencies.
     *
     * @access public
     * @since 2.6.0
     * @var array
     */
    var $deps = array();

    /**
     * The handle version.
     *
     * Used for cache-busting.
     *
     * @access public
     * @since 2.6.0
     * @var bool string
    */
    var $ver = false;

    /**
     * Additional arguments for the handle.
     *
     * @access public
     * @since 2.6.0
     * @var null
     */
    var $args = null; // Custom property, such as $in_footer or $media.

    /**
     * Extra data to supply to the handle.
     *
     * @access public
     * @since 2.6.0
     * @var array
     */
    var $extra = array();

    /**
     * Setup dependencies.
     *
     * @since 2.6.0
    */
    function __construct()
    {
        @list ($this->handle, $this->src, $this->deps, $this->ver, $this->args) = func_get_args();
        if (! is_array($this->deps))
            $this->deps = array();
    }

    /**
     * Add handle data.
     *
     * @access public
     * @since 2.6.0
     *
     * @param string $name
     *            The data key to add.
     * @param mixed $data
     *            The data value to add.
     * @return bool False if not scalar, true otherwise.
     */
    function add_data($name, $data)
    {
        if (! is_scalar($name))
            return false;
        $this->extra[$name] = $data;
        return true;
    }
}

// end