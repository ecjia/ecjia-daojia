<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/7/16
 * Time: 10:19 AM
 */

class RC_Hook extends Royalcms\Component\Hook\Facades\Hook
{


    /**
     * FILTERS
     */

    /**
     * add_filter Hooks a function or method to a specific filter action.
     *
     * @access public
     * @since 0.1
     * @see \Royalcms\Component\Hook\Hooks::add_filter()
     * @param string $tag
     *            The name of the filter to hook the $function_to_add to.
     * @param callback $function_to_add
     *            The name of the function to be called when the filter is applied.
     * @param int $priority
     *            optional. Used to specify the order in which the functions associated with a particular action are executed (default: 10). Lower numbers correspond with earlier execution, and functions with the same priority are executed in the order in which they were added to the action.
     * @param int $accepted_args
     *            optional. The number of arguments the function accept (default 1).
     * @return boolean true
     */
    public static function add_filter($tag, $function_to_add, $priority = 10, $accepted_args = 1) {}


    /**
     * remove_filter Removes a function from a specified filter hook.
     *
     * @access public
     * @since 0.1
     * @see \Royalcms\Component\Hook\Hooks::remove_filter()
     * @param string $tag
     *            The filter hook to which the function to be removed is hooked.
     * @param callback $function_to_remove
     *            The name of the function which should be removed.
     * @param int $priority
     *            optional. The priority of the function (default: 10).
     * @param int $accepted_args
     *            optional. The number of arguments the function accepts (default: 1).
     * @return boolean Whether the function existed before it was removed.
     */
    public static function remove_filter($tag, $function_to_remove, $priority = 10) {}


    /**
     * remove_all_filters Remove all of the hooks from a filter.
     *
     * @access public
     * @since 0.1
     * @see \Royalcms\Component\Hook\Hooks::remove_all_filters()
     * @param string $tag
     *            The filter to remove hooks from.
     * @param int $priority
     *            The priority number to remove.
     * @return bool True when finished.
     */
    public static function remove_all_filters($tag, $priority = false) {}


    /**
     * has_filter Check if any filter has been registered for a hook.
     *
     * @access public
     * @since 0.1
     * @see \Royalcms\Component\Hook\Hooks::has_filter()
     * @param string $tag
     *            The name of the filter hook.
     * @param callback $function_to_check
     *            optional.
     * @return mixed If $function_to_check is omitted, returns boolean for whether the hook has anything registered.
     *         When checking a specific function, the priority of that hook is returned, or false if the function is not attached.
     *         When using the $function_to_check argument, this function may return a non-boolean value that evaluates to false
     *         (e.g.) 0, so use the === operator for testing the return value.
     */
    public static function has_filter($tag, $function_to_check = false) {}


    /**
     * apply_filters Call the functions added to a filter hook.
     *
     * @access public
     * @since 0.1
     * @see \Royalcms\Component\Hook\Hooks::apply_filters()
     * @param string $tag
     *            The name of the filter hook.
     * @param mixed $value
     *            The value on which the filters hooked to <tt>$tag</tt> are applied on.
     * @param mixed $var,...
     *            Additional variables passed to the functions hooked to <tt>$tag</tt>.
     * @return mixed The filtered value after all hooked functions are applied to it.
     */
    public static function apply_filters($tag, $value, $var1 = null, $var2 = null, $var3 = null, $var4 = null, $var5 = null, $var6 = null, $var7 = null, $var8 = null) {}


    /**
     * apply_filters_ref_array Execute functions hooked on a specific filter hook, specifying arguments in an array.
     *
     * @access public
     * @since 0.1
     * @see \Royalcms\Component\Hook\Hooks::apply_filters_ref_array()
     * @param string $tag
     *            The name of the filter hook.
     * @param array $args
     *            The arguments supplied to the functions hooked to <tt>$tag</tt>
     * @return mixed The filtered value after all hooked functions are applied to it.
     */
    public static function apply_filters_ref_array($tag, $args) {}


    /**
     * ACTIONS
     */

