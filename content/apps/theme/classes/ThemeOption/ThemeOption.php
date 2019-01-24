<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/20
 * Time: 18:23
 */

namespace Ecjia\App\Theme\ThemeOption;

use Ecjia\App\Theme\ThemeOption\Repositories\TemplateOptionsRepository;
use RC_Hook;
use RC_Format;

class ThemeOption
{
    /**
     * @var \Ecjia\App\Theme\ThemeOption\Repositories\TemplateOptionsRepository
     */
    protected $repository;

    const APPCACHE_KEY = 'theme-option';

    public function __construct($repository = null)
    {
        if (is_null($repository)) {
            $this->repository = new TemplateOptionsRepository();
        } else {
            $this->repository = $repository;
        }

    }


    /**
     * Loads and caches all autoloaded options, if available or all options.
     *
     * @since 2.2.0
     *
     * @return array List of all options.
     */
    public function load_alloptions()
    {
        $alloptions = ecjia_cache(self::APPCACHE_KEY)->get( 'alloptions' );

        if ( ! $alloptions ) {
            $alloptions_db = $this->repository->getAllOptions();

            $alloptions = array();
            foreach ( $alloptions_db as $o ) {
                $alloptions[$o->option_name] = $o->option_value;
            }

            /**
             * Filters all options before caching them.
             *
             * @since 4.9.0
             *
             * @param array $alloptions Array with all options.
             */
            $alloptions = RC_Hook::apply_filters( 'ecjia_theme_pre_cache_alloptions', $alloptions );
            ecjia_cache(self::APPCACHE_KEY)->add( 'alloptions', $alloptions );
        }

        /**
         * Filters all options after retrieving them.
         *
         * @since 4.9.0
         *
         * @param array $alloptions Array with all options.
         */
        return RC_Hook::apply_filters( 'ecjia_theme_alloptions', $alloptions );
    }

    /**
     * Sanitises various option values based on the nature of the option.
     *
     * This is basically a switch statement which will pass $value through a number
     * of functions depending on the $option.
     *
     * @since 2.0.5
     *
     * @param string $option The name of the option.
     * @param string $value  The unsanitised value.
     * @return string Sanitized value.
     */
    public function sanitize_option( $option, $value )
    {
        $original_value = $value;

        /**
         * Filters an option value following sanitization.
         *
         * @since 2.3.0
         * @since 4.3.0 Added the `$original_value` parameter.
         *
         * @param string $value          The sanitized option value.
         * @param string $option         The option name.
         * @param string $original_value The original value passed to the function.
         */
        return RC_Hook::apply_filters( "ecjia_theme_sanitize_option_{$option}", $value, $option, $original_value );
    }


