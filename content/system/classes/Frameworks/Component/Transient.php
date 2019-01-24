<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/22
 * Time: 14:22
 */

namespace Ecjia\System\Frameworks\Component;

use RC_Hook;

class Transient
{

    /**
     * Get the value of a transient.
     *
     * If the transient does not exist, does not have a value, or has expired,
     * then the return value will be false.
     *
     * @since 2.8.0
     *
     * @param string $transient Transient name. Expected to not be SQL-escaped.
     * @return mixed Value of transient.
     */
    public function get_transient( $transient )
    {

        /**
         * Filters the value of an existing transient.
         *
         * The dynamic portion of the hook name, `$transient`, refers to the transient name.
         *
         * Passing a truthy value to the filter will effectively short-circuit retrieval
         * of the transient, returning the passed value instead.
         *
         * @since 2.8.0
         * @since 4.4.0 The `$transient` parameter was added
         *
         * @param mixed  $pre_transient The default value to return if the transient does not exist.
         *                              Any value other than false will short-circuit the retrieval
         *                              of the transient, and return the returned value.
         * @param string $transient     Transient name.
         */
        $pre = RC_Hook::apply_filters( "ecjia_pre_transient_{$transient}", false, $transient );
        if ( false !== $pre )
        {
            return $pre;
        }

        $value = ecjia_cache('transient')->get( $transient );

        /**
         * Filters an existing transient's value.
         *
         * The dynamic portion of the hook name, `$transient`, refers to the transient name.
         *
         * @since 2.8.0
         * @since 4.4.0 The `$transient` parameter was added
         *
         * @param mixed  $value     Value of transient.
         * @param string $transient Transient name.
         */
        return RC_Hook::apply_filters( "ecjia_transient_{$transient}", $value, $transient );
    }

    /**
     * Set/update the value of a transient.
     *
     * You do not need to serialize values. If the value needs to be serialized, then
     * it will be serialized before it is set.
     *
     * @since 2.8.0
     *
     * @param string $transient  Transient name. Expected to not be SQL-escaped. Must be
     *                           172 characters or fewer in length.
     * @param mixed  $value      Transient value. Must be serializable if non-scalar.
     *                           Expected to not be SQL-escaped.
     * @param int    $expiration Optional. Time until expiration in seconds. Default 0 (no expiration).
     * @return bool False if value was not set and true if value was set.
     */
    public function set_transient( $transient, $value, $expiration = 0 )
    {

        $expiration = (int) $expiration;

        /**
         * Filters a specific transient before its value is set.
         *
         * The dynamic portion of the hook name, `$transient`, refers to the transient name.
         *
         * @since 3.0.0
         * @since 4.2.0 The `$expiration` parameter was added.
         * @since 4.4.0 The `$transient` parameter was added.
         *
         * @param mixed  $value      New value of transient.
         * @param int    $expiration Time until expiration in seconds.
         * @param string $transient  Transient name.
         */
        $value = RC_Hook::apply_filters( "ecjia_pre_set_transient_{$transient}", $value, $expiration, $transient );

        /**
         * Filters the expiration for a transient before its value is set.
         *
         * The dynamic portion of the hook name, `$transient`, refers to the transient name.
         *
         * @since 4.4.0
         *
         * @param int    $expiration Time until expiration in seconds. Use 0 for no expiration.
         * @param mixed  $value      New value of transient.
         * @param string $transient  Transient name.
         */
        $expiration = RC_Hook::apply_filters( "ecjia_expiration_of_transient_{$transient}", $expiration, $value, $transient );

        $result = ecjia_cache('transient')->set( $transient, $value, $expiration );

        if ( $result ) {

            /**
             * Fires after the value for a specific transient has been set.
             *
             * The dynamic portion of the hook name, `$transient`, refers to the transient name.
             *
             * @since 3.0.0
             * @since 3.6.0 The `$value` and `$expiration` parameters were added.
             * @since 4.4.0 The `$transient` parameter was added.
             *
             * @param mixed  $value      Transient value.
             * @param int    $expiration Time until expiration in seconds.
             * @param string $transient  The name of the transient.
             */
            RC_Hook::do_action( "ecjia_set_transient_{$transient}", $value, $expiration, $transient );

            /**
             * Fires after the value for a transient has been set.
             *
             * @since 3.0.0
             * @since 3.6.0 The `$value` and `$expiration` parameters were added.
             *
             * @param string $transient  The name of the transient.
             * @param mixed  $value      Transient value.
             * @param int    $expiration Time until expiration in seconds.
             */
            RC_Hook::do_action( 'ecjia_setted_transient', $transient, $value, $expiration );
        }
        return $result;
    }


    /**
     * Delete a transient.
     *
     * @since 2.8.0
     *
     * @param string $transient Transient name. Expected to not be SQL-escaped.
     * @return bool true if successful, false otherwise
     */
    public function delete_transient( $transient )
    {

        /**
         * Fires immediately before a specific transient is deleted.
         *
         * The dynamic portion of the hook name, `$transient`, refers to the transient name.
         *
         * @since 3.0.0
         *
         * @param string $transient Transient name.
         */
        RC_Hook::do_action( "ecjia_delete_transient_{$transient}", $transient );

        $result = ecjia_cache('transient')->delete( $transient);

        if ( $result ) {

            /**
             * Fires after a transient is deleted.
             *
             * @since 3.0.0
             *
             * @param string $transient Deleted transient name.
             */
            RC_Hook::do_action( 'ecjia_deleted_transient', $transient );
        }

        return $result;
    }


    /**
     * Deletes all expired transients.
     *
     * The multi-table delete syntax is used to delete the transient record
     * from table a, and the corresponding transient_timeout record from table b.
     *
     * @since 4.9.0
     *
     * @param bool $force_db Optional. Force cleanup to run against the database even when an external object cache is used.
     */
    public function delete_expired_transients( $force_db = false )
    {
        if ( ! $force_db ) {
            return;
        }

    }

}