    /**
     * add_action Hooks a function on to a specific action.
     *
     * @access public
     * @since 0.1
     * @see \Royalcms\Component\Hook\Hooks::add_action()
     * @param string $tag
     *            The name of the action to which the $function_to_add is hooked.
     * @param callback $function_to_add
     *            The name of the function you wish to be called.
     * @param int $priority
     *            optional. Used to specify the order in which the functions associated with a particular action are executed (default: 10). Lower numbers correspond with earlier execution, and functions with the same priority are executed in the order in which they were added to the action.
     * @param int $accepted_args
     *            optional. The number of arguments the function accept (default 1).
     */
    public static function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1) {}


    /**
     * has_action Check if any action has been registered for a hook.
     *
     * @access public
     * @since 0.1
     * @see \Royalcms\Component\Hook\Hooks::has_action()
     * @param string $tag
     *            The name of the action hook.
     * @param callback $function_to_check
     *            optional.
     * @return mixed If $function_to_check is omitted, returns boolean for whether the hook has anything registered.
     *         When checking a specific function, the priority of that hook is returned, or false if the function is not attached.
     *         When using the $function_to_check argument, this function may return a non-boolean value that evaluates to false
     *         (e.g.) 0, so use the === operator for testing the return value.
     */
    public static function has_action($tag, $function_to_check = false) {}


    /**
     * remove_action Removes a function from a specified action hook.
     *
     * @access public
     * @since 0.1
     * @see \Royalcms\Component\Hook\Hooks::remove_action()
     * @param string $tag
     *            The action hook to which the function to be removed is hooked.
     * @param callback $function_to_remove
     *            The name of the function which should be removed.
     * @param int $priority
     *            optional The priority of the function (default: 10).
     * @return boolean Whether the function is removed.
     */
    public static function remove_action($tag, $function_to_remove, $priority = 10) {}


    /**
     * remove_all_actions Remove all of the hooks from an action.
     *
     * @access public
     * @since 0.1
     * @see \Royalcms\Component\Hook\Hooks::remove_all_actions()
     * @param string $tag
     *            The action to remove hooks from.
     * @param int $priority
     *            The priority number to remove them from.
     * @return bool True when finished.
     */
    public static function remove_all_actions($tag, $priority = false) {}


    /**
     * do_action Execute functions hooked on a specific action hook.
     *
     * @access public
     * @since 0.1
     * @see \Royalcms\Component\Hook\Hooks::do_action()
     * @param string $tag
     *            The name of the action to be executed.
     * @param mixed $arg,...
     *            Optional additional arguments which are passed on to the functions hooked to the action.
     * @return null Will return null if $tag does not exist in $filter array
     */
    public static function do_action($tag, $arg = '', $arg2 = null, $arg3 = null) {}


    /**
     * do_action_ref_array Execute functions hooked on a specific action hook, specifying arguments in an array.
     *
     * @access public
     * @since 0.1
     * @see \Royalcms\Component\Hook\Hooks::do_action_ref_array()
     * @param string $tag
     *            The name of the action to be executed.
     * @param array $args
     *            The arguments supplied to the functions hooked to <tt>$tag</tt>
     * @return null Will return null if $tag does not exist in $filter array
     */
    public static function do_action_ref_array($tag, $args) {}


    /**
     * did_action Retrieve the number of times an action is fired.
     *
     * @access public
     * @since 0.1
     * @see \Royalcms\Component\Hook\Hooks::did_action()
     * @param string $tag
     *            The name of the action hook.
     * @return int The number of times action hook <tt>$tag</tt> is fired
     */
    public static function did_action($tag) {}


    /**
     * HELPERS
     */

    /**
     * current_filter Retrieve the name of the current filter or action.
     *
     * @access public
     * @since 0.1
     * @see \Royalcms\Component\Hook\Hooks::current_filter()
     * @return string Hook name of the current filter or action.
     */
    public static function current_filter() {}


    /**
     * Retrieve the name of the current action.
     *
     * @since 0.1.2
     * @see \Royalcms\Component\Hook\Hooks::current_action()
     * @uses current_filter()
     *
     * @return string Hook name of the current action.
     */
    public static function current_action() {}


    /**
     * Retrieve the name of a filter currently being processed.
     *
     * The function current_filter() only returns the most recent filter or action
     * being executed. did_action() returns true once the action is initially
     * processed. This function allows detection for any filter currently being
     * executed (despite not being the most recent filter to fire, in the case of
     * hooks called from hook callbacks) to be verified.
     *
     * @since 0.1.2
     * @see \Royalcms\Component\Hook\Hooks::doing_filter()
     * @see current_filter()
     * @see did_action()
     * @global array $wp_current_filter Current filter.
     *
     * @param null|string $filter
     *            Optional. Filter to check. Defaults to null, which
     *            checks if any filter is currently being run.
     * @return bool Whether the filter is currently in the stack
     */
    public static function doing_filter($filter = null) {}

    /**
     * Retrieve the name of an action currently being processed.
     *
     * @since 0.1.2
     * @see \Royalcms\Component\Hook\Hooks::doing_action()
     * @uses doing_filter()
     *
     * @param string|null $action
     *            Optional. Action to check. Defaults to null, which checks
     *            if any action is currently being run.
     * @return bool Whether the action is currently in the stack.
     */
    public static function doing_action($action = null) {}


}