    /**
     * Retrieves an option value based on an option name.
     *
     * If the option does not exist or does not have a value, then the return value
     * will be false. This is useful to check whether you need to install an option
     * and is commonly used during installation of plugin options and to test
     * whether upgrading is required.
     *
     * If the option was serialized then it will be unserialized when it is returned.
     *
     * Any scalar values will be returned as strings. You may coerce the return type of
     * a given option by registering an {@see 'option_$option'} filter callback.
     *
     * @since 1.5.0
     *
     * @param string $option  Name of option to retrieve. Expected to not be SQL-escaped.
     * @param mixed  $default Optional. Default value to return if the option does not exist.
     * @return mixed Value set for the option.
     */
    public function get_option( $option, $default = false )
    {
        $option = trim( $option );
        if ( empty( $option ) ) {
            return false;
        }

        /**
         * Filters the value of an existing option before it is retrieved.
         *
         * The dynamic portion of the hook name, `$option`, refers to the option name.
         *
         * Passing a truthy value to the filter will short-circuit retrieving
         * the option value, returning the passed value instead.
         *
         * @since 1.5.0
         * @since 4.4.0 The `$option` parameter was added.
         * @since 4.9.0 The `$default` parameter was added.
         *
         *
         * @param bool|mixed $pre_option The value to return instead of the option value. This differs from
         *                               `$default`, which is used as the fallback value in the event the option
         *                               doesn't exist elsewhere in get_option(). Default false (to skip past the
         *                               short-circuit).
         * @param string     $option     Option name.
         * @param mixed      $default    The fallback value to return if the option does not exist.
         *                               Default is false.
         */
        $pre = RC_Hook::apply_filters( "ecjia_theme_pre_option_{$option}", false, $option, $default );

        if ( false !== $pre )
        {
            return $pre;
        }

        // Distinguish between `false` as a default, and not passing one.
        $passed_default = func_num_args() > 1;

        // prevent non-existent options from triggering multiple queries
        $notoptions = ecjia_cache(self::APPCACHE_KEY)->get( 'notoptions');
        if ( isset( $notoptions[ $option ] ) ) {
            /**
             * Filters the default value for an option.
             *
             * The dynamic portion of the hook name, `$option`, refers to the option name.
             *
             * @since 3.4.0
             * @since 4.4.0 The `$option` parameter was added.
             * @since 4.7.0 The `$passed_default` parameter was added to distinguish between a `false` value and the default parameter value.
             *
             * @param mixed  $default The default value to return if the option does not exist
             *                        in the database.
             * @param string $option  Option name.
             * @param bool   $passed_default Was `get_option()` passed a default value?
             */
            return RC_Hook::apply_filters( "ecjia_theme_default_option_{$option}", $default, $option, $passed_default );
        }

        $alloptions = $this->load_alloptions();

        if ( isset( $alloptions[$option] ) ) {
            $value = $alloptions[$option];
        } else {
            $value = ecjia_cache(self::APPCACHE_KEY)->get( $option );

            if ( is_null($value) ) {
                $row = $this->repository->getOption($option);

                // Has to be get_row instead of get_var because of funkiness with 0, false, null values
                if ( is_object( $row ) ) {
                    $value = $row->option_value;
                    ecjia_cache(self::APPCACHE_KEY)->add( $option, $value, 'options' );
                } else { // option does not exist, so we must cache its non-existence
                    if ( ! is_array( $notoptions ) ) {
                        $notoptions = array();
                    }
                    $notoptions[$option] = true;
                    ecjia_cache(self::APPCACHE_KEY)->set( 'notoptions', $notoptions );

                    /** This filter is documented in wp-includes/option.php */
                    return RC_Hook::apply_filters( "ecjia_theme_default_option_{$option}", $default, $option, $passed_default );
                }
            }
        }

        /**
         * Filters the value of an existing option.
         *
         * The dynamic portion of the hook name, `$option`, refers to the option name.
         *
         * @since 1.5.0 As 'option_' . $setting
         * @since 3.0.0
         * @since 4.4.0 The `$option` parameter was added.
         *
         * @param mixed  $value  Value of the option. If stored serialized, it will be
         *                       unserialized prior to being returned.
         * @param string $option Option name.
         */
        return RC_Hook::apply_filters( "ecjia_theme_option_{$option}", RC_Format::maybe_unserialize( $value ), $option );
    }


    /**
     * Protect WordPress special option from being modified.
     *
     * Will die if $option is in protected list. Protected options are 'alloptions'
     * and 'notoptions' options.
     *
     * @since 2.2.0
     *
     * @param string $option Option name.
     */
    public function protect_special_option( $option )
    {
        if ( 'alloptions' === $option || 'notoptions' === $option )
        {
            rc_die( sprintf( __( '%s is a protected ECJia Theme option and may not be modified' ), RC_Format::esc_html( $option ) ) );
        }
    }

    /**
     * Print option value after sanitizing for forms.
     *
     * @since 1.5.0
     *
     * @param string $option Option name.
     */
    public function form_option( $option )
    {
        echo RC_Format::esc_attr( $this->get_option( $option ) );
    }


    /**
     * Update the value of an option that was already added.
     *
     * You do not need to serialize values. If the value needs to be serialized, then
     * it will be serialized before it is inserted into the database. Remember,
     * resources can not be serialized or added as an option.
     *
     * If the option does not exist, then the option will be added with the option value,
     * with an `$autoload` value of 'yes'.
     *
     * @since 1.0.0
     * @since 4.2.0 The `$autoload` parameter was added.
     *
     * @param string      $option   Option name. Expected to not be SQL-escaped.
     * @param mixed       $value    Option value. Must be serializable if non-scalar. Expected to not be SQL-escaped.
     * @param string|bool $autoload Optional. Whether to load the option when WordPress starts up. For existing options,
     *                              `$autoload` can only be updated using `update_option()` if `$value` is also changed.
     *                              Accepts 'yes'|true to enable or 'no'|false to disable. For non-existent options,
     *                              the default value is 'yes'. Default null.
     * @return bool False if value was not updated and true if value was updated.
     */
    public function update_option( $option, $value, $autoload = null )
    {
        $option = trim($option);
        if ( empty($option) )
        {
            return false;
        }

        $this->protect_special_option( $option );

        if ( is_object( $value ) )
        {
            $value = clone $value;
        }

        $value = $this->sanitize_option( $option, $value );
        $old_value = $this->get_option( $option );

        /**
         * Filters a specific option before its value is (maybe) serialized and updated.
         *
         * The dynamic portion of the hook name, `$option`, refers to the option name.
         *
         * @since 2.6.0
         * @since 4.4.0 The `$option` parameter was added.
         *
         * @param mixed  $value     The new, unserialized option value.
         * @param mixed  $old_value The old option value.
         * @param string $option    Option name.
         */
        $value = RC_Hook::apply_filters( "ecjia_theme_pre_update_option_{$option}", $value, $old_value, $option );

        /**
         * Filters an option before its value is (maybe) serialized and updated.
         *
         * @since 3.9.0
         *
         * @param mixed  $value     The new, unserialized option value.
         * @param string $option    Name of the option.
         * @param mixed  $old_value The old option value.
         */
        $value = RC_Hook::apply_filters( 'ecjia_theme_pre_update_option', $value, $option, $old_value );

        /*
         * If the new and old values are the same, no need to update.
         *
         * Unserialized values will be adequate in most cases. If the unserialized
         * data differs, the (maybe) serialized data is checked to avoid
         * unnecessary database calls for otherwise identical object instances.
         *
         * See https://core.trac.wordpress.org/ticket/38903
         */
        if ( $value === $old_value || RC_Format::maybe_serialize( $value ) === RC_Format::maybe_serialize( $old_value ) ) {
            return false;
        }

        /** This filter is documented in wp-includes/option.php */
        if ( RC_Hook::apply_filters( "ecjia_theme_default_option_{$option}", false, $option, false ) === $old_value ) {
            return $this->add_option( $option, $value );
        }

        $serialized_value = RC_Format::maybe_serialize( $value );

        /**
         * Fires immediately before an option value is updated.
         *
         * @since 2.9.0
         *
         * @param string $option    Name of the option to update.
         * @param mixed  $old_value The old option value.
         * @param mixed  $value     The new option value.
         */
        RC_Hook::do_action( 'ecjia_theme_update_option', $option, $old_value, $value );

        $result = $this->repository->updateOption($option, $serialized_value);

        if ( ! $result ) {
            return false;
        }

        $notoptions = ecjia_cache(self::APPCACHE_KEY)->get( 'notoptions' );
        if ( is_array( $notoptions ) && isset( $notoptions[$option] ) ) {
            unset( $notoptions[$option] );
            ecjia_cache(self::APPCACHE_KEY)->set( 'notoptions', $notoptions );
        }

        $alloptions = $this->load_alloptions();
        if ( isset( $alloptions[$option] ) ) {
            $alloptions[ $option ] = $serialized_value;
            ecjia_cache(self::APPCACHE_KEY)->set( 'alloptions', $alloptions );
        } else {
            ecjia_cache(self::APPCACHE_KEY)->set( $option, $serialized_value );
        }

        /**
         * Fires after the value of a specific option has been successfully updated.
         *
         * The dynamic portion of the hook name, `$option`, refers to the option name.
         *
         * @since 2.0.1
         * @since 4.4.0 The `$option` parameter was added.
         *
         * @param mixed  $old_value The old option value.
         * @param mixed  $value     The new option value.
         * @param string $option    Option name.
         */
        RC_Hook::do_action( "ecjia_theme_update_option_{$option}", $old_value, $value, $option );

        /**
         * Fires after the value of an option has been successfully updated.
         *
         * @since 2.9.0
         *
         * @param string $option    Name of the updated option.
         * @param mixed  $old_value The old option value.
         * @param mixed  $value     The new option value.
         */
        RC_Hook::do_action( 'ecjia_theme_updated_option', $option, $old_value, $value );
        return true;
    }


    /**
     * Add a new option.
     *
     * You do not need to serialize values. If the value needs to be serialized, then
     * it will be serialized before it is inserted into the database. Remember,
     * resources can not be serialized or added as an option.
     *
     * You can create options without values and then update the values later.
     * Existing options will not be updated and checks are performed to ensure that you
     * aren't adding a protected WordPress option. Care should be taken to not name
     * options the same as the ones which are protected.
     *
     * @since 1.0.0
     *
     * @param string         $option      Name of option to add. Expected to not be SQL-escaped.
     * @param mixed          $value       Optional. Option value. Must be serializable if non-scalar. Expected to not be SQL-escaped.
     * @param string         $deprecated  Optional. Description. Not used anymore.
     * @param string|bool    $autoload    Optional. Whether to load the option when WordPress starts up.
     *                                    Default is enabled. Accepts 'no' to disable for legacy reasons.
     * @return bool False if option was not added and true if option was added.
     */
    public function add_option( $option, $value = '', $deprecated = '', $autoload = 'yes' )
    {
        if ( !empty( $deprecated ) )
        {
            _deprecated_argument( __FUNCTION__, '2.3.0' );
        }

        $option = trim($option);
        if ( empty($option) )
        {
            return false;
        }

        $this->protect_special_option( $option );

        if ( is_object($value) )
        {
            $value = clone $value;
        }

        $value = $this->sanitize_option( $option, $value );

        // Make sure the option doesn't already exist. We can check the 'notoptions' cache before we ask for a db query
        $notoptions = ecjia_cache(self::APPCACHE_KEY)->get( 'notoptions' );
        if ( !is_array( $notoptions ) || !isset( $notoptions[$option] ) )
            /** This filter is documented in wp-includes/option.php */
        {
            if ( RC_Hook::apply_filters( "ecjia_theme_default_option_{$option}", false, $option, false ) !== $this->get_option( $option ) )
            {
                return false;
            }
        }

        $serialized_value = RC_Format::maybe_serialize( $value );

        /**
         * Fires before an option is added.
         *
         * @since 2.9.0
         *
         * @param string $option Name of the option to add.
         * @param mixed  $value  Value of the option.
         */
        RC_Hook::do_action( 'ecjia_theme_add_option', $option, $value );

        $result = $this->repository->addOption($option, $serialized_value);
        if ( ! $result )
        {
            return false;
        }

        $alloptions = $this->load_alloptions();
        $alloptions[ $option ] = $serialized_value;
        ecjia_cache(self::APPCACHE_KEY)->set( 'alloptions', $alloptions );

        // This option exists now
        $notoptions = ecjia_cache(self::APPCACHE_KEY)->get( 'notoptions' ); // yes, again... we need it to be fresh
        if ( is_array( $notoptions ) && isset( $notoptions[$option] ) ) {
            unset( $notoptions[$option] );
            ecjia_cache(self::APPCACHE_KEY)->set( 'notoptions', $notoptions );
        }

        /**
         * Fires after a specific option has been added.
         *
         * The dynamic portion of the hook name, `$option`, refers to the option name.
         *
         * @since 2.5.0 As "add_option_{$name}"
         * @since 3.0.0
         *
         * @param string $option Name of the option to add.
         * @param mixed  $value  Value of the option.
         */
        RC_Hook::do_action( "ecjia_theme_add_option_{$option}", $option, $value );

        /**
         * Fires after an option has been added.
         *
         * @since 2.9.0
         *
         * @param string $option Name of the added option.
         * @param mixed  $value  Value of the option.
         */
        RC_Hook::do_action( 'ecjia_theme_added_option', $option, $value );
        return true;
    }


    /**
     * Removes option by name. Prevents removal of protected WordPress options.
     *
     * @since 1.2.0
     *
     * @param string $option Name of option to remove. Expected to not be SQL-escaped.
     * @return bool True, if option is successfully deleted. False on failure.
     */
    public function delete_option( $option )
    {
        $option = trim( $option );
        if ( empty( $option ) )
        {
            return false;
        }

        $this->protect_special_option( $option );

        // Get the ID, if no ID then return
        $row = $this->repository->getOption($option);
        if ( is_null( $row ) )
        {
            return false;
        }

        /**
         * Fires immediately before an option is deleted.
         *
         * @since 2.9.0
         *
         * @param string $option Name of the option to delete.
         */
        RC_Hook::do_action( 'ecjia_theme_delete_option', $option );

        $result = $this->repository->deleteOption($option);
        $alloptions = $this->load_alloptions();
        if ( is_array( $alloptions ) && isset( $alloptions[$option] ) ) {
            unset( $alloptions[$option] );
            ecjia_cache(self::APPCACHE_KEY)->set( 'alloptions', $alloptions );
        }
        if ( $result ) {

            /**
             * Fires after a specific option has been deleted.
             *
             * The dynamic portion of the hook name, `$option`, refers to the option name.
             *
             * @since 3.0.0
             *
             * @param string $option Name of the deleted option.
             */
            RC_Hook::do_action( "ecjia_theme_delete_option_{$option}", $option );

            /**
             * Fires after an option has been deleted.
             *
             * @since 2.9.0
             *
             * @param string $option Name of the deleted option.
             */
            RC_Hook::do_action( 'ecjia_theme_deleted_option', $option );
            return true;
        }
        return false;
    }

}